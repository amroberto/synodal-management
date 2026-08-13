<?php

namespace App\Livewire\FinancialAccount;

use App\Enums\FinancialAccountTypeEnum;
use App\Models\FinancialAccount;
use Livewire\Component;

class Form extends Component
{
    public ?FinancialAccount $financialAccount = null;

    public string $code = '';

    public string $name = '';

    public string $type = '';

    public ?string $bank_name = null;

    public ?string $agency = null;

    public ?string $account_number = null;

    public string $initial_balance = '0.00';

    public bool $active = true;

    public array $types = [];

    protected function rules(): array
    {
        return [
            'code' => [
                'required',
                'string',
                'max:50',
                'unique:financial_accounts,code,' . ($this->financialAccount?->id ?? 'NULL'),
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
            ],

            'bank_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'agency' => [
                'nullable',
                'string',
                'max:50',
            ],

            'account_number' => [
                'nullable',
                'string',
                'max:50',
            ],

            'initial_balance' => [
                'required',
                'numeric',
                'min:0',
            ],

            'active' => [
                'boolean',
            ],
        ];
    }

    public function mount(?FinancialAccount $financialAccount = null): void
    {
        $this->financialAccount = $financialAccount;

        $this->types = FinancialAccountTypeEnum::getLabels();

        if (! $this->financialAccount?->exists) {
            return;
        }

        $this->code = $this->financialAccount->code;

        $this->name = $this->financialAccount->name;

        $this->type = $this->financialAccount->type->value;

        $this->bank_name = $this->financialAccount->bank_name;

        $this->agency = $this->financialAccount->agency;

        $this->account_number = $this->financialAccount->account_number;

        $this->initial_balance = $this->financialAccount->initial_balance;

        $this->active = $this->financialAccount->active;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'code' => $this->code,
            'name' => $this->name,
            'type' => $this->type,
            'bank_name' => $this->bank_name,
            'agency' => $this->agency,
            'account_number' => $this->account_number,
            'initial_balance' => $this->initial_balance,
            'active' => $this->active,
        ];

        if ($this->financialAccount && $this->financialAccount->exists) {

            $this->financialAccount->update($data);

            $message = 'Conta financeira atualizada com sucesso!';

        } else {

            $this->financialAccount = FinancialAccount::create($data);

            $message = 'Conta financeira criada com sucesso!';
        }

        session()->flash('message', $message);

        return redirect()->route('financial-accounts.index');
    }

    public function render()
    {
        return view('livewire.financial-account.form');
    }
}