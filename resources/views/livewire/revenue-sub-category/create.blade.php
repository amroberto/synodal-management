<div>
    <div class="space-y-1">
        <flux:heading size="xl" weight="bold">
            Nova Subcategoria de Receita
        </flux:heading>

        <flux:text class="text-sm text-gray-500 dark:text-gray-400">
            Cadastre uma subcategoria vinculada a uma categoria de receita e a uma conta contábil.
        </flux:text>

        <flux:separator variant="subtle" class="my-4" />
    </div>

    <livewire:revenue-sub-category.form
        :subcategory="$subcategory"
    />
</div>