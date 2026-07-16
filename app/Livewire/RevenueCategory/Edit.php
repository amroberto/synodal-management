<?php

namespace App\Livewire\RevenueCategory;

use App\Models\RevenueCategory;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Flux\Flux;

class Edit extends Component
{
    public $name, $revenueCategoryId;

    #[On('edit-revenue-category')]
    public function editRevenueCategory($id)
    {
        $revenue_category = RevenueCategory::findOrFail($id);
        $this->revenueCategoryId = $revenue_category->id;
        $this->name = $revenue_category->name;

        // Abre o modal
        Flux::modal('edit-revenue-category')->show();
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('revenue-categories', 'name')->ignore($this->revenueCategoryId)],
        ]);

        $revenue_category = RevenueCategory::findOrFail($this->revenueCategoryId);
        $revenue_category->name = $this->name;
        $revenue_category->save();

        session()->flash('success', 'Categoria das receitas atualizada com sucesso!');

        $this->redirectRoute('revenue-categories.index', navigate: true);

        // Fecha o modal
        Flux::modal('edit-revenue-category')->close();
    }

    public function render()
    {
        return view('livewire.revenue-category.edit');
    }
}
