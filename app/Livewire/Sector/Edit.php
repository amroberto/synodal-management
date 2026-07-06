<?php

namespace App\Livewire\Sector;

use App\Models\Sector;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Flux\Flux;


class Edit extends Component
{
    public $name, $sectorId;

    #[On('edit-sector')]
    public function editSector($id)
    {
        $sector = Sector::findOrFail($id);
        $this->sectorId = $sector->id;
        $this->name = $sector->name;

        // Abre o modal
        Flux::modal('edit-sector')->show();
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('sectors', 'name')->ignore($this->sectorId)],
        ]);

        $sector = Sector::findOrFail($this->sectorId);
        $sector->name = $this->name;
        $sector->save();

        session()->flash('success', 'Núcleo atualizado com sucesso!');

        $this->redirectRoute('sectors.index', navigate: true);

        // Fecha o modal
        Flux::modal('edit-sector')->close();
    }

    public function render()
    {
        return view('livewire.sector.edit');
    }
}
