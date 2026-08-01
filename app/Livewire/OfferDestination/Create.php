<?php

namespace App\Livewire\OfferDestination;

use App\Models\OfferDestination;
use Livewire\Component;

class Create extends Component
{
    public function render()
    {
        return view('livewire.offer-destination.create', [
            'offerDestination' => new OfferDestination(),
        ]);
    }
}