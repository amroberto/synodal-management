<?php

namespace App\Livewire\CostCenter;

use App\Models\CostCenter;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?int $costCenterId = null;

    public function edit(int $id)
    {
        $this->dispatch('edit-cost-center', $id);
    }

    public function delete(int $id)
    {
        $this->costCenterId = $id;
        Flux::modal('delete-cost-center')->show();
    }

    public function deleteCostCenter ()
    {
        CostCenter::find($this->costCenterId)->delete();
        Flux::modal('delete-cost-center')->close();
        session()->flash('success', 'Centro de custo deletado com sucesso!');
        $this->redirectRoute('cost-centers.index', navigate: true);
    }

    public function render()
    {
        $costCenters = CostCenter::orderBy('created_at', 'asc')->paginate(10);
        return view('livewire.cost-center.index', ['costCenters' => $costCenters])->layout('layouts.app');
    }    
}
