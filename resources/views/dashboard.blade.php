<x-app-layout>
    <x-slot name="pageTitle">Dashboard</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(auth()->user()->hasRole('admin'))
                <!-- Admin Dashboard -->
                <div class="space-y-6">
                    <!-- Welcome Section -->
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold">Welcome back, {{ auth()->user()->first_name }} 🤚</h1>
                                <p class="text-indigo-100 mt-1">Here's what's happening with your ProjectFlow system today.</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-indigo-100">Today is</div>
                                <div class="text-lg font-semibold">{{ now()->format('l, F j, Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                        <livewire:components.dashboard.tasks-summary-widget />
                        <livewire:components.dashboard.leads-stats-widget />
                        <livewire:components.dashboard.project-stats-widget />
                        <livewire:components.dashboard.client-stats-widget />
                    </div>

                    <!-- Main Content Grid -->
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Work Duration Widget -->
                        <div class="flex-1 w-full md:w-1/3">
                            <livewire:components.work-duration-widget />
                        </div>
                        
                        <!-- Attendance Stats -->
                        <div class="flex-1 w-full md:w-1/3">
                            <livewire:components.dashboard.attendance-stats-widget />
                        </div>
                        
                        <!-- Leave Management -->
                        <div class="flex-1 w-full md:w-1/3">
                            <livewire:components.dashboard.leave-stats-widget />
                        </div>
                    </div>

                    <!-- Quick Actions Row -->
                    <div class="w-full">
                        <livewire:components.dashboard.quick-actions-widget />
                    </div>

                    <!-- Recent Activities Row -->
                    <div class="w-full">
                        <livewire:components.dashboard.recent-activities-widget />
                    </div>
                </div>
            @else
                <!-- Employee Dashboard -->
                <div class="space-y-6">
                    <!-- Welcome Section -->
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold">Welcome back, {{ auth()->user()->first_name }}!</h1>
                                <p class="text-blue-100 mt-1">Here's your work overview for today.</p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-blue-100">Today is</div>
                                <div class="text-lg font-semibold">{{ now()->format('l, F j, Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content Grid -->
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Work Duration Widget -->
                        <div class="flex-1 w-full md:w-1/2">
                            <livewire:components.work-duration-widget />
                        </div>
                        
                        <!-- Work Summary Widget -->
                        <div class="flex-1 w-full md:w-1/2">
                            <livewire:components.dashboard.employee-work-summary-widget />
                        </div>
                    </div>

                    <!-- Bottom Row -->
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                        <!-- Leave Balance Widget -->
                        <div>
                            <livewire:components.leave-balance-widget />
                        </div>
                        
                        <!-- Quick Actions Widget -->
                        <div>
                            <livewire:components.dashboard.employee-quick-actions-widget />
                        </div>
                    </div>

                    
                    
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
