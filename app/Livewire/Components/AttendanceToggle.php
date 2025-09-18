<?php

namespace App\Livewire\Components;

use App\Models\Attendance;
use App\Models\AttendanceLog;
use Illuminate\Support\Carbon;
use Livewire\Component;

class AttendanceToggle extends Component
{
    public string $statusText = '';
    public ?Attendance $active = null;
    public bool $showModal = false;

    public function mount(): void
    {
        $this->active = Attendance::where('user_id', auth()->id())
            ->whereNull('clock_out_at')
            ->latest('clock_in_at')
            ->first();
    }

    public function toggleModal(): void
    {
        $this->showModal = true;
        $this->statusText = '';
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->statusText = '';
    }

    public function clockIn(): void
    {
        $this->validate([
            'statusText' => ['required', 'string', 'min:3']
        ]);

        // Check if user is on leave
        if (auth()->user()->isOnLeave()) {
            session()->flash('error', 'You are currently on leave and cannot clock in.');
            $this->closeModal();
            return;
        }

        if ($this->active) {
            session()->flash('error', 'Already clocked in.');
            $this->closeModal();
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

        $this->active = $attendance;
        $this->closeModal();
        session()->flash('status', 'Clocked in successfully.');
        
        // Dispatch event to refresh work duration widget
        $this->dispatch('attendance-updated');
    }

    public function clockOut(): void
    {
        $this->validate([
            'statusText' => ['required', 'string', 'min:3']
        ]);

        if (! $this->active) {
            session()->flash('error', 'Not currently clocked in.');
            $this->closeModal();
            return;
        }

        $clockOutTime = \Carbon\Carbon::now('Asia/Kolkata');

        $this->active->update(['clock_out_at' => $clockOutTime]);

        AttendanceLog::create([
            'attendance_id' => $this->active->id,
            'user_id' => auth()->id(),
            'type' => 'clock_out',
            'status' => $this->statusText,
            'logged_at' => $clockOutTime,
        ]);

        $this->active = null;
        $this->closeModal();
        session()->flash('status', 'Clocked out successfully.');
        
        // Dispatch event to refresh work duration widget
        $this->dispatch('attendance-updated');
    }

    public function render()
    {
        return view('livewire.components.attendance-toggle');
    }
}
