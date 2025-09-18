<?php

namespace App\Livewire\Pages\Admin\Projects;

use App\Models\Project;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Projects')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $priorityFilter = '';
    public $projectLeadFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPriorityFilter()
    {
        $this->resetPage();
    }

    public function updatingProjectLeadFilter()
    {
        $this->resetPage();
    }

    public function delete($projectId)
    {
        if (!auth()->user()->can('delete projects')) {
            session()->flash('error', 'You do not have permission to delete projects.');
            return;
        }

        $project = Project::findOrFail($projectId);
        $project->delete();
        
        session()->flash('success', 'Project deleted successfully!');
    }

    public function render()
    {
        $query = Project::with('projectLead')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->priorityFilter, function ($query) {
                $query->where('priority', $this->priorityFilter);
            })
            ->when($this->projectLeadFilter, function ($query) {
                $query->where('project_lead_id', $this->projectLeadFilter);
            })
            ->orderBy('created_at', 'desc');

        $projects = $query->paginate(10);

        $projectLeads = User::orderBy('name')->get();
        
        $statuses = [
            'planned' => 'Planned',
            'in_progress' => 'In Progress',
            'on_hold' => 'On Hold',
            'completed' => 'Completed',
        ];

        $priorities = [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
        ];

        return view('livewire.pages.admin.projects.index', [
            'projects' => $projects,
            'projectLeads' => $projectLeads,
            'statuses' => $statuses,
            'priorities' => $priorities,
        ]);
    }
}