<?php

namespace App\Livewire\OfferDestination;

use App\Models\OfferDestination;
use Livewire\Component;

class Edit extends Component
{
    public OfferDestination $offerDestination;

    public function mount(OfferDestination $offerDestination): void
    {
        $this->offerDestination = $offerDestination;
    }

    public function render()
    {
        return view('livewire.offer-destination.edit', [
            'offerDestination' => $this->offerDestination,
        ]);
    }
}