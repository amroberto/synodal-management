<?php

namespace App\Livewire\CostCenter;

use App\Models\CostCenter;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';
    public string $code = '';
    public string $description = '';
    public bool $active = true;

    

    protected $rules = [
        'name' => 'required|string|max:255|unique:cost_centers,name',
        'code' => 'required|string|max:255|unique:cost_centers,code',
        'description' => 'nullable|string|max:255',
        'active' => 'boolean',
    ];

    protected $messages = [
        'name.required' => 'O NOME é um campo obrigatório.',
        'name.string' => 'O campo NOME deve ser do tipo texto.',
        'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
        'name.unique' => 'Já existe este nome cadastrado',
        'code.required' => 'O CÓDIGO é um campo obrigatório.',
        'code.string' => 'O campo CÓDIGO deve ser do tipo texto.',
        'code.max' => 'O campo CÓDIGO deve ter no máximo 255 caracteres.',
        'code.unique' => 'Já existe este código cadastrado',
        'description.string' => 'O campo DESCRIÇÃO deve ser do tipo texto.',
        'description.max' => 'O campo DESCRIÇÃO deve ter no máximo 255 caracteres.',
        'active.boolean' => 'O campo ATIVO deve ser do tipo booleano.',
    ];

    public function save()
    {
        $this->validate();

        CostCenter::create([
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'active' => $this->active,
        ]);

        $this->reset();
      
        session()->flash('success', 'Centro de custo criado com sucesso!');

        $this->redirectRoute('cost-centers.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.cost-center.create');
    }
}
