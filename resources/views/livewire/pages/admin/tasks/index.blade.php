<div>
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Task Management</h1>
                    <p class="text-gray-600 mt-1">Manage and track all tasks across projects</p>
                </div>
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

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Filters</h3>
                <button wire:click="resetFilters" 
                        class="text-sm text-gray-600 hover:text-gray-800 underline">
                    Reset All Filters
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" 
                           wire:model.live="search" 
                           placeholder="Search tasks..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select wire:model.live="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <!-- Priority -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                    <select wire:model.live="priority" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="">All Priorities</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>

                <!-- Assigned To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assigned To</label>
                    <select wire:model.live="assignedTo" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Project -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Project</label>
                    <select wire:model.live="projectId" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="">All Projects</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Created By -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Created By</label>
                    <select wire:model.live="createdBy" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="">All Creators</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                    <select wire:model.live="dateRange" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="">All Time</option>
                        <option value="today">Today</option>
                        <option value="this_week">This Week</option>
                        <option value="this_month">This Month</option>
                        <option value="last_week">Last Week</option>
                        <option value="last_month">Last Month</option>
                        <option value="last_30_days">Last 30 Days</option>
                        <option value="last_90_days">Last 90 Days</option>
                    </select>
                </div>

                <!-- Overdue -->
                <div class="flex items-center">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               wire:model.live="overdue" 
                               class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Overdue Only</span>
                    </label>
                </div>
            </div>

            <!-- Results Count -->
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Showing {{ $tasks->count() }} of {{ $tasks->total() }} tasks
                    </p>
                    <div class="flex items-center space-x-4">
                        <label class="flex items-center text-sm text-gray-600">
                            <span class="mr-2">Per Page:</span>
                            <select wire:model.live="perPage" 
                                    class="px-2 py-1 border border-gray-300 rounded text-sm">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Task</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Status</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Priority</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Assigned</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Project</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Start</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">End</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tasks as $task)
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href='{{ route('admin.tasks.show', $task) }}'">
                            <td class="px-4 py-3">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 truncate">{{ $task->title }}</div>
                                    
                                </div>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <x-colored-label :value="ucfirst(str_replace('_', ' ', $task->status))" enum-type="task_status" />
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <x-colored-label :value="ucfirst($task->priority)" enum-type="task_priority" />
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-900">
                                <div class="truncate">{{ $task->assignedTo?->name ?? 'Unassigned' }}</div>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-900">
                                <div class="truncate">{{ $task->project?->title ?? 'No Project' }}</div>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-900">
                                @if($task->start_date)
                                    <span class="{{ $task->isUpcoming() ? 'text-blue-600 font-medium' : '' }}">
                                        {{ $task->start_date->format('M d') }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-xs text-gray-900">
                                @if($task->end_date)
                                    <div class="flex flex-col">
                                        <span class="{{ $task->isOverdueByEndDate() ? 'text-red-600 font-medium' : '' }}">
                                            {{ $task->end_date->format('M d') }}
                                        </span>
                                        @if($task->isOverdueByEndDate())
                                            <span class="text-xs text-red-500">Overdue</span>
                                        @elseif($task->isActive())
                                            <span class="text-xs text-green-500">Active</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap text-xs font-medium" onclick="event.stopPropagation()">
                                <div class="flex items-center space-x-1">
                                    @can('view tasks')
                                    <a href="{{ route('admin.tasks.show', $task) }}" 
                                       class="text-blue-600 hover:text-blue-900">View</a>
                                    @endcan
                                    @can('edit task')
                                    <a href="{{ route('admin.tasks.edit', $task) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    @endcan
                                    @can('delete task')
                                    <button wire:click="delete({{ $task->id }})" 
                                            onclick="return confirm('Are you sure you want to delete this task?')"
                                            class="text-red-600 hover:text-red-900">Del</button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                No tasks found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</div>