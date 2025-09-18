<?php

namespace App\Livewire\Pages\Admin\Clients;

use App\Models\Client;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Edit Client')]
class Edit extends Component
{
    public Client $client;
    public $client_name = '';
    public $company_name = '';
    public $description = '';
    public $email = '';
    public $mobile = '';

    protected $rules = [
        'client_name' => 'required|string|max:255',
        'company_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'email' => 'nullable|email|max:255',
        'mobile' => 'required|string|max:20',
    ];

    protected $messages = [
        'client_name.required' => 'Client name is required.',
        'company_name.required' => 'Company name is required.',
        'email.email' => 'Please enter a valid email address.',
        'mobile.required' => 'Mobile number is required.',
    ];

    public function mount(Client $client)
    {
        if (!auth()->user()->can('update client')) {
            session()->flash('error', 'You do not have permission to edit clients.');
            return $this->redirect(route('admin.clients.index'));
        }

        $this->client = $client;
        $this->client_name = $client->client_name;
        $this->company_name = $client->company_name;
        $this->description = $client->description;
        $this->email = $client->email;
        $this->mobile = $client->mobile;
    }

    public function save()
    {
        $this->validate();

        $this->client->update([
            'client_name' => $this->client_name,
            'company_name' => $this->company_name,
            'description' => $this->description,
            'email' => $this->email,
            'mobile' => $this->mobile,
        ]);

        session()->flash('success', 'Client updated successfully!');
        return $this->redirect(route('admin.clients.index'));
    }

    public function render()
    {
        return view('livewire.pages.admin.clients.edit');
    }
}
