<div>

    <div class="space-y-1">

        <flux:heading size="lg" class="mb-4">
            Editar Subcategoria de Receita
        </flux:heading>


        <flux:text class="text-sm text-gray-500 dark:text-gray-400">
            Altere os dados da subcategoria.
        </flux:text>


        <flux:separator variant="subtle" class="my-4" />

    </div>


    <livewire:revenue-sub-category.form
        :subcategory="$subcategory"
        :key="$subcategory->id"
    />

</div>