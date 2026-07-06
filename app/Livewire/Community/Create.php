<?php

namespace App\Livewire\Community;

use Livewire\Component;
use App\Models\Community;

class Create extends Component
{
    public function render()
    {
        return view('livewire.community.create', [
            'community' => new Community(),
        ]);
    }
}
