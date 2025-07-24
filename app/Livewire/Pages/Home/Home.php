<?php

namespace App\Livewire\Pages\Home;

use App\Services\Core\StatusService;
use App\Models\Rezerve;
use App\Repositories\BedRepository;
use App\Repositories\RezerveRepository;
use App\Services\Report\AllReportService;
use Livewire\Component;

class Home extends Component
{

    // ویژگی‌ها را به صورت nullable تعریف کنید
    protected AllReportService $allReportService;
    protected RezerveRepository $rezerveRepository;
    protected BedRepository $bedRepository;
    protected StatusService $statusService; // اضافه شد


    // رویدادهایی که این کامپوننت به آنها گوش می‌دهد


    public function mount(
        AllReportService $occupancyReportService,
        RezerveRepository $rezerveRepository,
        BedRepository $bed_repository,
        StatusService $statusService // اضافه شد

    ): void {
        $this->allReportService = $occupancyReportService;
        $this->rezerveRepository = $rezerveRepository;
        $this->bedRepository = $bed_repository;
        $this->statusService = $statusService; // اضافه شد

    }


    // // این متد public getter را اضافه کنید
    // public function getAllReportServiceInstance(): AllReportService
    // {
    //     // از Null Coalescing استفاده می‌کنیم تا مطمئن شویم که سرویس همیشه مقداردهی شده است.
    //     // این حالت فقط برای رندر اولیه کاربرد دارد، در Livewire mount همیشه اجرا می‌شود.
    //     return $this->allReportService ??= app(AllReportService::class);
    // }

    // متدی که هنگام دریافت رویداد show-alert فراخوانی می‌شود

    public function render()
    {
        // اطمینان حاصل کنید که سرویس‌ها مقداردهی شده‌اند، در غیر این صورت Resolve کنید
        // $allReportServiceInstance = $this->allReportService ?? app(AllReportService::class);
        // $rezerveRepositoryInstance = $this->rezerveRepository ?? app(RezerveRepository::class);

        return view('livewire.pages.home.home', [
            'allReportService' => $this->allReportService,
            'rezerves' => $this->rezerveRepository,
            'beds' => $this->bedRepository,
            'statusService' => $this->statusService, // اضافه شد برای استفاده در view

        ]);
    }
}
