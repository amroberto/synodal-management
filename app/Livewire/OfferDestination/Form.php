<?php

namespace App\Livewire\OfferDestination;

use App\Models\OfferDestination;
use Livewire\Component;

class Form extends Component
{
    public ?OfferDestination $offerDestination = null;
    
    public string $name = '';
    public ?string $description = null;
    public bool $active = true;

    protected function rules(): array
    {
        return [

            'name' => [
                'required',
                'string',
                'max:255',
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
            'O nome da Destinação da Oferta é obrigatória.',
    ];

    public function mount(?OfferDestination $offerDestination = null): void
    {
        $this->offerDestination = $offerDestination;

        if (! $offerDestination) {
            return;
        }

        $this->name = $offerDestination->name;
        $this->description = $offerDestination->description;
        $this->active = $offerDestination->active;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name'           => $this->name,
            'description'    => $this->description,
            'active'      => $this->active,
        ];

        if ($this->offerDestination && $this->offerDestination->exists) {
            $this->offerDestination->update($data);
            $message = 'Destinação de Oferta atualizada com sucesso!';
        } else {
            $this->offerDestination = OfferDestination::create($data);
            $message = 'Destinação de Oferta criada com sucesso!';
        }

        session()->flash('message', $message);

        return redirect()->route('offer-destinations.index');
    }

    public function render()
    {
        return view('livewire.offer-destination.form');
    }
}