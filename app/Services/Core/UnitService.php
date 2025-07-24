<?php

namespace App\Services\Core;

use App\Repositories\UnitRepository;
use App\Models\Unit;

class UnitService
{
    public function __construct(
        protected UnitRepository $unitRepo
    ) {}

    public function getAllUnits()
    {
        return $this->unitRepo->getAllWithRoomsCount();
    }

    public function createUnit(array $data): Unit
    {
        return $this->unitRepo->create([
            'name' => $data['name'],
            'code' => $data['code'],
            'desc' => $data['desc'] ?? null
        ]);
    }

    public function updateUnit(int $id, array $data): Unit
    {
        return $this->unitRepo->update($id, [
            'name' => $data['name'],
            'code' => $data['code'],
            'desc' => $data['desc'] ?? null
        ]);
    }

    public function getUnitWithRooms(int $unitId)
    {
        return $this->unitRepo->getWithRooms($unitId);
    }
}
