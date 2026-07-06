<?php

namespace App\Livewire\Sector;

use App\Models\Sector;
use Livewire\Component;
use Flux\Flux;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $sectorId;

    public function edit($id)
    {
        $this->dispatch('edit-sector', $id);
    }

    public function delete($id)
    {
        $this->sectorId = $id;
        Flux::modal('delete-sector')->show();
    }

    public function deleteSector ()
    {
        Sector::find($this->sectorId)->delete();
        Flux::modal('delete-sector')->close();
        session()->flash('success', 'Núcleo deletado com sucesso!');
        $this->redirectRoute('sectors.index', navigate: true);
    }

    public function render()
    {
        $sectors = Sector::orderBy('created_at', 'asc')->paginate(10);
        return view('livewire.sector.index', ['sectors' => $sectors])->layout('layouts.app');
    }    
}
