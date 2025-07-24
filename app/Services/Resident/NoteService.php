<?php
namespace App\Services\Resident;

use App\Repositories\NoteRepository;
use App\Enums\NoteType;

class NoteService
{
    public function __construct(
        protected NoteRepository $noteRepo
    ) {}

    public function addNote(array $data)
    {
        if (!NoteType::isValid($data['type'])) {
            throw new \InvalidArgumentException('Invalid note type');
        }

        return $this->noteRepo->create([
            'resident_id' => $data['resident_id'],
            'type' => $data['type'],
            'note' => $data['note']
        ]);
    }

    public function getResidentNotes(int $residentId, NoteType|string|null $type = null)
    {
        return $this->noteRepo->getByResident($residentId, $type);
    }

    public function getPaymentNotes(int $residentId)
    {
        return $this->getResidentNotes($residentId, NoteType::PAYMENT);
    }
}
