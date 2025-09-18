<?php

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.app')] class extends Component
{
    public string $selectedDate;
    public int $thresholdHour = 9; // 9 AM threshold for late
    public int $thresholdMinute = 0;

    public function mount(): void
    {
        $this->selectedDate = now()->setTimezone('Asia/Kolkata')->format('Y-m-d');
    }

    public function previousDay(): void
    {
        $date = Carbon::parse($this->selectedDate)->subDay();
        $this->selectedDate = $date->format('Y-m-d');
    }

    public function nextDay(): void
    {
        $date = Carbon::parse($this->selectedDate)->addDay();
        if ($date->isFuture()) {
            session()->flash('error', 'Cannot view future dates.');
            return;
        }
        $this->selectedDate = $date->format('Y-m-d');
    }

    public function getAttendanceData(): array
    {
        $date = Carbon::parse($this->selectedDate)->setTimezone('Asia/Kolkata');
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();
        $threshold = $date->copy()->setTime($this->thresholdHour, $this->thresholdMinute);

        $users = User::all();
        $data = [];

        foreach ($users as $user) {
            $attendances = Attendance::where('user_id', $user->id)
                ->whereBetween('clock_in_at', [$startOfDay, $endOfDay])
                ->orderBy('clock_in_at')
                ->get();



            $firstClockIn = $attendances->first()?->clock_in_at;
            $lastClockOut = null;
            $latestClockIn = $attendances->last()?->clock_in_at;
            $isOnline = false;
            $totalDuration = 0;

            // Check if user is on leave
            $isOnLeave = $user->isOnLeave($date->format('Y-m-d'));
            
            // Calculate status
            $status = 'Absent';
            if ($isOnLeave) {
                $status = 'On Leave';
            } elseif ($firstClockIn) {
                if ($firstClockIn->lte($threshold)) {
                    $status = 'Present';
                } else {
                    $status = 'Late';
                }
            }

            // Calculate duration and find last clock out
            if ($attendances->isNotEmpty()) {
                // Find the last clock out time and calculate total duration
                foreach ($attendances as $attendance) {
                    $clockIn = $attendance->clock_in_at;
                    $clockOut = $attendance->clock_out_at;


                    if ($clockOut) {
                        // Clocked out - add the session duration
                        $sessionDuration = $clockIn->diffInMinutes($clockOut);
                        $totalDuration += $sessionDuration;
                        $lastClockOut = $clockOut;
                        
                        
                    } else {
                        // Not clocked out - still online, add time from clock in to now
                        $isOnline = true;
                        $currentTime = $date->isToday() ? now()->setTimezone('Asia/Kolkata') : $date->copy()->setTime(20, 30);
                        $sessionDuration = $clockIn->diffInMinutes($currentTime);
                        $totalDuration += $sessionDuration;
                        
                        
                    }
                }
            }

            // For previous days, if not clocked out, don't set a default time
            // We'll show "—" instead of 20:30 for incomplete sessions

            $data[] = [
                'user' => $user,
                'status' => $status,
                'first_clock_in' => $firstClockIn,
                'last_clock_out' => $lastClockOut,
                'latest_clock_in' => $latestClockIn,
                'duration' => $this->formatDuration($totalDuration),
                'is_online' => $isOnline && $date->isToday(),
                'has_unclosed_session' => $isOnline && $date->isPast() && !$date->isToday(),
            ];
        }

        return $data;
    }

    private function formatDuration(int $minutes): string
    {
        $hours = intval($minutes / 60);
        $mins = $minutes % 60;
        return "{$hours}h {$mins}m";
    }

    public function with(): array
    {
        return [
            'attendanceData' => $this->getAttendanceData(),
            'canGoNext' => !Carbon::parse($this->selectedDate)->addDay()->isFuture(),
            'canGoPrevious' => true,
        ];
    }
}; ?>

<div>
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daily Attendance Report</h2>
        
        <div class="flex items-center gap-4">
            <button 
                wire:click="previousDay" 
                class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700"
            >
                ← Previous
            </button>
            
            <div class="text-lg font-medium">
                {{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }}
            </div>
            
            <button 
                wire:click="nextDay" 
                @if(!$canGoNext) disabled @endif
                class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                Next →
            </button>
        </div>
    </div>

    @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First Clock In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Clock Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latest Clock In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Online</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($attendanceData as $row)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $row['user']->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusColors = [
                                        'Present' => 'bg-green-100 text-green-800',
                                        'Late' => 'bg-yellow-100 text-yellow-800',
                                        'Absent' => 'bg-red-100 text-red-800',
                                        'On Leave' => 'bg-blue-100 text-blue-800'
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$row['status']] }}">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $row['first_clock_in'] ? $row['first_clock_in']->format('H:i') : '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($row['last_clock_out'])
                                    {{ $row['last_clock_out']->format('H:i') }}
                                @elseif($row['has_unclosed_session'])
                                    — <span class="text-orange-500 ml-1" title="User did not clock out on this day">⚠</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $row['latest_clock_in'] ? $row['latest_clock_in']->format('H:i') : '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $row['duration'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($row['is_online'])
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Online</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Offline</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
