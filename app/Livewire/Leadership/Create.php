<?php

namespace App\Livewire\Leadership;

use Livewire\Component;
use App\Models\Leadership;

class Create extends Component
{
    
    public function render()
    {
        return view('livewire.leadership.create', [
            'leadership' => new Leadership(),
        ]);
    }
}
