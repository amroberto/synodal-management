<?php

namespace App\Livewire\Position;

use App\Models\Position;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Flux\Flux;

class Edit extends Component
{
    public $name, $positionId;

    #[On('edit-position')]
    public function editPosition($id)
    {
        $position = Position::findOrFail($id);
        $this->positionId = $position->id;
        $this->name = $position->name;

        // Abre o modal
        Flux::modal('edit-position')->show();
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('positions', 'name')->ignore($this->positionId)],
        ]);

        $position = Position::findOrFail($this->positionId);
        $position->name = $this->name;
        $position->save();

        session()->flash('success', 'Cargo atualizado com sucesso!');

        $this->redirectRoute('positions.index', navigate: true);

        // Fecha o modal
        Flux::modal('edit-position')->close();
    }

    public function render()
    {
        return view('livewire.position.edit');
    }
}
