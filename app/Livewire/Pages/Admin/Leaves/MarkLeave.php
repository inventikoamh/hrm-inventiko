<?php

namespace App\Livewire\Pages\Admin\Leaves;

use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Mark Leave')]
class MarkLeave extends Component
{
    public $user_id = '';
    public $type = '';
    public $start_date = '';
    public $end_date = '';
    public $remark = '';
    public $total_days = 0;
    public $showBalanceModal = false;
    public $balanceIncrease = 0;

    protected $rules = [
        'user_id' => 'required|exists:users,id',
        'type' => 'required|in:sick,casual,festival,privilege,emergency',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'remark' => 'nullable|string|max:500',
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
            $this->total_days = Leave::calculateDays($this->start_date, $this->end_date);
        } else {
            $this->total_days = 0;
        }
    }

    public function save()
    {
        if (!auth()->user()->can('mark leave')) {
            session()->flash('error', 'You do not have permission to mark leaves.');
            return;
        }

        $this->validate();

        // Check for overlapping leaves
        $overlappingLeave = Leave::where('user_id', $this->user_id)
            ->where('status', 'approved')
            ->where(function ($query) {
                $query->whereBetween('start_date', [$this->start_date, $this->end_date])
                    ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                    ->orWhere(function ($q) {
                        $q->where('start_date', '<=', $this->start_date)
                          ->where('end_date', '>=', $this->end_date);
                    });
            })
            ->exists();

        if ($overlappingLeave) {
            session()->flash('error', 'This user already has an approved leave during the selected period.');
            return;
        }

        // Check leave balance
        $balance = LeaveBalance::getOrCreate($this->user_id, $this->type);
        if (!$balance->hasEnoughBalance($this->total_days)) {
            $this->showBalanceModal = true;
            return;
        }

        Leave::create([
            'user_id' => $this->user_id,
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_days' => $this->total_days,
            'remark' => $this->remark,
            'status' => 'approved', // Admin can directly approve
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'source' => 'marked',
        ]);

        // Update leave balance
        LeaveBalance::updateUsedLeaves($this->user_id, $this->type, $this->total_days, 'add');

        session()->flash('success', 'Leave marked successfully!');
        
        $this->reset();
        
        return $this->redirect(route('admin.leaves.manage'));
    }

    public function increaseBalance()
    {
        $this->validate([
            'balanceIncrease' => 'required|integer|min:1'
        ]);

        $balance = LeaveBalance::getOrCreate($this->user_id, $this->type);
        $balance->total_allowed += $this->balanceIncrease;
        $balance->updateRemaining();

        $this->showBalanceModal = false;
        $this->balanceIncrease = 0;

        // Now proceed with marking the leave
        $this->save();
    }

    public function closeBalanceModal()
    {
        $this->showBalanceModal = false;
        $this->balanceIncrease = 0;
    }

    public function render()
    {
        return view('livewire.pages.admin.leaves.mark-leave', [
            'users' => User::orderBy('name')->get(),
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