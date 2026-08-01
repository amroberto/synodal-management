<?php

namespace App\Livewire\OfferPlan;

use App\Models\OfferPlan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $month = null;

    public ?int $year = null;

    public ?int $offerPlanId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'month'  => ['except' => null],
        'year'   => ['except' => null],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingMonth(): void
    {
        $this->resetPage();
    }

    public function updatingYear(): void
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $this->offerPlanId = $id;

        $this->dispatch('open-modal', name: 'delete-offer-plan');
    }

    public function deleteOfferPlan(): void
    {
        OfferPlan::findOrFail($this->offerPlanId)->delete();

        session()->flash(
            'message',
            'Plano de Oferta excluído com sucesso!'
        );

        $this->dispatch('close-modal', name: 'delete-offer-plan');
    }

    public function render()
    {
        $offerPlans = OfferPlan::query()
            ->with('offerDestination')

            ->when($this->search, function ($query) {

                $query->where('liturgical_date', 'like', "%{$this->search}%")
                    ->orWhereHas('offerDestination', function ($query) {

                        $query->where('name', 'like', "%{$this->search}%")
                              ->orWhere('description', 'like', "%{$this->search}%");

                    });

            })

            ->when(
                $this->month,
                fn ($query) => $query->month($this->month)
            )

            ->when(
                $this->year,
                fn ($query) => $query->year($this->year)
            )

            ->ordered()

            ->paginate(15);

        return view('livewire.offer-plan.index', [
            'offerPlans' => $offerPlans,
        ]);
    }
}