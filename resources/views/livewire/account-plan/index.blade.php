<div>

    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">
                Home
            </flux:breadcrumbs.item>

            <flux:breadcrumbs.item>
                Plano de Contas
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:heading size="xl">
        Plano de Contas
    </flux:heading>

    <flux:separator class="my-4"/>

    <div class="mb-4">

        <flux:input
            wire:model.live="search"
            placeholder="Pesquisar..."
            class="w-full md:w-80"
        />

    </div>

    <table class="table-auto w-full">

        <thead>

            <tr>

                <th class="text-left px-4 py-2">Código</th>

                <th class="text-left px-4 py-2">Descrição</th>

                <th class="text-center px-4 py-2">Nível</th>

                <th class="text-center px-4 py-2">Ações</th>

            </tr>

        </thead>

        <tbody>

            @forelse($accountPlans as $plan)

                <tr class="border-t">

                    <td class="px-4 py-2">

                        {{ $plan->code }}

                    </td>

                    <td class="px-4 py-2">

                        {{ $plan->description }}

                    </td>

                    <td class="text-center px-4 py-2">

                        {{ $plan->level }}

                    </td>

                    <td class="text-center px-4 py-2">

                        <flux:button
                            icon="eye"
                            size="sm"
                            variant="primary"
                            href="{{ route('account-plans.show', $plan) }}"
                        >
                            Visualizar
                        </flux:button>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center py-4">

                        Nenhum registro encontrado.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    <div class="mt-5">

        {{ $accountPlans->links() }}

    </div>

</div>