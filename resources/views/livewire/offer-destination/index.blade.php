<div>
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">
                Home
            </flux:breadcrumbs.item>

            <flux:breadcrumbs.item>
                Destinação das Ofertas
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="relative mb-6 w-full">

        <flux:heading size="xl" level="1">
            {{ __('Listagem de Destinação das Ofertas') }}
        </flux:heading>

        <flux:separator variant="subtle" class="mb-6 my-4" />

        {{-- FLASH MESSAGE --}}
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

        {{-- Pesquisa e botão Novo --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">

            <div class="flex-grow w-full md:w-auto">
                <flux:input
                    type="text"
                    placeholder="{{ __('Pesquisar...') }}"
                    wire:model.live="search"
                    class="w-full md:w-64"
                />
            </div>

            <div class="flex-shrink-0">
                <flux:button
                    icon="plus"
                    variant="primary"
                    href="{{ route('offer-destinations.create') }}"
                >
                    {{ __('Nova Destinação') }}
                </flux:button>
            </div>

        </div>

        {{-- Tabela --}}
        <table class="table-auto w-full shadow-md rounded-md mt-5">

            <thead>
                <tr class="text-left">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nome</th>
                    <th class="px-4 py-2">Descrição</th>
                    <th class="px-4 py-2 text-center">Ativa?</th>
                    <th class="px-4 py-2 text-center">Ações</th>
                </tr>
            </thead>

            <tbody>

                @forelse($offerDestinations as $destination)

                    <tr class="border-t">

                        <td class="px-4 py-2">
                            {{ $destination->id }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $destination->name }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $destination->description }}
                        </td>

                        <td class="px-4 py-2 text-center">

                            @if($destination->active)
                                <span class="inline-flex items-center rounded-md bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                    Sim
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-md bg-red-100 px-2 py-1 text-xs font-medium text-red-700">
                                    Não
                                </span>
                            @endif

                        </td>

                        <td class="px-4 py-2 text-center space-x-2">

                            <flux:button
                                size="sm"
                                icon="pencil"
                                variant="primary"
                                href="{{ route('offer-destinations.edit', $destination) }}"
                            >
                                Editar
                            </flux:button>
                            

                            <flux:button
                                size="sm"
                                icon="trash"
                                variant="danger"
                                wire:click="delete({{ $destination->id }})"
                            >
                                Excluir
                            </flux:button>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                            {{ __('Nenhuma destinação cadastrada!') }}
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

        {{-- Paginação --}}
        <div class="mt-4">
            {{ $offerDestinations->links() }}
        </div>

        {{-- Modal Exclusão --}}
        <flux:modal
            name="delete-offer-destination"
            class="min-w-[22rem]"
        >

            <div class="space-y-6">

                <div>

                    <flux:heading size="lg">
                        Excluir Destinação
                    </flux:heading>

                    <flux:text class="mt-2">
                        Você realmente deseja excluir esta destinação de oferta?
                        <br>
                        Esta ação não poderá ser desfeita.
                    </flux:text>

                </div>

                <div class="flex gap-2">

                    <flux:spacer />

                    <flux:modal.close>
                        <flux:button variant="ghost">
                            Cancelar
                        </flux:button>
                    </flux:modal.close>

                    <flux:button
                        variant="danger"
                        wire:click="deleteOfferDestination"
                    >
                        Excluir
                    </flux:button>

                </div>

            </div>

        </flux:modal>

    </div>
</div>