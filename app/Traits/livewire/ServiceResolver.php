<?php

namespace App\Traits\livewire;

trait ServiceResolver
{
    protected function service(string $class)
    {
        return app($class);
    }
}
