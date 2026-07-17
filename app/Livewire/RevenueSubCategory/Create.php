<?php

namespace App\Livewire\RevenueSubCategory;

use Livewire\Component;
use App\Models\RevenueSubCategory;

class Create extends Component
{
    public function render()
    {
        return view('livewire.revenue-sub-category.create', [
            'subcategory' => new RevenueSubCategory(),
        ]);
    }
}