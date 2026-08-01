<div>

    <div class="space-y-1">

        <flux:heading size="lg" class="mb-4">
            Editar Destinação de Oferta
        </flux:heading>

        <flux:text class="text-sm text-gray-500 dark:text-gray-400">
            Altere os dados da destinação da oferta.
        </flux:text>

        <flux:separator variant="subtle" class="my-4" />

    </div>

    <livewire:offer-destination.form :offerDestination="$offerDestination" />

</div>