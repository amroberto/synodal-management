<?php

namespace App\Livewire\RevenueSubCategory;

use Livewire\Component;
use App\Models\RevenueSubCategory;
use App\Models\Leadership;
use Flux\Flux;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';  
    
    public $subcategoryId;

    public function clearSearch()
    {
        $this->search = '';
    }

    public function updatedSearch()
    {
        $subcategories = RevenueSubCategory::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('revenue_category_id', 'asc')
            ->paginate(10);
        return view('livewire.revenue-sub-category.index', ['subcategories' => $subcategories]);
    }
 
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->dispatch('edit-revenue-sub-category', $id);
    }

    public function delete($id)
    {
        $this->subcategoryId = $id;
        Flux::modal('delete-sub-category')->show();
    }

    public function deleteSubCategory ()
    {
        RevenueSubCategory::find($this->subcategoryId)->delete();
        Flux::modal('delete-sub-category')->close();
        session()->flash('success', 'Subcategoria deletada com sucesso!');
        $this->redirectRoute('revenue-sub-category.index', navigate: true);
    }   

    public function render()
    {
        $subcategories = RevenueSubCategory::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('revenue_category_id', 'asc')
            ->paginate(10);
        return view('livewire.revenue-sub-category.index', ['subcategories' => $subcategories]);
    }
}
