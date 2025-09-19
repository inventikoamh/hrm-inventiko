<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Livewire\Components\ThemeToggle;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set timezone to Asia/Kolkata
        date_default_timezone_set('Asia/Kolkata');
        
        // Register Spatie permission middlewares with aliases
        Route::aliasMiddleware('role', RoleMiddleware::class);
        Route::aliasMiddleware('permission', PermissionMiddleware::class);
        Route::aliasMiddleware('role_or_permission', RoleOrPermissionMiddleware::class);
        
        // Register model observers
        User::observe(UserObserver::class);
        
        // Register Livewire components
        Livewire::component('theme-toggle', ThemeToggle::class);
    }
}
