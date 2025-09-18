<?php

namespace App\Livewire\Pages\Admin\Projects;

use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Project Details')]
class Show extends Component
{
    public Project $project;

    public function mount(Project $project)
    {
        if (!auth()->user()->can('view projects')) {
            session()->flash('error', 'You do not have permission to view projects.');
            return $this->redirect(route('admin.projects.index'));
        }

        $this->project = $project->load('projectLead');
    }

    public function render()
    {
        // Get team members
        $teamMembers = [];
        if ($this->project->team_members) {
            $teamMembers = \App\Models\User::whereIn('id', $this->project->team_members)->get();
        }

        return view('livewire.pages.admin.projects.show', [
            'teamMembers' => $teamMembers,
        ]);
    }
}