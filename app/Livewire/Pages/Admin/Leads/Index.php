<?php

namespace App\Livewire\Pages\Admin\Leads;

use App\Models\Lead;
use App\Models\Client;
use App\Models\LeadRemark;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $productType = '';
    public $dateRange = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $showConvertModal = false;
    public $showViewModal = false;
    public $selectedLead = null;
    public $companyName = '';
    public $description = '';
    public $remark = '';
    public $showPromoteModal = false;
    public $promoteDescription = '';
    public $targetStatus = '';
    public $showHoldModal = false;
    public $holdDescription = '';
    public $showLostModal = false;
    public $lostDescription = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingProductType()
    {
        $this->resetPage();
    }

    public function updatingDateRange()
    {
        $this->resetPage();
    }

    public function delete(Lead $lead)
    {
        $lead->delete();
        session()->flash('status', 'Lead deleted successfully.');
    }

    public function openConvertModal($lead)
    {
        if (!auth()->user()->can('convert lead to client')) {
            session()->flash('error', 'You do not have permission to convert leads to clients.');
            return;
        }

        // Handle both Lead object and lead ID
        if (is_numeric($lead)) {
            $this->selectedLead = Lead::find($lead);
        } else {
            $this->selectedLead = $lead;
        }

        if (!$this->selectedLead) {
            session()->flash('error', 'Lead not found.');
            return;
        }

        $this->companyName = '';
        $this->description = '';
        $this->showConvertModal = true;
    }

    public function closeConvertModal()
    {
        $this->showConvertModal = false;
        $this->selectedLead = null;
        $this->companyName = '';
        $this->description = '';
    }

    public function openViewModal(Lead $lead)
    {
        $this->selectedLead = $lead;
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->selectedLead = null;
        $this->remark = '';
    }

    public function openPromoteModal(Lead $lead, $targetStatus)
    {
        $this->selectedLead = $lead;
        $this->targetStatus = $targetStatus;
        $this->promoteDescription = '';
        $this->showPromoteModal = true;
    }

    public function closePromoteModal()
    {
        $this->showPromoteModal = false;
        $this->selectedLead = null;
        $this->targetStatus = '';
        $this->promoteDescription = '';
    }

    public function openHoldModal(Lead $lead)
    {
        $this->selectedLead = $lead;
        $this->holdDescription = '';
        $this->showHoldModal = true;
    }

    public function closeHoldModal()
    {
        $this->showHoldModal = false;
        $this->selectedLead = null;
        $this->holdDescription = '';
    }

    public function openLostModal(Lead $lead)
    {
        $this->selectedLead = $lead;
        $this->lostDescription = '';
        $this->showLostModal = true;
    }

    public function closeLostModal()
    {
        $this->showLostModal = false;
        $this->selectedLead = null;
        $this->lostDescription = '';
    }

    public function promoteLead()
    {
        if (!auth()->user()->can('update lead status')) {
            session()->flash('error', 'You do not have permission to update lead status.');
            return;
        }

        $this->validate([
            'promoteDescription' => 'required|string|min:3',
        ]);

        if ($this->selectedLead && $this->targetStatus) {
            // Check if promoting to converted status
            if ($this->targetStatus === Lead::STATUS_CONVERTED) {
                // Store the lead before closing the modal
                $leadToConvert = $this->selectedLead;
                $this->closePromoteModal();
                $this->openConvertModal($leadToConvert);
                return;
            }

            // Update lead status for non-conversion promotions
            $this->selectedLead->update(['status' => $this->targetStatus]);

            // Add preset remark
            $statusLabels = Lead::getStatuses();
            $statusLabel = $statusLabels[$this->targetStatus] ?? $this->targetStatus;
            
            $presetRemark = "Status promoted to: {$statusLabel}";
            if ($this->promoteDescription) {
                $presetRemark .= "\n\nDescription: {$this->promoteDescription}";
            }
            $presetRemark .= "\n\nPromoted by: " . auth()->user()->name;

            LeadRemark::create([
                'lead_id' => $this->selectedLead->id,
                'user_id' => auth()->id(),
                'remark' => $presetRemark,
            ]);

            session()->flash('status', 'Lead status promoted successfully.');
            $this->closePromoteModal();
        }
    }

    public function markAsDead()
    {
        if (!auth()->user()->can('update lead status')) {
            session()->flash('error', 'You do not have permission to update lead status.');
            return;
        }

        $this->validate([
            'lostDescription' => 'required|string|min:3',
        ]);

        if ($this->selectedLead) {
            $this->selectedLead->update(['status' => Lead::STATUS_DEAD]);
            
            // Add preset remark with description
            LeadRemark::create([
                'lead_id' => $this->selectedLead->id,
                'user_id' => auth()->id(),
                'remark' => "Lead marked as LOST\n\nReason: {$this->lostDescription}\n\nMarked by: " . auth()->user()->name,
            ]);

            session()->flash('status', 'Lead marked as lost.');
            $this->closeLostModal();
        }
    }

    public function markAsOnHold()
    {
        if (!auth()->user()->can('update lead status')) {
            session()->flash('error', 'You do not have permission to update lead status.');
            return;
        }

        $this->validate([
            'holdDescription' => 'required|string|min:3',
        ]);

        if ($this->selectedLead) {
            $this->selectedLead->update(['status' => Lead::STATUS_ON_HOLD]);
            
            // Add preset remark with description
            LeadRemark::create([
                'lead_id' => $this->selectedLead->id,
                'user_id' => auth()->id(),
                'remark' => "Lead marked as ON HOLD\n\nReason: {$this->holdDescription}\n\nMarked by: " . auth()->user()->name,
            ]);

            session()->flash('status', 'Lead marked as on hold.');
            $this->closeHoldModal();
        }
    }

    public function unholdLead(Lead $lead)
    {
        if (!auth()->user()->can('update lead status')) {
            session()->flash('error', 'You do not have permission to update lead status.');
            return;
        }

        $lead->update(['status' => $lead->getPreviousStatus()]);
        
        // Add preset remark
        LeadRemark::create([
            'lead_id' => $lead->id,
            'user_id' => auth()->id(),
            'remark' => "Lead removed from HOLD and restored to " . strtoupper(str_replace('_', ' ', $lead->getPreviousStatus())) . "\n\nRestored by: " . auth()->user()->name,
        ]);

        session()->flash('status', 'Lead removed from hold and restored.');
    }

    public function undeadLead(Lead $lead)
    {
        if (!auth()->user()->can('update lead status')) {
            session()->flash('error', 'You do not have permission to update lead status.');
            return;
        }

        $lead->update(['status' => $lead->getPreviousStatus()]);
        
        // Add preset remark
        LeadRemark::create([
            'lead_id' => $lead->id,
            'user_id' => auth()->id(),
            'remark' => "Lead restored from LOST status to " . strtoupper(str_replace('_', ' ', $lead->getPreviousStatus())) . "\n\nRestored by: " . auth()->user()->name,
        ]);

        session()->flash('status', 'Lead restored from lost status.');
    }

    public function addRemark()
    {
        if (!auth()->user()->can('add lead remark')) {
            session()->flash('error', 'You do not have permission to add lead remarks.');
            return;
        }

        $this->validate([
            'remark' => 'required|string|min:3',
        ]);

        if ($this->selectedLead) {
            LeadRemark::create([
                'lead_id' => $this->selectedLead->id,
                'user_id' => auth()->id(),
                'remark' => $this->remark,
            ]);

            $this->remark = '';
            session()->flash('status', 'Remark added successfully.');
        }
    }

    public function deleteRemark(LeadRemark $remark)
    {
        $remark->delete();
        session()->flash('status', 'Remark deleted successfully.');
    }

    public function convertToClient()
    {
        if (!auth()->user()->can('convert lead to client')) {
            session()->flash('error', 'You do not have permission to convert leads to clients.');
            return;
        }

        $this->validate([
            'companyName' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($this->selectedLead && !$this->selectedLead->converted_to_client) {
            // Create client from lead data
            $client = Client::create([
                'client_name' => $this->selectedLead->name,
                'company_name' => $this->companyName,
                'description' => $this->description,
                'email' => $this->selectedLead->email,
                'mobile' => $this->selectedLead->mobile,
            ]);

            // Update lead to mark as converted and update status
            $this->selectedLead->update([
                'converted_to_client' => true,
                'client_id' => $client->id,
                'status' => Lead::STATUS_CONVERTED,
            ]);

            // Add preset remark for conversion
            LeadRemark::create([
                'lead_id' => $this->selectedLead->id,
                'user_id' => auth()->id(),
                'remark' => "Lead converted to client successfully\n\nClient: {$this->companyName}\nDescription: {$this->description}\n\nConverted by: " . auth()->user()->name,
            ]);

            session()->flash('status', 'Lead converted to client successfully.');
            $this->closeConvertModal();
        }
    }

    private function applyDateRangeFilter($query, $dateRange)
    {
        $now = now();
        
        switch ($dateRange) {
            case 'today':
                $query->whereDate('created_at', $now->toDateString());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', $now->month)
                      ->whereYear('created_at', $now->year);
                break;
            case 'last_week':
                $query->whereBetween('created_at', [$now->subWeek()->startOfWeek(), $now->subWeek()->endOfWeek()]);
                break;
            case 'last_month':
                $query->whereMonth('created_at', $now->subMonth()->month)
                      ->whereYear('created_at', $now->subMonth()->year);
                break;
            case 'last_30_days':
                $query->where('created_at', '>=', $now->subDays(30));
                break;
            case 'last_90_days':
                $query->where('created_at', '>=', $now->subDays(90));
                break;
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->productType = '';
        $this->dateRange = '';
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function render()
    {
        $leads = Lead::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('mobile', 'like', '%' . $this->search . '%')
                  ->orWhere('product_type', 'like', '%' . $this->search . '%');
        })
        ->when($this->status, function ($query) {
            $query->where('status', $this->status);
        })
        ->when($this->productType, function ($query) {
            $query->where('product_type', 'like', '%' . $this->productType . '%');
        })
        ->when($this->dateRange, function ($query) {
            $this->applyDateRangeFilter($query, $this->dateRange);
        })
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);

        $remarks = collect();
        if ($this->selectedLead) {
            $remarks = $this->selectedLead->remarks()->with('user')->orderBy('created_at', 'desc')->get();
        }

        return view('livewire.pages.admin.leads.index', [
            'leads' => $leads,
            'remarks' => $remarks,
        ]);
    }

    protected function paginationTheme()
    {
        return 'tailwind';
    }
}
