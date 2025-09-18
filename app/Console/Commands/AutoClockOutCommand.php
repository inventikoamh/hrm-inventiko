<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoClockOutCommand extends Command
{
    protected $signature = 'attendance:auto-clockout';
    protected $description = 'Automatically clock out users who forgot to clock out (only those who never clocked out)';

    public function handle()
    {
        $this->info('Starting automatic clock-out process...');
        
        // Get current time in Asia/Kolkata timezone
        $now = Carbon::now('Asia/Kolkata');
        $autoClockOutTime = Setting::getAutoClockOutTime();
        $endOfDay = Carbon::today('Asia/Kolkata')->setTimeFromTimeString($autoClockOutTime);
        
        // Only run if it's past the configured auto clock-out time
        if ($now->lt($endOfDay)) {
            $this->info("It's not yet {$autoClockOutTime}. No auto clock-out needed.");
            return;
        }
        
        // Find all users who are still clocked in (no clock_out_at at all)
        // Only process records from previous days (not today)
        $activeAttendances = Attendance::whereNull('clock_out_at')
            ->whereDate('clock_in_at', '<', $now->toDateString())
            ->with('user')
            ->get();
            
        if ($activeAttendances->isEmpty()) {
            $this->info('No users need auto clock-out.');
            return;
        }
        
        $this->info("Found {$activeAttendances->count()} users to auto clock-out.");
        
        foreach ($activeAttendances as $attendance) {
            // Set clock out time to the configured auto clock-out time of the clock-in day
            $clockInDate = Carbon::parse($attendance->clock_in_at)->startOfDay();
            $configuredTime = Setting::getAutoClockOutTime();
            $autoClockOutTime = $clockInDate->copy()->setTimeFromTimeString($configuredTime);
            
            // Update attendance record
            $attendance->update([
                'clock_out_at' => $autoClockOutTime
            ]);
            
            // Create attendance log
            AttendanceLog::create([
                'attendance_id' => $attendance->id,
                'user_id' => $attendance->user_id,
                'type' => 'clock_out',
                'status' => "Auto clock-out at end of day ({$configuredTime}) - User forgot to clock out",
                'logged_at' => $autoClockOutTime,
            ]);
            
            $this->info("Auto clocked out: {$attendance->user->name} at {$autoClockOutTime->format('Y-m-d H:i:s')} (forgot to clock out)");
        }
        
        $this->info('Auto clock-out process completed.');
    }
}