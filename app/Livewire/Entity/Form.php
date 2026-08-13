<?php

namespace App\Livewire\Entity;

use App\Enums\UnityTypeEnum;
use App\Helpers\BrazilianFormatter;
use App\Models\Entity;
use App\Models\Leadership;
use App\Models\Position;
use App\Models\Sector;
use App\Traits\GetAddressByCepTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Flux\Flux;

class Form extends Component
{
    use GetAddressByCepTrait;

    public ?Entity $entity = null;

    // Campos do formulário principal da Entidade
    public $corporate_name = '';
    public $fantasy_name = '';
    public string $unity_type = '';
    public $cnpj = '';
    public $cep = '';
    public $street = '';
    public $number = '';
    public $complement = '';
    public $neighborhood = '';
    public $city = '';
    public $state = '';
    public ?int $sector_id = null;
    public $phone = '';
    public $mobile = '';
    public $email = '';
    public $website = '';

    // Propriedades para o gerenciamento das Lideranças e do Modal
    public $selected_leadership_id = '';
    public $selected_position_id = '';
    public $editing_pivot_id = null;
    public $current_leaderships = [];

    protected function rules()
    {
        return [
            'corporate_name' => 'required|string|max:255',
            'fantasy_name'   => 'required|string|max:255',
            'cnpj'           => [
                'nullable',
                'size:14',
                Rule::unique('entities', 'cnpj')->ignore($this->entity?->id),
            ],
            'cep'            => 'nullable|size:8',
            'street'         => 'required|string|max:255',
            'number'         => 'nullable|string|max:20',
            'complement'     => 'nullable|string|max:100',
            'neighborhood'   => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'state'          => 'nullable|size:2',
            'sector_id'      => 'nullable|exists:sectors,id',
            'unity_type'     => 'required|in:' . implode(',', UnityTypeEnum::getValues()),
            'phone'          => 'nullable|string|max:20',
            'mobile'         => 'nullable|string|max:20',
        ];
    } 

    protected function messages()
    {
        return [
            'corporate_name.required' => 'O campo Razão Social é obrigatório.',
            'fantasy_name.required'   => 'O campo Nome Fantasia é obrigatório.',
            'street.required'         => 'O campo Rua é obrigatório.',
            'neighborhood.required'   => 'O campo Bairro é obrigatório.',
            'city.required'           => 'O campo Cidade é obrigatório.',
        ];
    }
    
    public function mount(?Entity $entity = null): void
    {
        $this->entity = $entity;

        if ($this->entity?->exists) {
            $this->corporate_name  = $this->entity->corporate_name;
            $this->fantasy_name    = $this->entity->fantasy_name;
            $this->unity_type      = $this->entity->unity_type?->value ?? '';
            $this->cnpj            = $this->entity->cnpj;
            $this->cep             = $this->entity->cep;
            $this->street          = $this->entity->street;
            $this->number          = $this->entity->number;
            $this->complement      = $this->entity->complement;
            $this->neighborhood    = $this->entity->neighborhood;
            $this->city            = $this->entity->city;
            $this->state           = $this->entity->state;
            $this->sector_id       = $this->entity->sector_id;
            $this->phone           = $this->entity->phone;
            $this->mobile          = $this->entity->mobile;
            $this->email           = $this->entity->email;
            $this->website         = $this->entity->website;

            $this->loadLeaderships();
        }
    }

    public function loadLeaderships()
    {
        if ($this->entity?->exists) {
            $this->current_leaderships = DB::table('entity_leaderships')
                ->join('leaderships', 'entity_leaderships.leadership_id', '=', 'leaderships.id')
                ->join('positions', 'entity_leaderships.position_id', '=', 'positions.id')
                ->where('entity_leaderships.entity_id', $this->entity->id)
                ->select(
                    'entity_leaderships.id as pivot_id',
                    'leaderships.name as leader_name',
                    'positions.name as position_name'
                )
                ->orderBy('entity_leaderships.position_id', 'asc')
                ->get()->toArray();
        }
    }

    /**
     * Limpa os campos e ordena a abertura do modal
     */
    public function openNewLeadershipModal()
    {
        $this->reset(['selected_leadership_id', 'selected_position_id', 'editing_pivot_id']);
        
        // Abre o modal diretamente pelo PHP usando o Flux UI
        Flux::modal('add-leadership-modal')->show();
    }

    public function editLeadership($pivotId)
    {
        $this->editing_pivot_id = $pivotId;

        $relation = DB::table('entity_leaderships')
            ->where('id', $pivotId)
            ->first();

        if ($relation) {
            $this->selected_leadership_id = $relation->leadership_id;
            $this->selected_position_id = $relation->position_id;

            // Abre o modal diretamente pelo PHP usando o Flux UI
            Flux::modal('add-leadership-modal')->show();
        }
    }

    public function addLeadership()
    {
        $this->validate([
            'selected_leadership_id' => 'required',
            'selected_position_id' => 'required',
        ], [
            'selected_leadership_id.required' => 'Selecione uma liderança.',
            'selected_position_id.required' => 'Selecione um cargo.',
        ]);

        if ($this->editing_pivot_id) {
            DB::table('entity_leaderships')
                ->where('id', $this->editing_pivot_id)
                ->update([
                    'leadership_id' => $this->selected_leadership_id,
                    'position_id' => $this->selected_position_id,
                    'updated_at' => now(),
                ]);
            
            $headingMessage = 'Vínculo de liderança atualizado!';
        } else {
            $this->entity->leaderships()->attach($this->selected_leadership_id, [
                'position_id' => $this->selected_position_id
            ]);

            $headingMessage = 'Liderança vinculada com sucesso!';
        }

        $this->reset(['selected_leadership_id', 'selected_position_id', 'editing_pivot_id']);
        $this->loadLeaderships();
        
        // Fecha o modal usando a Facade estável do Flux
        Flux::modal('add-leadership-modal')->close();
        
        $this->dispatch('toast', variant: 'success', heading: $headingMessage);
    }

    public function removeLeadership($pivotId)
    {
        DB::table('entity_leaderships')->where('id', $pivotId)->delete();
        $this->loadLeaderships();
        
        $this->dispatch('toast', variant: 'success', heading: 'Liderança removida da entidade.');
    }

    #[Computed]
    public function leadershipsList()
    {
        return Leadership::orderBy('name')->get();
    }

    #[Computed]
    public function positionsList()
    {
        return Position::orderBy('name')->get();
    }

    public function updatedCep($value)
    {
        $clean = BrazilianFormatter::clean($value);
        $this->cep = $clean;

        if (strlen($clean) === 8) {
            $this->getAddressByCep('cep');
        }
    }

    public function updatedCnpj($value) { $this->cnpj = BrazilianFormatter::clean($value); }
    public function updatedPhone($value) { $this->phone = BrazilianFormatter::clean($value); }
    public function updatedMobile($value) { $this->mobile = BrazilianFormatter::clean($value); }

    #[Computed]
    public function formattedCep() { return $this->cep ? BrazilianFormatter::formatCep($this->cep) : ''; }
    #[Computed]
    public function formattedCnpj() { return $this->cnpj ? BrazilianFormatter::formatCnpj($this->cnpj) : ''; }
    #[Computed]
    public function formattedPhone() { return $this->phone ? BrazilianFormatter::formatPhone($this->phone) : ''; }
    #[Computed]
    public function formattedMobile() { return $this->mobile ? BrazilianFormatter::formatMobile($this->mobile) : ''; }

    public function save()
    {
        $this->validate();

        $data = [
            'corporate_name' => $this->corporate_name,
            'fantasy_name'   => $this->fantasy_name,
            'cnpj'           => BrazilianFormatter::clean($this->cnpj),
            'cep'            => $this->cep,
            'unity_type'     => $this->unity_type,
            'street'         => $this->street,
            'number'         => $this->number,
            'complement'     => $this->complement,
            'neighborhood'   => $this->neighborhood,
            'city'           => $this->city,
            'state'          => $this->state,
            'sector_id'      => $this->sector_id ?: null,
            'phone'          => $this->phone,
            'mobile'         => $this->mobile,
            'email'          => $this->email,
            'website'        => $this->website,
        ];

        if ($this->entity && $this->entity->exists) {
            $this->entity->update($data);
            $message = 'Entidade atualizada com sucesso';
        } else {
            $this->entity = Entity::create($data);
            $message = 'Entidade criada com sucesso!';
        }

        session()->flash('message', $message);
        return redirect()->route('entities.index');
    }

    public function render()
    {
        $sectors = Sector::all();
        return view('livewire.entity.form', [
            'sectors' => $sectors
        ]);
    }
}