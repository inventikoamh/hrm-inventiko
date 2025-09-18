<?php

namespace App\Livewire\Components\Dashboard;

use App\Models\Client;
use App\Models\Lead;
use Livewire\Component;

class ClientStatsWidget extends Component
{
    public function render()
    {
        $totalClients = Client::count();
        $clientsThisMonth = Client::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $clientsWithProjects = Client::whereHas('projects')->count();
        $totalLeads = Lead::count();
        $leadsToday = Lead::whereDate('created_at', today())->count();

        return view('livewire.components.dashboard.client-stats-widget', [
            'totalClients' => $totalClients,
            'clientsThisMonth' => $clientsThisMonth,
            'clientsWithProjects' => $clientsWithProjects,
            'totalLeads' => $totalLeads,
            'leadsToday' => $leadsToday,
        ]);
    }
}
