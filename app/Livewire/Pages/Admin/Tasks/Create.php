<?php

namespace App\Livewire\Pages\Admin\Tasks;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Create extends Component
{
    public $title = '';
    public $description = '';
    public $status = Task::STATUS_PENDING;
    public $priority = Task::PRIORITY_MEDIUM;
    public $assigned_to = '';
    public $project_id = '';
    public $start_date = '';
    public $end_date = '';

    protected function rules()
    {
        $statuses = array_map('strtolower', array_map('str_replace', [' ', ' '], ['_', '_'], Setting::getEnumValues('task_status')));
        $priorities = array_map('strtolower', array_map('str_replace', [' ', ' '], ['_', '_'], Setting::getEnumValues('task_priority')));
        
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:' . implode(',', $statuses),
            'priority' => 'required|in:' . implode(',', $priorities),
            'assigned_to' => 'nullable|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }

    public function save()
    {
        $this->validate();

        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'assigned_to' => $this->assigned_to ?: null,
            'project_id' => $this->project_id ?: null,
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->end_date ?: null,
            'created_by' => auth()->id(),
        ]);

        session()->flash('status', 'Task created successfully.');
        return redirect()->route('admin.tasks.index');
    }

    public function getUsersProperty()
    {
        return User::orderBy('first_name')->get();
    }

    public function getProjectsProperty()
    {
        return Project::orderBy('title')->get();
    }

    public function getStatusOptions()
    {
        $statuses = Setting::getEnumValues('task_status');
        return array_combine(
            array_map('strtolower', array_map('str_replace', [' ', ' '], ['_', '_'], $statuses)),
            $statuses
        );
    }

    public function getPriorityOptions()
    {
        $priorities = Setting::getEnumValues('task_priority');
        return array_combine(
            array_map('strtolower', array_map('str_replace', [' ', ' '], ['_', '_'], $priorities)),
            $priorities
        );
    }

    public function render()
    {
        return view('livewire.pages.admin.tasks.create', [
            'users' => $this->users,
            'projects' => $this->projects,
            'statusOptions' => $this->getStatusOptions(),
            'priorityOptions' => $this->getPriorityOptions(),
        ]);
    }
}