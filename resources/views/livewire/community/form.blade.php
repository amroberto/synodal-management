<div x-data="{}">
    {{-- Escuta de eventos nativa e segura do Livewire v3 --}}
    @script
    <script>
        $wire.on('trigger-modal', (data) => {
            // No Livewire v3, os parâmetros chegam direto no primeiro argumento
            const modalData = Array.isArray(data) ? data[0] : data;

            if (modalData.name === 'add-leadership-modal') {
                if (modalData.action === 'show') {
                    $flux.show('add-leadership-modal');
                } else {
                    $flux.close('add-leadership-modal');
                }
            }
        });
    </script>
    @endscript

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="space-y-6">

            {{-- Razão Social / Nome Fantasia --}}
            <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                <flux:input label="{{ __('Razão Social') }}" wire:model.defer="corporate_name"
                    placeholder="{{ __('Ex: Comunidade Exemplo LTDA') }}" required autofocus />

                <flux:input label="{{ __('Nome Fantasia') }}" wire:model.defer="fantasy_name"
                    placeholder="{{ __('Ex: Exemplo') }}" required />
                
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
                    placeholder="{{ __('Selecione o Núcleo') }}" 
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
                <flux:separator text="Endereço" variant="subtle" />
            </div>
            <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                <flux:input label="{{ __('CEP') }}" wire:model.lazy="cep" mask="99999-999"
                    placeholder="{{ __('Ex: 00000-000') }}" required />
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

            <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                <flux:input label="{{ __('Telefone') }}" wire:model.defer="phone" mask="(99) 9999-9999"
                    placeholder="{{ __('Ex: (11) 1234-5678') }}" />
                <flux:input label="{{ __('Celular') }}" wire:model.defer="mobile" mask="(99) 99999-9999"
                    placeholder="{{ __('Ex: (11) 91234-5678') }}" />
            </div>

            <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
                <flux:input label="{{ __('E-mail') }}" wire:model.defer="email"
                    placeholder="{{ __('Ex: comunidade@email.com') }}" />
                <flux:input label="{{ __('Website') }}" wire:model.defer="website"
                    placeholder="{{ __('Ex: https://www.comunidade.com') }}" />
            </div>
            {{-- SEÇÃO DE LIDERANÇAS --}}
            <div class="pt-8 max-w-2xl mx-auto">
                {{-- Cabeçalho com Grande Destaque --}}
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-800">
                    <div>
                        <flux:heading size="xl" level="2" class="font-bold text-gray-900 dark:text-white">
                            {{ __('Lideranças da Comunidade') }}
                        </flux:heading>
                        <flux:text size="sm" variant="subtle" class="mt-1">
                            {{ __('Gerencie os líderes vinculados e seus respectivos cargos nesta comunidade.') }}
                        </flux:text>
                    </div>

                    <div class="flex items-center shrink-0">
                    @if ($community && $community->exists)
                        {{-- Botão Ativo 100% no Padrão Flux UI (Utilizando Variant Primary) --}}
                        <flux:button 
                            type="button" 
                            wire:click="openNewLeadershipModal" 
                            variant="primary"
                            icon="plus"
                        >
                            {{ __('Vincular Liderança') }}
                        </flux:button>
                    @else
                        {{-- Botão Desabilitado no Padrão Flux UI com aviso --}}
                        <div class="flex flex-col items-end gap-1">
                            <flux:button 
                                type="button" 
                                disabled
                                icon="plus"
                            >
                                {{ __('Vincular Liderança') }}
                            </flux:button>
                            <span class="text-xs text-amber-600 dark:text-amber-400 italic">{{ __('Salve a comunidade primeiro para vincular lideranças.') }}</span>
                        </div>
                    @endif
                </div>
                </div>

                {{-- Tabela de lideranças vinculadas (Adicionado mt-4 para afastar do novo cabeçalho) --}}
                @if ($community && $community->exists)
                    <div class="mt-4 border border-gray-100 dark:border-gray-800 rounded-lg overflow-hidden shadow-sm">
                        @if(count($current_leaderships) > 0)
                            <flux:table>
                                <flux:table.columns>
                                    <flux:table.column>Nome da Liderança</flux:table.column>
                                    <flux:table.column>Cargo </flux:table.column>
                                    <flux:table.column class="text-right w-24">Ações</flux:table.column>
                                </flux:table.columns>

                                <flux:table.rows>
                                    @foreach($current_leaderships as $relation)
                                        <flux:table.row :key="$relation->pivot_id">
                                            <flux:table.cell class="font-medium text-sm">{{ $relation->leader_name }}</flux:table.cell>
                                            <flux:table.cell class="text-sm text-gray-600 dark:text-gray-400">{{ $relation->position_name }}</flux:table.cell>
                                            <flux:table.cell class="text-right flex justify-end gap-1">
                                                
                                                <flux:button 
                                                    type="button"
                                                    wire:click="editLeadership({{ $relation->pivot_id }})" 
                                                    variant="primary" 
                                                    icon="pencil" 
                                                    size="sm" 
                                                />

                                                <flux:button 
                                                    type="button"
                                                    wire:click="removeLeadership({{ $relation->pivot_id }})" 
                                                    wire:confirm="Deseja remover esta liderança da comunidade?"
                                                    icon="trash"
                                                    variant="danger"
                                                    icon="trash" 
                                                    size="sm" 
                                                />
                                            </flux:cell>
                                        </flux:table.row>
                                    @endforeach
                                </flux:table.rows>
                            </flux:table>
                        @else
                            <flux:text class="text-center italic text-gray-400 py-6 block text-sm bg-white dark:bg-zinc-900">
                                Nenhuma liderança vinculada a esta comunidade ainda.
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Ações Globais do Formulário --}}
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

    {{-- INTERFACE DO MODAL DO FLUX UI --}}
    <flux:modal name="add-leadership-modal" class="md:w-104 space-y-6">
        <div>
            <flux:heading size="lg">
                {{ $editing_pivot_id ? 'Editar Vínculo de Liderança' : 'Vincular Nova Liderança' }}
            </flux:heading>
            <flux:text variant="subtle">Escolha a pessoa e o cargo ocupado nesta unidade.</flux:text>
        </div>

        <form wire:submit.prevent="addLeadership" class="space-y-4">
            <flux:select label="Liderança" wire:model="selected_leadership_id" placeholder="Selecione o Líder...">
                @foreach($this->leadershipsList as $leader)
                    <flux:select.option :value="$leader->id">{{ $leader->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <flux:select label="Cargo / Função" wire:model="selected_position_id" placeholder="Selecione o Cargo...">
                @foreach($this->positionsList as $position)
                    <flux:select.option :value="$position->id">{{ $position->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex gap-2 justify-end pt-4">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>
                <flux:button type="submit"
                variant="primary">Salvar</flux:button>
            </div>
        </form>
    </flux:modal>
</div>