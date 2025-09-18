<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure default roles exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);

        // Ensure standard permissions exist
        $permissionNames = [
            'create user',
            'view user',
            'edit user',
            'delete user',
            'create role',
            'view roles',
            'delete roles',
            'create permission',
            'view permissions',
            'mark leave',
            'view leaves',
            'delete leaves',
            'approve leave requests',
            'view leave report',
            'manage leave balances',
            'view monthly attendance report',
            // Project management permissions
            'add project',
            'edit projects',
            'view projects',
            'delete projects',
            // Client management permissions
            'create client',
            'view clients',
            'update client',
            'delete client',
            // Lead management permissions
            'create lead',
            'view leads',
            'edit lead',
            'delete lead',
            'convert lead to client',
            // Task management permissions
            'create task',
            'view tasks',
            'edit task',
            'delete task',
            'assign task',
            'complete task',
        ];

        foreach ($permissionNames as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Assign all permissions to admin
        $adminRole->givePermissionTo($permissionNames);

        // Create or update the first admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
            ]
        );

        if (! $admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

        // Seed leave balances for all users
        $this->call(LeaveBalanceSeeder::class);
        
        // Seed sample lead data
        $this->call(LeadSeeder::class);
    }
}
