<?php

namespace App\Livewire\Pages\Admin\Leads;

use App\Models\Lead;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Create extends Component
{
    public $name = '';
    public $mobile = '';
    public $email = '';
    public $product_type = '';
    public $budget = '';
    public $start = '';

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'product_type' => 'required|string|max:255',
            'budget' => 'required|string|max:255',
            'start' => 'required|string|max:255',
        ]);

        Lead::create([
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'product_type' => $this->product_type,
            'budget' => $this->budget,
            'start' => $this->start,
        ]);

        session()->flash('status', 'Lead created successfully.');
        return redirect()->route('admin.leads.index');
    }

    public function render()
    {
        return view('livewire.pages.admin.leads.create');
    }
}
