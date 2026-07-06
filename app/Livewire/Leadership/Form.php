<?php

namespace App\Livewire\Leadership;

use Livewire\Component;
use App\Models\Community;
use App\Models\Leadership;
use Illuminate\Validation\Rule;
use App\Enums\GenderEnum;
use Livewire\Attributes\Computed;
use App\Helpers\BrazilianFormatter;
use App\Traits\GetAddressByCepTrait;

class Form extends Component
{
    use GetAddressByCepTrait;

    public ?Leadership $leadership = null;

    public string $name = '';
    public ?string $rg = null;
    public ?string $birthdate = null;
    public ?string $cpf = null;
    public string $gender = 'Male';
    public string $community_id = '';
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
    public bool $is_active = true;
    public ?string $email = null;

    protected function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'cpf' => [
                'nullable',
                'size:11',
                Rule::unique('leaderships', 'cpf')->ignore($this->leadership?->id),
            ],
            'community_id'  => 'required|exists:communities,id',
            'gender'        => 'required|in:' . implode(',', GenderEnum::getValues()),
            'cep'           => 'nullable|size:8',
            'street'        => 'required|string|max:255',
            'number'        => 'nullable|string|max:20',
            'complement'    => 'nullable|string|max:100',
            'neighborhood'  => 'required|string|max:100',
            'city'          => 'required|string|max:100',
            'state'         => 'nullable|size:2',
            'phone'         => 'nullable|string|max:20',
            'mobile'        => 'nullable|string|max:20',
            'business_phone'=> 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
        ];
    }

    protected $messages = [
        'name.required'         => 'O nome é obrigatório.',
        'cpf.unique'            => 'Este CPF já está cadastado!',
        'community_id.required' => 'A comunidade é obrigatória.',
        'gender.required'       => 'O gênero é obrigatório.',
        'community_id.exists'   => 'A comunidade selecionada é inválida.',
        'street.required'       => 'O logradouro é obrigatório.',
        'neighborhood.required' => 'O bairro é obrigatório.',
        'city.required'         => 'A cidade é obrigatória.',
        'cpf.unique'            => 'Este CPF já está cadastrado para outra liderança.',
    ];

    
    public function mount(?Leadership $leadership = null): void
    {
        $this->leadership = $leadership;

        if ($this->leadership?->exists) {
            $this->name        = $this->leadership->name;
            $this->cpf         = $this->leadership->cpf;
            $this->rg          = $this->leadership->rg;
            $this->birthdate   = $this->leadership->birthdate->format('d-m-Y');
            $this->gender      = $this->leadership->gender ?? 'Male';
            $this->community_id = $this->leadership->community_id;
            $this->is_active = (bool) $this->leadership->is_active;
            $this->cep         = $this->leadership->cep;
            $this->street      = $this->leadership->street;
            $this->number      = $this->leadership->number;
            $this->complement  = $this->leadership->complement;
            $this->neighborhood= $this->leadership->neighborhood;
            $this->city        = $this->leadership->city;
            $this->state       = $this->leadership->state;
            $this->phone       = $this->leadership->phone;
            $this->mobile      = $this->leadership->mobile;
            $this->email       = $this->leadership->email;
            $this->business_phone = $this->leadership->business_phone ?? '';
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
    public function communities()
    {
        return Community::orderBy('fantasy_name')->get();
    }

    public function updatedBirthDate($value)
    {
        $this->birthdate = preg_replace('/(\d{2})\/(\d{2})\/(\d{4})/', '$3-$2-$1', $value);
    }

    public function updatedRg($value)
    {
        $this->rg = preg_replace('/\D/', '', (string) $value);
    }

    public function updatedCpf($value)
    {
        $this->cpf = BrazilianFormatter::clean($value);
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
            'name'           => $this->name,
            'cpf'            => BrazilianFormatter::clean($this->cpf),
            'rg'             => BrazilianFormatter::clean($this->rg),
            'community_id'   => $this->community_id,
            'gender'         => $this->gender,
            'birthdate'      => $this->birthdate,
            'cep'            => BrazilianFormatter::clean($this->cep),
            'street'         => $this->street,
            'number'         => $this->number,
            'complement'     => $this->complement,
            'neighborhood'   => $this->neighborhood,
            'city'           => $this->city,
            'state'          => $this->state,
            'phone'          => BrazilianFormatter::clean($this->phone),
            'mobile'         => BrazilianFormatter::clean($this->mobile),
            'business_phone' => BrazilianFormatter::clean($this->business_phone ?? ''),
            'email'          => $this->email,
            'is_active'      => $this->is_active,
        ];

        if ($this->leadership && $this->leadership->exists) {
            $this->leadership->update($data);
            $message = 'Liderança atualizada com sucesso!';
        } else {
            $this->leadership = Leadership::create($data);
            $message = 'Liderança criada com sucesso!';
        }

        session()->flash('message', $message);

        return redirect()->route('leaderships.index');
    }

        /**
     * Helpers
     */
    protected function sanitizeFields(): void
    {
        $this->cpf   = preg_replace('/\D/', '', (string) $this->cpf);
        $this->cep    = preg_replace('/\D/', '', (string) $this->cep);
        $this->phone  = preg_replace('/\D/', '', (string) $this->phone);
        $this->business_phone  = preg_replace('/\D/', '', (string) $this->business_phone);
        $this->mobile = preg_replace('/\D/', '', (string) $this->mobile);
    }

    protected function formatCpf(?string $value): ?string
    {
        return $value
            ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $value)
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

    protected function formatBusinessPhone(?string $value): ?string
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
        return view('livewire.leadership.form', [
            'communities' => $this->communities,
        ]);
    }
}
