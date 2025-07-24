<?php
namespace App\Services\Resident;

use App\Repositories\ContractRepository;
use App\Enums\ContractState;
use Carbon\Carbon;

class ContractService
{
    public function __construct(
        protected ContractRepository $contractRepo
    ) {}

    public function createContract(array $data)
    {
        $this->validateContractDates($data['start_date'], $data['end_date']);

        return $this->contractRepo->create([
            'resident_id' => $data['resident_id'],
            'bed_id' => $data['bed_id'],
            'state' => ContractState::ACTIVE,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'expir_date' => $data['expir_date'] ?? null
        ]);
    }

    public function renewContract(int $contractId, array $data)
    {
        $this->validateContractDates($data['start_date'], $data['end_date']);

        return $this->contractRepo->update($contractId, [
            'state' => ContractState::ACTIVE,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'expir_date' => $data['expir_date'] ?? null
        ]);
    }

    public function terminateContract(int $contractId)
    {
        return $this->contractRepo->update($contractId, [
            'state' => ContractState::EXIT,
            'end_date' => now()
        ]);
    }

    protected function validateContractDates($startDate, $endDate)
    {
        if (Carbon::parse($startDate)->greaterThan(Carbon::parse($endDate))) {
            throw new \InvalidArgumentException('End date must be after start date');
        }
    }

    public function getActiveContracts()
    {
        return $this->contractRepo->getActiveContracts();
    }
}
