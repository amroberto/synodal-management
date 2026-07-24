<div>
    <form wire:submit.prevent="save" class="space-y-6">
        
        {{-- div razão social, nome fantasia e cnpj --}}
        <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
            <flux:input label="{{ __('Razão Social') }}" wire:model.defer="corporate_name" placeholder="{{ __('Ex. Sinodo teste') }}" required autofocus />
            <flux:input label="{{ __('Nome Fantasia') }}" wire:model.defer="fantasy_name" placeholder="{{ __('Ex. Teste') }}" required autofocus />
            <flux:input label="{{ __('CNPJ') }}" wire:model.defer="cnpj" mask="99.999.999/9999-99" placeholder="{{ __('Ex. 12.345.678/9000-00') }}" />
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
            <flux:input label="{{ __('E-mail') }}" wire:model.defer="email"
                placeholder="{{ __('Ex: jose@email.com') }}" />
            <flux:input label="{{ __('Site') }}" wire:model.defer="website"
                placeholder="{{ __('Ex: www.sinodo.com.br') }}" />
        </div>

        {{-- NOVO CAMPO: Identidade Visual / Logo --}}
        <flux:separator text="Identidade Visual" variant="subtle"/>

        <div class="flex items-center gap-6 p-4 border rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50/50 dark:bg-zinc-800/30">
            {{-- Área de Pré-visualização do Logo --}}
            <div class="flex-shrink-0">
                @if ($logo)
                    {{-- Mostra a pré-visualização em tempo real da imagem temporária que o usuário acabou de selecionar --}}
                    <div class="relative size-24 border rounded-lg overflow-hidden bg-white flex items-center justify-center">
                        <img src="{{ $logo->temporaryUrl() }}" class="object-contain size-full" alt="Preview Novo Logo">
                    </div>
                @elseif ($currentLogo)
                    {{-- Mostra o logo atual cadastrado no banco de dados --}}
                    <div class="relative size-24 border rounded-lg overflow-hidden bg-white flex items-center justify-center">
                        <img src="{{ asset('storage/' . $currentLogo) }}" class="object-contain size-full" alt="Logo Atual">
                    </div>
                @else
                    {{-- Caso não tenha nenhuma imagem --}}
                    <div class="size-24 border-2 border-dashed rounded-lg flex flex-col items-center justify-center text-zinc-400 bg-zinc-100 dark:bg-zinc-800 text-xs text-center p-2">
                        <span>Sem Logo</span>
                    </div>
                @endif
            </div>

            {{-- Componente de Input de Arquivo do Flux UI --}}
            <div class="flex-1 space-y-1">
                <flux:input 
                    type="file" 
                    label="{{ __('Logo') }}" 
                    wire:model="logo" 
                    accept="image/*"
                    description="Formatos suportados: JPG, PNG. Máximo de 2MB."
                />
                {{-- Exibe mensagens de erro de validação específicas do arquivo --}}
                @error('logo') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
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
    </form>
</div>