<?php

namespace App\Livewire\Pages\Employee;

use App\Models\LeaveRequest;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('My Leave Requests')]
class MyLeaveRequests extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $leaveRequests = LeaveRequest::where('user_id', auth()->id())
            ->when($this->search, function ($query) {
                $query->where('reason', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.pages.employee.my-leave-requests', [
            'leaveRequests' => $leaveRequests,
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