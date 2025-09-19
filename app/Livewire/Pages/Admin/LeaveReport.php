<?php

namespace App\Livewire\Pages\Admin;

use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Leave Report')]
class LeaveReport extends Component
{
    use WithPagination;

    public $search = '';
    public $sortBy = 'name';
    public $sortDirection = 'asc';

    public function updatingSearch()
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
    }

    public function render()
    {
        $users = User::with(['leaveBalances', 'leaves'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);

        // Get leave counts for each user
        $leaveCounts = [];
        foreach ($users as $user) {
            $leaveCounts[$user->id] = [
                'sick' => Leave::where('user_id', $user->id)
                    ->where('type', 'sick')
                    ->where('status', 'approved')
                    ->sum('total_days'),
                'casual' => Leave::where('user_id', $user->id)
                    ->where('type', 'casual')
                    ->where('status', 'approved')
                    ->sum('total_days'),
                'festival' => Leave::where('user_id', $user->id)
                    ->where('type', 'festival')
                    ->where('status', 'approved')
                    ->sum('total_days'),
                'privilege' => Leave::where('user_id', $user->id)
                    ->where('type', 'privilege')
                    ->where('status', 'approved')
                    ->sum('total_days'),
                'emergency' => Leave::where('user_id', $user->id)
                    ->where('type', 'emergency')
                    ->where('status', 'approved')
                    ->sum('total_days'),
            ];
        }

        return view('livewire.pages.admin.leave-report', [
            'users' => $users,
            'leaveCounts' => $leaveCounts,
            'leaveTypes' => [
                'sick' => 'Sick Leave',
                'casual' => 'Casual Leave',
                'festival' => 'Festival Leave',
                'privilege' => 'Privilege Leave',
                'emergency' => 'Emergency Leave',
            ]
        ]);
    }

    protected function paginationTheme()
    {
        return 'tailwind';
    }
}