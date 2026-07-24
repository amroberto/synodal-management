<?php

namespace App\Livewire\Synod;

use App\Models\Synod;
use Livewire\Component;

class Edit extends Component
{
    public ?Synod $synod = null;
    
    public function mount(Synod $synod): void
    {
        $this->synod = $synod;
    }

    public function render()
    {
        return view('livewire.synod.edit', [
            'synod' => $this->synod,
        ]);
    }
}
