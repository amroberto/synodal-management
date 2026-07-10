<?php

namespace App\Livewire\AccountPlan;

use App\Models\AccountPlan;
use Livewire\Component;

class Show extends Component
{
    public AccountPlan $accountPlan;

    public function mount(AccountPlan $accountPlan)
    {
        $this->accountPlan = $accountPlan;
    }

    public function render()
    {
        return view('livewire.account-plan.show');
    }
}