<?php

namespace App\Livewire\Pages\Admin\Tasks;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $priority = '';
    public $assignedTo = '';
    public $projectId = '';
    public $createdBy = '';
    public $dateRange = '';
    public $overdue = false;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 10;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingPriority()
    {
        $this->resetPage();
    }

    public function updatingAssignedTo()
    {
        $this->resetPage();
    }

    public function updatingProjectId()
    {
        $this->resetPage();
    }

    public function updatingCreatedBy()
    {
        $this->resetPage();
    }

    public function updatingDateRange()
    {
        $this->resetPage();
    }

    public function updatingOverdue()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function delete(Task $task)
    {
        $task->delete();
        session()->flash('status', 'Task deleted successfully.');
    }

    public function markAsCompleted(Task $task)
    {
        $task->markAsCompleted();
        session()->flash('status', 'Task marked as completed.');
    }

    public function getTasksProperty()
    {
        $query = Task::with(['assignedTo', 'createdBy', 'project'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->priority, function ($query) {
                $query->where('priority', $this->priority);
            })
            ->when($this->assignedTo, function ($query) {
                $query->where('assigned_to', $this->assignedTo);
            })
            ->when($this->projectId, function ($query) {
                $query->where('project_id', $this->projectId);
            })
            ->when($this->createdBy, function ($query) {
                $query->where('created_by', $this->createdBy);
            })
            ->when($this->dateRange, function ($query) {
                $this->applyDateRangeFilter($query, $this->dateRange);
            })
            ->when($this->overdue, function ($query) {
                $query->where('end_date', '<', now())
                      ->whereIn('status', ['pending', 'in_progress']);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
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

    private function applyDateRangeFilter($query, $dateRange)
    {
        $now = now();
        
        switch ($dateRange) {
            case 'today':
                $query->whereDate('created_at', $now->toDateString());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', $now->month)
                      ->whereYear('created_at', $now->year);
                break;
            case 'last_week':
                $query->whereBetween('created_at', [$now->subWeek()->startOfWeek(), $now->subWeek()->endOfWeek()]);
                break;
            case 'last_month':
                $query->whereMonth('created_at', $now->subMonth()->month)
                      ->whereYear('created_at', $now->subMonth()->year);
                break;
            case 'last_30_days':
                $query->where('created_at', '>=', $now->subDays(30));
                break;
            case 'last_90_days':
                $query->where('created_at', '>=', $now->subDays(90));
                break;
        }
    }

    public function resetFilters()
    {
        $this->search = '';
        $this->status = '';
        $this->priority = '';
        $this->assignedTo = '';
        $this->projectId = '';
        $this->createdBy = '';
        $this->dateRange = '';
        $this->overdue = false;
        $this->resetPage();
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
        return view('livewire.pages.admin.tasks.index', [
            'tasks' => $this->tasks,
            'users' => $this->users,
            'projects' => $this->projects,
            'statusOptions' => $this->getStatusOptions(),
            'priorityOptions' => $this->getPriorityOptions(),
        ]);
    }
}