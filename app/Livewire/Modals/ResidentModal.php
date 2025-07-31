<?php

namespace App\Livewire\Modals;

use App\Models\Bed;
use App\Models\Contract;
use App\Models\Resident;
use App\Repositories\BedRepository;
use App\Rules\PersianDate;
use App\Traits\HasDateConversion;
use App\Traits\livewire\RepositoryResolver;
use App\Traits\livewire\ServiceResolver;
use Carbon\Carbon;
use Livewire\Component;

class ResidentModal extends Component // نام تغییر کرد
{
    use HasDateConversion;
    use RepositoryResolver;
    use ServiceResolver;

    // Modal state
    public $showModal = false;
    public $selectedBed = null;
    public $modalMode = 'add'; // 'add' یا 'edit'
    public $editingResidentId = null;

    // Form properties for resident
    public $full_name_modal = '';
    public $phone_modal = '';
    public $age_modal = '';
    public $job_modal = '';
    public $referral_source_modal = '';
    public $form_modal = false;
    public $document_modal = false;
    public $rent_modal = false;
    public $trust_modal = false;

    // Form properties for contract
    public $payment_date_modal = '';
    public $state_modal = '';
    public $start_date = '';
    public $end_date = '';

    protected $bedRepository;

    public function __construct()
    {
        $this->bedRepository = $this->repository(BedRepository::class);
    }

    protected $listeners = [
        'openAddResidentModal' => 'openAddModal',
        'openEditResidentModal' => 'openEditModal',
        'closeModal' => 'closeModal',
        'phoneModalUpdated' => 'updatePhoneModal'
    ];

    protected function rules()
    {
        return [
            'full_name_modal' => 'required|string|max:255',
            'payment_date_modal' => ['required', new PersianDate],
            'state_modal' => 'required|in:rezerve,nightly,active,leaving,exit',
//            'phone_modal' => 'digits:11'
        ];
    }

    protected $messages = [
        'full_name_modal.required' => 'نام و نام خانوادگی الزامی است',
        'payment_date_modal.required' => 'تاریخ پرداخت الزامی است',
        'state_modal.required' => 'وضعیت رو مشخص کنید',
//        'phone_modal.digits' => 'شماره تلفن باید 11 رقم باشد'
    ];

    public function openAddModal($bedName, $roomName)
    {
        $this->modalMode = 'add';
        $this->editingResidentId = null;

        // پیدا کردن تخت
        $bed = Bed::with('room')
            ->where('name', $bedName)
            ->whereHas('room', function ($query) use ($roomName) {
                $query->where('name', $roomName);
            })
            ->first();
        if ($bed) {
            $this->selectedBed = [
                'id' => $bed->id,
                'name' => $bed->name,
                'room' => $bed->room->name,
            ];
            $this->resetForm();
            $this->showModal = true;
            $this->resetValidation();
            $this->dispatch('show-modal');
        } else {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'title' => 'خطا!',
                'description' => 'تخت مورد نظر یافت نشد',
                'timer' => 3000
            ]);
        }
    }

    public function openEditModal($residentId)
    {
        $this->modalMode = 'edit';
        $this->editingResidentId = $residentId;
//        $this->selectedBed =

        // بارگذاری اطلاعات resident
        $resident = Resident::with(['contract' => function ($query) {
            $query->latest()->first();
        }, 'contract.bed.room'])->find($residentId);

        if ($resident) {
            $contract = $resident->contract;

            // تنظیم اطلاعات تخت
            if ($contract && $contract->bed) {
                $this->selectedBed = [
                    'id' => $contract->bed->id,
                    'name' => $contract->bed->name,
                    'room' => $contract->bed->room->name,
                ];
            } else {
                $this->selectedBed = null;
            }


            // پر کردن فرم با اطلاعات موجود
            $this->full_name_modal = $resident->full_name ?? '';
            $this->phone_modal = $resident->phone ?? '';
            $this->age_modal = $resident->age ?? '';
            $this->job_modal = $resident->job ?? '';
            $this->referral_source_modal = $resident->referral_source ?? '';
            $this->form_modal = $resident->form ?? false;
            $this->document_modal = $resident->document ?? false;
            $this->rent_modal = $resident->rent ?? false;
            $this->trust_modal = $resident->trust ?? false;

            if ($contract) {
                $this->payment_date_modal = $this->toJalali($contract->payment_date) ?? '';
                $this->state_modal = $contract->state ?? '';
            }

            $this->showModal = true;
            $this->resetValidation();
            $this->dispatch('show-modal');
        } else {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'title' => 'خطا!',
                'description' => 'اقامتگر مورد نظر یافت نشد',
                'timer' => 3000
            ]);
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedBed = null;
        $this->modalMode = 'add';
        $this->editingResidentId = null;
        $this->resetForm();
        $this->dispatch('hide-modal');
    }

    public function updatePhoneModal($value)
    {

        $this->phone_modal = $value;
        $this->validateOnly('phone_modal');
    }

    private function resetForm()
    {
        $this->full_name_modal = '';
        $this->phone_modal = '';
        $this->age_modal = '';
        $this->job_modal = '';
        $this->referral_source_modal = '';
        $this->form_modal = false;
        $this->document_modal = false;
        $this->rent_modal = false;
        $this->trust_modal = false;
        $this->state_modal = '';
        $this->payment_date_modal = '';
        $this->resetValidation();
    }



    public function saveResident()
    {
        $this->phone_modal = str_replace('-', '', $this->phone_modal);
        $this->validate();

        try {
            if ($this->modalMode == 'add') {
                $this->createNewResident();
            } else {
                $this->updateExistingResident();
            }
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [
                'type' => 'error',
                'title' => 'ناموفق!',
                'description' => 'خطا در انجام عملیات: ' . $e->getMessage(),
                'timer' => 3000
            ]);
            $this->closeModal();
        }
    }

    private function createNewResident()
    {
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->payment_date_modal = $this->toMiladi($this->payment_date_modal);
        // ایجاد resident جدید
        $resident = Resident::create([
            'full_name' => $this->full_name_modal,
            'phone' => $this->phone_modal,
            'age' => $this->age_modal ?: null,
            'job' => $this->job_modal ?: null,
            'referral_source' => $this->referral_source_modal ?: null,
            'form' => $this->form_modal,
            'document' => $this->document_modal ?: false,
            'rent' => $this->rent_modal,
            'trust' => $this->trust_modal,
        ]);

        // ایجاد contract
        $contract = Contract::create([
            'resident_id' => $resident->id,
            'bed_id' => $this->selectedBed['id'],
            'payment_date' => $this->payment_date_modal,
            'state' => $this->state_modal,
            'start_date' => $this->start_date,
        ]);
        // بروزرسانی وضعیت تخت
        \App\Models\Bed::where('id', $this->selectedBed['id'])
            ->update([
                'state' => 'active',
                'state_ratio_resident' => in_array($this->state_modal, ['nightly', 'active', 'leaving'])
                    ? 'full'
                    : ($this->state_modal === 'rezerve' ? 'rezerve' : null)
            ]);

        $this->dispatch('show-toast', [
            'type' => 'success',
            'title' => 'موفقیت!',
            'description' => "اقامتگر {$this->full_name_modal} با موفقیت اضافه شد",
            'timer' => 3000
        ]);

        $this->dispatch('residentAdded');
        $this->closeModal();
    }

    private function updateExistingResident()
    {
//        dd($this->document_modal, $this->rent_modal, $this->trust_modal);
        $resident = Resident::find($this->editingResidentId);
        if ($resident) {
            // بروزرسانی اطلاعات resident
            $resident->update([
                'full_name' => $this->full_name_modal,
                'phone' => $this->phone_modal,
                'age' => $this->age_modal ?: null,
                'job' => $this->job_modal ?: null,
                'referral_source' => $this->referral_source_modal ?: null,
                'form' => $this->form_modal,
                'document' => $this->document_modal ?: false,
                'rent' => $this->rent_modal,
                'trust' => $this->trust_modal,
            ]);

            // بروزرسانی contract
            $contract = $resident->contract()->latest()->first();
            if ($contract) {
                $contract->update([
                    'payment_date' => $this->toMiladi($this->payment_date_modal),
                    'state' => $this->state_modal,
                ]);
            }
            // بروزرسانی وضعیت تخت
            \App\Models\Bed::where('id', $contract->bed_id)
                ->update([
                    'state' => 'active',
                    'state_ratio_resident' => in_array($this->state_modal, ['nightly', 'active', 'leaving'])
                        ? 'full'
                        : ($this->state_modal === 'rezerve' ? 'rezerve' : null)
                ]);

            $this->dispatch('show-toast', [
                'type' => 'success',
                'title' => 'موفقیت!',
                'description' => "اطلاعات {$this->full_name_modal} با موفقیت بروزرسانی شد",
                'timer' => 4000
            ]);

            $this->dispatch('residentAdded'); // برای refresh کردن جدول
            $this->closeModal();
        }
    }

    public function render()
    {
        return view('livewire.modals.resident-modal'); // نام ویو تغییر کرد
    }
}
