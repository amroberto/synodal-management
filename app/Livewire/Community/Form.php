<?php

namespace App\Livewire\Community;

use Livewire\Component;
use App\Models\Community;
use App\Models\Sector;
use App\Enums\UnityTypeEnum;
use Livewire\Attributes\Computed;
use Illuminate\Validation\Rule;
use App\Helpers\BrazilianFormatter;
use App\Traits\GetAddressByCepTrait;

class Form extends Component
{
    use GetAddressByCepTrait;

    public ?Community $community = null;

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
            'unity_type' => 'required|in:' . implode(',', UnityTypeEnum::getValues()),
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
        }
    }

    // Limpa ao digitar (mantém interno limpo)
    public function updatedCep($value)
    {
        $clean = BrazilianFormatter::clean($value);
        $this->cep = $clean;

        if (strlen($clean) === 8) {
            $this->getAddressByCep('cep');
        }
    }

    public function updatedCnpj($value)
    {
        $this->cnpj = BrazilianFormatter::clean($value);
    }

    public function updatedPhone($value)
    {
        $this->phone = BrazilianFormatter::clean($value);
    }

    public function updatedMobile($value)
    {
        $this->mobile = BrazilianFormatter::clean($value);
    }

    // Computed properties para EXIBIÇÃO com formatação (cacheadas!)
    #[Computed]
    public function formattedCep()
    {
        return $this->cep ? BrazilianFormatter::formatCep($this->cep) : '';
    }

    #[Computed]
    public function formattedCnpj()
    {
        return $this->cnpj ? BrazilianFormatter::formatCnpj($this->cnpj) : '';
    }

    #[Computed]
    public function formattedPhone()
    {
        return $this->phone ? BrazilianFormatter::formatPhone($this->phone) : '';
    }

    #[Computed]
    public function formattedMobile()
    {
        return $this->mobile ? BrazilianFormatter::formatMobile($this->mobile) : '';
    }

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
            $message = 'Comunidade atualizada com sucesso!';
        } else {
            $this->community = Community::create($data);
            $message = 'Comunidade criada com sucesso!';
        }

        session()->flash('message', $message);

        return redirect()->route('communities.index');
    }

    /**
     * Helpers
     */
    protected function sanitizeFields(): void
    {
        $this->cnpj   = preg_replace('/\D/', '', (string) $this->cnpj);
        $this->cep    = preg_replace('/\D/', '', (string) $this->cep);
        $this->phone  = preg_replace('/\D/', '', (string) $this->phone);
        $this->mobile = preg_replace('/\D/', '', (string) $this->mobile);
    }

    public function render()
    {
        $sectors = Sector::all();
        return view('livewire.community.form', ['sectors' => $sectors]);
    }
}
