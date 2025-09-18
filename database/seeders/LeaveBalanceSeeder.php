<?php

namespace Database\Seeders;

use App\Models\LeaveBalance;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeaveBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultAllowances = LeaveBalance::getDefaultAllowances();
        
        // Get all users
        $users = User::all();
        
        foreach ($users as $user) {
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
    }
}