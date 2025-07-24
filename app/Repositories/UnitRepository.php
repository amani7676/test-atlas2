<?php

// app/Repositories/UnitRepository.php
namespace App\Repositories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Collection;

class UnitRepository
{
    protected $model;

    public function __construct(Unit $unit)
    {
        $this->model = $unit;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id): ?Unit
    {
        return $this->model->find($id);
    }

    public function create(array $data): Unit
    {
        return $this->model->create($data);
    }


    public function update(int $id, array $data): Unit
    {
        $unit = $this->model->findOrFail($id);
        $unit->update($data);
        return $unit->fresh(); // بازگرداندن مدل به‌روزرسانی شده
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id);
    }

    public function getAllWithRoomsCount(): Collection
    {
        return $this->model->withCount('rooms')->get();
    }

    public function getWithRooms(int $unitId)
    {
        return $this->model->with('rooms')->find($unitId);
    }
}
