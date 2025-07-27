<?php

namespace App\Traits\livewire;

trait RepositoryResolver
{
    protected function repository(string $class)
    {
        return app($class);
    }
}
