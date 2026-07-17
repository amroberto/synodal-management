<?php

namespace App\Livewire\RevenueCategory;
use App\Models\RevenueCategory;
use Livewire\Component;
use Flux\Flux;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $categoryId;

    public function edit($id)
    {
        $this->dispatch('edit-revenue-category', $id);
    }

    public function delete($id)
    {
        $this->categoryId = $id;
        Flux::modal('delete-revenue-category')->show();
    }

    public function deleteRevenueCategory ()
    {
        RevenueCategory::find($this->categoryId)->delete();
        Flux::modal('delete-revenue-category')->close();
        session()->flash('success', 'Categoria deletada com sucesso!');
        $this->redirectRoute('revenue-categories.index', navigate: true);
    }

    public function render()
    {
        $categories = RevenueCategory::orderBy('created_at', 'asc')->paginate(10);
        return view('livewire.revenue-category.index', ['categories' => $categories])->layout('layouts.app');
    }
}