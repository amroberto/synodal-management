<?php

namespace App\Livewire\Community;

use Livewire\Component;
use App\Models\Community;
use Flux\Flux;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $communityId;

    public function clearSearch()
    {
        $this->search = '';
    }

    public function updatedSearch()
    {
        $communities = Community::where('fantasy_name', 'like', '%' . $this->search . '%')
            ->orderBy('sector_id', 'asc')
            ->paginate(10);
        return view('livewire.community.index', ['communities' => $communities]);
    }

    public function edit($id)
    {
        $this->dispatch('edit-community', $id);
    }
    
    public function delete($id)
    {
        $this->communityId = $id;
        Flux::modal('delete-community')->show();
    }

    public function deleteCommunity ()
    {
        Community::find($this->communityId)->delete();
        Flux::modal('delete-community')->close();
        session()->flash('success', 'Comunidade deletada com sucesso!');
        $this->redirectRoute('communities.index', navigate: true);
    }
   
    public function render()
    {
        $communities = Community::where('fantasy_name', 'like', '%' . $this->search . '%')
        ->orderBy('sector_id','asc')->paginate(10);
        return view('livewire.community.index', ['communities' => $communities]);
    }
}
