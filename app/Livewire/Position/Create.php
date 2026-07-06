<?php

namespace App\Livewire\Position;

use Livewire\Component;
use App\Models\Position;

class Create extends Component
{
    public string $name = '';

    protected $rules = [
        'name' => 'required|string|max:255|unique:positions,name',
    ];

    protected $messages = [
        'name.required' => 'O NOME é um campo obrigatório.',
        'name.string' => 'O campo NOME deve ser do tipo texto.',
        'name.max' => 'O campo nome deve ter no máximo 255 caracteres.',
        'name.unique' => 'Já existe este nome cadastrado'
    ];

    public function save()
    {
        $this->validate();

        Position::create([
            'name' => $this->name,
        ]);

        $this->reset();
      
        session()->flash('success', 'Cargo criado com sucesso!');

        $this->redirectRoute('positions.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.position.create');
    }
}
