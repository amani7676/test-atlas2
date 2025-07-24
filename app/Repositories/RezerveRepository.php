<?php

namespace App\Repositories;

use App\Models\Rezerve;
use Illuminate\Database\Eloquent\Collection;

class RezerveRepository
{
    protected $model;
    public function __construct(Rezerve $rezerve) {
        $this->model = $rezerve;
    }
    public function create(array $data): Rezerve
    {
        return $this->model->create($data);
    }
    public function getAll(): Collection
    {
        return $this->model->all();
    }
}
