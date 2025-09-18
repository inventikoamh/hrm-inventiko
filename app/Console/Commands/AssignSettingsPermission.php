<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignSettingsPermission extends Command
{
    protected $signature = 'settings:assign-permission';
    protected $description = 'Assign manage settings permission to admin role';

    public function handle()
    {
        $admin = Role::findByName('admin');
        $admin->givePermissionTo('manage settings');
        
        $this->info('Settings permission assigned to admin role successfully!');
    }
}