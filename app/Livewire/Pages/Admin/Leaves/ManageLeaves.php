<?php

namespace App\Livewire\Pages\Admin\Leaves;

use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\LeaveRequest;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Manage Leaves')]
class ManageLeaves extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $typeFilter = '';
    public $userFilter = '';
    public $sourceFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingUserFilter()
    {
        $this->resetPage();
    }

    public function updatingSourceFilter()
    {
        $this->resetPage();
    }

    public function approve($leaveId)
    {
        $leave = Leave::findOrFail($leaveId);
        
        if ($leave->status !== 'pending') {
            session()->flash('error', 'Only pending leaves can be approved.');
            return;
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        // Update leave balance - add the used days
        LeaveBalance::updateUsedLeaves($leave->user_id, $leave->type, $leave->total_days, 'add');

        session()->flash('success', 'Leave approved successfully!');
    }

    public function reject($leaveId)
    {
        $leave = Leave::findOrFail($leaveId);
        
        if ($leave->status !== 'pending') {
            session()->flash('error', 'Only pending leaves can be rejected.');
            return;
        }

        $leave->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        session()->flash('success', 'Leave rejected successfully!');
    }

    public function delete($leaveId)
    {
        if (!auth()->user()->can('delete leaves')) {
            session()->flash('error', 'You do not have permission to delete leaves.');
            return;
        }

        $leave = Leave::findOrFail($leaveId);
        
        // Update leave balance - subtract the used days
        if ($leave->status === 'approved') {
            LeaveBalance::updateUsedLeaves($leave->user_id, $leave->type, $leave->total_days, 'subtract');
        }
        
        // If this leave was created from a request, delete the request too
        if ($leave->source === 'requested' && $leave->leave_request_id) {
            $leaveRequest = LeaveRequest::find($leave->leave_request_id);
            if ($leaveRequest) {
                $leaveRequest->delete();
            }
        }
        
        $leave->delete();
        
        session()->flash('success', 'Leave deleted successfully!');
    }

    public function render()
    {
        $leaves = Leave::with(['user', 'approver'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('type', $this->typeFilter);
            })
            ->when($this->userFilter, function ($query) {
                $query->where('user_id', $this->userFilter);
            })
            ->when($this->sourceFilter, function ($query) {
                $query->where('source', $this->sourceFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.pages.admin.leaves.manage-leaves', [
            'leaves' => $leaves,
            'users' => User::orderBy('name')->get(),
            'leaveTypes' => [
                'sick' => 'Sick Leave',
                'casual' => 'Casual Leave',
                'festival' => 'Festival Leave',
                'privilege' => 'Privilege Leave',
                'emergency' => 'Emergency Leave',
            ],
            'statuses' => [
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
            ],
            'sources' => [
                'marked' => 'Marked by Admin',
                'requested' => 'Requested by Employee',
            ]
        ]);
    }
}