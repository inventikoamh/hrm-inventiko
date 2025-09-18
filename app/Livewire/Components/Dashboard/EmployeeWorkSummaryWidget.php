<?php

namespace App\Livewire\Components\Dashboard;

use App\Models\Attendance;
use App\Models\LeaveRequest;
use Livewire\Component;
use Carbon\Carbon;

class EmployeeWorkSummaryWidget extends Component
{
    protected $listeners = ['attendance-updated' => 'refreshWidget'];

    public function refreshWidget()
    {
        // This method will be called when attendance is updated
        // The render method will automatically recalculate the times
    }

    public function render()
    {
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        // Today's work - get all attendance records for today
        $todayAttendances = Attendance::where('user_id', auth()->id())
            ->whereDate('clock_in_at', $today)
            ->get();
        
        $todayHours = 0;
        foreach ($todayAttendances as $attendance) {
            if ($attendance->clock_out_at) {
                // Completed session
                $sessionMinutes = $attendance->clock_in_at->diffInMinutes($attendance->clock_out_at);
                $todayHours += $sessionMinutes / 60;
            } else {
                // Current active session
                $sessionMinutes = $attendance->clock_in_at->diffInMinutes(now());
                $todayHours += $sessionMinutes / 60;
            }
        }

        // This week's work
        $weekAttendances = Attendance::where('user_id', auth()->id())
            ->whereBetween('clock_in_at', [$thisWeek, Carbon::now()])
            ->get();
        
        $weekHours = 0;
        foreach ($weekAttendances as $attendance) {
            if ($attendance->clock_out_at) {
                // Completed session
                $sessionMinutes = $attendance->clock_in_at->diffInMinutes($attendance->clock_out_at);
                $weekHours += $sessionMinutes / 60;
            } else {
                // Current active session
                $sessionMinutes = $attendance->clock_in_at->diffInMinutes(now());
                $weekHours += $sessionMinutes / 60;
            }
        }

        // Leave requests
        $pendingLeaves = LeaveRequest::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->count();
        
        $approvedLeaves = LeaveRequest::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->count();

        return view('livewire.components.dashboard.employee-work-summary-widget', [
            'todayHours' => $todayHours,
            'weekHours' => $weekHours,
            'pendingLeaves' => $pendingLeaves,
            'approvedLeaves' => $approvedLeaves,
        ]);
    }
}
