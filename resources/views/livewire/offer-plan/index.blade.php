<div>

    {{-- Breadcrumb --}}
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">
                Home
            </flux:breadcrumbs.item>

            <flux:breadcrumbs.item>
                Plano de Ofertas
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="relative mb-6 w-full">

        {{-- Heading --}}
        <flux:heading
            size="xl"
            level="1"
        >
            {{ __('Plano de Ofertas') }}
        </flux:heading>

        <flux:separator
            variant="subtle"
            class="my-4"
        />

        {{-- Flash Message --}}
        @if(session('message'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)"
                class="fixed top-5 right-5 bg-green-600 text-white px-4 py-2 rounded shadow-lg z-50"
            >
                {{ session('message') }}
            </div>
        @endif

        {{-- Filtros --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">

            {{-- Pesquisa --}}
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Pesquisar..."
            />

            {{-- Mês --}}
            <flux:select wire:model.live="month">
                <option value="">
                    Todos os meses
                </option>
                @foreach([
                    1=>'Janeiro',
                    2=>'Fevereiro',
                    3=>'Março',
                    4=>'Abril',
                    5=>'Maio',
                    6=>'Junho',
                    7=>'Julho',
                    8=>'Agosto',
                    9=>'Setembro',
                    10=>'Outubro',
                    11=>'Novembro',
                    12=>'Dezembro'
                ] as $value => $month)

                    <option value="{{ $value }}">
                        {{ $month }}
                    </option>
                @endforeach
            </flux:select>

            {{-- Ano --}}
            <flux:select wire:model.live="year">
                <option value="">
                    Todos os anos
                </option>
                @for($i = now()->year + 2; $i >= 2025; $i--)
                    <option value="{{ $i }}">
                        {{ $i }}
                    </option>
                @endfor
            </flux:select>

            {{-- Limpar --}}
            <flux:button
                variant="outline"
                wire:click="$set('search',''); $set('month', null); $set('year', null)"
            >
                Limpar
            </flux:button>

            {{-- Novo --}}
            <flux:button
                variant="primary"
                icon="plus"
                href="{{ route('offer-plans.create') }}"
            >
                Novo Plano </flux:button>
        </div>

        {{-- Tabela --}}
        <table class="table-auto w-full shadow rounded-md">
            <thead>
                <tr class="text-left border-b">
                    <th class="px-4 py-2">Data</th>
                    <th class="px-4 py-2">Data Litúrgica</th>
                    <th class="px-4 py-2">Instância</th>
                    <th class="px-4 py-2">Destinação</th>
                    <th class="px-4 py-2">Ativo</th>
                    <th class="px-4 py-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($offerPlans as $offerPlan)
                    <tr class="border-b">
                        <td class="px-4 py-2">
                            {{ $offerPlan->offer_date->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $offerPlan->liturgical_date }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $offerPlan->offer_instance->label() }}
                        </td>
                        <td class="px-4 py-2">
                            {{ $offerPlan->offerDestination->name }}
                        </td>
                        <td class="px-4 py-2">

                            @if($offerPlan->active)
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
                                variant="ghost"
                                icon="eye"
                                href="{{ route('offer-plans.show', $offerPlan) }}"
                            />

                            <flux:button
                                size="sm"
                                variant="primary"
                                icon="pencil"
                                href="{{ route('offer-plans.edit', $offerPlan) }}"
                            />

                            <flux:button
                                size="sm"
                                variant="danger"
                                icon="trash"
                                wire:click="confirmDelete({{ $offerPlan->id }})"
                            />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="6"
                            class="text-center py-8 text-gray-500"
                        >
                            Nenhum Plano de Oferta encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Paginação --}}
        <div class="mt-6">
            {{ $offerPlans->links() }}
        </div>
    </div>

    {{-- Modal Exclusão --}}
    <flux:modal name="delete-offer-plan">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    Excluir Plano de Oferta?
                </flux:heading>
                <flux:text class="mt-2">
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
                    wire:click="deleteOfferPlan"
                >
                    Excluir
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>