<?php

namespace App\Livewire\Position;

use App\Models\Position;
use Livewire\Component;
use Flux\Flux;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $positionId;

    public function edit($id)
    {
        $this->dispatch('edit-position', $id);
    }

    public function delete($id)
    {
        $this->positionId = $id;
        Flux::modal('delete-position')->show();
    }

    public function deletePosition ()
    {
        Position::find($this->positionId)->delete();
        Flux::modal('delete-position')->close();
        session()->flash('success', 'Cargo deletado com sucesso!');
        $this->redirectRoute('positions.index', navigate: true);
    }

    public function render()
    {
        $positions = Position::orderBy('created_at', 'asc')->paginate(10);
        return view('livewire.position.index', ['positions' => $positions])->layout('layouts.app');
    }
}
