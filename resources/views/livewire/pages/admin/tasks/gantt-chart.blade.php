<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Task Gantt Chart</h1>
                    <p class="text-gray-600 mt-1">Visualize task assignments across users and time periods</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.tasks.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Tasks
                    </a>
                    @can('create task')
                    <a href="{{ route('admin.tasks.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Task
                    </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Tasks</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $this->tasks->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Active Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ count($this->ganttData) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Completed</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $this->tasks->where('status', 'completed')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">In Progress</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $this->tasks->where('status', 'in_progress')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Filters</h3>
                <div class="flex items-center space-x-3">
                    <!-- Quick View Buttons -->
                    <div class="flex items-center space-x-2">
                        <button wire:click="setWeekView" 
                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
                            This Week
                        </button>
                    </div>
                    <button wire:click="$set('selectedWeek', '{{ now()->startOfWeek()->format('Y-m-d') }}'); $set('selectedUsers', []); $set('selectedProjects', [])" 
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset All
                    </button>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Week Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Week</label>
                    <select wire:model.live="selectedWeek" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        @foreach($this->weekOptions as $week)
                            <option value="{{ $week['value'] }}" 
                                    @if($week['is_current']) selected @endif>
                                {{ $week['label'] }}
                                @if($week['is_current']) (Current) @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Users Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Users</label>
                    <select wire:model.live="selectedUsers" multiple
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        @foreach($this->users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple</p>
                </div>

                <!-- Projects Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Projects</label>
                    <select wire:model.live="selectedProjects" multiple
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        @foreach($this->projects as $project)
                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple</p>
                </div>
            </div>
        </div>

        <!-- Gantt Chart -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            @if(count($this->ganttData) > 0)
                <div class="overflow-x-auto">
                    <div class="min-w-full">
                        <!-- Header -->
                        <div class="flex border-b border-gray-200 bg-gray-50">
                            <div class="w-64 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10 border-r border-gray-200">
                                Employee
                            </div>
                            <div class="flex-1 flex">
                                @foreach($this->dateRange as $date)
                                    <div class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider min-w-20 border-r border-gray-100 {{ $date->isToday() ? 'bg-blue-50' : '' }}">
                                        <div class="flex flex-col">
                                            <span class="text-gray-400 text-xs">{{ $date->format('D') }}</span>
                                            <span class="text-sm font-semibold text-gray-900">{{ $date->format('d') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="divide-y divide-gray-200">
                            @foreach($this->ganttData as $userData)
                                <div class="flex hover:bg-gray-50 transition-colors" style="min-height: {{ max(80, count($userData['tasks']) * 24 + 32) }}px;">
                                    <!-- User Column -->
                                    <div class="w-64 px-4 py-4 sticky left-0 bg-white z-10 border-r border-gray-200">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                @if($userData['user']->profile_picture)
                                                    <img class="h-8 w-8 rounded-full object-cover" 
                                                         src="{{ $userData['user']->profile_picture_url }}" 
                                                         alt="{{ $userData['user']->name }}">
                                                @else
                                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold text-sm">
                                                        {{ substr($userData['user']->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $userData['user']->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $userData['user']->roles->first()->name ?? 'Employee' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Timeline Column -->
                                    <div class="flex-1 flex relative">
                                        @foreach($this->dateRange as $date)
                                            <div class="px-3 py-4 min-w-20 border-r border-gray-100 relative" style="min-height: {{ max(80, count($userData['tasks']) * 24 + 32) }}px;">
                                                <!-- Empty cell for spacing -->
                                            </div>
                                        @endforeach
                                        
                                        <!-- Task Bars Overlay -->
                                        <div class="absolute inset-0">
                                            @php
                                                $taskIndex = 0;
                                                $columnWidth = 80; // min-w-20 = 80px
                                                $padding = 12; // px-3 = 12px on each side
                                            @endphp
                                            @foreach($userData['tasks'] as $task)
                                                @php
                                                    $startDate = $task['start_date'];
                                                    $endDate = $task['end_date'];
                                                    
                                                    // Find start and end indices in the date range
                                                    $startIndex = -1;
                                                    $endIndex = -1;
                                                    $currentIndex = 0;
                                                    
                                                    foreach($this->dateRange as $date) {
                                                        if ($date->isSameDay($startDate)) {
                                                            $startIndex = $currentIndex;
                                                        }
                                                        if ($date->isSameDay($endDate)) {
                                                            $endIndex = $currentIndex;
                                                            break;
                                                        }
                                                        $currentIndex++;
                                                    }
                                                    
                                                    // Skip if task dates are not in current range
                                                    if ($startIndex === -1 || $endIndex === -1) {
                                                        continue;
                                                    }
                                                    
                                                    // Calculate precise positioning
                                                    $leftPosition = ($startIndex * $columnWidth) + $padding;
                                                    $width = (($endIndex - $startIndex + 1) * $columnWidth) - ($padding * 2);
                                                    $topPosition = 16 + ($taskIndex * 24); // Increased spacing between tasks
                                                @endphp
                                                
                                                <div class="absolute h-4 rounded cursor-pointer hover:opacity-80 transition-all duration-200 flex items-center
                                                    @if($task['status'] === 'completed') bg-green-500
                                                    @elseif($task['status'] === 'in_progress') bg-blue-500
                                                    @elseif($task['status'] === 'pending') bg-orange-500
                                                    @else bg-red-500
                                                    @endif"
                                                    style="left: {{ $leftPosition }}px; width: {{ $width }}px; top: {{ $topPosition }}px; z-index: 10;"
                                                    title="{{ $task['title'] }}&#10;Status: {{ ucfirst($task['status']) }}&#10;Priority: {{ ucfirst($task['priority']) }}&#10;Project: {{ $task['project']->title ?? 'No Project' }}&#10;Duration: {{ $task['duration'] }} days&#10;Click to view details"
                                                    onclick="window.location.href='{{ route('admin.tasks.show', $task['id']) }}'">
                                                    @if($task['priority'] === 'urgent')
                                                        <span class="ml-1 w-1 h-1 bg-white rounded-full"></span>
                                                    @endif
                                                </div>
                                                @php
                                                    $taskIndex++;
                                                @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No tasks found</h3>
                    <p class="text-gray-500 mb-4">Try adjusting your filters or date range to see task assignments.</p>
                    <div class="flex justify-center space-x-3">
                        <a href="{{ route('admin.tasks.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Task
                        </a>
                        <button wire:click="$set('selectedWeek', '{{ now()->startOfWeek()->format('Y-m-d') }}')" 
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset Filters
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Legend -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Legend</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Task Status</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <div class="w-8 h-3 bg-orange-500 rounded mr-3"></div>
                            <span class="text-sm text-gray-700">Pending</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-3 bg-blue-500 rounded mr-3"></div>
                            <span class="text-sm text-gray-700">In Progress</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-3 bg-green-500 rounded mr-3"></div>
                            <span class="text-sm text-gray-700">Completed</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-8 h-3 bg-red-500 rounded mr-3"></div>
                            <span class="text-sm text-gray-700">Cancelled</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-900 mb-3">How to Use</h4>
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-white rounded-full mr-3"></div>
                            <span class="text-sm text-gray-700">Urgent tasks (white dot)</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-700">Hover over bars to see task details</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-sm text-gray-700">Click bars to view task details</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
