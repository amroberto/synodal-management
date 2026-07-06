<div>
    <flux:modal name="create-sector" class="md:w-900">
        
        <form wire:submit.prevent="save" class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ __('Criar Núcleo') }}
                </flux:heading>

                <flux:text class="mt-2">
                    {{ __('Insira os dados do núcleo.') }}
                </flux:text>
            </div>

            <flux:input
                label="{{ __('Nome do Núcleo') }}"
                wire:model.defer="name"
                placeholder="{{ __('Ex: São Paulo') }}"
                required
                autofocus
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