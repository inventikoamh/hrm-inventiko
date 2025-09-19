<?php

namespace App\Livewire\Pages\Admin\Tasks;

use App\Models\Task;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Carbon\Carbon;

#[Layout('layouts.app')]
class GanttChart extends Component
{
    public $selectedWeek;
    public $selectedUsers = [];
    public $selectedProjects = [];
    public $viewMode = 'week'; // week only

    public function mount()
    {
        // Set default to current week
        $this->selectedWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
    }

    public function setWeekView()
    {
        $this->selectedWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
    }

    public function getStartDateProperty()
    {
        return $this->selectedWeek ? Carbon::parse($this->selectedWeek) : null;
    }

    public function getEndDateProperty()
    {
        return $this->selectedWeek ? Carbon::parse($this->selectedWeek)->addDays(5) : null;
    }


    public function getUsersProperty()
    {
        return User::orderBy('first_name')->get();
    }

    public function getProjectsProperty()
    {
        return \App\Models\Project::orderBy('title')->get();
    }

    public function getTasksProperty()
    {
        $query = Task::with(['assignedTo', 'project', 'createdBy'])
            ->whereNotNull('assigned_to')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date');

        // Filter by date range
        if ($this->startDate && $this->endDate) {
            $query->where(function($q) {
                $q->whereBetween('start_date', [$this->startDate->format('Y-m-d'), $this->endDate->format('Y-m-d')])
                  ->orWhereBetween('end_date', [$this->startDate->format('Y-m-d'), $this->endDate->format('Y-m-d')])
                  ->orWhere(function($q2) {
                      $q2->where('start_date', '<=', $this->startDate->format('Y-m-d'))
                         ->where('end_date', '>=', $this->endDate->format('Y-m-d'));
                  });
            });
        }

        // Filter by selected users
        if (!empty($this->selectedUsers)) {
            $query->whereIn('assigned_to', $this->selectedUsers);
        }

        // Filter by selected projects
        if (!empty($this->selectedProjects)) {
            $query->whereIn('project_id', $this->selectedProjects);
        }

        return $query->get();
    }

    public function getGanttDataProperty()
    {
        $tasks = $this->tasks;
        $users = $this->users;
        $ganttData = [];

        // Group tasks by user
        foreach ($users as $user) {
            $userTasks = $tasks->where('assigned_to', $user->id);
            
            if ($userTasks->count() > 0) {
                $ganttData[] = [
                    'user' => $user,
                    'tasks' => $userTasks->map(function($task) {
                        return [
                            'id' => $task->id,
                            'title' => $task->title,
                            'start_date' => $task->start_date,
                            'end_date' => $task->end_date,
                            'status' => $task->status,
                            'priority' => $task->priority,
                            'project' => $task->project,
                            'duration' => $task->start_date->diffInDays($task->end_date) + 1,
                            'status_color' => $task->status_color,
                            'priority_color' => $task->priority_color,
                        ];
                    })->values()
                ];
            }
        }

        return $ganttData;
    }

    public function getDateRangeProperty()
    {
        if (!$this->startDate || !$this->endDate) {
            return [];
        }

        $start = $this->startDate;
        $end = $this->endDate;
        $dates = [];

        // Show Monday to Saturday only
        while ($start->lte($end)) {
            // Include Monday to Saturday (Monday = 1, Saturday = 6)
            if ($start->dayOfWeek >= 1 && $start->dayOfWeek <= 6) {
                $dates[] = $start->copy();
            }
            $start->addDay();
        }

        return $dates;
    }

    public function getWeekOptionsProperty()
    {
        $weeks = [];
        $currentWeek = Carbon::now()->startOfWeek();
        
        // Generate 12 weeks (3 months) - 6 weeks before and 6 weeks after current week
        for ($i = -6; $i <= 6; $i++) {
            $weekStart = $currentWeek->copy()->addWeeks($i);
            $weekEnd = $weekStart->copy()->addDays(5);
            
            $weeks[] = [
                'value' => $weekStart->format('Y-m-d'),
                'label' => $weekStart->format('M d') . ' - ' . $weekEnd->format('M d, Y'),
                'is_current' => $i === 0
            ];
        }
        
        return $weeks;
    }

    public function getStatusOptions()
    {
        return [
            Task::STATUS_PENDING => 'Pending',
            Task::STATUS_IN_PROGRESS => 'In Progress',
            Task::STATUS_COMPLETED => 'Completed',
            Task::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function getPriorityOptions()
    {
        return [
            Task::PRIORITY_LOW => 'Low',
            Task::PRIORITY_MEDIUM => 'Medium',
            Task::PRIORITY_HIGH => 'High',
            Task::PRIORITY_URGENT => 'Urgent',
        ];
    }

    public function render()
    {
        return view('livewire.pages.admin.tasks.gantt-chart');
    }
}
