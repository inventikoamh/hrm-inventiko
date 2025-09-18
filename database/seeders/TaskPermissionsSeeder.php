<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class TaskPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'create task',
            'view tasks',
            'edit task',
            'delete task',
            'complete task',
            'assign task',
            'add task comment',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
