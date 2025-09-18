<?php

namespace App\Livewire\Pages\Employee;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\Setting;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Request Leave')]
class LeaveRequestForm extends Component
{
    public $type = '';
    public $start_date = '';
    public $end_date = '';
    public $reason = '';
    public $total_days = 0;

    protected $rules = [
        'type' => 'required|in:sick,casual,festival,privilege,emergency',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|min:10|max:500',
    ];

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

    public function submit()
    {
        $this->validate();

        // Check for overlapping leave requests
        $overlappingRequest = LeaveRequest::where('user_id', auth()->id())
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

        LeaveRequest::create([
            'user_id' => auth()->id(),
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_days' => $this->total_days,
            'reason' => $this->reason,
        ]);

        session()->flash('success', 'Leave request submitted successfully!');
        
        $this->reset();
        
        return $this->redirect(route('employee.my-leave-requests'));
    }

    public function render()
    {
        return view('livewire.pages.employee.leave-request-form', [
            'leaveTypes' => array_combine(
                array_map('strtolower', array_map('str_replace', [' ', ' '], ['_', '_'], Setting::getEnumValues('leave_type'))),
                Setting::getEnumValues('leave_type')
            )
        ]);
    }
}