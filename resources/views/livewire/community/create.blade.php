<div>
    {{-- Título da página --}}
    <div class="space-y-1">
        <flux:heading size="lg" class="mb-4">
            Criar Comunidade
        </flux:heading>
        <flux:text class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Insira os dados da comunidade.') }}
        </flux:text>
        <flux:separator variant="subtle" class="my-4" />
    </div>
    
    <livewire:community.form :community="$community" />

</div>
