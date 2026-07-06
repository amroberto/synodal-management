<div>
    {{-- Título da página --}}
    <div class="space-y-1 py-4">
        <flux:heading size="lg" class="mb-4">
            Editar Liderança
        </flux:heading>
        <flux:text class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Atualize os dados da liderança.') }}
        </flux:text>
        <flux:separator variant="subtle" class="my-4" />
    </div>

    <livewire:leadership.form :leadership="$leadership" />
</div>
