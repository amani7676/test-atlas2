<?php

namespace App\Livewire\Pages\Tablelists;

use App\Services\Core\StatusService;
use App\Services\Report\AllReportService;
use App\Traits\HasDateConversion;
use Livewire\Component;

class Tablelists extends Component
{

    use HasDateConversion;
    // خصوصیات برای ذخیره داده های فرم
    public $editingResidents = [];
    public $full_name = [];
    public $phone = [];
    public $payment_date = [];

    public function mount()
    {
        // تمام واحدها را با وابستگی‌هایشان (ساکنین و قراردادها) دریافت می‌کنیم
        $allUnitsData = $this->allReportService()->getUnitWithDependence();

        foreach ($allUnitsData as $unitData) {
            foreach ($unitData['rooms'] as $roomData) {
                foreach ($roomData['beds'] as $bed) {
                    // فقط برای تخت‌هایی که قرارداد فعال دارند
                    if ($bed['contracts']->first()) {
                        $contractData = $bed['contracts']->first();
                        $resident = $contractData['resident'];
                        $contract = $contractData['contract'];

                        // خصوصیات Livewire را با داده‌های موجود مقداردهی اولیه می‌کنیم
                        // این کار باعث می‌شود که wire:model این مقادیر را در فیلد نمایش دهد
                        $this->full_name[$resident['id']] = $resident['full_name'] ?? '';
                        $this->phone[$resident['id']] = $resident['phone'] ?? '';
                        $this->payment_date[$resident['id']] = $contract['payment_date'] ?? '';
                    }
                }
            }
        }
    }

    protected function allReportService(): AllReportService
    {
        return app(AllReportService::class);
    }

    protected function statusService(): StatusService
    {
        return app(StatusService::class);
    }
    public function getColorClass($vahedId)
    {
        $colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
        return $colors[$vahedId];
    }

    public function editResident($residentId)
    {
        // کد ویرایش ساکن
    }

    public function addNoteResident($residentId)
    {
        // کد اضافه کردن توضیحات
    }

    public function editResidentInline($residentId)
    {

        try {


            // بروزرسانی اطلاعات ساکن
            $resident = \App\Models\Resident::find($residentId);
            if ($resident) {
                $resident->update([
                    'full_name' => $this->full_name[$residentId] ?? $resident->full_name,
                    'phone' => $this->phone[$residentId] ?? $resident->phone,
                ]);

                // بروزرسانی تاریخ پرداخت در قرارداد
                $contract = $resident->contracts()->latest()->first();

                if ($contract && isset($this->payment_date[$residentId])) {

                    $contract->update([
                        'payment_date' => $this->toMiladi($this->payment_date[$residentId])
                    ]);
                }

                $this->dispatch('show-toast', [
                    'type' => 'success',
                    'title' => 'موفقیت!',
                    'description' => "مشخصات " . ($resident->full_name ?? 'کاربر') . " به روز شد",
                    'timer' => 3000
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('show-toast', [ // !!! تغییر به 'show-toast'
                'type' => 'error',
                'title' => 'مشکل!',
                'description' => 'خطا در انجام اپدیت خطی',
                'timer' => 3000 // Toast پس از 3 ثانیه ناپدید می‌شود
            ]);
        }
    }

    public function openAddModal($bedName, $roomName)
    {
        // کد باز کردن مودال اضافه کردن ساکن
    }

    public function render()
    {

        return view('livewire.pages.tablelists.tablelists', [
            'allReportService' => $this->allReportService(),
            'statusService' => $this->statusService(),
        ]);
    }
}
