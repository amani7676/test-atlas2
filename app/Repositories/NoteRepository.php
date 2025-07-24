<?php

// app/Repositories/NoteRepository.php
namespace App\Repositories;

use App\Models\Note;
use App\Enums\NoteType;
use Illuminate\Database\Eloquent\Collection;

class NoteRepository
{
    protected $model;

    public function __construct(Note $note)
    {
        $this->model = $note;
    }

    public function create(array $data): Note
    {
        return $this->model->create($data);
    }

    public function getByResident(int $residentId, NoteType|string|null $type = null): Collection
    {
        $query = $this->model->where('resident_id', $residentId);

        if ($type) {
            $query->where('type', $type);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function getPaymentNotes(int $residentId): Collection
    {
        return $this->getByResident($residentId, NoteType::PAYMENT);
    }

    public function getLatestNotes(int $limit = 5): Collection
    {
        return $this->model->with('resident')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
