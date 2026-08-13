<?php

namespace App\Livewire\FinancialAccount;

use App\Models\FinancialAccount;
use Livewire\Component;

class Edit extends Component
{
    public FinancialAccount $financialAccount;

    public function mount(FinancialAccount $financialAccount): void
    {
        $this->financialAccount = $financialAccount;
    }

    public function render()
    {
        return view('livewire.financial-account.edit');
    }
}