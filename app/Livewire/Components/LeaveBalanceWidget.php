<?php

namespace App\Livewire\Components;

use App\Models\LeaveBalance;
use Livewire\Component;

class LeaveBalanceWidget extends Component
{
    public function render()
    {
        $user = auth()->user();
        $leaveBalances = LeaveBalance::getUserBalances($user->id);
        
        return view('livewire.components.leave-balance-widget', [
            'leaveBalances' => $leaveBalances
        ]);
    }
}