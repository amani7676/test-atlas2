<?php

namespace App\Providers;


use App\Services\Core\ModalManagerService;
use App\Services\Core\StatusService;
use Illuminate\Support\ServiceProvider;

// Service Imports
use App\Services\Core\BedService;
use App\Services\Core\RoomService;
use App\Services\Core\UnitService;
use App\Services\Report\AllReportService;
use App\Services\Resident\ContractService;
use App\Services\Resident\NoteService;
use App\Services\Resident\ResidentService;

// Repository Imports (برای dependency injection)
use App\Repositories\BedRepository;
use App\Repositories\ContractRepository;
use App\Repositories\NoteRepository;
use App\Repositories\ResidentRepository;
use App\Repositories\RoomRepository;
use App\Repositories\UnitRepository;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerCoreServices();
        $this->registerReportServices();
        $this->registerResidentServices();
        $this->registerUtilityServices(); // اضافه شد
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register Core Services
     *
     * @return void
     */
    protected function registerCoreServices(): void
    {
        // BedService
        $this->app->bind(BedService::class, function ($app) {
            return new BedService(
                $app->make(BedRepository::class)
            );
        });

        // RoomService
        $this->app->bind(RoomService::class, function ($app) {
            return new RoomService(
                $app->make(RoomRepository::class)
            );
        });

        // UnitService
        $this->app->bind(UnitService::class, function ($app) {
            return new UnitService(
                $app->make(UnitRepository::class)
            );
        });


        // UnitService
        $this->app->bind(ModalManagerService::class, function ($app) {
            return new ModalManagerService();
        });
    }

    /**
     * Register Report Services
     *
     * @return void
     */
    protected function registerReportServices(): void
    {
        // AllReportService - ترتیب پارامترها تصحیح شد
        $this->app->bind(AllReportService::class, function ($app) {
            return new AllReportService(
                $app->make(UnitRepository::class),      // پارامتر اول - اشتباه قبلی: BedRepository
                $app->make(RoomRepository::class),      // پارامتر دوم - درست بود
                $app->make(BedRepository::class),       // پارامتر سوم - اشتباه قبلی: BedRepository دوباره
                $app->make(ContractRepository::class)   // پارامتر چهارم - درست بود
            );
        });
    }

    /**
     * Register Resident Services
     *
     * @return void
     */
    protected function registerResidentServices(): void
    {
        // ContractService
        $this->app->bind(ContractService::class, function ($app) {
            return new ContractService(
                $app->make(ContractRepository::class)
            );
        });

        // NoteService
        $this->app->bind(NoteService::class, function ($app) {
            return new NoteService(
                $app->make(NoteRepository::class)
            );
        });

        // ResidentService
        $this->app->bind(ResidentService::class, function ($app) {
            return new ResidentService(
                $app->make(ResidentRepository::class)
            );
        });
    }
    /**
     * Register Utility Services
     *
     * @return void
     */
    protected function registerUtilityServices(): void
    {
        // StatusService
        $this->app->singleton(StatusService::class, function ($app) {
            return new StatusService();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            // Core Services
            BedService::class,
            RoomService::class,
            UnitService::class,

            // Report Services
            AllReportService::class,

            // Resident Services
            ContractService::class,
            NoteService::class,
            ResidentService::class,

            //Utility Services
            StatusService::class,

            ModalManagerService::class,
        ];
    }
}
