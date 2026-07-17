<?php

namespace App\Livewire\RevenueSubCategory;

use Livewire\Component;
use App\Models\RevenueCategory;
use App\Models\RevenueSubCategory;

class Form extends Component
{

    public ?RevenueSubCategory $subcategory = null;


    public string $name = '';

    public ?string $description = null;

    public ?int $revenue_category_id = null;

    public bool $active = true;



    protected function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'revenue_category_id' => [
                'required',
                'exists:revenue_categories,id',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'active' => [
                'boolean',
            ],
        ];
    }



    protected $messages = [

        'name.required' =>
            'O nome da subcategoria é obrigatório.',

        'revenue_category_id.required' =>
            'A categoria da receita é obrigatória.',

    ];



    public function mount(?RevenueSubCategory $subcategory = null): void
    {
        $this->subcategory = $subcategory;


        if ($this->subcategory?->exists) {

            $this->name =
                $this->subcategory->name;

            $this->description =
                $this->subcategory->description;

            $this->revenue_category_id =
                $this->subcategory->revenue_category_id;

            $this->active =
                $this->subcategory->active;
        }
    }



    public function categories()
    {
        return RevenueCategory::orderBy('id')->get();
    }



    public function save()
    {
        $data = $this->validate();


        if ($this->subcategory?->exists) {

            $this->subcategory->update($data);

            $message =
                'Subcategoria atualizada com sucesso!';

        } else {

            RevenueSubCategory::create($data);

            $message =
                'Subcategoria criada com sucesso!';
        }


        session()->flash('message', $message);


        return redirect()
            ->route('revenue-sub-categories.index');
    }



    public function render()
    {
        return view(
            'livewire.revenue-sub-category.form',
            [
                'categories' => $this->categories(),
            ]
        );
    }
}