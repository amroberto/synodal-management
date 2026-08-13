<?php

namespace App\Livewire\Entity;

use Livewire\Component;
use App\Models\Entity;
use App\Helpers\BrazilianFormatter;
use App\Traits\GetAddressByCepTrait;

class Create extends Component
{
    public function render()
    {
        return view('livewire.entity.create', [
            'entity' => new Entity(),
        ]);
    }
}
