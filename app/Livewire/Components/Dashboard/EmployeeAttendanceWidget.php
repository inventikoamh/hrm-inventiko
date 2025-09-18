<?php

namespace App\Livewire\Components\Dashboard;

use App\Models\Attendance;
use App\Models\AttendanceLog;
use Livewire\Component;

class EmployeeAttendanceWidget extends Component
{
    public string $statusText = '';
    public ?Attendance $active = null;
    public $logs;

    public function mount(): void
    {
        $this->active = Attendance::where('user_id', auth()->id())
            ->whereNull('clock_out_at')
            ->latest('clock_in_at')
            ->first();
        $this->logs = AttendanceLog::where('user_id', auth()->id())
            ->orderByDesc('logged_at')
            ->limit(5)
            ->get();
    }

    public function clockIn(): void
    {
        $this->validate([
            'statusText' => ['required', 'string', 'min:3']
        ]);

        // Check if user is on leave
        if (auth()->user()->isOnLeave()) {
            session()->flash('error', 'You are currently on leave and cannot clock in.');
            return;
        }

        if ($this->active) {
            session()->flash('error', 'Already clocked in.');
            return;
        }

        $clockInTime = \Carbon\Carbon::now('Asia/Kolkata');

        $attendance = Attendance::create([
            'user_id' => auth()->id(),
            'clock_in_at' => $clockInTime,
        ]);

        AttendanceLog::create([
            'attendance_id' => $attendance->id,
            'user_id' => auth()->id(),
            'type' => 'clock_in',
            'status' => $this->statusText,
            'logged_at' => now()->setTimezone('Asia/Kolkata'),
        ]);

        $this->statusText = '';
        $this->active = $attendance;
        $this->logs = AttendanceLog::where('user_id', auth()->id())
            ->orderByDesc('logged_at')
            ->limit(5)
            ->get();
        session()->flash('status', 'Clocked in successfully.');
    }

    public function clockOut(): void
    {
        if (!$this->active) {
            session()->flash('error', 'Not clocked in.');
            return;
        }

        $clockOutTime = \Carbon\Carbon::now('Asia/Kolkata');
        
        $this->active->update([
            'clock_out_at' => $clockOutTime,
        ]);

        AttendanceLog::create([
            'attendance_id' => $this->active->id,
            'user_id' => auth()->id(),
            'type' => 'clock_out',
            'status' => 'Clocked out',
            'logged_at' => now()->setTimezone('Asia/Kolkata'),
        ]);

        $this->active = null;
        $this->logs = AttendanceLog::where('user_id', auth()->id())
            ->orderByDesc('logged_at')
            ->limit(5)
            ->get();
        session()->flash('status', 'Clocked out successfully.');
    }

    public function render()
    {
        return view('livewire.components.dashboard.employee-attendance-widget');
    }
}
