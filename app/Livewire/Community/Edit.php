<?php

namespace App\Livewire\Community;

use Livewire\Component;
use App\Models\Community;

class Edit extends Component
{
    public ?Community $community = null;
    
    public function mount(Community $community): void
    {
        $this->community = $community;
    }

    public function render()
    {
        return view('livewire.community.edit', [
            'community' => $this->community,
        ]);
    }
}
