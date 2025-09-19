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
        <h2 class="font-semibold text-xl leading-tight transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-800', 'text-slate-100') }}">Daily Attendance Report</h2>
        
        <div class="flex items-center gap-4">
            <button 
                wire:click="previousDay" 
                class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition-colors duration-200"
            >
                ← Previous
            </button>
            
            <div class="text-lg font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                {{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }}
            </div>
            
            <button 
                wire:click="nextDay" 
                @if(!$canGoNext) disabled @endif
                class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200"
            >
                Next →
            </button>
        </div>
    </div>

    @if (session('error'))
        <div class="mb-4 p-3 rounded transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-100 text-red-700', 'bg-red-900/20 border border-red-800 text-red-300') }}">{{ session('error') }}</div>
    @endif

    <div class="rounded shadow overflow-hidden transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('divide-gray-200', 'divide-slate-700') }}">
                <thead class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50', 'bg-slate-700') }}">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">First Clock In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Last Clock Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Latest Clock In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Online</th>
                    </tr>
                </thead>
                <tbody class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white divide-gray-200', 'bg-slate-800 divide-slate-700') }}">
                    @foreach($attendanceData as $row)
                        <tr class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('hover:bg-gray-50', 'hover:bg-slate-700') }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                                {{ $row['user']->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $statusColors = [
                                        'Present' => \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-100 text-green-800', 'bg-green-900/30 text-green-300'),
                                        'Late' => \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-yellow-100 text-yellow-800', 'bg-yellow-900/30 text-yellow-300'),
                                        'Absent' => \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-100 text-red-800', 'bg-red-900/30 text-red-300'),
                                        'On Leave' => \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100 text-blue-800', 'bg-blue-900/30 text-blue-300')
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$row['status']] }}">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                                {{ $row['first_clock_in'] ? $row['first_clock_in']->format('H:i') : '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                                @if($row['last_clock_out'])
                                    {{ $row['last_clock_out']->format('H:i') }}
                                @elseif($row['has_unclosed_session'])
                                    — <span class="text-orange-500 ml-1" title="User did not clock out on this day">⚠</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                                {{ $row['latest_clock_in'] ? $row['latest_clock_in']->format('H:i') : '—' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                                {{ $row['duration'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($row['is_online'])
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-100 text-green-800', 'bg-green-900/30 text-green-300') }}">Online</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 text-gray-800', 'bg-slate-700 text-slate-300') }}">Offline</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
