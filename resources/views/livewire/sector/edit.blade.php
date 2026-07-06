<div>
    <flux:modal name="edit-sector" class="md:w-900">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Atualizar Núcleo') }}</flux:heading>
                <flux:text class="mt-2">{{ __('Atualize os dados do núcleo.') }}</flux:text>
            </div>

            <flux:input
                label="{{ __('Nome do Núcleo') }}"
                wire:model="name"
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

                <flux:button type="submit" variant="primary" wire:click="update">
                    {{ __('Atualizar') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>