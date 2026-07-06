<?php

namespace App\Livewire\Leadership;

use Livewire\Component;
use App\Models\Leadership;
use Flux\Flux;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';  
    
    public $leadershipId;

    public function clearSearch()
    {
        $this->search = '';
    }

    public function updatedSearch()
    {
        $leaderships = Leadership::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        return view('livewire.leadership.index', ['leaderships' => $leaderships]);
    }
 
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->dispatch('edit-leadership', $id);
    }

    public function delete($id)
    {
        $this->leadershipId = $id;
        Flux::modal('delete-leadership')->show();
    }

    public function deleteLeadership ()
    {
        Leadership::find($this->leadershipId)->delete();
        Flux::modal('delete-leadership')->close();
        session()->flash('success', 'Liderança deletada com sucesso!');
        $this->redirectRoute('leadership.index', navigate: true);
    }   

    protected function formatPhone(?string $value): ?string
    {
        return $value
            ? preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $value)
            : null;
    }

    protected function formatMobile(?string $value): ?string
    {
        return $value
            ? preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $value)
            : null;
    }

    public function render()
    {
        $leaderships = Leadership::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('created_at', 'asc')
            ->paginate(10);
        return view('livewire.leadership.index', ['leaderships' => $leaderships]);
    }
}
