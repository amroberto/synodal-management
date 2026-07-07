<?php

namespace App\Livewire\RevenueCategory;
use App\Models\RevenueCategory;
use Livewire\Component;
use Flux\Flux;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $revenueCategoryId;

    public function edit($id)
    {
        $this->dispatch('edit-revenue_category', $id);
    }

    public function delete($id)
    {
        $this->revenueCategoryId = $id;
        Flux::modal('delete-revenue_category')->show();
    }

    public function deleteRevenueCategory ()
    {
        RevenueCategory::find($this->revenueCategoryId)->delete();
        Flux::modal('delete-revenue_category')->close();
        session()->flash('success', 'Categoria das receitas deletada com sucesso!');
        $this->redirectRoute('revenue_categories.index', navigate: true);
    }

    public function render()
    {
        $revenue_categories = RevenueCategory::orderBy('created_at', 'asc')->paginate(10);
        return view('livewire.revenue_category.index', ['revenue_categories' => $revenue_categories])->layout('layouts.app');
    }
}
