<?php

namespace App\Livewire\OfferPlan;

use App\Enums\OfferInstanceEnum;
use App\Models\AccountPlan;
use App\Models\CostCenter;
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

    public ?int $cost_center_id = null;

    public bool $active = true;

    /*
    |--------------------------------------------------------------------------
    | Busca do Plano de Contas
    |--------------------------------------------------------------------------
    */

    public string $accountPlanSearch = '';

    public bool $showAccountPlanResults = false;

    /*
    |--------------------------------------------------------------------------
    | Dados para os selects
    |--------------------------------------------------------------------------
    */

    public $offerDestinations = [];

    public $costCenters = [];

    public array $instances = [];

    /**
     * Regras de validação.
     */
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

            'account_plan_id' => [
                'nullable',
                'exists:account_plans,id',
            ],

            'cost_center_id' => [
                'required',
                'exists:cost_centers,id',
            ],

            'active' => [
                'boolean',
            ],
        ];
    }

    /**
     * Inicialização do formulário.
     */
    public function mount(?OfferPlan $offerPlan = null): void
    {
        $this->offerPlan = $offerPlan;

        /*
        |--------------------------------------------------------------------------
        | Carrega os selects
        |--------------------------------------------------------------------------
        */

        $this->offerDestinations = OfferDestination::query()
            ->orderBy('name')
            ->get();

        $this->costCenters = CostCenter::query()
            ->where('active', true)
            ->orderBy('name')
            ->get();

        $this->instances = OfferInstanceEnum::options();

        /*
        |--------------------------------------------------------------------------
        | Edição
        |--------------------------------------------------------------------------
        */

        if (! $this->offerPlan?->exists) {
            return;
        }

        $this->offer_date = $this->offerPlan->offer_date->format('Y-m-d');

        $this->liturgical_date = $this->offerPlan->liturgical_date;

        $this->offer_instance = $this->offerPlan->offer_instance->value;

        $this->offer_destination_id =
            $this->offerPlan->offer_destination_id;

        $this->account_plan_id =
            $this->offerPlan->account_plan_id;

        $this->cost_center_id =
            $this->offerPlan->cost_center_id;

        $this->active = $this->offerPlan->active;

        /*
        |--------------------------------------------------------------------------
        | Mostra o Plano de Contas selecionado no campo de busca
        |--------------------------------------------------------------------------
        */

        if ($this->account_plan_id) {

            $accountPlan = AccountPlan::find($this->account_plan_id);

            if ($accountPlan) {

                $this->accountPlanSearch =
                    $accountPlan->code . ' - ' . $accountPlan->description;
            }
        }
    }

    /**
     * Filtra os planos de contas conforme o usuário digita.
     */
    public function updatedAccountPlanSearch(): void
    {
        $this->showAccountPlanResults = true;

        /*
        |--------------------------------------------------------------------------
        | Se o usuário apagou o campo, remove a seleção
        |--------------------------------------------------------------------------
        */

        if (trim($this->accountPlanSearch) === '') {

            $this->account_plan_id = null;

            return;
        }
    }

    /**
     * Retorna os planos de contas filtrados.
     */
    public function getFilteredAccountPlansProperty()
    {
        $search = trim($this->accountPlanSearch);

        if ($search === '') {

            return AccountPlan::query()
                ->where('active', true)
                ->orderBy('description')
                ->limit(20)
                ->get();
        }

        return AccountPlan::query()
            ->where('active', true)
            ->where(function ($query) use ($search) {

                $query
                    ->where('description', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");

            })
            ->orderBy('description')
            ->limit(20)
            ->get();
    }

    /**
     * Seleciona um plano de contas.
     */
    public function selectAccountPlan(int $id): void
    {
        $accountPlan = AccountPlan::find($id);

        if (! $accountPlan) {
            return;
        }

        $this->account_plan_id = $accountPlan->id;

        $this->accountPlanSearch =
            $accountPlan->code . ' - ' . $accountPlan->description;

        $this->showAccountPlanResults = false;
    }

    /**
     * Limpa o plano de contas selecionado.
     */
    public function clearAccountPlan(): void
    {
        $this->account_plan_id = null;

        $this->accountPlanSearch = '';

        $this->showAccountPlanResults = false;
    }

    /**
     * Salva o formulário.
     */
    public function save()
    {
        $this->validate();

        $data = [

            'offer_date' => $this->offer_date,

            'liturgical_date' => $this->liturgical_date,

            'offer_instance' => $this->offer_instance,

            'offer_destination_id' => $this->offer_destination_id,

            'account_plan_id' => $this->account_plan_id,

            'cost_center_id' => $this->cost_center_id,

            'active' => $this->active,
        ];

        /*
        |--------------------------------------------------------------------------
        | Atualização
        |--------------------------------------------------------------------------
        */

        if ($this->offerPlan && $this->offerPlan->exists) {

            $this->offerPlan->update($data);

            $message = 'Plano de Oferta atualizado com sucesso!';

        } else {

            /*
            |--------------------------------------------------------------------------
            | Criação
            |--------------------------------------------------------------------------
            */

            $this->offerPlan = OfferPlan::create($data);

            $message = 'Plano de Oferta criado com sucesso!';
        }

        session()->flash('message', $message);

        return redirect()->route('offer-plans.index');
    }

    public function render()
    {
        return view('livewire.offer-plan.form', [

            'filteredAccountPlans' =>
                $this->filteredAccountPlans,
        ]);
    }
}