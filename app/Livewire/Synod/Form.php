<?php

namespace App\Livewire\Synod;

use App\Helpers\BrazilianFormatter;
use App\Models\Synod;
use App\Traits\GetAddressByCepTrait;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads; // Importante para o upload de arquivos

class Form extends Component
{
    use GetAddressByCepTrait;
    use WithFileUploads; // Habilita o upload no componente

    public ?Synod $synod = null;

    // Propriedades do formulário
    public ?string $fantasy_name = null;
    public ?string $corporate_name = null;
    public ?string $cnpj = null;
    public ?string $cep = null;
    public ?string $street = null;
    public ?string $number = null;
    public ?string $complement = null;
    public ?string $neighborhood = null;
    public ?string $city = null;
    public ?string $state = null;
    public ?string $phone = null;
    public ?string $mobile = null;
    public ?string $business_phone = null;
    public ?string $email = null;
    public ?string $website = null;
    
    // Propriedades para o controle do Logo
    public $logo = null; // Receberá o arquivo temporário do upload
    public ?string $currentLogo = null; // Armazenará o caminho do logo já existente

    protected function rules(): array
    {
        return [
            'corporate_name' => 'required|string|max:255',
            'fantasy_name'   => 'required|string|max:255',
            'cnpj' => [
                'nullable',
                'size:14',
                Rule::unique('synods', 'cnpj')->ignore($this->synod?->id),
            ],
            'cep'            => 'nullable|size:8',
            'street'         => 'required|string|max:255',
            'number'         => 'nullable|string|max:20',
            'complement'     => 'nullable|string|max:100',
            'neighborhood'   => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'state'          => 'nullable|size:2',
            'phone'          => 'nullable|string|max:20',
            'mobile'         => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255',
            'website'        => 'nullable|string|max:255', // Corrigido de ! para |
            'logo'           => 'nullable|image|max:2048', // Regra para validação da imagem (Máx: 2MB)
        ];
    }

    protected $messages = [
        'corporate_name.required' => 'O campo Razão Social é obrigatório.',
        'fantasy_name.required'   => 'O Campo Nome Fantasia é obrigatório.', // Corrigido o .required
        'cnpj.unique'             => 'Este CNPJ já está cadastrado!',
        'street.required'         => 'O logradouro é obrigatório.',
        'neighborhood.required'   => 'O bairro é obrigatório.',
        'city.required'           => 'A cidade é obrigatória.',
        'logo.image'              => 'O arquivo enviado deve ser uma imagem válida.',
        'logo.max'                => 'A imagem do logo não pode ser maior que 2MB.',
    ];

    public function mount(?Synod $synod = null): void
    {
        $this->synod = $synod;

        if ($this->synod?->exists) {
            $this->corporate_name = $this->synod->corporate_name;
            $this->fantasy_name   = $this->synod->fantasy_name;
            $this->cnpj           = $this->synod->cnpj;
            $this->cep            = $this->synod->cep;
            $this->street         = $this->synod->street;
            $this->number         = $this->synod->number;
            $this->complement     = $this->synod->complement;
            $this->neighborhood   = $this->synod->neighborhood;
            $this->city           = $this->synod->city;
            $this->state          = $this->synod->state;
            $this->phone          = $this->synod->phone;
            $this->mobile         = $this->synod->mobile;
            $this->email          = $this->synod->email;
            $this->website        = $this->synod->website ?? '';
            $this->currentLogo    = $this->synod->logo; // Guarda o caminho da imagem atual do banco
        }
    }

    public function updatedCep($value)
    {
        $clean = BrazilianFormatter::clean($value);
        if (strlen($clean) === 8) {
            $this->cep = $clean;
            $this->getAddressByCep('cep');
        }
    }

    #[Computed]
    public function synods()
    {
        return Synod::orderBy('fantasy_name')->get();
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

    public function save()
    {
        $this->validate();

        $data = [
            'corporate_name' => $this->corporate_name,
            'fantasy_name'   => $this->fantasy_name,
            'cnpj'           => BrazilianFormatter::clean($this->cnpj),
            'cep'            => BrazilianFormatter::clean($this->cep),
            'street'         => $this->street,
            'number'         => $this->number,
            'complement'     => $this->complement,
            'neighborhood'   => $this->neighborhood,
            'city'           => $this->city,
            'state'          => $this->state,
            'phone'          => BrazilianFormatter::clean($this->phone),
            'mobile'         => BrazilianFormatter::clean($this->mobile),
            'email'          => $this->email,
            'website'        => $this->website,
        ];

        // Processa o upload se uma nova imagem for enviada
        if ($this->logo) {
            // Salva na pasta 'logos' dentro do disco público (storage/app/public/logos)
            $data['logo'] = $this->logo->store('logos', 'public');
        }

        // Verifica se é atualização ou criação de um novo registro
        if ($this->synod && $this->synod->exists) {
            $this->synod->update($data);
            $message = 'Sínodo atualizado com sucesso!';
        } else {
            Synod::create($data);
            $message = 'Sínodo criado com sucesso!';
        }

        session()->flash('message', $message);

        return redirect()->route('communities.index');
    }

    /**
     * Helpers de Limpeza e Máscaras
     */
    protected function sanitizeFields(): void
    {
        $this->cnpj   = preg_replace('/\D/', '', (string) $this->cnpj);
        $this->cep    = preg_replace('/\D/', '', (string) $this->cep);
        $this->phone  = preg_replace('/\D/', '', (string) $this->phone);
        $this->mobile = preg_replace('/\D/', '', (string) $this->mobile);
    }

    protected function formatCnpj(?string $value): ?string
    {
        return $value
            ? preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $value)
            : null;
    }

    protected function formatCep(?string $value): ?string
    {
        return $value
            ? preg_replace('/(\d{5})(\d{3})/', '$1-$2', $value)
            : null;
    }

    protected function formatPhone(?string $value): ?string
    {
        return $value
            ? preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $value)
            : null;
    }

    protected function formatMobile(?string $value): ?string
    {
        return $value
            ? preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $value)
            : null;
    }
    
    public function render()
    {
        return view('livewire.synod.form', [
            'synods' => $this->synods,
        ]);
    }
}