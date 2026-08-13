<?php

namespace App\Livewire\Entity;

use Livewire\Component;
use App\Models\Entity;

class Edit extends Component
{
    public ?Entity $entity = null;
    
    public function mount(Entity $entity): void
    {
        $this->entity = $entity;
    }

    public function render()
    {
        return view('livewire.entity.edit', [
            'entity' => $this->entity,
        ]);
    }
}
