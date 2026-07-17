<div>

<form wire:submit.prevent="save" class="space-y-6">


    <flux:select
        label="Categoria da Receita"
        wire:model="revenue_category_id"
        required
    >

        <flux:select.option value="">
            Selecione...
        </flux:select.option>


        @foreach($categories as $category)

            <flux:select.option
                value="{{ $category->id }}"
            >
                {{ $category->name }}
            </flux:select.option>

        @endforeach

    </flux:select>



    <flux:input
        label="Nome"
        wire:model="name"
        required
    />



    <flux:textarea
        label="Descrição"
        wire:model="description"
    />



    <div class="flex items-center">

        <flux:checkbox
            wire:model="active"
        />

        <span class="ml-2">
            Subcategoria ativa
        </span>

    </div>



    <div class="flex justify-end gap-3">

        <flux:button
            type="button"
            variant="outline"
            href="{{ route('revenue-sub-categories.index') }}"
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