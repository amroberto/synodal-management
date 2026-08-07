<div>
    <flux:modal name="create-cost-center" class="md:w-900">
        
        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ __('Criar Centro de Custos') }}
                </flux:heading>

                <flux:text class="mt-2">
                    {{ __('Insira os dados do centro de custos.') }}
                </flux:text>
            </div>

            <flux:input
                label="{{ __('Nome do Centro de Custos') }}"
                wire:model.defer="name"
                placeholder="{{ __('Ex: Administrativo') }}"
                required
                autofocus
            />

            <flux:input
                label="{{ __('Código do Centro de Custos') }}"
                wire:model.defer="code"
                placeholder="{{ __('Ex: ADM') }}"
                required
            />

            <flux:checkbox
                label="{{ __('Ativo') }}"
                wire:model.defer="active"
            />

            <flux:text label="{{ __('Descrição') }}" class="mt-2">
                {{ __('Insira informações adicionais sobre o centro de custos.') }}
            </flux:text>
            <flux:textarea
                wire:model.defer="description"
                placeholder="{{ __('Ex: Centro de custos responsável pelo setor administrativo da empresa.') }}"
            />

            <div class="flex justify-end gap-3 mt-6">
                <flux:modal.close>
                    <flux:button type="button" variant="filled">
                        {{ __('Cancelar') }}
                    </flux:button>
                </flux:modal.close>

                {{-- SEM wire:click --}}
                <flux:button type="submit" variant="primary">
                    {{ __('Salvar') }}
                </flux:button>
            </div>
        </form>

    </flux:modal>
</div>