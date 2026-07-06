<?php

namespace App\Livewire\Leadership;

use Livewire\Component;
use App\Models\Leadership;

class Edit extends Component
{
    public ?Leadership $leadership = null;
    
    public function mount(Leadership $leadership): void
    {
        $this->leadership = $leadership;
    }

    public function render()
    {
        return view('livewire.leadership.edit', [
            'leadership' => $this->leadership,
        ]);
    }
}
