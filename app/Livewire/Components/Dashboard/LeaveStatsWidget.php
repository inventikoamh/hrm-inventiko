<?php

namespace App\Livewire\Components\Dashboard;

use App\Models\LeaveRequest;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon;

class LeaveStatsWidget extends Component
{
    public function render()
    {
        $today = Carbon::today();
        
        $pendingLeaves = LeaveRequest::where('status', 'pending')->count();
        $approvedLeaves = LeaveRequest::where('status', 'approved')->count();
        $rejectedLeaves = LeaveRequest::where('status', 'rejected')->count();
        $leavesThisMonth = LeaveRequest::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        // Count users on approved leave today (all user types)
        $onLeaveToday = User::whereHas('leaveRequests', function($query) use ($today) {
            $query->where('status', 'approved')
                  ->where('start_date', '<=', $today)
                  ->where('end_date', '>=', $today);
        })->count();

        return view('livewire.components.dashboard.leave-stats-widget', [
            'pendingLeaves' => $pendingLeaves,
            'approvedLeaves' => $approvedLeaves,
            'rejectedLeaves' => $rejectedLeaves,
            'leavesThisMonth' => $leavesThisMonth,
            'onLeaveToday' => $onLeaveToday,
        ]);
    }
}
