<div>
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">
                Home
            </flux:breadcrumbs.item>

            <flux:breadcrumbs.item>
                Contas Financeiras
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <div class="relative mb-6 w-full">

        <flux:heading size="xl" level="1">
            {{ __('Listagem de Contas Financeiras') }}
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

        {{-- BOTÃO CRIAR E INPUT PESQUISAR --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-4">

            {{-- SEARCH INPUT --}}
            <div class="flex-grow w-full md:w-auto">
                <flux:input
                    type="text"
                    placeholder="{{ __('Pesquisar ...') }}"
                    wire:model.live="search"
                    class="w-full md:w-64"
                />
            </div>

            {{-- BOTÃO CRIAR --}}
            <div class="flex-shrink-0">
                <flux:button
                    icon="plus"
                    variant="primary"
                    href="{{ route('financial-accounts.create') }}"
                >
                    {{ __('Criar Nova Conta Financeira') }}
                </flux:button>
            </div>

        </div>

        {{-- TABELA --}}
        <table class="table-auto w-full shadow-md rounded-md mt-5">

            <thead>
                <tr class="text-left">
                    <th class="px-4 py-2">
                        {{ __('ID') }}
                    </th>

                    <th class="px-4 py-2">
                        {{ __('Código') }}
                    </th>

                    <th class="px-4 py-2">
                        {{ __('Nome') }}
                    </th>

                    <th class="px-4 py-2">
                        {{ __('Tipo') }}
                    </th>

                    <th class="px-4 py-2">
                        {{ __('Saldo Inicial') }}
                    </th>

                    <th class="px-4 py-2">
                        {{ __('Status') }}
                    </th>

                    <th class="px-4 py-2">
                        {{ __('Ações') }}
                    </th>
                </tr>
            </thead>

            <tbody>

                @forelse ($financialAccounts as $account)

                    <tr class="border-t">

                        <td class="px-4 py-2">
                            {{ $account->id }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $account->code }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $account->name }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $account->type?->label() ?? $account->type?->value }}
                        </td>

                        <td class="px-4 py-2">
                            R$
                            {{ number_format($account->initial_balance, 2, ',', '.') }}
                        </td>

                        <td class="px-4 py-2 text-center">

                            @if($account->active)
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
                                href="{{ route('financial-accounts.edit', $account->id) }}"
                            >
                                Edit
                            </flux:button>

                            <flux:button
                                size="sm"
                                icon="trash"
                                variant="danger"
                                wire:click="delete({{ $account->id }})"
                            >
                                Delete
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="7"
                            class="px-4 py-2 text-center text-gray-500"
                        >
                            {{ __('Nenhuma conta financeira cadastrada!') }}
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

        {{-- PAGINAÇÃO --}}
        <div class="mt-4">
            {{ $financialAccounts->links() }}
        </div>

        {{-- MODAL DELETE --}}
        <flux:modal
            name="delete-financial-account"
            class="min-w-[22rem]"
        >

            <div class="space-y-6">

                <div>

                    <flux:heading size="lg">
                        Deseja realmente apagar esta conta financeira?
                    </flux:heading>

                    <flux:text class="mt-2">
                        Você está prestes a excluir esta conta financeira.<br>
                        Esta ação não poderá ser revertida.
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
                        type="button"
                        variant="danger"
                        wire:click="deleteFinancialAccount"
                    >
                        Apagar Conta Financeira
                    </flux:button>

                </div>

            </div>

        </flux:modal>

    </div>
</div>