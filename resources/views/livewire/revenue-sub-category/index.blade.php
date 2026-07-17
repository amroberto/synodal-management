<div>
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="route('dashboard')">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Subcategoria das Receitas</flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">
            {{ __('Listagem de Subcategoria das receitas') }}
        </flux:heading>

        <flux:separator variant="subtle" class="mb-6 my-4" />

        {{-- FLASH MESSAGE --}}
        <div>
            @if (session('message'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)"
                class="fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow-lg z-50"
                role="alert"
            >
                <p>{{ session('message') }}</p>
            </div>
        @endif
        </div>

        {{-- div botão criar e input pesquisar --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">
        {{-- search input  --}}
        <div class="flex-grow w-full md:w-auto">
            <flux:input 
                type="text" 
                placeholder="{{ __('Pesquisar ...') }}" 
                wire:model.live="search"
                class="w-full md:w-64 " 
            />
        </div>
        
        <div class="flex-shrink-0">
             {{-- botão criar --}}
            <flux:button
                icon="plus"
                variant="primary"
                href="{{ route('revenue-sub-categories.create') }}"
            >
                {{ __('Criar Nova Subcategoria') }}
            </flux:button>
        </div>    
    </div>

        {{-- TABELA --}}
        <table class="table-auto w-full shadow-md rounded-md mt-5">
            <thead>
                <tr class="text-left">
                    <th class="px-4 py-2">{{ __('ID') }}</th>
                    <th class="px-4 py-2">{{ __('Nome') }}</th>
                    <th class="px-4 py-2">{{ __('Categoria') }}</th>
                    <th class="px-4 py-2">{{ __('Ativo?') }}</th>
                    <th class="px-4 py-2">{{ __('Ações') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($subcategories as $subcategory)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $subcategory->id }}</td>
                        <td class="px-4 py-2">{{ $subcategory->name }}</td>
                        <td class="px-4 py-2">{{ $subcategory->revenueCategory->name }}</td>
                        <td class="px-4 py-2">
                            @if ($subcategory->active)
                                <span class="inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                    Sim
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-700">
                                    Não
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <flux:button
                                size="sm"
                                icon="pencil"
                                variant="primary"
                                href="{{ route('revenue-sub-categories.edit', $subcategory->id) }}"
                            >
                                Edit
                            </flux:button>

                            <flux:button
                                size="sm"
                                icon="trash"
                                variant="danger"
                                wire:click="delete({{ $subcategory->id }})"
                            >
                                Delete
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">
                            {{ __('Nenhuma subcategoria cadastrada!') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINAÇÃO --}}
        <div class="mt-4">
            {{ $subcategories->links() }}
        </div>

        {{-- MODAL DELETE --}}
        <flux:modal name="delete-revenue-sub-category" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">
                        Deseja realmente apagar esta subcategoria?
                    </flux:heading>

                    <flux:text class="mt-2">
                        Você está prestes a excluir esta Subcategoria.<br>
                        Esta ação não poderá ser revertida.
                    </flux:text>
                </div>

                <div class="flex gap-2">
                    <flux:spacer />

                    <flux:modal.close>
                        <flux:button variant="ghost">Cancelar</flux:button>
                    </flux:modal.close>

                    <flux:button
                        type="button"
                        variant="danger"
                        wire:click="deleteRevenueSubCategory"
                    >
                        Apagar Subcategoria
                    </flux:button>
                </div>
            </div>
        </flux:modal>
    </div>
</div>