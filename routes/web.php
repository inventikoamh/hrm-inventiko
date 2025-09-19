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
    
    // Storage link route
    Route::post('storage-link', function () {
        try {
            $output = [];
            $publicStoragePath = public_path('storage');
            $storagePath = storage_path('app/public');
            
            // Remove existing link if it exists
            if (is_link($publicStoragePath)) {
                unlink($publicStoragePath);
                $output[] = "Removed existing storage link";
            }
            
            // Remove directory if it exists (in case it's a directory instead of link)
            if (is_dir($publicStoragePath)) {
                rmdir($publicStoragePath);
                $output[] = "Removed existing storage directory";
            }
            
            // Create the symbolic link
            if (symlink($storagePath, $publicStoragePath)) {
                $output[] = "Created symbolic link: {$publicStoragePath} -> {$storagePath}";
            } else {
                throw new \Exception("Failed to create symbolic link");
            }
            
            // Verify the link works
            if (is_link($publicStoragePath) && is_dir($publicStoragePath)) {
                $output[] = "Storage link verified successfully";
            } else {
                throw new \Exception("Storage link verification failed");
            }
            
            $outputText = implode("\n", $output);
            
            return response()->json([
                'success' => true,
                'message' => 'Storage linked successfully',
                'output' => $outputText
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Storage link failed: ' . $e->getMessage()
            ], 500);
        }
    })->middleware('permission:manage settings')->name('storage-link');
    
    // Fix permissions route
    Route::post('fix-permissions', function () {
        try {
            $output = [];
            
            // Set permissions for storage directory
            $storagePath = storage_path('app/public');
            $publicStoragePath = public_path('storage');
            
            // Create storage directory if it doesn't exist
            if (!is_dir($storagePath)) {
                mkdir($storagePath, 0755, true);
                $output[] = "Created storage directory: {$storagePath}";
            }
            
            // Set permissions for storage directory
            if (is_dir($storagePath)) {
                chmod($storagePath, 0755);
                $output[] = "Set permissions for storage directory: 755";
                
                // Set permissions for all subdirectories and files
                $iterator = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($storagePath, \RecursiveDirectoryIterator::SKIP_DOTS),
                    \RecursiveIteratorIterator::SELF_FIRST
                );
                
                foreach ($iterator as $item) {
                    if ($item->isDir()) {
                        chmod($item->getPathname(), 0755);
                        $output[] = "Set directory permissions: {$item->getPathname()} (755)";
                    } else {
                        chmod($item->getPathname(), 0644);
                        $output[] = "Set file permissions: {$item->getPathname()} (644)";
                    }
                }
            }
            
            // Ensure public/storage link exists and has correct permissions
            if (is_link($publicStoragePath)) {
                chmod($publicStoragePath, 0755);
                $output[] = "Set link permissions: {$publicStoragePath} (755)";
            }
            
            $outputText = implode("\n", $output);
            if (empty($outputText)) {
                $outputText = "Permissions check completed successfully!";
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Permissions fixed successfully',
                'output' => $outputText
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permissions fix failed: ' . $e->getMessage()
            ], 500);
        }
    })->middleware('permission:manage settings')->name('fix-permissions');
    
    // Check storage link status
    Route::get('storage-status', function () {
        try {
            $output = [];
            $publicStoragePath = public_path('storage');
            $storagePath = storage_path('app/public');
            
            $output[] = "Checking storage link status...";
            $output[] = "Public storage path: {$publicStoragePath}";
            $output[] = "Storage path: {$storagePath}";
            $output[] = "";
            
            // Check if public/storage exists
            if (file_exists($publicStoragePath)) {
                if (is_link($publicStoragePath)) {
                    $linkTarget = readlink($publicStoragePath);
                    $output[] = "✓ public/storage is a symbolic link";
                    $output[] = "  Link target: {$linkTarget}";
                    
                    if ($linkTarget === $storagePath) {
                        $output[] = "✓ Link target is correct";
                    } else {
                        $output[] = "✗ Link target is incorrect";
                    }
                } elseif (is_dir($publicStoragePath)) {
                    $output[] = "✗ public/storage is a directory (should be a link)";
                } else {
                    $output[] = "✗ public/storage exists but is not a link or directory";
                }
            } else {
                $output[] = "✗ public/storage does not exist";
            }
            
            $output[] = "";
            
            // Check if storage/app/public exists
            if (is_dir($storagePath)) {
                $output[] = "✓ storage/app/public directory exists";
                
                // Check for profile-pictures directory
                $profilePicsPath = $storagePath . '/profile-pictures';
                if (is_dir($profilePicsPath)) {
                    $output[] = "✓ profile-pictures directory exists";
                    $files = scandir($profilePicsPath);
                    $imageFiles = array_filter($files, function($file) {
                        return in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']);
                    });
                    $output[] = "  Found " . count($imageFiles) . " image files";
                    foreach ($imageFiles as $file) {
                        $output[] = "  - {$file}";
                    }
                } else {
                    $output[] = "✗ profile-pictures directory does not exist";
                }
            } else {
                $output[] = "✗ storage/app/public directory does not exist";
            }
            
            $output[] = "";
            
            // Test if a file is accessible via web
            $testFile = null;
            if (is_dir($storagePath . '/profile-pictures')) {
                $files = scandir($storagePath . '/profile-pictures');
                foreach ($files as $file) {
                    if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif'])) {
                        $testFile = $file;
                        break;
                    }
                }
            }
            
            if ($testFile) {
                $webUrl = url('storage/profile-pictures/' . $testFile);
                $output[] = "Test file: {$testFile}";
                $output[] = "Web URL: {$webUrl}";
                $output[] = "Direct file path: {$storagePath}/profile-pictures/{$testFile}";
            }
            
            $outputText = implode("\n", $output);
            
            return response()->json([
                'success' => true,
                'message' => 'Storage status checked',
                'output' => $outputText
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Storage status check failed: ' . $e->getMessage()
            ], 500);
        }
    })->middleware('permission:manage settings')->name('storage-status');
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
