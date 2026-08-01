<div>

    <form wire:submit.prevent="save" class="space-y-6">

        <flux:input
            label="{{ __('Nome') }}"
            wire:model.defer="name"
            placeholder="{{ __('Ex.: Missão na Metrópole') }}"
            required
            autofocus
        />

        <flux:textarea
            label="{{ __('Descrição') }}"
            wire:model.defer="description"
            rows="4"
            placeholder="{{ __('Descrição (opcional)') }}"
        />

        <div class="flex items-center">

            <flux:checkbox
                wire:model.live="active"
                id="active"
            />

            <label
                for="active"
                class="ml-2"
            >
                {{ __('Destinação ativa') }}
            </label>

        </div>

        <div class="flex justify-end gap-3 mt-6">

            <flux:button
                type="button"
                variant="outline"
                href="{{ route('offer-destinations.index') }}"
            >
                {{ __('Cancelar') }}
            </flux:button>

            <flux:button
                type="submit"
                variant="primary"
            >
                {{ __('Salvar') }}
            </flux:button>

        </div>

    </form>

</div>