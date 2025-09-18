<?php

namespace App\Livewire\Pages\Admin\Attendance;

use App\Models\Attendance;
use App\Models\User;
use App\Models\Leave;
use App\Models\Setting;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class MonthlyReport extends Component
{
    use WithPagination;

    public $selectedMonth;
    public $selectedYear;
    public $totalWorkingDays;
    public $monthName;
    public $attendanceData = [];

    protected $listeners = ['refreshReport' => 'loadReport'];

    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;
        $this->validateDateRange();
        $this->loadReport();
    }

    public function updatedSelectedMonth()
    {
        $this->validateDateRange();
        $this->loadReport();
    }

    public function updatedSelectedYear()
    {
        $this->validateDateRange();
        $this->resetPage(); // Reset pagination if any
        $this->loadReport();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['selectedMonth', 'selectedYear'])) {
            $this->validateDateRange();
            $this->loadReport();
        }
    }

    public function validateDateRange()
    {
        $now = Carbon::now();
        $selectedDate = Carbon::create($this->selectedYear, $this->selectedMonth, 1);
        
        // If selected date is in the future, reset to current month
        if ($selectedDate->gt($now->startOfMonth())) {
            $this->selectedYear = $now->year;
            $this->selectedMonth = $now->month;
            session()->flash('error', 'Cannot view attendance for future months. Showing current month instead.');
        }
    }

    public function loadReport()
    {
        $this->monthName = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->format('F Y');
        $this->calculateWorkingDays();
        $this->loadAttendanceData();
    }

    public function calculateWorkingDays()
    {
        $startDate = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->startOfMonth();
        
        // If viewing current month, calculate only up to current day
        // Otherwise, calculate for the entire month
        $now = Carbon::now();
        if ($this->selectedYear == $now->year && $this->selectedMonth == $now->month) {
            $endDate = $now->copy()->startOfDay();
        } else {
            $endDate = $startDate->copy()->endOfMonth();
        }
        
        $workingDays = 0;
        $current = $startDate->copy();
        
        while ($current->lte($endDate)) {
            // Monday to Saturday are working days (1-6), Sunday is holiday (0)
            if ($current->dayOfWeek >= 1 && $current->dayOfWeek <= 6) {
                $workingDays++;
            }
            $current->addDay();
        }
        
        $this->totalWorkingDays = $workingDays;
    }

    public function loadAttendanceData()
    {
        $startDate = Carbon::create($this->selectedYear, $this->selectedMonth, 1)->startOfMonth();
        
        // If viewing current month, calculate only up to current day
        // Otherwise, calculate for the entire month
        $now = Carbon::now();
        if ($this->selectedYear == $now->year && $this->selectedMonth == $now->month) {
            $endDate = $now->copy()->startOfDay();
        } else {
            $endDate = $startDate->copy()->endOfMonth();
        }
        
        // Get all users with employee or admin role
        $users = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['employee', 'admin']);
        })->get();
        
        $this->attendanceData = [];
        
        foreach ($users as $user) {
            $userData = [
                'user' => $user,
                'present' => 0,
                'late' => 0,
                'left_early' => 0,
                'absent' => 0,
                'on_leave' => 0,
                'total_days' => 0
            ];
            
            // Calculate attendance for each day of the month
            $current = $startDate->copy();
            while ($current->lte($endDate)) {
                // Skip Sundays (holidays)
                if ($current->dayOfWeek == 0) {
                    $current->addDay();
                    continue;
                }
                
                $userData['total_days']++;
                
                // Check if user was on leave
                $onLeave = Leave::where('user_id', $user->id)
                    ->where('start_date', '<=', $current->toDateString())
                    ->where('end_date', '>=', $current->toDateString())
                    ->where('status', 'approved')
                    ->exists();
                
                if ($onLeave) {
                    $userData['on_leave']++;
                } else {
                    // Check attendance for this day
                    $attendance = Attendance::where('user_id', $user->id)
                        ->whereDate('clock_in_at', $current->toDateString())
                        ->whereNotNull('clock_out_at')
                        ->first();
                    
                    if ($attendance) {
                        $userData['present']++;
                        
                        // Check if late (first clock in after configured time)
                        $clockInTime = Carbon::parse($attendance->clock_in_at);
                        $lateClockInTime = Setting::getLateClockInTime();
                        if ($clockInTime->format('H:i') > $lateClockInTime) {
                            $userData['late']++;
                        }
                        
                        // Check if left early (clock out before 8:00 PM or auto clock out at configured time)
                        $clockOutTime = Carbon::parse($attendance->clock_out_at);
                        $autoClockOutTime = Setting::getAutoClockOutTime();
                        if ($clockOutTime->format('H:i') < '20:00' || 
                            ($clockOutTime->format('H:i') == $autoClockOutTime && 
                             str_contains($attendance->logs()->where('type', 'clock_out')->first()->status ?? '', 'Auto clock-out'))) {
                            $userData['left_early']++;
                        }
                    } else {
                        $userData['absent']++;
                    }
                }
                
                $current->addDay();
            }
            
            $this->attendanceData[] = $userData;
        }
    }


    public function getMonthOptions()
    {
        $allMonths = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
        
        // If current year is selected, only show months up to current month
        $now = Carbon::now();
        if ($this->selectedYear == $now->year) {
            $availableMonths = [];
            for ($i = 1; $i <= $now->month; $i++) {
                $availableMonths[$i] = $allMonths[$i];
            }
            return $availableMonths;
        }
        
        // For past years, show all months
        return $allMonths;
    }

    public function getYearOptions()
    {
        $currentYear = now()->year;
        $years = [];
        for ($i = $currentYear - 2; $i <= $currentYear; $i++) {
            $years[$i] = $i;
        }
        return $years;
    }

    public function render()
    {
        return view('livewire.pages.admin.attendance.monthly-report');
    }
}