<?php

namespace App\Livewire\FinancialAccount;

use App\Models\FinancialAccount;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $financialAccounts = FinancialAccount::query()
            ->when(
                $this->search,
                fn ($query) => $query
                    ->where('code', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
            )
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.financial-account.index', [
            'financialAccounts' => $financialAccounts,
        ]);
    }
}