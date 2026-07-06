<?php

namespace App\Livewire\Community;

use App\Enums\UnityTypeEnum;
use App\Helpers\BrazilianFormatter;
use App\Models\Community;
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

    public ?Community $community = null;

    // Campos do formulário principal da Comunidade
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
    public $sector_id = '';
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
                Rule::unique('communities', 'cnpj')->ignore($this->community?->id),
            ],
            'cep'            => 'nullable|size:8',
            'street'         => 'required|string|max:255',
            'number'         => 'nullable|string|max:20',
            'complement'     => 'nullable|string|max:100',
            'neighborhood'   => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'state'          => 'nullable|size:2',
            'sector_id'      => 'required|exists:sectors,id',
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
            'sector_id.required'      => 'O núcleo é obrigatório!',
        ];
    }
    
    public function mount(?Community $community = null): void
    {
        $this->community = $community;

        if ($this->community?->exists) {
            $this->corporate_name  = $this->community->corporate_name;
            $this->fantasy_name    = $this->community->fantasy_name;
            $this->unity_type      = $this->community->unity_type?->value ?? '';
            $this->cnpj            = $this->community->cnpj;
            $this->cep             = $this->community->cep;
            $this->street          = $this->community->street;
            $this->number          = $this->community->number;
            $this->complement      = $this->community->complement;
            $this->neighborhood    = $this->community->neighborhood;
            $this->city            = $this->community->city;
            $this->state           = $this->community->state;
            $this->sector_id       = $this->community->sector_id;
            $this->phone           = $this->community->phone;
            $this->mobile          = $this->community->mobile;
            $this->email           = $this->community->email;
            $this->website         = $this->community->website;

            $this->loadLeaderships();
        }
    }

    public function loadLeaderships()
    {
        if ($this->community?->exists) {
            $this->current_leaderships = DB::table('community_leaderships')
                ->join('leaderships', 'community_leaderships.leadership_id', '=', 'leaderships.id')
                ->join('positions', 'community_leaderships.position_id', '=', 'positions.id')
                ->where('community_leaderships.community_id', $this->community->id)
                ->select(
                    'community_leaderships.id as pivot_id',
                    'leaderships.name as leader_name',
                    'positions.name as position_name'
                )
                ->orderBy('community_leaderships.position_id', 'asc')
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

        $relation = DB::table('community_leaderships')
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
            DB::table('community_leaderships')
                ->where('id', $this->editing_pivot_id)
                ->update([
                    'leadership_id' => $this->selected_leadership_id,
                    'position_id' => $this->selected_position_id,
                    'updated_at' => now(),
                ]);
            
            $headingMessage = 'Vínculo de liderança atualizado!';
        } else {
            $this->community->leaderships()->attach($this->selected_leadership_id, [
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
        DB::table('community_leaderships')->where('id', $pivotId)->delete();
        $this->loadLeaderships();
        
        $this->dispatch('toast', variant: 'success', heading: 'Liderança removida da comunidade.');
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
            'sector_id'      => $this->sector_id,
            'phone'          => $this->phone,
            'mobile'         => $this->mobile,
            'email'          => $this->email,
            'website'        => $this->website,
        ];

        if ($this->community && $this->community->exists) {
            $this->community->update($data);
            $message = 'Comunidade atualizada com Sucesso';
        } else {
            $this->community = Community::create($data);
            $message = 'Comunidade criada com sucesso!';
        }

        session()->flash('message', $message);
        return redirect()->route('communities.index');
    }

    public function render()
    {
        $sectors = Sector::all();
        return view('livewire.community.form', [
            'sectors' => $sectors
        ]);
    }
}