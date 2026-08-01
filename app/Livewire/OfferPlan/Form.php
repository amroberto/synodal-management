<?php

namespace App\Livewire\OfferPlan;

use App\Enums\OfferInstanceEnum;
use App\Models\OfferDestination;
use App\Models\OfferPlan;
use Livewire\Component;

class Form extends Component
{
    public ?OfferPlan $offerPlan = null;


    public string $offer_date = '';

    public string $liturgical_date = '';

    public ?string $offer_instance = null;

    public ?int $offer_destination_id = null;

    public bool $active = true;


    protected function rules(): array
    {
        return [

            'offer_date' => [
                'required',
                'date',
            ],

            'liturgical_date' => [
                'required',
                'string',
                'max:255',
            ],

            'offer_instance' => [
                'required',
            ],

            'offer_destination_id' => [
                'required',
                'exists:offer_destinations,id',
            ],

            'active' => [
                'boolean',
            ],

        ];
    }


    protected $messages = [

        'offer_date.required' =>
            'A data da oferta é obrigatória.',

        'liturgical_date.required' =>
            'A data litúrgica é obrigatória.',

        'offer_instance.required' =>
            'A instância da oferta é obrigatória.',

        'offer_destination_id.required' =>
            'A destinação da oferta é obrigatória.',

    ];

    public function mount(?OfferPlan $offerPlan = null): void
    {
        $this->offerPlan = $offerPlan;


        if ($this->offerPlan?->exists) {

            $this->offer_date =
                $this->offerPlan->offer_date
                    ->format('Y-m-d');


            $this->liturgical_date =
                $this->offerPlan->liturgical_date;


            $this->offer_instance =
                $this->offerPlan->offer_instance->value;


            $this->offer_destination_id =
                $this->offerPlan->offer_destination_id;


            $this->active =
                $this->offerPlan->active;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'offer_date' => $this->offer_date,
            'liturgical_date' =>
                $this->liturgical_date,
            'offer_instance' =>
                $this->offer_instance,
            'offer_destination_id' =>
                $this->offer_destination_id,
            'active' =>
                $this->active,
        ];

        if ($this->offerPlan && $this->offerPlan->exists) {
            $this->offerPlan->update($data);
            $message =
                'Plano de Oferta atualizado com sucesso!';
        } else {
            $this->offerPlan =
                OfferPlan::create($data);
            $message =
                'Plano de Oferta criado com sucesso!';
        }

        session()->flash(
            'message',
            $message
        );

        return redirect()
            ->route('offer-plans.index');
    }

    public function render()
    {
        return view('livewire.offer-plan.form', [

            'destinations' =>
                OfferDestination::where('active', true)
                    ->orderBy('name')
                    ->get(),

            'instances' =>
                OfferInstanceEnum::cases(),

        ]);
    }
}