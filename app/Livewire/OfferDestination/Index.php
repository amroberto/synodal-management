<?php

namespace App\Livewire\OfferDestination;

use App\Models\OfferDestination;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $deleteId = null;

    protected $paginationTheme = 'tailwind';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $this->deleteId = $id;

        $this->modal('delete-offer-destination')->show();
    }

    public function deleteOfferDestination(): void
    {
        OfferDestination::findOrFail($this->deleteId)->delete();

        session()->flash(
            'message',
            'Destinação da oferta excluída com sucesso!'
        );

        $this->modal('delete-offer-destination')->close();
    }

    public function render()
    {
        return view('livewire.offer-destination.index', [
            'offerDestinations' => OfferDestination::query()
                ->where(function ($query) {
                    $query
                        ->where('name', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                })
                ->orderBy('id')
                ->paginate(10),
        ]);
    }
}