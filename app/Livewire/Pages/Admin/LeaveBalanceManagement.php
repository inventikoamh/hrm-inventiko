<?php

namespace App\Livewire\Pages\Admin;

use App\Models\LeaveBalance;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Leave Balance Management')]
class LeaveBalanceManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedUser = null;
    public $editingBalances = [];
    public $showEditModal = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::with('leaveBalances')->findOrFail($userId);
        $this->loadUserBalances();
        $this->showEditModal = true;
    }

    public function loadUserBalances()
    {
        if (!$this->selectedUser) return;

        $this->editingBalances = [];
        foreach ($this->selectedUser->leaveBalances as $balance) {
            $this->editingBalances[$balance->leave_type] = [
                'id' => $balance->id,
                'total_allowed' => $balance->total_allowed,
                'used' => $balance->used,
                'remaining' => $balance->remaining,
            ];
        }
    }

    public function updateBalance($leaveType)
    {
        if (!isset($this->editingBalances[$leaveType])) return;

        $balanceData = $this->editingBalances[$leaveType];
        $balance = LeaveBalance::find($balanceData['id']);

        if ($balance) {
            $balance->update([
                'total_allowed' => $balanceData['total_allowed'],
            ]);
            $balance->updateRemaining();
            
            // Refresh the selected user data
            $this->selectedUser->refresh();
            $this->loadUserBalances();
            
            session()->flash('success', ucfirst($leaveType) . ' leave balance updated successfully!');
        }
    }

    public function updateAllBalances()
    {
        foreach ($this->editingBalances as $leaveType => $balanceData) {
            $this->updateBalance($leaveType);
        }
        
        session()->flash('success', 'All leave balances updated successfully!');
    }

    public function closeModal()
    {
        $this->showEditModal = false;
        $this->selectedUser = null;
        $this->editingBalances = [];
    }

    public function render()
    {
        $users = User::with('leaveBalances')
            ->when($this->search, function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.pages.admin.leave-balance-management', [
            'users' => $users,
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