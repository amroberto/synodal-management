<?php

namespace App\Livewire\OfferPlan;

use App\Models\OfferPlan;
use Livewire\Component;

class Edit extends Component
{
    public OfferPlan $offerPlan;


    public function mount(OfferPlan $offerPlan): void
    {
        $this->offerPlan = $offerPlan;
    }


    public function render()
    {
        return view('livewire.offer-plan.edit');
    }
}