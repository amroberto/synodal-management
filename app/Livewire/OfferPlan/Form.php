<?php

namespace App\Livewire\OfferPlan;

use App\Enums\OfferInstanceEnum;
use App\Models\AccountPlan;
use App\Models\OfferDestination;
use App\Models\OfferPlan;
use Livewire\Component;

class Form extends Component
{
    public ?OfferPlan $offerPlan = null;

    public string $offer_date = '';

    public string $liturgical_date = '';

    public string $offer_instance = '';

    public ?int $offer_destination_id = null;

    public ?int $account_plan_id = null;

    public bool $active = true;

    /**
     * Dados para os selects
     */
    public $offerDestinations = [];

    public $accountPlans = [];

    public array $instances = [];

    protected function rules(): array
    {
        return [

            'offer_date' => ['required', 'date'],

            'liturgical_date' => ['required', 'string', 'max:255'],

            'offer_instance' => ['required'],

            'offer_destination_id' => ['required', 'exists:offer_destinations,id'],

            'account_plan_id' => ['nullable', 'exists:account_plans,id'],

            'active' => ['boolean'],

        ];
    }

    public function mount(?OfferPlan $offerPlan = null): void
    {
        $this->offerPlan = $offerPlan;

        /*
        |--------------------------------------------------------------------------
        | Carrega os selects
        |--------------------------------------------------------------------------
        */

        $this->offerDestinations = OfferDestination::orderBy('name')->get();

        $this->accountPlans = AccountPlan::where('active', true)
            ->orderBy('code')
            ->get();

        $this->instances = OfferInstanceEnum::options();

        /*
        |--------------------------------------------------------------------------
        | Edit
        |--------------------------------------------------------------------------
        */

        if (! $this->offerPlan?->exists) {
            return;
        }

        $this->offer_date = $this->offerPlan->offer_date->format('Y-m-d');

        $this->liturgical_date = $this->offerPlan->liturgical_date;

        $this->offer_instance = $this->offerPlan->offer_instance->value;

        $this->offer_destination_id = $this->offerPlan->offer_destination_id;

        $this->account_plan_id = $this->offerPlan->account_plan_id;

        $this->active = $this->offerPlan->active;
    }

    public function save()
    {
        $this->validate();

        $data = [

            'offer_date' => $this->offer_date,

            'liturgical_date' => $this->liturgical_date,

            'offer_instance' => $this->offer_instance,

            'offer_destination_id' => $this->offer_destination_id,

            'account_plan_id' => $this->account_plan_id,

            'active' => $this->active,

        ];

        if ($this->offerPlan && $this->offerPlan->exists) {

            $this->offerPlan->update($data);

            $message = 'Plano de Oferta atualizado com sucesso!';

        } else {

            $this->offerPlan = OfferPlan::create($data);

            $message = 'Plano de Oferta criado com sucesso!';
        }

        session()->flash('message', $message);

        return redirect()->route('offer-plans.index');
    }

    public function render()
    {
        return view('livewire.offer-plan.form');
    }
}