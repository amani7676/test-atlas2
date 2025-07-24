<?php
namespace App\Services\Core;

use App\Repositories\RoomRepository;

class RoomService
{
    public function __construct(
        protected RoomRepository $roomRepo
    ) {}

    public function createRoom(array $data)
    {
        return $this->roomRepo->create([
            'name' => $data['name'],
            'unit_id' => $data['unit_id'],
            'bed_count' => $data['bed_count'],
            'desc' => $data['desc'] ?? null
        ]);
    }

    public function getAvailableRooms(int $unitId)
    {
        return $this->roomRepo->getAvailableRooms($unitId);
    }

    public function getRoomWithBeds(int $roomId)
    {
        return $this->roomRepo->getWithBeds($roomId);
    }
}
