<?php

// app/Providers/RepositoryServiceProvider.php
namespace App\Providers;

use App\Models\Bed;
use App\Models\Contract;
use App\Models\Note;
use App\Models\Resident;
use App\Models\Rezerve;
use App\Models\Room;
use App\Models\Unit;
use Illuminate\Support\ServiceProvider;

// Repository Imports
use App\Repositories\BedRepository;
use App\Repositories\ContractRepository;
use App\Repositories\NoteRepository;
use App\Repositories\ResidentRepository;
use App\Repositories\RezerveRepository;
use App\Repositories\RoomRepository;
use App\Repositories\UnitRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public array $bindings = [
        // Repository bindings - اگر از Interface استفاده نمی‌کنید
        BedRepository::class => BedRepository::class,
        ContractRepository::class => ContractRepository::class,
        NoteRepository::class => NoteRepository::class,
        ResidentRepository::class => ResidentRepository::class,
        RoomRepository::class => RoomRepository::class,
        UnitRepository::class => UnitRepository::class,
    ];

    /**
     * All of the container singletons that should be registered.
     * Repository ها معمولاً singleton نیستند
     *
     * @var array
     */
    public array $singletons = [
        // اگر می‌خواهید Repository ها singleton باشند (توصیه نمی‌شود)
        // BedRepository::class => BedRepository::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Manual binding - اگر نیاز به logic خاصی دارید
        $this->registerRepositories();
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
     * Register all repositories
     *
     * @return void
     */
    protected function registerRepositories(): void
    {
        // BedRepository
        $this->app->bind(BedRepository::class, function ($app) {
            return new BedRepository($app->make(Bed::class));
        });

        // ContractRepository
        $this->app->bind(ContractRepository::class, function ($app) {
            return new ContractRepository($app->make(Contract::class));
        });

        // NoteRepository
        $this->app->bind(NoteRepository::class, function ($app) {
            return new NoteRepository($app->make(Note::class));
        });

        // ResidentRepository
        $this->app->bind(ResidentRepository::class, function ($app) {
            return new ResidentRepository($app->make(Resident::class));
        });

        // RoomRepository
        $this->app->bind(RoomRepository::class, function ($app) {
            return new RoomRepository($app->make(Room::class));
        });

        // UnitRepository
        $this->app->bind(UnitRepository::class, function ($app) {
            return new UnitRepository($app->make(Unit::class));
        });

        // RezerveRepository
        $this->app->bind(RezerveRepository::class, function ($app) {
            return new RezerveRepository($app->make(Rezerve::class));
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
            BedRepository::class,
            ContractRepository::class,
            NoteRepository::class,
            ResidentRepository::class,
            RoomRepository::class,
            UnitRepository::class,
            RezerveRepository::class
        ];
    }
}
