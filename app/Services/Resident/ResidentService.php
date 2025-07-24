<?php

namespace App\Services\Resident;

use App\Repositories\ResidentRepository;
use App\Enums\ReferralSource;

class ResidentService
{
    public function __construct(
        protected ResidentRepository $residentRepo
    ) {}

    public function registerResident(array $data)
    {
        $validated = $this->validateResidentData($data);

        return $this->residentRepo->create($validated);
    }

    public function updateResident(int $id, array $data)
    {
        $validated = $this->validateResidentData($data);

        return $this->residentRepo->update($id, $validated);
    }

    protected function validateResidentData(array $data): array
    {
        if (!ReferralSource::isValid($data['referral_source'])) {
            throw new \InvalidArgumentException('Invalid referral source');
        }

        return [
            'full_name' => $data['full_name'],
            'phone' => $data['phone'],
            'age' => $data['age'],
            'job' => $data['job'],
            'referral_source' => $data['referral_source'],
            'form' => $data['form'] ?? false,
            'document' => $data['document'] ?? false,
            'rent' => $data['rent'] ?? false,
            'trust' => $data['trust'] ?? false
        ];
    }

    public function searchResidents(string $query)
    {
        return $this->residentRepo->search($query);
    }
}
