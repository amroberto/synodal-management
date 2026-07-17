<?php

namespace App\Livewire\RevenueSubCategory;

use Livewire\Component;
use App\Models\RevenueSubCategory;

class Edit extends Component
{
    public RevenueSubCategory $subcategory;


    public function mount(RevenueSubCategory $revenueSubCategory): void
    {
        $this->subcategory = $revenueSubCategory;
    }


    public function render()
    {
        return view('livewire.revenue-sub-category.edit');
    }
}