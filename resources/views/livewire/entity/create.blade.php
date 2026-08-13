<div>
    {{-- Título da página --}}
    <div class="space-y-1">
        <flux:heading size="lg" class="mb-4">
            Criar Entidade
        </flux:heading>
        <flux:text class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Insira os dados da entidade.') }}
        </flux:text>
        <flux:separator variant="subtle" class="my-4" />
    </div>
    
    <livewire:entity.form :Entity="$entity" />

</div>
