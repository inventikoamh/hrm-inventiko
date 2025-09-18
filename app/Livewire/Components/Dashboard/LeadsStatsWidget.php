<?php

namespace App\Livewire\Components\Dashboard;

use App\Models\Lead;
use Livewire\Component;

class LeadsStatsWidget extends Component
{
    public function render()
    {
        $totalLeads = Lead::count();
        $newLeads = Lead::where('status', Lead::STATUS_NEW_LEAD)->count();
        $convertedLeads = Lead::where('status', Lead::STATUS_CONVERTED)->count();
        $leadsToday = Lead::whereDate('created_at', now()->toDateString())->count();

        return view('livewire.components.dashboard.leads-stats-widget', [
            'totalLeads' => $totalLeads,
            'newLeads' => $newLeads,
            'convertedLeads' => $convertedLeads,
            'leadsToday' => $leadsToday,
        ]);
    }
}
