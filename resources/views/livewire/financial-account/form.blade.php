<div>

    <form wire:submit.prevent="save" class="space-y-6">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <flux:input
                label="Código"
                wire:model.defer="code"
                required
            />

            <flux:input
                label="Nome da Conta"
                wire:model.defer="name"
                required
            />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <flux:select
                label="Tipo de Conta"
                wire:model.defer="type"
                required
            >

                <option value="">
                    Selecione...
                </option>

                @foreach($types as $value => $label)

                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                @endforeach

            </flux:select>

            <flux:input
                label="Saldo Inicial"
                type="number"
                step="0.01"
                min="0"
                wire:model.defer="initial_balance"
                required
            />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <flux:input
                label="Banco"
                wire:model.defer="bank_name"
            />

            <flux:input
                label="Agência"
                wire:model.defer="agency"
            />

            <flux:input
                label="Número da Conta"
                wire:model.defer="account_number"
            />
        </div>

        <div class="flex items-center">
            <flux:checkbox
                wire:model.live="active"
                id="active"
            />

            <label
                for="active"
                class="ml-2"
            >
                Conta financeira ativa
            </label>

        </div>

        <flux:separator variant="subtle"/>

        <div class="flex justify-end gap-3">

            <flux:button
                type="button"
                variant="outline"
                href="{{ route('financial-accounts.index') }}"
            >
                Cancelar
            </flux:button>

            <flux:button
                type="submit"
                variant="primary"
            >
                Salvar
            </flux:button>
        </div>
    </form>
</div>