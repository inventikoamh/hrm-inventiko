<?php

namespace App\Livewire\Pages\Admin;

use App\Models\LeaveRequest;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Leave Requests')]
class LeaveRequests extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $typeFilter = '';
    public $userFilter = '';

    public $selectedRequest = null;
    public $adminRemark = '';

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

    public function selectRequest($requestId)
    {
        $this->selectedRequest = LeaveRequest::with(['user', 'reviewer'])->findOrFail($requestId);
        $this->adminRemark = '';
        $this->dispatch('open-modal');
    }

    public function approve()
    {
        if (!auth()->user()->can('approve leave requests')) {
            session()->flash('error', 'You do not have permission to approve leave requests.');
            return;
        }

        if (!$this->selectedRequest) {
            session()->flash('error', 'No request selected.');
            return;
        }

        if ($this->selectedRequest->status !== 'pending') {
            session()->flash('error', 'Only pending requests can be approved.');
            return;
        }

        $this->selectedRequest->approve(auth()->id(), $this->adminRemark);
        
        session()->flash('success', 'Leave request approved successfully!');
        $this->selectedRequest = null;
        $this->adminRemark = '';
        $this->dispatch('close-modal');
        
        return $this->redirect(route('admin.leaves.manage'));
    }

    public function reject()
    {
        if (!auth()->user()->can('approve leave requests')) {
            session()->flash('error', 'You do not have permission to approve leave requests.');
            return;
        }

        if (!$this->selectedRequest) {
            session()->flash('error', 'No request selected.');
            return;
        }

        if ($this->selectedRequest->status !== 'pending') {
            session()->flash('error', 'Only pending requests can be rejected.');
            return;
        }

        $this->selectedRequest->reject(auth()->id(), $this->adminRemark);
        
        session()->flash('success', 'Leave request rejected successfully!');
        $this->selectedRequest = null;
        $this->adminRemark = '';
        $this->dispatch('close-modal');
        
        return $this->redirect(route('admin.leave-requests.index'));
    }

    public function closeModal()
    {
        $this->selectedRequest = null;
        $this->adminRemark = '';
        $this->dispatch('close-modal');
    }

    public function render()
    {
        $leaveRequests = LeaveRequest::with(['user', 'reviewer'])
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                })->orWhere('reason', 'like', '%' . $this->search . '%');
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
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.pages.admin.leave-requests', [
            'leaveRequests' => $leaveRequests,
            'users' => User::orderBy('first_name')->get(),
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
            ]
        ]);
    }

    protected function paginationTheme()
    {
        return 'tailwind';
    }
}