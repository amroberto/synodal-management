<div>

    {{-- Breadcrumb --}}
    <div class="mb-6">

        <flux:breadcrumbs>

            <flux:breadcrumbs.item href="{{ route('dashboard') }}">
                Home
            </flux:breadcrumbs.item>

            <flux:breadcrumbs.item href="{{ route('offer-plans.index') }}">
                Plano de Ofertas
            </flux:breadcrumbs.item>

            <flux:breadcrumbs.item>
                Visualizar
            </flux:breadcrumbs.item>

        </flux:breadcrumbs>

    </div>


    <div class="relative mb-6 w-full">

        <flux:heading size="xl" level="1">
            Visualizar Plano de Oferta
        </flux:heading>


        <flux:separator
            variant="subtle"
            class="my-4"
        />


        <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 space-y-5">


            {{-- Data --}}
            <div>

                <flux:text class="text-sm text-gray-500">
                    Data da Oferta
                </flux:text>

                <flux:text class="font-semibold">
                    {{ $offerPlan->offer_date->format('d/m/Y') }}
                </flux:text>

            </div>



            {{-- Data Litúrgica --}}
            <div>

                <flux:text class="text-sm text-gray-500">
                    Data Litúrgica
                </flux:text>

                <flux:text class="font-semibold">
                    {{ $offerPlan->liturgical_date }}
                </flux:text>

            </div>



            {{-- Instância --}}
            <div>

                <flux:text class="text-sm text-gray-500">
                    Instância
                </flux:text>

                <flux:text class="font-semibold">
                    {{ $offerPlan->offer_instance->label() }}
                </flux:text>

            </div>



            {{-- Destinação --}}
            <div>

                <flux:text class="text-sm text-gray-500">
                    Destinação da Oferta
                </flux:text>

                <flux:text class="font-semibold">
                    {{ $offerPlan->offerDestination->name }}
                </flux:text>

            </div>



            {{-- Descrição da Destinação --}}
            @if($offerPlan->offerDestination->description)

                <div>

                    <flux:text class="text-sm text-gray-500">
                        Descrição
                    </flux:text>

                    <flux:text>
                        {{ $offerPlan->offerDestination->description }}
                    </flux:text>

                </div>

            @endif



            {{-- Status --}}
            <div>

                <flux:text class="text-sm text-gray-500">
                    Status
                </flux:text>


                @if($offerPlan->active)

                    <span class="text-green-600 font-semibold">
                        Sim
                    </span>

                @else

                    <span class="text-red-600 font-semibold">
                        Não
                    </span>

                @endif

            </div>


        </div>


        {{-- Botões --}}
        <div class="flex justify-end gap-3 mt-6">


            <flux:button
                variant="outline"
                href="{{ route('offer-plans.index') }}"
            >
                Voltar
            </flux:button>


            <flux:button
                variant="primary"
                icon="pencil"
                href="{{ route('offer-plans.edit', $offerPlan) }}"
            >
                Editar
            </flux:button>


        </div>


    </div>

</div>