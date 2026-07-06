<div>
    <form wire:submit.prevent="save" class="space-y-6">
        <div class="space-y-6">

            {{-- Razão Social / Nome Fantasia --}}
            <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                <flux:input label="{{ __('Razão Social') }}" wire:model.defer="corporate_name"
                    placeholder="{{ __('Ex: Comunidade Exemplo LTDA') }}" required autofocus />

                <flux:input label="{{ __('Nome Fantasia') }}" wire:model.defer="fantasy_name"
                    placeholder="{{ __('Ex: Exemplo') }}" required />
                {{-- CNPJ --}}
                <flux:input label="{{ __('CNPJ') }}" wire:model.defer="cnpj" mask="99.999.999/9999-99"
                    placeholder="{{ __('Ex: 00.000.000/0000-00') }}" required />

                <flux:select 
                    label="{{ __('Tipo') }}" 
                    wire:model.defer="unity_type"
                    placeholder="{{ __('Selecione o tipo') }}" 
                    required
                >
                    @foreach (App\Enums\UnityTypeEnum::cases() as $case)
                        <flux:select.option :value="$case->value">
                            {{ $case->label() }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select 
                    label="{{ __('Núcleo') }}" 
                    wire:model.defer="sector_id"
                    placeholder="{{ __('Selecione o núcleo') }}" 
                    required
                >
                    @foreach ($sectors as $sector)
                        <flux:select.option :value="$sector->id">
                            {{ $sector->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div class="pt-4">
                {{-- Endereço --}}
                <flux:separator variant="strong" text="Endereço" variant="subtle" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <flux:input label="{{ __('CEP') }}" wire:model.lazy="cep" mask="99999-999"
                    placeholder="{{ __('Ex: 00000-000') }}" class="" required />
            </div>

            <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                <flux:input label="{{ __('Logradouro') }}" wire:model.defer="street"
                    placeholder="{{ __('Ex: Rua das Flores') }}" required />
                <flux:input label="{{ __('Número') }}" wire:model.defer="number" placeholder="{{ __('Ex: 123') }}" />
                <flux:input label="{{ __('Complemento') }}" wire:model.defer="complement"
                    placeholder="{{ __('Ex: Apto 101') }}" />
            </div>

            <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                
                <flux:input label="{{ __('Bairro') }}" wire:model.defer="neighborhood"
                    placeholder="{{ __('Ex: Centro') }}" required />
                <flux:input label="{{ __('Cidade') }}" wire:model.defer="city" placeholder="{{ __('Ex: São Paulo') }}"
                    required />
                <flux:input label="{{ __('Estado') }}" wire:model.defer="state" placeholder="{{ __('Ex: SP') }}"
                    required />
            </div>

            {{-- Contato --}}
            <flux:separator text="Dados de contato" variant="subtle"/>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input label="{{ __('Telefone') }}" wire:model.defer="phone" mask="(99) 9999-9999"
                    placeholder="{{ __('Ex: (11) 1234-5678') }}" />
                <flux:input label="{{ __('Celular') }}" wire:model.defer="mobile" mask="(99) 99999-9999"
                    placeholder="{{ __('Ex: (11) 91234-5678') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:input label="{{ __('E-mail') }}" wire:model.defer="email"
                    placeholder="{{ __('Ex: comunidade@email.com') }}" />
                <flux:input label="{{ __('Website') }}" wire:model.defer="website"
                    placeholder="{{ __('Ex: https://www.comunidade.com') }}" />
            </div>

            {{-- Ações --}}
            <div class="flex justify-end gap-3 mt-6">
                <flux:button type="button" variant="outline" href="{{ route('communities.index') }}">
                    {{ __('Cancelar') }}
                </flux:button>

                <flux:button type="submit" variant="primary">
                    {{ __('Salvar') }}
                </flux:button>
            </div>
        </div>
    </form>
</div>