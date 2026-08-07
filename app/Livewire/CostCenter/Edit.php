<?php

namespace App\Livewire\CostCenter;

use App\Models\CostCenter;
use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Edit extends Component
{
    public ?string $name = null;
    public ?string $code = null;
    public ?string $description = null;
    public ?bool $active = null;
    public ?int $costCenterId = null;

    #[On('edit-cost-center')]
    public function editCostCenter(int $id): void
    {
        $costCenter = CostCenter::findOrFail($id);
        $this->costCenterId = $costCenter->id;
        $this->name = $costCenter->name;
        $this->code = $costCenter->code;
        $this->description = $costCenter->description;
        $this->active = $costCenter->active;

        // Abre o modal
        Flux::modal('edit-cost-center')->show();
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('cost_centers', 'name')->ignore($this->costCenterId)],
            'code' => ['required', 'string', 'max:255', Rule::unique('cost_centers', 'code')->ignore($this->costCenterId)],
        ]);

        $costCenter = CostCenter::findOrFail($this->costCenterId);
        $costCenter->name = $this->name;
        $costCenter->code = $this->code;
        $costCenter->description = $this->description;
        $costCenter->active = $this->active;
        $costCenter->save();

        session()->flash('success', 'Centro de custo atualizado com sucesso!');

        $this->redirectRoute('cost-centers.index', navigate: true);

        // Fecha o modal
        Flux::modal('edit-cost-center')->close();
    }

    public function render()
    {
        return view('livewire.cost-center.edit');
    }
}
