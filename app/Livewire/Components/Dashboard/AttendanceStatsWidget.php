<?php

namespace App\Livewire\Components\Dashboard;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Setting;
use Livewire\Component;
use Carbon\Carbon;

class AttendanceStatsWidget extends Component
{
    public function render()
    {
        $today = Carbon::today();
        
        // Get total active users (exclude admin users from attendance stats)
        $totalUsers = User::count();
        
        // Count unique users who clocked in today
        $presentToday = Attendance::whereDate('clock_in_at', $today)
            ->distinct('user_id')
            ->count('user_id');
        
        // Count users who clocked in late (after configured time)
        $lateClockInTime = Setting::getLateClockInTime();
        $lateToday = Attendance::whereDate('clock_in_at', $today)
            ->whereTime('clock_in_at', '>', $lateClockInTime)
            ->distinct('user_id')
            ->count('user_id');
        
        // Count users who are currently online (clocked in but not clocked out)
        $onlineNow = Attendance::whereDate('clock_in_at', $today)
            ->whereNull('clock_out_at')
            ->distinct('user_id')
            ->count('user_id');
        
        // Calculate absent users (total - present - online)
        $absentToday = max(0, $totalUsers - $presentToday - $onlineNow);

        return view('livewire.components.dashboard.attendance-stats-widget', [
            'totalUsers' => $totalUsers,
            'presentToday' => $presentToday,
            'lateToday' => $lateToday,
            'onlineNow' => $onlineNow,
            'absentToday' => $absentToday,
        ]);
    }
}
