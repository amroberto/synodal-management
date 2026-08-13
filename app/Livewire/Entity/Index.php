<?php

namespace App\Livewire\Entity;

use Livewire\Component;
use App\Models\Entity;
use Flux\Flux;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $entityId;

    public function clearSearch()
    {
        $this->search = '';
    }

    public function updatedSearch()
    {
        $entities = Entity::where('fantasy_name', 'like', '%' . $this->search . '%')
            ->orderBy('sector_id', 'asc')
            ->paginate(10);
        return view('livewire.entity.index', ['entities' => $entities]);
    }

    public function edit($id)
    {
        $this->dispatch('edit-entity', $id);
    }
    
    public function delete($id)
    {
        $this->entityId = $id;
        Flux::modal('delete-entity')->show();
    }

    public function deleteEntity ()
    {
        Entity::find($this->entityId)->delete();
        Flux::modal('delete-entity')->close();
        session()->flash('success', 'Entidade deletada com sucesso!');
        $this->redirectRoute('entities.index', navigate: true);
    }
   
    public function render()
    {
        $entities = Entity::where('fantasy_name', 'like', '%' . $this->search . '%')
        ->orderBy('sector_id','asc')->paginate(10);
        return view('livewire.entity.index', ['entities' => $entities]);
    }
}
