<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class LeadPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'create lead',
            'view leads',
            'edit lead',
            'delete lead',
            'update lead status',
            'add lead remark',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
