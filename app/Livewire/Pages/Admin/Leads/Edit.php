<?php

namespace App\Livewire\Pages\Admin\Leads;

use App\Models\Lead;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Edit extends Component
{
    public Lead $lead;
    public $name = '';
    public $mobile = '';
    public $email = '';
    public $product_type = '';
    public $budget = '';
    public $start = '';

    public function mount(Lead $lead)
    {
        $this->lead = $lead;
        $this->name = $lead->name;
        $this->mobile = $lead->mobile;
        $this->email = $lead->email;
        $this->product_type = $lead->product_type;
        $this->budget = $lead->budget;
        $this->start = $lead->start;
    }

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

        $this->lead->update([
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'product_type' => $this->product_type,
            'budget' => $this->budget,
            'start' => $this->start,
        ]);

        session()->flash('status', 'Lead updated successfully.');
        return redirect()->route('admin.leads.index');
    }

    public function render()
    {
        return view('livewire.pages.admin.leads.edit');
    }
}
