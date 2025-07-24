<?php

// app/Repositories/RoomRepository.php
namespace App\Repositories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

class RoomRepository
{
    protected $model;

    public function __construct(Room $room)
    {
        $this->model = $room;
    }

    public function create(array $data): Room
    {
        return $this->model->create($data);
    }

    public function getByUnit(int $unitId): Collection
    {
        return $this->model->where('unit_id', $unitId)->get();
    }

    public function getAvailableRooms(int $unitId): Collection
    {
        return $this->model->where('unit_id', $unitId)
            ->whereHas('beds', function($query) {
                $query->where('state_ratio_resident', 'empty');
            })
            ->get();
    }

    public function getWithBeds(int $roomId)
    {
        return $this->model->with('beds')->find($roomId);
    }

    public function updateBedCount(int $roomId, int $count): bool
    {
        return $this->model->where('id', $roomId)->update(['bed_count' => $count]);
    }
}
