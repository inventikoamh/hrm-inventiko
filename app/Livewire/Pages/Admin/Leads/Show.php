<?php

namespace App\Livewire\Pages\Admin\Leads;

use App\Models\Lead;
use App\Models\LeadRemark;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Show extends Component
{
    public Lead $lead;
    public $remark = '';

    public function mount(Lead $lead)
    {
        $this->lead = $lead;
    }

    public function addRemark()
    {
        $this->validate([
            'remark' => 'required|string|min:3',
        ]);

        LeadRemark::create([
            'lead_id' => $this->lead->id,
            'user_id' => auth()->id(),
            'remark' => $this->remark,
        ]);

        $this->remark = '';
        session()->flash('status', 'Remark added successfully.');
    }

    public function deleteRemark(LeadRemark $remark)
    {
        $remark->delete();
        session()->flash('status', 'Remark deleted successfully.');
    }

    public function render()
    {
        $this->lead->load(['remarks.user']);
        
        return view('livewire.pages.admin.leads.show', [
            'remarks' => $this->lead->remarks()->with('user')->orderBy('created_at', 'desc')->get(),
        ]);
    }
}
