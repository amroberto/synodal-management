<div>
    <form wire:submit.prevent="save" class="space-y-6">
        
        {{-- div nome, cpf e RG --}}
        <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
            <flux:input label="{{ __('Nome') }}" wire:model.defer="name" placeholder="{{ __('Ex. José da Silva') }}" required autofocus />
            <flux:input label="{{ __('CPF') }}" wire:model.defer="cpf" mask="999.999.999-99" placeholder="{{ __('Ex. 123.456.789-00') }}" />
            <flux:input label="{{ __('RG') }}" wire:model.defer="rg" mask="99.999.999-9" placeholder="{{ __('Ex. 12.345.678-9') }}" />
        </div>

        {{--is_active, birthdate, gender(GenderEnum) --}}
        <div class="grid grid-cols-4 md:grid-cols-4 gap-4">
           <div class="flex items-center">
                <flux:checkbox wire:model.live="is_active" id="is_active" />
                <label for="is_active" class="ml-2">{{ __('Liderança ativa') }}</label>
            </div>
                
            <flux:input
                label="{{ __('Data de Nascimento') }}"
                wire:model.defer="birthdate"
                mask="99/99/9999"
                placeholder="{{ __('Ex: 31/12/1990') }}"
            />

            <flux:select label="{{ __('Gênero') }}" wire:model.defer="gender" ... required>
                <flux:select.option :value="App\Enums\GenderEnum::MALE->value">{{ __('Masculino') }}</flux:select.option>
                <flux:select.option :value="App\Enums\GenderEnum::FEMALE->value">{{ __('Feminino') }}</flux:select.option>
                <flux:select.option :value="App\Enums\GenderEnum::OTHER->value">{{ __('Outro') }}</flux:select.option>
            </flux:select>

            <flux:select
                label="{{ __('Comunidade') }}"
                wire:model.live="community_id"
                placeholder="{{ __('Selecione a comunidade') }}"
                required
            >
                @foreach ($communities as $community)
                    <flux:select.option
                        :value="$community->id"
                    >
                        {{ $community->fantasy_name }}
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

        <div class="grid grid-cols-4 md:grid-cols-4 gap-4">
            <flux:input label="{{ __('Telefone Residencial') }}" wire:model.defer="phone" mask="(99) 9999-9999"
                placeholder="{{ __('Ex: (11) 1234-5678') }}" />
            <flux:input label="{{ __('Celular') }}" wire:model.defer="mobile" mask="(99) 99999-9999"
                placeholder="{{ __('Ex: (11) 91234-5678') }}" />
            <flux:input label="{{ __('Telefone Comercial') }}" wire:model.defer="business_phone" mask="(99) 9999-9999"
                placeholder="{{ __('Ex: (11) 1234-5678') }}" />
            <flux:input label="{{ __('E-mail') }}" wire:model.defer="email"
                placeholder="{{ __('Ex: jose@email.com') }}" />
        </div>

        {{-- Ações --}}
        <div class="flex justify-end gap-3 mt-6">
            <flux:button type="button" variant="outline" href="{{ route('leaderships.index') }}">
                {{ __('Cancelar') }}
            </flux:button>

            <flux:button type="submit" variant="primary">
                {{ __('Salvar') }}
            </flux:button>
        </div>
    </form>
</div>