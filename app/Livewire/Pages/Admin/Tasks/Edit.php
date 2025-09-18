<?php

namespace App\Livewire\Pages\Admin\Tasks;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Setting;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Edit extends Component
{
    public Task $task;
    public $title = '';
    public $description = '';
    public $status = '';
    public $priority = '';
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
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ];
    }

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->status = $task->status;
        $this->priority = $task->priority;
        $this->assigned_to = $task->assigned_to;
        $this->project_id = $task->project_id;
        $this->start_date = $task->start_date?->format('Y-m-d');
        $this->end_date = $task->end_date?->format('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        $updateData = [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'assigned_to' => $this->assigned_to ?: null,
            'project_id' => $this->project_id ?: null,
            'start_date' => $this->start_date ?: null,
            'end_date' => $this->end_date ?: null,
        ];

        // If marking as completed, set completed_at
        if ($this->status === Task::STATUS_COMPLETED && $this->task->status !== Task::STATUS_COMPLETED) {
            $updateData['completed_at'] = now();
        }

        // If changing from completed to another status, clear completed_at
        if ($this->status !== Task::STATUS_COMPLETED && $this->task->status === Task::STATUS_COMPLETED) {
            $updateData['completed_at'] = null;
        }

        $this->task->update($updateData);

        session()->flash('status', 'Task updated successfully.');
        return redirect()->route('admin.tasks.index');
    }

    public function getUsersProperty()
    {
        return User::whereHas('roles', function($query) {
            $query->whereIn('name', ['admin', 'employee']);
        })->orderBy('name')->get();
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
        return view('livewire.pages.admin.tasks.edit', [
            'users' => $this->users,
            'projects' => $this->projects,
            'statusOptions' => $this->getStatusOptions(),
            'priorityOptions' => $this->getPriorityOptions(),
        ]);
    }
}