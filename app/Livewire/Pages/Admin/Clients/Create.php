<?php

namespace App\Livewire\Pages\Admin\Clients;

use App\Models\Client;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Create Client')]
class Create extends Component
{
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

    public function save()
    {
        if (!auth()->user()->can('create client')) {
            session()->flash('error', 'You do not have permission to create clients.');
            return;
        }

        $this->validate();

        Client::create([
            'client_name' => $this->client_name,
            'company_name' => $this->company_name,
            'description' => $this->description,
            'email' => $this->email,
            'mobile' => $this->mobile,
        ]);

        session()->flash('success', 'Client created successfully!');
        return $this->redirect(route('admin.clients.index'));
    }

    public function render()
    {
        return view('livewire.pages.admin.clients.create');
    }
}
