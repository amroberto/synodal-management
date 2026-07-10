<div>

    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('dashboard') }}">
                Home
            </flux:breadcrumbs.item>

            <flux:breadcrumbs.item href="{{ route('account-plans.index') }}">
                Plano de Contas
            </flux:breadcrumbs.item>

            <flux:breadcrumbs.item>
                {{ $accountPlan->code }}
            </flux:breadcrumbs.item>
        </flux:breadcrumbs>
    </div>

    <flux:heading size="xl">
        Conta Contábil
    </flux:heading>

    <flux:separator class="my-4" />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <flux:input
            label="Código"
            :value="$accountPlan->code"
            readonly
        />

        <flux:input
            label="Nível"
            :value="$accountPlan->level"
            readonly
        />

    </div>

    @if ($accountPlan->parent)

        <div class="mt-5">

            <flux:input
                label="Conta Pai"
                :value="$accountPlan->parent->code . ' - ' . $accountPlan->parent->description"
                readonly
            />

        </div>

    @endif

    <div class="mt-5">

        <flux:textarea
            label="Descrição"
            readonly
        >{{ $accountPlan->description }}</flux:textarea>

    </div>

    <div class="mt-8">

        <flux:button
            href="{{ route('account-plans.index') }}"
            icon="arrow-left"
            variant="ghost"
        >
            Voltar
        </flux:button>

    </div>

</div>