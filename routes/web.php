<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

// Admin routes (admin role required)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Users management
    Volt::route('users', 'pages.admin.users.index')->middleware('permission:view user')->name('users.index');
    Volt::route('users/create', 'pages.admin.users.create')->middleware('permission:create user')->name('users.create');
    Volt::route('users/{user}/edit', 'pages.admin.users.edit')->middleware('permission:edit user')->name('users.edit');

    // Access Control: Roles
    Volt::route('roles', 'pages.admin.roles.index')->middleware('permission:view roles')->name('roles.index');
    Volt::route('roles/create', 'pages.admin.roles.create')->middleware('permission:create role')->name('roles.create');
    Volt::route('roles/{role}/edit', 'pages.admin.roles.edit')->middleware('permission:view roles')->name('roles.edit');

    // Access Control: Permissions
    Volt::route('permissions', 'pages.admin.permissions.index')->middleware('permission:view permissions')->name('permissions.index');
    Volt::route('permissions/create', 'pages.admin.permissions.create')->middleware('permission:create permission')->name('permissions.create');
    
    // Settings
    Route::get('settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->middleware('permission:manage settings')->name('settings.index');
    Route::post('settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->middleware('permission:manage settings')->name('settings.update');
    Route::post('settings/enums', [App\Http\Controllers\Admin\SettingsController::class, 'updateEnums'])->middleware('permission:manage settings')->name('settings.update-enums');
    Route::post('settings/colors', [App\Http\Controllers\Admin\SettingsController::class, 'updateColors'])->middleware('permission:manage settings')->name('settings.update-colors');
    Route::delete('settings/remove-file/{type}', [App\Http\Controllers\Admin\SettingsController::class, 'removeFile'])->middleware('permission:manage settings')->name('settings.remove-file');
    
    // Migration route (for server deployment)
    Route::post('migrate', function () {
        try {
            \Artisan::call('migrate', ['--force' => true]);
            $output = \Artisan::output();
            return response()->json([
                'success' => true,
                'message' => 'Migrations completed successfully',
                'output' => $output
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Migration failed: ' . $e->getMessage()
            ], 500);
        }
    })->middleware('permission:manage settings')->name('migrate');
});

// Leave management routes (accessible to users with leave permissions)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Reports (accessible to users with leave permissions)
    Volt::route('attendance-report', 'pages.admin.attendance-report.index')->middleware('permission:view user|view leaves|mark leave')->name('attendance-report.index');
    Volt::route('attendance/monthly-report', 'pages.admin.attendance.monthly-report')->middleware('permission:view monthly attendance report')->name('attendance.monthly-report');
    
    // Leave Management
    Volt::route('leaves/mark', 'pages.admin.leaves.mark-leave')->middleware('permission:mark leave')->name('leaves.mark');
    Volt::route('leaves/manage', 'pages.admin.leaves.manage-leaves')->middleware('permission:view leaves')->name('leaves.manage');
    Volt::route('leave-requests', 'pages.admin.leave-requests')->middleware('permission:approve leave requests')->name('leave-requests.index');
    Volt::route('leave-report', 'pages.admin.leave-report')->middleware('permission:view leave report')->name('leave-report');
    Volt::route('leave-balance-management', 'pages.admin.leave-balance-management')->middleware('permission:manage leave balances')->name('leave-balance-management');
    
    // Project Management
    Volt::route('projects', 'pages.admin.projects.index')->middleware('permission:view projects')->name('projects.index');
    Volt::route('projects/create', 'pages.admin.projects.create')->middleware('permission:add project')->name('projects.create');
    Volt::route('projects/{project}/edit', 'pages.admin.projects.edit')->middleware('permission:edit projects')->name('projects.edit');
    Volt::route('projects/{project}', 'pages.admin.projects.show')->middleware('permission:view projects')->name('projects.show');
    
    // Client Management
    Volt::route('clients', 'pages.admin.clients.index')->middleware('permission:view clients')->name('clients.index');
    Volt::route('clients/create', 'pages.admin.clients.create')->middleware('permission:create client')->name('clients.create');
    Volt::route('clients/{client}/edit', 'pages.admin.clients.edit')->middleware('permission:update client')->name('clients.edit');
    Volt::route('clients/{client}', 'pages.admin.clients.show')->middleware('permission:view clients')->name('clients.show');
    
    // Lead Management
    Volt::route('leads', 'pages.admin.leads.index')->middleware('permission:view leads')->name('leads.index');
    Volt::route('leads/create', 'pages.admin.leads.create')->middleware('permission:create lead')->name('leads.create');
    Volt::route('leads/{lead}/edit', 'pages.admin.leads.edit')->middleware('permission:edit lead')->name('leads.edit');
    Volt::route('leads/{lead}', 'pages.admin.leads.show')->middleware('permission:view leads')->name('leads.show');
    
    // Task Management
    Volt::route('tasks', 'pages.admin.tasks.index')->middleware('permission:view tasks')->name('tasks.index');
    Volt::route('tasks/create', 'pages.admin.tasks.create')->middleware('permission:create task')->name('tasks.create');
    Volt::route('tasks/gantt-chart', 'pages.admin.tasks.gantt-chart')->middleware('permission:view tasks')->name('tasks.gantt-chart');
    Volt::route('tasks/{task}', 'pages.admin.tasks.show')->middleware('permission:view tasks')->name('tasks.show');
    Volt::route('tasks/{task}/edit', 'pages.admin.tasks.edit')->middleware('permission:edit task')->name('tasks.edit');
});

// Employee routes
Route::middleware(['auth'])->group(function () {
    Volt::route('employee/leave-request', 'pages.employee.leave-request-form')->name('employee.leave-request');
    Volt::route('employee/my-leave-requests', 'pages.employee.my-leave-requests')->name('employee.my-leave-requests');
    Volt::route('employee/edit-leave-request/{id}', 'pages.employee.edit-leave-request')->name('employee.edit-leave-request');
});
