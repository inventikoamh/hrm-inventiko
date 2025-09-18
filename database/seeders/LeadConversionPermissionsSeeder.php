<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class LeadConversionPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'convert lead to client',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
