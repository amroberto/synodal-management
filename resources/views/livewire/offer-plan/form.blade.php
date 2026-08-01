<div>

    <form wire:submit.prevent="save" class="space-y-6">


        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">


            {{-- Data --}}
            <div>
                <flux:input
                    label="Data da Oferta"
                    type="date"
                    wire:model.defer="offer_date"
                />
            </div>


            {{-- Instância --}}
            <div class="md:col-span-2">

                <flux:select
                    label="Instância"
                    wire:model.defer="offer_instance"
                >

                    <option value="">
                        Selecione
                    </option>


                    @foreach($instances as $instance)

                        <option value="{{ $instance->value }}">
                            {{ $instance->label() }}
                        </option>

                    @endforeach

                </flux:select>

            </div>


        </div>



        {{-- Destinação --}}
        <div>

            <flux:select
                label="Destinação da Oferta"
                wire:model.defer="offer_destination_id"
            >

                <option value="">
                    Selecione
                </option>


                @foreach($destinations as $destination)

                    <option value="{{ $destination->id }}">
                        {{ $destination->name }}
                    </option>

                @endforeach


            </flux:select>

        </div>



        {{-- Data Litúrgica --}}
        <div>

            <flux:input
                label="Data Litúrgica"
                wire:model.defer="liturgical_date"
                placeholder="Ex.: 7º Domingo após Pentecostes"
            />

        </div>



        {{-- Ativo --}}
        <div class="flex items-center">

            <flux:checkbox
                wire:model.live="active"
                id="active"
            />

            <label
                for="active"
                class="ml-2"
            >
                Oferta ativa
            </label>

        </div>



        {{-- Botões --}}
        <div class="flex justify-end gap-3 mt-6">


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