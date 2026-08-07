<div>
    <flux:modal name="edit-cost-center" class="md:w-900">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Atualizar Centro de Custos') }}</flux:heading>
                <flux:text class="mt-2">{{ __('Atualize os dados do centro de custos.') }}</flux:text>
            </div>

            <flux:input
                label="{{ __('Nome do Centro de Custos') }}"
                wire:model="name"
                placeholder="{{ __('Ex: Administrativo') }}"
                required
                autofocus
            />

            <flux:input
                label="{{ __('Código do Centro de Custos') }}"
                wire:model="code"
                placeholder="{{ __('Ex: ADM') }}"
                required
            />

            <flux:checkbox
                label="{{ __('Ativo') }}"
                wire:model="active"
            />

            <flux:text label="{{ __('Descrição') }}" class="mt-2">
                {{ __('Insira informações adicionais sobre o centro de custos.') }}
            </flux:text>
            <flux:textarea
                wire:model="description"
                placeholder="{{ __('Ex: Centro de custos responsável pelo setor administrativo da empresa.') }}"
            />

            <div class="flex justify-end gap-3 mt-6">
                <flux:modal.close>
                    <flux:button type="button" variant="filled">
                        {{ __('Cancelar') }}
                    </flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary" wire:click="update">
                    {{ __('Atualizar') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>