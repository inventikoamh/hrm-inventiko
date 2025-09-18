<?php

use App\Models\Attendance;
use App\Models\AttendanceLog;
use Illuminate\Support\Carbon;
use Livewire\Volt\Component;

new class extends Component
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
            ->limit(10)
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
            ->limit(10)
            ->get();
        session()->flash('status', 'Clocked in.');
    }

    public function clockOut(): void
    {
        $this->validate([
            'statusText' => ['required', 'string', 'min:3']
        ]);

        if (! $this->active) {
            session()->flash('error', 'Not currently clocked in.');
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

        $this->statusText = '';
        $this->active = null;
        $this->logs = AttendanceLog::where('user_id', auth()->id())
            ->orderByDesc('logged_at')
            ->limit(10)
            ->get();
        session()->flash('status', 'Clocked out.');
    }
}; ?>

<div class="bg-white p-3 rounded border shadow-sm max-w-md text-sm">
    <h3 class="font-semibold text-base mb-2">Attendance</h3>

    @if (session('status'))
        <div class="mb-2 text-green-700">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-2 text-red-700">{{ session('error') }}</div>
    @endif

    @if(auth()->user()->isOnLeave())
        <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-blue-800 font-medium">You are currently on leave</span>
            </div>
        </div>
    @else
        <div class="mb-3">
            <label class="block text-xs text-gray-700">Work status</label>
            <textarea wire:model.live="statusText" rows="2" class="mt-1 w-full border rounded px-2 py-1.5 text-sm" placeholder="What are you working on?"></textarea>
            @error('statusText') <div class="text-xs text-red-600">{{ $message }}</div> @enderror
        </div>

        <div class="flex gap-2">
            @if (!$active)
                <button wire:click="clockIn" class="px-3 py-1.5 bg-emerald-600 text-white rounded">Clock In</button>
            @else
                <button wire:click="clockOut" class="px-3 py-1.5 bg-rose-600 text-white rounded">Clock Out</button>
            @endif
        </div>
    @endif
    <div class="mt-3" x-data="{open:false}">
        <button type="button" @click="open=!open" class="text-xs text-gray-600 hover:text-gray-800"><span x-text="open ? 'Hide' : 'Show'"></span> recent logs</button>
        <div x-show="open" x-collapse class="mt-2 space-y-2 max-h-48 overflow-y-auto">
            @forelse(($logs ?? collect())->take(3) as $log)
                <div class="border rounded p-2">
                    <div class="flex justify-between">
                        <span class="font-medium {{ $log->type === 'clock_in' ? 'text-emerald-700' : 'text-rose-700' }}">{{ ucfirst(str_replace('_',' ', $log->type)) }}</span>
                        <span class="text-gray-500">{{ $log->logged_at->format('Y-m-d H:i') }}</span>
                    </div>
                    <div class="text-gray-700 mt-1">{{ $log->status }}</div>
                </div>
            @empty
                <div class="text-gray-500 text-xs">No logs yet.</div>
            @endforelse
        </div>
    </div>
</div>


