<?php
namespace App\Services\Core;

use App\Repositories\BedRepository;
use App\Enums\BedState;
use App\Enums\BedResidentState;

class BedService
{
    public function __construct(
        protected BedRepository $bedRepo
    ) {}

    public function createBed(array $data)
    {
        return $this->bedRepo->create([
            'name' => $data['name'],
            'room_id' => $data['room_id'],
            'state_ratio_resident' => BedResidentState::EMPTY,
            'state' => BedState::ACTIVE,
            'desc' => $data['desc'] ?? null
        ]);
    }

    public function changeBedState(int $bedId, string $state)
    {
        if (!in_array($state, BedState::all())) {
            throw new \InvalidArgumentException('Invalid bed state');
        }

        return $this->bedRepo->update($bedId, ['state' => $state]);
    }

    public function getAvailableBeds(int $roomId)
    {
        return $this->bedRepo->getAvailableBeds($roomId);
    }
}
