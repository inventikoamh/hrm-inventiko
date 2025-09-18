<?php

namespace App\Livewire\Components;

use App\Models\Attendance;
use Illuminate\Support\Carbon;
use Livewire\Component;

class WorkDurationWidget extends Component
{
    public ?Attendance $active = null;
    public string $workDuration = '00:00:00';
    public string $clockInTime = '';
    public bool $isClockedIn = false;

    protected $listeners = ['attendance-updated' => 'refreshDuration'];

    public function mount(): void
    {
        $this->loadActiveAttendance();
    }

    public function loadActiveAttendance(): void
    {
        $this->active = Attendance::where('user_id', auth()->id())
            ->whereNull('clock_out_at')
            ->latest('clock_in_at')
            ->first();

        if ($this->active) {
            $this->isClockedIn = true;
            $this->clockInTime = $this->active->clock_in_at;
            $this->updateWorkDuration();
        } else {
            $this->isClockedIn = false;
            $this->workDuration = '00:00:00';
            $this->clockInTime = '';
        }
    }

    public function updateWorkDuration(): void
    {
        if ($this->active && $this->active->clock_in_at) {
            // Parse the clock in time
            $clockInTime = \Carbon\Carbon::parse($this->active->clock_in_at);
            $now = \Carbon\Carbon::now('Asia/Kolkata');
            
            // Calculate duration in minutes (clockIn to now)
            $totalMinutes = $clockInTime->diffInMinutes($now);
            
            // Calculate hours, minutes, and seconds
            $hours = floor($totalMinutes / 60);
            $minutes = $totalMinutes % 60;
            $seconds = $clockInTime->diffInSeconds($now) % 60;
            
            $this->workDuration = sprintf(
                '%02d:%02d:%02d',
                $hours,
                $minutes,
                $seconds
            );
        } else {
            $this->workDuration = '00:00:00';
        }
    }

    public function refreshDuration()
    {
        $this->loadActiveAttendance();
    }

    public function updated()
    {
        // This method is called whenever the component updates
        // We can use this to refresh the duration periodically
        if ($this->isClockedIn) {
            $this->updateWorkDuration();
        }
    }

    public function getTodayTotalDuration(): string
    {
        $today = \Carbon\Carbon::today('Asia/Kolkata');
        $tomorrow = $today->copy()->addDay();
        
        // Get all completed attendance records for today
        $completedAttendances = Attendance::where('user_id', auth()->id())
            ->whereNotNull('clock_out_at')
            ->whereBetween('clock_in_at', [$today, $tomorrow])
            ->get();

        $totalMinutes = 0;

        foreach ($completedAttendances as $attendance) {
            $clockIn = \Carbon\Carbon::parse($attendance->clock_in_at);
            $clockOut = \Carbon\Carbon::parse($attendance->clock_out_at);
            
            // Calculate duration in minutes (clockIn to clockOut)
            $sessionMinutes = $clockIn->diffInMinutes($clockOut);
            
            // Only add positive durations
            if ($sessionMinutes > 0) {
                $totalMinutes += $sessionMinutes;
            }
        }

        // Add current session if clocked in
        if ($this->active && $this->active->clock_in_at) {
            $clockIn = \Carbon\Carbon::parse($this->active->clock_in_at);
            $now = \Carbon\Carbon::now('Asia/Kolkata');
            
            // Calculate current session duration (clockIn to now)
            $currentSessionMinutes = $clockIn->diffInMinutes($now);
            
            // Only add positive durations
            if ($currentSessionMinutes > 0) {
                $totalMinutes += $currentSessionMinutes;
            }
        }

        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    public function render()
    {
        return view('livewire.components.work-duration-widget');
    }
}
