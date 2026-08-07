<div>

    <form wire:submit.prevent="save" class="space-y-6">

        {{-- DIV para Data da Oferta, Instância e centro de custos --}}

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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

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


            <flux:select
                label="Plano de Contas"
                wire:model.defer="account_plan_id"
            >

                <option value="">
                    Selecione...
                </option>

                @foreach($accountPlans as $account)

                    <option value="{{ $account->id }}">
                        {{ $account->code }} - {{ $account->description }}
                    </option>

                @endforeach

            </flux:select>

        </div>


        <flux:input
            label="Data Litúrgica"
            wire:model.defer="liturgical_date"
            placeholder="Ex.: 3º Domingo após Pentecostes"
            required
        />


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


        <flux:separator variant="subtle"/>


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