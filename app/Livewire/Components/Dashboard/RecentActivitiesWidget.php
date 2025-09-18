<?php

namespace App\Livewire\Components\Dashboard;

use App\Models\LeaveRequest;
use App\Models\Project;
use App\Models\Client;
use App\Models\User;
use Livewire\Component;

class RecentActivitiesWidget extends Component
{
    public function render()
    {
        $recentLeaves = LeaveRequest::with('user')
            ->latest()
            ->limit(5)
            ->get();
            
        $recentProjects = Project::with('projectLead')
            ->latest()
            ->limit(3)
            ->get();
            
        $recentClients = Client::latest()
            ->limit(3)
            ->get();

        return view('livewire.components.dashboard.recent-activities-widget', [
            'recentLeaves' => $recentLeaves,
            'recentProjects' => $recentProjects,
            'recentClients' => $recentClients,
        ]);
    }
}
