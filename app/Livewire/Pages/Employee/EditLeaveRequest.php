<?php

namespace App\Livewire\Pages\Employee;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Edit Leave Request')]
class EditLeaveRequest extends Component
{
    public $leaveRequest;
    public $type = '';
    public $start_date = '';
    public $end_date = '';
    public $reason = '';
    public $total_days = 0;
    public $isResubmit = false;
    public $resubmitNote = '';

    protected $rules = [
        'type' => 'required|in:sick,casual,festival,privilege,emergency',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|min:10|max:500',
        'resubmitNote' => 'nullable|string|max:500',
    ];

    public function mount($id)
    {
        $this->leaveRequest = LeaveRequest::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Check if user can edit this request
        if ($this->leaveRequest->status === 'approved') {
            session()->flash('error', 'You cannot edit an approved leave request.');
            return $this->redirect(route('employee.my-leave-requests'));
        }

        $this->isResubmit = $this->leaveRequest->status === 'rejected';
        
        // Populate form with existing data
        $this->type = $this->leaveRequest->type;
        $this->start_date = $this->leaveRequest->start_date->format('Y-m-d');
        $this->end_date = $this->leaveRequest->end_date->format('Y-m-d');
        $this->reason = $this->leaveRequest->reason;
        $this->total_days = $this->leaveRequest->total_days;
    }

    public function updatedStartDate()
    {
        $this->calculateDays();
    }

    public function updatedEndDate()
    {
        $this->calculateDays();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['start_date', 'end_date'])) {
            $this->calculateDays();
        }
    }

    public function calculateDays()
    {
        if ($this->start_date && $this->end_date) {
            $this->total_days = LeaveRequest::calculateDays($this->start_date, $this->end_date);
        } else {
            $this->total_days = 0;
        }
    }

    public function update()
    {
        $this->validate();

        // Check for overlapping leave requests (excluding current one)
        $overlappingRequest = LeaveRequest::where('user_id', auth()->id())
            ->where('id', '!=', $this->leaveRequest->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($query) {
                $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                    ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                    ->orWhere(function ($q) {
                        $q->where('start_date', '<=', $this->start_date)
                          ->where('end_date', '>=', $this->end_date);
                    });
            })
            ->exists();

        if ($overlappingRequest) {
            session()->flash('error', 'You already have a pending or approved leave request during the selected period.');
            return;
        }

        // Check leave balance
        $balance = LeaveBalance::getOrCreate(auth()->id(), $this->type);
        if (!$balance->hasEnoughBalance($this->total_days)) {
            session()->flash('error', "Insufficient leave balance. You have {$balance->remaining} days remaining for {$balance->type_name}, but requesting {$this->total_days} days.");
            return;
        }

        // Update the leave request
        $updateData = [
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_days' => $this->total_days,
            'reason' => $this->reason,
        ];

        // If resubmitting a rejected request, reset status and add note
        if ($this->isResubmit) {
            $updateData['status'] = 'pending';
            $updateData['reviewed_by'] = null;
            $updateData['reviewed_at'] = null;
            $updateData['admin_remark'] = null;
            
            // Add resubmit note to reason if provided
            if ($this->resubmitNote) {
                $updateData['reason'] = $this->reason . "\n\nResubmit Note: " . $this->resubmitNote;
            }
        }

        $this->leaveRequest->update($updateData);

        $message = $this->isResubmit ? 'Leave request resubmitted successfully!' : 'Leave request updated successfully!';
        session()->flash('success', $message);
        
        return $this->redirect(route('employee.my-leave-requests'));
    }

    public function render()
    {
        return view('livewire.pages.employee.edit-leave-request', [
            'leaveTypes' => [
                'sick' => 'Sick Leave',
                'casual' => 'Casual Leave',
                'festival' => 'Festival Leave',
                'privilege' => 'Privilege Leave',
                'emergency' => 'Emergency Leave',
            ]
        ]);
    }
}