<div class="relative mb-6 w-full">
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="route('dashboard')">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Categoria das Receitas</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>
    
    <flux:heading size="xl" level="1">{{ __('Listagem das Categorias das Receitas') }}</flux:heading>
    <flux:separator variant="subtle" class="mb-6 my-4" />

    @session('success')
    <div 
        x-data="{ show: true }" 
        x-show="show" 
        x-init="setTimeout(() => { show = false }, 3000)" 
        class="fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow-lg z-50"
        role="alert"
    >
        <p>{{ $value }}</p>
    </div>
    @endsession('success')
    
    <flux:modal.trigger name="create-revenue_category">
        <flux:button variant="primary" icon="plus-circle">{{ __('Criar Categoria das Receitas') }}</flux:button>
    </flux:modal.trigger>

    <livewire:position.create />
    <livewire:position.edit />

    <table class="table-auto w-full shadow-md rounded-md mt-5">
        <thead>
            <tr class="text-left">
                <th class="px-4 py-2">{{ __('ID') }}</th>
                <th class="px-4 py-2">{{ __('Nome') }}</th>
                <th class="px-4 py-2">{{ __('Ações') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($revenue_categories as $category)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $category->id }}</td>
                    <td class="px-4 py-2">{{ $category->name }}</td>
                    <td class="px-4 py-2 space-x-2">
                            <flux:button
                                size="sm"
                                icon="pencil"
                                variant="primary"
                                wire:click="edit({{ $category->id }})"
                            >
                                Edit
                            </flux:button>

                            <flux:button
                                size="sm"
                                icon="trash"
                                variant="danger"
                                wire:click="delete({{ $category->id }})"
                            >
                                Delete
                            </flux:button>
                        </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="px-4 py-2 text-center text-gray-500">
                        {{ __('Nenhuma categoria das receitas encontrada!') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $revenue_categories->links() }}
    </div>

    {{-- Delete Modal --}}
    <flux:modal name="delete-revenue_category" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Deseja realmente apagar esta categoria das receitas?</flux:heading>

                <flux:text class="mt-2">
                    Você está prestes a excluir este categoria.<br>
                    Esta ação não poderá ser revertida.
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger" wire:click="deleteRevenueCategory()">Apagar Categoria das Receitas</flux:button>
            </div>
        </div>
    </flux:modal>
</div>