<?php

namespace App\Livewire\Pages\Home\Componets;

use App\Models\Contract;
use App\Models\Resident;
use App\Repositories\BedRepository;
use App\Rules\PersianDate;
use App\Services\Report\AllReportService;
use App\Traits\HasDateConversion;
use Carbon\Carbon;
use Livewire\Component;

class EmptyBeds extends Component
{
    use HasDateConversion;
    // Modal state
    public $showModal = false;
    public $selectedRoom = null;
    public $selectedBed = null;

    // Form properties for resident
    public $full_name = '';
    public $phone = '';
    public $age = '';
    public $job = '';
    public $referral_source = '';
    public $form = false;
    public $document = false;
    public $rent = false;
    public $trust = false;

    // Form properties for contract
    public $payment_date = '';
    public $state = '';
    public $start_date = '';
    public $end_date = '';

    protected $allReportService;
    protected $beds;

    // به جای $rules از متد استفاده می‌کنیم
    protected function rules()
    {
        return [
            'full_name'    => 'required|string|max:255',
            'payment_date' => ['required', new PersianDate],
            'state'        => 'required|in:rezerve,nightly,active,leaving,exit',
            'phone' => 'digits:11'
        ];
    }

    protected $messages = [
        'full_name.required' => 'نام و نام خانوادگی الزامی است',
        'payment_date.required' => 'تاریخ پرداخت الزامی است',
        'state.required' => 'وضعیت رو مشخص کنید',
        'phone.digits' => 'شماره تلفن باید 11 رقم باشد'
    ];

    public function mount(AllReportService $allReportService, BedRepository $beds)
    {
        $this->allReportService = $allReportService;
        $this->beds = $beds;
    }

    public function openModal($bedData)
    {
        $this->selectedBed = $bedData;
        $this->selectedRoom = $bedData['room'] ?? null;
        $this->showModal = true;
        $this->resetValidation();
        $this->dispatch('show-modal');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedRoom = null;
        $this->selectedBed = null;
        $this->resetForm();
        $this->dispatch('hide-modal');
    }

    private function resetForm()
    {
        $this->full_name = '';
        $this->phone = '';
        $this->age = '';
        $this->job = '';
        $this->referral_source = '';
        $this->form = false;
        $this->document = false;
        $this->rent = false;
        $this->trust = false;
        $this->state = '';



        $this->resetValidation();
    }
    public function updatedPhone($value)
    {
        $this->phone = str_replace('-', '', $value); // تبدیل به `09961351938`
        $this->validateOnly('phone');
    }
    public function saveaddresident()
    {


        $this->validate();


        //change dates(payment,start) to miladi
        // Set default dates
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->payment_date = $this->toMiladi($this->payment_date);

        try {

            // Create resident
            $resident = Resident::create([
                'full_name' => $this->full_name,
                'phone' => $this->phone,
                'age' => $this->age ?: null,
                'job' => $this->job ?: null,
                'referral_source' => $this->referral_source ?: null,
                'form' => $this->form,
                'document' => $this->document ?: false,
                'rent' => $this->rent,
                'trust' => $this->trust,
            ]);
            // Create contract
            $contract = Contract::create([
                'resident_id' => $resident->id,
                'bed_id' => $this->selectedBed['id'],
                'payment_date' => $this->payment_date,
                'state' => $this->state,
                'start_date' => $this->start_date,
            ]);




            // Update bed status to inactive (occupied)
             \App\Models\Bed::where('id', $this->selectedBed['id'])
                ->update(
                    [
                        'state' => 'active',
                        'state_ratio_resident' => in_array($this->state, ['nightly', 'active', 'leaving'])
                            ? 'full'
                            : ($this->state === 'rezerve' ? 'rezerve' : null)
                    ]
                );
            // !!! تغییر 'message' به 'description' برای هماهنگی با cute-alert
            $this->dispatch('show-toast', [ // !!! تغییر به 'show-toast'
                'type' => 'success',
                'title' => 'موفقیت!',
                'description' => "مشخصات .'$this->full_name'. ثبت شد",
                'timer' => 3000 // Toast پس از 3 ثانیه ناپدید می‌شود
            ]);
            $this->closeModal();

            // Refresh the component
            $this->dispatch('$refresh');
        } catch (\Exception $e) {
            $this->closeModal();
            // Refresh the component
            $this->dispatch('$refresh');
            // !!! تغییر 'message' به 'description' برای هماهنگی با cute-alert
            $this->dispatch('show-toast', [ // !!! تغییر به 'show-toast'
                'type' => 'error',
                'title' => 'ناموفق!',
                'description' => 'خطا در ثبت اطلاعات: ',
                'timer' => 3000 // Toast پس از 3 ثانیه ناپدید می‌شود
            ]);
        }
    }

    public function render()
    {
        $this->allReportService ??= app(AllReportService::class);
        $this->beds ??= app(BedRepository::class);

        return view('livewire.pages.home.componets.empty-beds',);
    }
}
