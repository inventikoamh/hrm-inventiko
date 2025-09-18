<?php

namespace App\Livewire\Components\Dashboard;

use App\Models\User;
use Livewire\Component;

class UserStatsWidget extends Component
{
    public function render()
    {
        $totalUsers = User::count();
        $activeUsers = User::whereHas('attendances', function($query) {
            $query->whereNull('clock_out_at');
        })->count();
        $employeeUsers = User::role('employee')->count();
        $adminUsers = User::role('admin')->count();
        $activeToday = User::whereHas('attendances', function($query) {
            $query->whereDate('clock_in_at', today());
        })->count();

        return view('livewire.components.dashboard.user-stats-widget', [
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'employeeUsers' => $employeeUsers,
            'adminUsers' => $adminUsers,
            'activeToday' => $activeToday,
        ]);
    }
}
