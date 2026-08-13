<div class="space-y-6">

    <div>
        <flux:heading size="xl">
            Editar Conta Financeira
        </flux:heading>

        <flux:subheading>
            Atualize os dados da conta financeira.
        </flux:subheading>
    </div>

    <livewire:financial-account.form
        :financialAccount="$financialAccount"
    />

</div>