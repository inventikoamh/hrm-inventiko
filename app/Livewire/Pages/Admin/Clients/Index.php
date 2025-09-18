<?php

namespace App\Livewire\Pages\Admin\Clients;

use App\Models\Client;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Clients')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($clientId)
    {
        if (!auth()->user()->can('delete client')) {
            session()->flash('error', 'You do not have permission to delete clients.');
            return;
        }

        $client = Client::findOrFail($clientId);
        
        // Check if client has projects
        if ($client->projects()->count() > 0) {
            session()->flash('error', 'Cannot delete client with associated projects. Please reassign or delete the projects first.');
            return;
        }
        
        $client->delete();
        
        session()->flash('success', 'Client deleted successfully!');
    }

    public function render()
    {
        $query = Client::query()
            ->when($this->search, function ($query) {
                $query->search($this->search);
            })
            ->orderBy('client_name', 'asc');

        $clients = $query->paginate(10);

        return view('livewire.pages.admin.clients.index', [
            'clients' => $clients,
        ]);
    }
}
