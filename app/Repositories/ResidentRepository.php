<?php

// app/Repositories/ResidentRepository.php
namespace App\Repositories;

use App\Models\Resident;
use Illuminate\Database\Eloquent\Collection;

class ResidentRepository
{
    protected $model;

    public function __construct(Resident $resident)
    {
        $this->model = $resident;
    }

    public function create(array $data): Resident
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function search(string $keyword): Collection
    {
        return $this->model->where('full_name', 'like', "%$keyword%")
            ->orWhere('phone', 'like', "%$keyword%")
            ->get();
    }

    public function getWithContracts(int $residentId)
    {
        return $this->model->with('contracts.bed.room.unit')->find($residentId);
    }

    public function getActiveResidents(): Collection
    {
        return $this->model->whereHas('contracts', function($query) {
            $query->where('state', 'active');
        })->get();
    }
}
