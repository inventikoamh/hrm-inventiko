<?php

namespace App\Livewire\Pages\Admin\Clients;

use App\Models\Client;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Client Details')]
class Show extends Component
{
    public Client $client;

    public function mount(Client $client)
    {
        if (!auth()->user()->can('view clients')) {
            session()->flash('error', 'You do not have permission to view clients.');
            return $this->redirect(route('admin.clients.index'));
        }

        $this->client = $client->load('projects');
    }

    public function render()
    {
        return view('livewire.pages.admin.clients.show');
    }
}
