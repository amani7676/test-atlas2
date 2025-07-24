<?php

// app/Repositories/ContractRepository.php
namespace App\Repositories;

use App\Models\Contract;
use App\Enums\ContractState;
use Illuminate\Database\Eloquent\Collection;

class ContractRepository
{
    protected $model;

    public function __construct(Contract $contract)
    {
        $this->model = $contract;
    }

    public function create(array $data): Contract
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function countActiveContracts(): int
    {
        return $this->model->where('state', ContractState::ACTIVE)->count();
    }

    public function getActiveContracts(): Collection
    {
        return $this->model->where('state', ContractState::ACTIVE)
            ->with(['resident', 'bed.room.unit'])
            ->get();
    }

    public function countActiveContractsByRoom(int $roomId): int
    {
        return $this->model->where('state', ContractState::ACTIVE)
            ->whereHas('bed', function($query) use ($roomId) {
                $query->where('room_id', $roomId);
            })
            ->count();
    }

    public function getResidentActiveContract(int $residentId)
    {
        return $this->model->where('resident_id', $residentId)
            ->where('state', ContractState::ACTIVE)
            ->first();
    }
}
