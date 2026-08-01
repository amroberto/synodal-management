<div>

    <div class="space-y-1">

        <flux:heading size="lg" class="mb-4">
            Editar Plano de Oferta
        </flux:heading>

        <flux:text class="text-sm text-gray-500 dark:text-gray-400">
            Altere os dados do plano de oferta.
        </flux:text>

        <flux:separator
            variant="subtle"
            class="my-4"
        />

    </div>


    <livewire:offer-plan.form :offerPlan="$offerPlan" />

</div>