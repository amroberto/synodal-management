<?php

namespace App\Livewire\OfferPlan;

use App\Models\OfferPlan;
use Livewire\Component;

class Show extends Component
{
    public OfferPlan $offerPlan;


    public function mount(OfferPlan $offerPlan): void
    {
        $this->offerPlan = $offerPlan->load([
            'offerDestination',
            'accountPlan',
        ]);
    }


    public function render()
    {
        return view('livewire.offer-plan.show');
    }
}