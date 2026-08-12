<div>
    <form wire:submit.prevent="save" class="space-y-6">
        {{-- ============================================================
             Data da Oferta, Instância e Centro de Custos
        ============================================================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <flux:input
                type="date"
                label="Data da Oferta"
                wire:model.defer="offer_date"
                required
            />

            <flux:select
                label="Instância"
                wire:model.defer="offer_instance"
                required
            >
                <option value="">
                    Selecione...
                </option>
                @foreach($instances as $value => $label)
                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                @endforeach
            </flux:select>
            <flux:select
                label="Centro de Custos"
                wire:model.defer="cost_center_id"
                required
            >
                <option value="">
                    Selecione...
                </option>
                @foreach($costCenters as $costCenter)
                    <option value="{{ $costCenter->id }}">
                        {{ $costCenter->code }} - {{ $costCenter->name }}
                    </option>
                @endforeach
            </flux:select>
        </div>

        {{-- ============================================================
             Destinação e Plano de Contas
        ============================================================= --}}

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Destinação da Oferta --}}

            <flux:select
                label="Destinação da Oferta"
                wire:model.defer="offer_destination_id"
                required
            >
                <option value="">
                    Selecione...
                </option>
                @foreach($offerDestinations as $destination)
                    <option value="{{ $destination->id }}">
                        {{ $destination->name }}
                    </option>
                @endforeach
            </flux:select>


            {{-- Plano de Contas --}}

            <div class="relative">

                <flux:input
                    label="Plano de Contas"
                    placeholder="Digite o código ou descrição..."
                    wire:model.live.debounce.300ms="accountPlanSearch"
                    wire:focus="$set('showAccountPlanResults', true)"
                    autocomplete="off"
                />

                {{-- ====================================================
                     Lista de resultados
                ===================================================== --}}

                @if($showAccountPlanResults)
                    <div
                        class="absolute z-50 mt-1 w-full rounded-lg border border-zinc-200 bg-white shadow-lg dark:border-zinc-700 dark:bg-zinc-800"
                    >

                        @forelse($filteredAccountPlans as $account)

                            <button
                                type="button"
                                wire:click="selectAccountPlan({{ $account->id }})"
                                class="block w-full px-4 py-2 text-left text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700"
                            >
                                <div class="font-medium">
                                    {{ $account->code }}
                                </div>
                                <div class="text-zinc-500 dark:text-zinc-400">
                                    {{ $account->description }}
                                </div>
                            </button>
                        @empty
                            <div class="px-4 py-3 text-sm text-zinc-500">
                                Nenhum plano de contas encontrado.
                            </div>
                        @endforelse
                    </div>
                @endif

                {{-- ====================================================
                     Plano selecionado
                ===================================================== --}}

                @if($account_plan_id)

                    <div class="mt-1 flex items-center justify-between">

                        <span class="text-xs text-zinc-500">
                            Plano de contas selecionado
                        </span>

                        <button
                            type="button"
                            wire:click="clearAccountPlan"
                            class="text-xs text-red-600 hover:text-red-800"
                        >
                            Limpar
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- ============================================================
             Data Litúrgica
        ============================================================= --}}

        <flux:input
            label="Data Litúrgica"
            wire:model.defer="liturgical_date"
            placeholder="Ex.: 3º Domingo após Pentecostes"
            required
        />

        {{-- ============================================================
             Ativo
        ============================================================= --}}

        <div class="flex items-center">

            <flux:checkbox
                wire:model.live="active"
                id="active"
            />

            <label
                for="active"
                class="ml-2"
            >
                Plano de Oferta ativo
            </label>
        </div>

        <flux:separator variant="subtle" />

        {{-- ============================================================
             Botões
        ============================================================= --}}

        <div class="flex justify-end gap-3">

            <flux:button
                type="button"
                variant="outline"
                href="{{ route('offer-plans.index') }}"
            >
                Cancelar
            </flux:button>

            <flux:button
                type="submit"
                variant="primary"
            >
                Salvar
            </flux:button>
        </div>
    </form>
</div>