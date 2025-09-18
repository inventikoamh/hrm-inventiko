<?php

namespace App\Livewire\Components\Dashboard;

use App\Models\Task;
use Livewire\Component;

class TasksSummaryWidget extends Component
{
    public function render()
    {
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $inProgressTasks = Task::where('status', 'in_progress')->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $overdueTasks = Task::where('status', '!=', 'completed')
            ->where('end_date', '<', now())
            ->count();

        return view('livewire.components.dashboard.tasks-summary-widget', [
            'totalTasks' => $totalTasks,
            'pendingTasks' => $pendingTasks,
            'inProgressTasks' => $inProgressTasks,
            'completedTasks' => $completedTasks,
            'overdueTasks' => $overdueTasks,
        ]);
    }
}
