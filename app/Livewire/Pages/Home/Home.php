<?php

namespace App\Livewire\Pages\Home;

use App\Repositories\NoteRepository;
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
    protected StatusService $statusService;
    protected NoteRepository $noteRepository;


    // رویدادهایی که این کامپوننت به آنها گوش می‌دهد


    public function mount(
        AllReportService $occupancyReportService,
        RezerveRepository $rezerveRepository,
        BedRepository $bed_repository,
        StatusService $statusService ,
        NoteRepository $noteRepository,
    ): void {
        $this->allReportService = $occupancyReportService;
        $this->rezerveRepository = $rezerveRepository;
        $this->bedRepository = $bed_repository;
        $this->statusService = $statusService; // اضافه شد
        $this->noteRepository = $noteRepository;

    }

    // متدی که هنگام دریافت رویداد show-alert فراخوانی می‌شود

    public function render()
    {
        return view('livewire.pages.home.home', [
            'allReportService' => $this->allReportService,
            'rezerves' => $this->rezerveRepository,
            'beds' => $this->bedRepository,
            'statusService' => $this->statusService, // اضافه شد برای استفاده در view
            'noteRepository' => $this->noteRepository
        ]);
    }
}
