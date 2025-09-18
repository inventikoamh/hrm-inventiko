<?php

namespace App\Observers;

use App\Models\LeaveBalance;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Assign default leave balances to new user
        $defaultAllowances = LeaveBalance::getDefaultAllowances();
        
        foreach ($defaultAllowances as $leaveType => $allowed) {
            LeaveBalance::create([
                'user_id' => $user->id,
                'leave_type' => $leaveType,
                'total_allowed' => $allowed,
                'used' => 0,
                'remaining' => $allowed,
            ]);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Delete associated leave balances when user is deleted
        $user->leaveBalances()->delete();
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}