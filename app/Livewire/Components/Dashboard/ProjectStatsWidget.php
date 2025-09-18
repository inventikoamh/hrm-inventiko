<?php

namespace App\Livewire\Components\Dashboard;

use App\Models\Project;
use Livewire\Component;

class ProjectStatsWidget extends Component
{
    public function render()
    {
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'in progress')->count();
        $completedProjects = Project::where('status', 'completed')->count();
        $onHoldProjects = Project::where('status', 'on hold')->count();
        $plannedProjects = Project::where('status', 'planned')->count();

        return view('livewire.components.dashboard.project-stats-widget', [
            'totalProjects' => $totalProjects,
            'activeProjects' => $activeProjects,
            'completedProjects' => $completedProjects,
            'onHoldProjects' => $onHoldProjects,
            'plannedProjects' => $plannedProjects,
        ]);
    }
}
