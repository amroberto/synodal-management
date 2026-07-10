<?php

namespace App\Livewire\AccountPlan;

use App\Models\AccountPlan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.account-plan.index', [
            'accountPlans' => AccountPlan::query()
                ->when($this->search, function ($query) {
                    $query->where('code', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                })
                ->orderBy('code')
                ->paginate(15),
        ]);
    }
}