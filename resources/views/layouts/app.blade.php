<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ theme: '{{ auth()->check() ? auth()->user()->getThemePreference() : 'light' }}' }"
      :class="{ 'dark': theme === 'dark' }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', \App\Models\Setting::getAppName())</title>
        
        @if(\App\Models\Setting::getFavicon())
            <link rel="icon" type="image/x-icon" href="{{ Storage::url(\App\Models\Setting::getFavicon()) }}">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Theme Detection Script -->
        <script>
            // Set initial theme immediately (before DOMContentLoaded)
            (function() {
                const userTheme = '{{ auth()->check() ? auth()->user()->getThemePreference() : 'light' }}';
                
                if (userTheme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
            
            // Additional setup on DOMContentLoaded
            document.addEventListener('DOMContentLoaded', function() {
                // Listen for Livewire theme changes
                document.addEventListener('livewire:init', () => {
                    Livewire.on('theme-changed', (theme) => {
                        if (theme === 'dark') {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    });
                });
            });
        </script>
        
        <!-- Dynamic Theme CSS -->
        <style>
            :root {
                --primary-color: {{ \App\Models\Setting::getThemeColor() }};
                --primary-50: {{ \App\Models\Setting::getThemeColor() }}1a;
                --primary-100: {{ \App\Models\Setting::getThemeColor() }}33;
                --primary-500: {{ \App\Models\Setting::getThemeColor() }};
                --primary-600: {{ \App\Models\Setting::getThemeColor() }}cc;
                --primary-700: {{ \App\Models\Setting::getThemeColor() }}99;
            }
            
            /* Dark mode overrides */
            .dark {
                --bg-primary: #0f172a;
                --bg-secondary: #1e293b;
                --bg-tertiary: #334155;
                --text-primary: #f8fafc;
                --text-secondary: #cbd5e1;
                --text-muted: #94a3b8;
                --border-primary: #334155;
                --border-secondary: #475569;
            }
        </style>
    </head>
    <body class="font-inter antialiased transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 text-gray-900', 'bg-slate-900 text-slate-100') }}" 
          style="font-family: 'Inter', sans-serif;">
        <div class="min-h-screen {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100', 'bg-slate-900') }}">
            <div class="flex">
                <!-- Sidebar -->
                <aside class="hidden md:block w-72 min-h-screen shadow-xl transition-colors duration-200
                           {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gradient-to-b from-white via-gray-50 to-white border-r border-gray-200', 'bg-gradient-to-b from-slate-800 via-slate-700 to-slate-800 border-r border-slate-600') }}">
                    <div class="p-6 border-b transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-600') }}">
                        <div class="flex items-center space-x-3">
                            @if(\App\Models\Setting::getLogo())
                                <img src="{{ Storage::url(\App\Models\Setting::getLogo()) }}" alt="{{ \App\Models\Setting::getAppName() }}" class="w-10 h-10 rounded-xl shadow-lg">
                            @else
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h2 class="text-xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ \App\Models\Setting::getAppName() }}</h2>
                                <p class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">by Inventiko</p>
                            </div>
                        </div>
                    </div>
                    
                    <nav class="px-4 py-4 space-y-1" x-data="{ 
                        usersOpen: {{ (request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*')) ? 'true' : 'false' }},
                        attendanceOpen: {{ (request()->routeIs('admin.attendance-report.*') || request()->routeIs('admin.attendance.*') || request()->routeIs('admin.leaves.*') || request()->routeIs('admin.leave-report') || request()->routeIs('admin.leave-balance-management') || request()->routeIs('employee.leave-request') || request()->routeIs('employee.my-leave-requests') || request()->routeIs('employee.edit-leave-request')) ? 'true' : 'false' }},
                        projectsOpen: {{ request()->routeIs('admin.projects.*') ? 'true' : 'false' }},
                        clientsOpen: {{ request()->routeIs('admin.clients.*') ? 'true' : 'false' }},
                        leadsOpen: {{ request()->routeIs('admin.leads.*') ? 'true' : 'false' }},
                        tasksOpen: {{ request()->routeIs('admin.tasks.*') ? 'true' : 'false' }}
                    }">
                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" wire:navigate 
                           class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200
                                  {{ request()->routeIs('dashboard') 
                                      ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 border border-indigo-200 shadow-sm', 'bg-gradient-to-r from-indigo-900/50 to-purple-900/50 text-indigo-300 border border-indigo-700 shadow-sm')
                                      : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 hover:bg-gray-100 hover:text-gray-900', 'text-slate-400 hover:bg-slate-700 hover:text-slate-200') }}">
                            <div class="flex items-center justify-center w-8 h-8 rounded-lg transition-colors duration-200
                                        {{ request()->routeIs('dashboard') 
                                            ? 'bg-indigo-500'
                                            : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 group-hover:bg-indigo-500', 'bg-slate-600 group-hover:bg-indigo-500') }}">
                                <svg class="w-4 h-4 transition-colors duration-200
                                           {{ request()->routeIs('dashboard') 
                                               ? 'text-white'
                                               : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 group-hover:text-white', 'text-slate-400 group-hover:text-white') }}" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                            </div>
                            <span class="ml-3 font-medium transition-colors duration-200
                                        {{ request()->routeIs('dashboard') 
                                            ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-indigo-700', 'text-indigo-300')
                                            : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 group-hover:text-gray-900', 'text-slate-400 group-hover:text-slate-200') }}">Dashboard</span>
                        </a>

                        @if(auth()->check())
                            @if(auth()->user()->can('view user') || auth()->user()->can('create user') || auth()->user()->can('view roles') || auth()->user()->can('view permissions'))
                            <!-- Users Section -->
                            <div class="pt-6">
                                <button type="button" @click="usersOpen = !usersOpen" 
                                        class="group w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 hover:bg-gray-100 hover:text-gray-900', 'text-slate-400 hover:bg-slate-700 hover:text-slate-200') }} {{ (request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*')) ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-700 border border-emerald-200 shadow-sm', 'bg-gradient-to-r from-emerald-900/50 to-teal-900/50 text-emerald-300 border border-emerald-700 shadow-sm') : '' }}">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-lg transition-colors duration-200 {{ (request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*')) ? 'bg-emerald-500' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 group-hover:bg-emerald-500', 'bg-slate-600 group-hover:bg-emerald-500') }}">
                                            <svg class="w-4 h-4 transition-colors duration-200 {{ (request()->routeIs('admin.users.*') || request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*')) ? 'text-white' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 group-hover:text-white', 'text-slate-400 group-hover:text-white') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                            </svg>
                                        </div>
                                        <span class="ml-3 font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-300') }}">Users</span>
                                    </div>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="usersOpen ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="usersOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-12 mt-3 space-y-2">
                                    @can('create user')
                                        <a href="{{ route('admin.users.create') }}" wire:navigate 
                                           class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-emerald-50 hover:text-emerald-700', 'text-slate-400 hover:bg-emerald-900/20 hover:text-emerald-300') }} {{ request()->routeIs('admin.users.create') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm', 'bg-emerald-900/30 text-emerald-300 border border-emerald-700 shadow-sm') : '' }}">
                                            <div class="w-2 h-2 bg-emerald-400 group-hover:bg-emerald-500 rounded-full mr-3 transition-colors duration-200"></div>
                                            <span class="font-medium">Create User</span>
                                        </a>
                                    @endcan
                                    @can('view user')
                                        <a href="{{ route('admin.users.index') }}" wire:navigate 
                                           class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-emerald-50 hover:text-emerald-700', 'text-slate-400 hover:bg-emerald-900/20 hover:text-emerald-300') }} {{ request()->routeIs('admin.users.index') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm', 'bg-emerald-900/30 text-emerald-300 border border-emerald-700 shadow-sm') : '' }}">
                                            <div class="w-2 h-2 bg-emerald-400 group-hover:bg-emerald-500 rounded-full mr-3 transition-colors duration-200"></div>
                                            <span class="font-medium">Manage Users</span>
                                        </a>
                                    @endcan
                                    @can('create role')
                                        <a href="{{ route('admin.roles.create') }}" wire:navigate 
                                           class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-emerald-50 hover:text-emerald-700', 'text-slate-400 hover:bg-emerald-900/20 hover:text-emerald-300') }} {{ request()->routeIs('admin.roles.create') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm', 'bg-emerald-900/30 text-emerald-300 border border-emerald-700 shadow-sm') : '' }}">
                                            <div class="w-2 h-2 bg-emerald-400 group-hover:bg-emerald-500 rounded-full mr-3 transition-colors duration-200"></div>
                                            <span class="font-medium">Create Role</span>
                                        </a>
                                    @endcan
                                    @can('view roles')
                                        <a href="{{ route('admin.roles.index') }}" wire:navigate 
                                           class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-emerald-50 hover:text-emerald-700', 'text-slate-400 hover:bg-emerald-900/20 hover:text-emerald-300') }} {{ request()->routeIs('admin.roles.index') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm', 'bg-emerald-900/30 text-emerald-300 border border-emerald-700 shadow-sm') : '' }}">
                                            <div class="w-2 h-2 bg-emerald-400 group-hover:bg-emerald-500 rounded-full mr-3 transition-colors duration-200"></div>
                                            <span class="font-medium">Manage Roles</span>
                                        </a>
                                    @endcan
                                    <!-- @can('create permission')
                                        <a href="{{ route('admin.permissions.create') }}"                                           class="flex items-center px-3 py-2 rounded-lg text-sm text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors {{ request()->routeIs('admin.permissions.create') ? 'bg-blue-50 text-blue-700' : '' }}">
                                            <div class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-3"></div>
                                            Create Permission
                                        </a>
                                    @endcan -->
                                    @can('view permissions')
                                        <a href="{{ route('admin.permissions.index') }}" wire:navigate
                                           class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-emerald-50 hover:text-emerald-700', 'text-slate-400 hover:bg-emerald-900/20 hover:text-emerald-300') }} {{ request()->routeIs('admin.permissions.*') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm', 'bg-emerald-900/30 text-emerald-300 border border-emerald-700 shadow-sm') : '' }}">
                                            <div class="w-2 h-2 bg-emerald-400 group-hover:bg-emerald-500 rounded-full mr-3 transition-colors duration-200"></div>
                                            <span class="font-medium">Permissions</span>
                                        </a>
                                    @endcan
                                </div>
                            </div>
                            @endif

                            

                            @if(auth()->check())
                            <!-- Attendance Section -->
                            <div class="pt-6">
                                <button type="button" @click="attendanceOpen = !attendanceOpen" 
                                        class="group w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 hover:bg-gray-100 hover:text-gray-900', 'text-slate-400 hover:bg-slate-700 hover:text-slate-200') }} {{ (request()->routeIs('admin.attendance-report.*') || request()->routeIs('admin.attendance.*') || request()->routeIs('admin.leaves.*') || request()->routeIs('admin.leave-report') || request()->routeIs('admin.leave-balance-management') || request()->routeIs('employee.leave-request') || request()->routeIs('employee.my-leave-requests') || request()->routeIs('employee.edit-leave-request')) ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 border border-blue-200 shadow-sm', 'bg-gradient-to-r from-blue-900/50 to-indigo-900/50 text-blue-300 border border-blue-700 shadow-sm') : '' }}">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-8 h-8 rounded-lg transition-colors duration-200 {{ (request()->routeIs('admin.attendance-report.*') || request()->routeIs('admin.attendance.*') || request()->routeIs('admin.leaves.*') || request()->routeIs('admin.leave-report') || request()->routeIs('admin.leave-balance-management') || request()->routeIs('employee.leave-request') || request()->routeIs('employee.my-leave-requests') || request()->routeIs('employee.edit-leave-request')) ? 'bg-blue-500' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 group-hover:bg-blue-500', 'bg-slate-600 group-hover:bg-blue-500') }}">
                                            <svg class="w-4 h-4 transition-colors duration-200 {{ (request()->routeIs('admin.attendance-report.*') || request()->routeIs('admin.attendance.*') || request()->routeIs('admin.leaves.*') || request()->routeIs('admin.leave-report') || request()->routeIs('admin.leave-balance-management') || request()->routeIs('employee.leave-request') || request()->routeIs('employee.my-leave-requests') || request()->routeIs('employee.edit-leave-request')) ? 'text-white' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 group-hover:text-white', 'text-slate-400 group-hover:text-white') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5a2.25 2.25 0 002.25-2.25m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5a2.25 2.25 0 012.25 2.25v7.5" />
                                            </svg>
                                        </div>
                                        <span class="ml-3 font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-300') }}">Attendance</span>
                                    </div>
                                    <svg class="w-4 h-4 transition-transform duration-200" :class="attendanceOpen ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="attendanceOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-12 mt-3 space-y-2">
                                    <!-- Admin-only options -->
                                    @canany(['view user', 'view leaves', 'mark leave'])
                                        <a href="{{ route('admin.attendance-report.index') }}" wire:navigate
                                           class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-blue-50 hover:text-blue-700', 'text-slate-400 hover:bg-blue-900/20 hover:text-blue-300') }} {{ request()->routeIs('admin.attendance-report.*') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100 text-blue-700 border border-blue-200 shadow-sm', 'bg-blue-900/30 text-blue-300 border border-blue-700 shadow-sm') : '' }}">
                                            <div class="w-2 h-2 bg-blue-400 group-hover:bg-blue-500 rounded-full mr-3 transition-colors duration-200"></div>
                                            <span class="font-medium">Daily Report</span>
                                        </a>
                                    @endcanany
                                    @can('view monthly attendance report')
                                        <a href="{{ route('admin.attendance.monthly-report') }}" wire:navigate
                                           class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-blue-50 hover:text-blue-700', 'text-slate-400 hover:bg-blue-900/20 hover:text-blue-300') }} {{ request()->routeIs('admin.attendance.monthly-report') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100 text-blue-700 border border-blue-200 shadow-sm', 'bg-blue-900/30 text-blue-300 border border-blue-700 shadow-sm') : '' }}">
                                            <div class="w-2 h-2 bg-blue-400 group-hover:bg-blue-500 rounded-full mr-3 transition-colors duration-200"></div>
                                            <span class="font-medium">Monthly Report</span>
                                        </a>
                                    @endcan
                                    @can('mark leave')
                                        <a href="{{ route('admin.leaves.mark') }}" wire:navigate
                                           class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-blue-50 hover:text-blue-700', 'text-slate-400 hover:bg-blue-900/20 hover:text-blue-300') }} {{ request()->routeIs('admin.leaves.mark') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100 text-blue-700 border border-blue-200 shadow-sm', 'bg-blue-900/30 text-blue-300 border border-blue-700 shadow-sm') : '' }}">
                                            <div class="w-2 h-2 bg-blue-400 group-hover:bg-blue-500 rounded-full mr-3 transition-colors duration-200"></div>
                                            <span class="font-medium">Mark Leave</span>
                                        </a>
                                    @endcan
                                    @can('view leaves')
                                        <a href="{{ route('admin.leaves.manage') }}" wire:navigate
                                           class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-blue-50 hover:text-blue-700', 'text-slate-400 hover:bg-blue-900/20 hover:text-blue-300') }} {{ request()->routeIs('admin.leaves.manage') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100 text-blue-700 border border-blue-200 shadow-sm', 'bg-blue-900/30 text-blue-300 border border-blue-700 shadow-sm') : '' }}">
                                            <div class="w-2 h-2 bg-blue-400 group-hover:bg-blue-500 rounded-full mr-3 transition-colors duration-200"></div>
                                            <span class="font-medium">Manage Leaves</span>
                                        </a>
                                    @endcan
                                    @can('approve leave requests')
                                        <a href="{{ route('admin.leave-requests.index') }}" wire:navigate
                                           class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-blue-50 hover:text-blue-700', 'text-slate-400 hover:bg-blue-900/20 hover:text-blue-300') }} {{ request()->routeIs('admin.leave-requests.*') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100 text-blue-700 border border-blue-200 shadow-sm', 'bg-blue-900/30 text-blue-300 border border-blue-700 shadow-sm') : '' }}">
                                            <div class="w-2 h-2 bg-blue-400 group-hover:bg-blue-500 rounded-full mr-3 transition-colors duration-200"></div>
                                            <span class="font-medium">Leave Requests</span>
                                        </a>
                                    @endcan
                                    @can('view leave report')
                                        <a href="{{ route('admin.leave-report') }}" wire:navigate
                                           class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-blue-50 hover:text-blue-700', 'text-slate-400 hover:bg-blue-900/20 hover:text-blue-300') }} {{ request()->routeIs('admin.leave-report') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100 text-blue-700 border border-blue-200 shadow-sm', 'bg-blue-900/30 text-blue-300 border border-blue-700 shadow-sm') : '' }}">
                                            <div class="w-2 h-2 bg-blue-400 group-hover:bg-blue-500 rounded-full mr-3 transition-colors duration-200"></div>
                                            <span class="font-medium">Leave Report</span>
                                        </a>
                                    @endcan
                                    @can('manage leave balances')
                                        <a href="{{ route('admin.leave-balance-management') }}" wire:navigate
                                           class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-blue-50 hover:text-blue-700', 'text-slate-400 hover:bg-blue-900/20 hover:text-blue-300') }} {{ request()->routeIs('admin.leave-balance-management') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100 text-blue-700 border border-blue-200 shadow-sm', 'bg-blue-900/30 text-blue-300 border border-blue-700 shadow-sm') : '' }}">
                                            <div class="w-2 h-2 bg-blue-400 group-hover:bg-blue-500 rounded-full mr-3 transition-colors duration-200"></div>
                                            <span class="font-medium">Balance Management</span>
                                        </a>
                                    @endcan
                                    
                                    <!-- Employee options (visible to all users) -->
                                    <a href="{{ route('employee.leave-request') }}" wire:navigate
                                       class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-blue-50 hover:text-blue-700', 'text-slate-400 hover:bg-blue-900/20 hover:text-blue-300') }} {{ request()->routeIs('employee.leave-request') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100 text-blue-700 border border-blue-200 shadow-sm', 'bg-blue-900/30 text-blue-300 border border-blue-700 shadow-sm') : '' }}">
                                        <div class="w-2 h-2 bg-blue-400 group-hover:bg-blue-500 rounded-full mr-3 transition-colors duration-200"></div>
                                        <span class="font-medium">Request Leave</span>
                                    </a>
                                    <a href="{{ route('employee.my-leave-requests') }}" wire:navigate
                                       class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-blue-50 hover:text-blue-700', 'text-slate-400 hover:bg-blue-900/20 hover:text-blue-300') }} {{ request()->routeIs('employee.my-leave-requests') || request()->routeIs('employee.edit-leave-request') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100 text-blue-700 border border-blue-200 shadow-sm', 'bg-blue-900/30 text-blue-300 border border-blue-700 shadow-sm') : '' }}">
                                        <div class="w-2 h-2 bg-blue-400 group-hover:bg-blue-500 rounded-full mr-3 transition-colors duration-200"></div>
                                        <span class="font-medium">My Leave Requests</span>
                                    </a>
                                </div>
                            </div>
                            @endif

        @if(auth()->user()->can('view projects') || auth()->user()->can('add project') || auth()->user()->can('edit projects') || auth()->user()->can('delete projects'))
        <!-- Projects Section -->
        <div class="pt-6">
            <button type="button" @click="projectsOpen = !projectsOpen" 
                    class="group w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 hover:bg-gray-100 hover:text-gray-900', 'text-slate-400 hover:bg-slate-700 hover:text-slate-200') }} {{ (request()->routeIs('admin.projects.*')) ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gradient-to-r from-orange-50 to-amber-50 text-orange-700 border border-orange-200 shadow-sm', 'bg-gradient-to-r from-orange-900/50 to-amber-900/50 text-orange-300 border border-orange-700 shadow-sm') : '' }}">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg transition-colors duration-200 {{ (request()->routeIs('admin.projects.*')) ? 'bg-orange-500' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 group-hover:bg-orange-500', 'bg-slate-600 group-hover:bg-orange-500') }}">
                        <svg class="w-4 h-4 transition-colors duration-200 {{ (request()->routeIs('admin.projects.*')) ? 'text-white' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 group-hover:text-white', 'text-slate-400 group-hover:text-white') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 8.006V4.5c0-1.324-.89-2.5-2.25-2.5H6.75c-1.324 0-2.25 1.176-2.25 2.5v9.006c0 1.324.89 2.5 2.25 2.5h9.75c1.324 0 2.25-1.176 2.25-2.5z" />
                        </svg>
                    </div>
                    <span class="ml-3 font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-300') }}">Projects</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200" :class="projectsOpen ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            
            <div x-show="projectsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-12 mt-3 space-y-2">
                @can('view projects')
                    <a href="{{ route('admin.projects.index') }}" wire:navigate
                       class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-orange-50 hover:text-orange-700', 'text-slate-400 hover:bg-orange-900/20 hover:text-orange-300') }} {{ request()->routeIs('admin.projects.index') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-orange-100 text-orange-700 border border-orange-200 shadow-sm', 'bg-orange-900/30 text-orange-300 border border-orange-700 shadow-sm') : '' }}">
                        <div class="w-2 h-2 bg-orange-400 group-hover:bg-orange-500 rounded-full mr-3 transition-colors duration-200"></div>
                        <span class="font-medium">All Projects</span>
                    </a>
                @endcan
                @can('add project')
                    <a href="{{ route('admin.projects.create') }}" wire:navigate
                       class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-orange-50 hover:text-orange-700', 'text-slate-400 hover:bg-orange-900/20 hover:text-orange-300') }} {{ request()->routeIs('admin.projects.create') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-orange-100 text-orange-700 border border-orange-200 shadow-sm', 'bg-orange-900/30 text-orange-300 border border-orange-700 shadow-sm') : '' }}">
                        <div class="w-2 h-2 bg-orange-400 group-hover:bg-orange-500 rounded-full mr-3 transition-colors duration-200"></div>
                        <span class="font-medium">Create Project</span>
                    </a>
                @endcan
            </div>
        </div>
        @endif

        @if(auth()->user()->can('view clients') || auth()->user()->can('create client') || auth()->user()->can('update client') || auth()->user()->can('delete client'))
        <!-- Clients Section -->
        <div class="pt-6">
            <button type="button" @click="clientsOpen = !clientsOpen" 
                    class="group w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 hover:bg-gray-100 hover:text-gray-900', 'text-slate-400 hover:bg-slate-700 hover:text-slate-200') }} {{ (request()->routeIs('admin.clients.*')) ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gradient-to-r from-purple-50 to-pink-50 text-purple-700 border border-purple-200 shadow-sm', 'bg-gradient-to-r from-purple-900/50 to-pink-900/50 text-purple-300 border border-purple-700 shadow-sm') : '' }}">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg transition-colors duration-200 {{ (request()->routeIs('admin.clients.*')) ? 'bg-purple-500' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 group-hover:bg-purple-500', 'bg-slate-600 group-hover:bg-purple-500') }}">
                        <svg class="w-4 h-4 transition-colors duration-200 {{ (request()->routeIs('admin.clients.*')) ? 'text-white' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 group-hover:text-white', 'text-slate-400 group-hover:text-white') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016.76 15.72m0 0a9.094 9.094 0 00-3.741.479 3 3 0 004.682 2.72m-4.682-2.72a9.094 9.094 0 003.741.479 3 3 0 004.682-2.72m0 0a9.094 9.094 0 713.741-.479 3 3 0 00-4.682 2.72m0 0a9.094 9.094 0 00-3.741.479 3 3 0 004.682 2.72" />
                        </svg>
                    </div>
                    <span class="ml-3 font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-300') }}">Clients</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200" :class="clientsOpen ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            
            <div x-show="clientsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-12 mt-3 space-y-2">
                @can('view clients')
                    <a href="{{ route('admin.clients.index') }}" wire:navigate
                       class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-purple-50 hover:text-purple-700', 'text-slate-400 hover:bg-purple-900/20 hover:text-purple-300') }} {{ request()->routeIs('admin.clients.index') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-purple-100 text-purple-700 border border-purple-200 shadow-sm', 'bg-purple-900/30 text-purple-300 border border-purple-700 shadow-sm') : '' }}">
                        <div class="w-2 h-2 bg-purple-400 group-hover:bg-purple-500 rounded-full mr-3 transition-colors duration-200"></div>
                        <span class="font-medium">All Clients</span>
                    </a>
                @endcan
                @can('create client')
                    <a href="{{ route('admin.clients.create') }}" wire:navigate
                       class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-purple-50 hover:text-purple-700', 'text-slate-400 hover:bg-purple-900/20 hover:text-purple-300') }} {{ request()->routeIs('admin.clients.create') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-purple-100 text-purple-700 border border-purple-200 shadow-sm', 'bg-purple-900/30 text-purple-300 border border-purple-700 shadow-sm') : '' }}">
                        <div class="w-2 h-2 bg-purple-400 group-hover:bg-purple-500 rounded-full mr-3 transition-colors duration-200"></div>
                        <span class="font-medium">Add Client</span>
                    </a>
                @endcan
            </div>
        </div>
        @endif

        @if(auth()->user()->can('view leads') || auth()->user()->can('create lead') || auth()->user()->can('edit lead') || auth()->user()->can('delete lead'))
        <!-- Leads Section -->
        <div class="pt-6">
            <button type="button" @click="leadsOpen = !leadsOpen" 
                    class="group w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 hover:bg-gray-100 hover:text-gray-900', 'text-slate-400 hover:bg-slate-700 hover:text-slate-200') }} {{ (request()->routeIs('admin.leads.*')) ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gradient-to-r from-teal-50 to-cyan-50 text-teal-700 border border-teal-200 shadow-sm', 'bg-gradient-to-r from-teal-900/50 to-cyan-900/50 text-teal-300 border border-teal-700 shadow-sm') : '' }}">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg transition-colors duration-200 {{ (request()->routeIs('admin.leads.*')) ? 'bg-teal-500' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 group-hover:bg-teal-500', 'bg-slate-600 group-hover:bg-teal-500') }}">
                        <svg class="w-4 h-4 transition-colors duration-200 {{ (request()->routeIs('admin.leads.*')) ? 'text-white' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 group-hover:text-white', 'text-slate-400 group-hover:text-white') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="ml-3 font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-300') }}">Leads</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200" :class="leadsOpen ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            
            <div x-show="leadsOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-12 mt-3 space-y-2">
                @can('view leads')
                    <a href="{{ route('admin.leads.index') }}" wire:navigate
                       class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-teal-50 hover:text-teal-700', 'text-slate-400 hover:bg-teal-900/20 hover:text-teal-300') }} {{ request()->routeIs('admin.leads.index') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-teal-100 text-teal-700 border border-teal-200 shadow-sm', 'bg-teal-900/30 text-teal-300 border border-teal-700 shadow-sm') : '' }}">
                        <div class="w-2 h-2 bg-teal-400 group-hover:bg-teal-500 rounded-full mr-3 transition-colors duration-200"></div>
                        <span class="font-medium">All Leads</span>
                    </a>
                @endcan
                @can('create lead')
                    <a href="{{ route('admin.leads.create') }}" wire:navigate
                       class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-teal-50 hover:text-teal-700', 'text-slate-400 hover:bg-teal-900/20 hover:text-teal-300') }} {{ request()->routeIs('admin.leads.create') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-teal-100 text-teal-700 border border-teal-200 shadow-sm', 'bg-teal-900/30 text-teal-300 border border-teal-700 shadow-sm') : '' }}">
                        <div class="w-2 h-2 bg-teal-400 group-hover:bg-teal-500 rounded-full mr-3 transition-colors duration-200"></div>
                        <span class="font-medium">Add Lead</span>
                    </a>
                @endcan
            </div>
        </div>
        @endif

        @if(auth()->user()->can('view tasks') || auth()->user()->can('create task') || auth()->user()->can('edit task') || auth()->user()->can('delete task'))
        <!-- Tasks Section -->
        <div class="pt-6">
            <button type="button" @click="tasksOpen = !tasksOpen" 
                    class="group w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 hover:bg-gray-100 hover:text-gray-900', 'text-slate-400 hover:bg-slate-700 hover:text-slate-200') }} {{ (request()->routeIs('admin.tasks.*')) ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gradient-to-r from-purple-50 to-pink-50 text-purple-700 border border-purple-200 shadow-sm', 'bg-gradient-to-r from-purple-900/50 to-pink-900/50 text-purple-300 border border-purple-700 shadow-sm') : '' }}">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg transition-colors duration-200 {{ (request()->routeIs('admin.tasks.*')) ? 'bg-purple-500' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 group-hover:bg-purple-500', 'bg-slate-600 group-hover:bg-purple-500') }}">
                        <svg class="w-4 h-4 transition-colors duration-200 {{ (request()->routeIs('admin.tasks.*')) ? 'text-white' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 group-hover:text-white', 'text-slate-400 group-hover:text-white') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <span class="ml-3 font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-300') }}">Tasks</span>
                </div>
                <svg class="w-4 h-4 transition-transform duration-200" :class="tasksOpen ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            
            <div x-show="tasksOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="ml-12 mt-3 space-y-2">
                @can('view tasks')
                    <a href="{{ route('admin.tasks.index') }}" wire:navigate
                       class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-purple-50 hover:text-purple-700', 'text-slate-400 hover:bg-purple-900/20 hover:text-purple-300') }} {{ request()->routeIs('admin.tasks.index') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-purple-100 text-purple-700 border border-purple-200 shadow-sm', 'bg-purple-900/30 text-purple-300 border border-purple-700 shadow-sm') : '' }}">
                        <div class="w-2 h-2 bg-purple-400 group-hover:bg-purple-500 rounded-full mr-3 transition-colors duration-200"></div>
                        <span class="font-medium">All Tasks</span>
                    </a>
                @endcan
                @can('view tasks')
                    <a href="{{ route('admin.tasks.gantt-chart') }}" wire:navigate
                       class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-purple-50 hover:text-purple-700', 'text-slate-400 hover:bg-purple-900/20 hover:text-purple-300') }} {{ request()->routeIs('admin.tasks.gantt-chart') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-purple-100 text-purple-700 border border-purple-200 shadow-sm', 'bg-purple-900/30 text-purple-300 border border-purple-700 shadow-sm') : '' }}">
                        <div class="w-2 h-2 bg-purple-400 group-hover:bg-purple-500 rounded-full mr-3 transition-colors duration-200"></div>
                        <span class="font-medium">Gantt Chart</span>
                    </a>
                @endcan
                @can('create task')
                    <a href="{{ route('admin.tasks.create') }}" wire:navigate
                       class="group flex items-center px-4 py-2.5 rounded-lg text-sm transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-purple-50 hover:text-purple-700', 'text-slate-400 hover:bg-purple-900/20 hover:text-purple-300') }} {{ request()->routeIs('admin.tasks.create') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-purple-100 text-purple-700 border border-purple-200 shadow-sm', 'bg-purple-900/30 text-purple-300 border border-purple-700 shadow-sm') : '' }}">
                        <div class="w-2 h-2 bg-purple-400 group-hover:bg-purple-500 rounded-full mr-3 transition-colors duration-200"></div>
                        <span class="font-medium">Create Task</span>
                    </a>
                @endcan
            </div>
        </div>
        @endif
        @can('manage settings')
                            <!-- Settings Section -->
                            <div class="pt-6">
                                <a href="{{ route('admin.settings.index') }}" wire:navigate
                                   class="group flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 hover:bg-gray-100 hover:text-gray-900', 'text-slate-400 hover:bg-slate-700 hover:text-slate-200') }} {{ request()->routeIs('admin.settings.*') ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gradient-to-r from-purple-50 to-pink-50 text-purple-700 border border-purple-200 shadow-sm', 'bg-gradient-to-r from-purple-900/50 to-pink-900/50 text-purple-300 border border-purple-700 shadow-sm') : '' }}">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-purple-500' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 group-hover:bg-purple-500', 'bg-slate-600 group-hover:bg-purple-500') }}">
                                        <svg class="w-4 h-4 transition-colors duration-200 {{ request()->routeIs('admin.settings.*') ? 'text-white' : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 group-hover:text-white', 'text-slate-400 group-hover:text-white') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                    <span class="ml-3 font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-300') }}">Settings</span>
                                </a>
                            </div>
                            @endcan
                        @endif

                    </nav>
                </aside>

                <div class="flex-1 flex flex-col">
                    <!-- Minimal Top Navigation -->
                    <header class="px-6 py-4 border-b transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
                        <div class="flex justify-between items-center">
                            <!-- Left side - Attendance Toggle and Theme Toggle -->
                            <div class="flex items-center space-x-4">
                                @livewire('components.attendance-toggle')
                                @livewire('theme-toggle')
                            </div>
                            
                            <!-- Profile Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700 hover:text-gray-900', 'text-slate-300 hover:text-slate-100') }} focus:outline-none">
                                    @if(auth()->user()->profile_picture)
                                        <img src="{{ auth()->user()->profile_picture_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <img src="{{ auth()->user()->getDefaultProfilePicture() }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover">
                                    @endif
                                    <span class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-slate-700', 'text-slate-300') }}">{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" 
                                     class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 z-50 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-700 border border-slate-600') }}">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700 hover:bg-gray-100', 'text-slate-300 hover:bg-slate-600') }}">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700 hover:bg-gray-100', 'text-slate-300 hover:bg-slate-600') }}">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </header>

                    <!-- Page Content -->
                    <main class="flex-1">
            @if (isset($header))
                            <div class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                            </div>
            @endif

                        <div class="p-6">
                            <!-- <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ $pageTitle ?? 'Dashboard' }}</h2> -->
                @yield('content')
                @isset($slot)
                    {{ $slot }}
                @endisset
                        </div>
            </main>
                </div>
            </div>
        </div>
        
        @livewireScripts
        
        <script>
            // Auto-refresh page when theme changes
            document.addEventListener('livewire:init', () => {
                Livewire.on('refresh-page', () => {
                    // Small delay to ensure the theme preference is saved
                    setTimeout(() => {
                        window.location.reload();
                    }, 100);
                });
            });
        </script>
    </body>
</html>
