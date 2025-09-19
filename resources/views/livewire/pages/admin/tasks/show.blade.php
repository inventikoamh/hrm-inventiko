<div>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="rounded-xl shadow-sm border p-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $task->title }}</h1>
                    <p class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }} mt-1">Task Details</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.tasks.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Tasks
                    </a>
                    @can('edit task')
                    <a href="{{ route('admin.tasks.edit', $task) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Task
                    </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Task Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description -->
                <div class="rounded-xl shadow-sm border p-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
                    <h3 class="text-lg font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }} mb-4">Description</h3>
                    <div class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">
                        @if($task->description)
                            {{ $task->description }}
                        @else
                            <span class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-400', 'text-slate-500') }} italic">No description provided</span>
                        @endif
                    </div>
                </div>

                <!-- Task Actions -->
                @can('complete task')
                @if($task->status !== 'completed')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="flex items-center space-x-4">
                        <button wire:click="markAsCompleted" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mark as Completed
                        </button>
                    </div>
                </div>
                @endif
                @endcan

                <!-- Comments Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Comments & Notes</h3>
                    
                    <!-- Add Comment Form -->
                    @can('add task comment')
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg border">
                        <form wire:submit="addComment">
                            <div class="mb-3">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Add Comment</label>
                                <textarea wire:model="comment" 
                                          id="comment"
                                          rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                          placeholder="Add a comment or note about this task..."></textarea>
                                @error('comment') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                            </div>
                            <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg text-sm font-medium">
                                Add Comment
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="mb-6 p-4 bg-gray-100 rounded-lg border text-center">
                        <p class="text-sm text-gray-500">You don't have permission to add comments to tasks.</p>
                    </div>
                    @endcan

                    <!-- Comments List -->
                    <div class="space-y-3 max-h-96 overflow-y-auto">
                        @forelse($task->comments as $comment)
                            <div class="border border-gray-200 rounded-lg p-3 bg-white">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="text-sm text-gray-900 mb-2 whitespace-pre-wrap">{{ $comment->comment }}</div>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <span>{{ $comment->user->name }}</span>
                                            <span class="mx-2">•</span>
                                            <span>{{ $comment->created_at->format('M d, Y H:i') }}</span>
                                        </div>
                                    </div>
                                    @if(auth()->id() === $comment->user_id)
                                        <button wire:click="deleteComment({{ $comment->id }})" 
                                                onclick="return confirm('Are you sure you want to delete this comment?')"
                                                class="text-red-600 hover:text-red-900 ml-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No comments yet</h3>
                                <p class="mt-1 text-xs text-gray-500">Add the first comment to track this task's progress.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Task Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Task Information</h3>
                    <div class="space-y-4">
                        <!-- Status -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Status</label>
                            <div class="mt-1">
                                <x-colored-label :value="ucfirst(str_replace('_', ' ', $task->status))" enum-type="task_status" />
                            </div>
                        </div>

                        <!-- Priority -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Priority</label>
                            <div class="mt-1">
                                <x-colored-label :value="ucfirst($task->priority)" enum-type="task_priority" />
                            </div>
                        </div>

                        <!-- Assigned To -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Assigned To</label>
                            <div class="mt-1 text-sm text-gray-900">
                                {{ $task->assignedTo?->name ?? 'Unassigned' }}
                            </div>
                        </div>

                        <!-- Project -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Project</label>
                            <div class="mt-1 text-sm text-gray-900">
                                {{ $task->project?->title ?? 'No Project' }}
                            </div>
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Start Date</label>
                            <div class="mt-1 text-sm text-gray-900">
                                @if($task->start_date)
                                    <span class="{{ $task->isUpcoming() ? 'text-blue-600 font-medium' : '' }}">
                                        {{ $task->start_date->format('M d, Y') }}
                                    </span>
                                    @if($task->isUpcoming())
                                        <span class="ml-2 text-xs text-blue-500">Upcoming</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">No start date</span>
                                @endif
                            </div>
                        </div>

                        <!-- End Date -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">End Date</label>
                            <div class="mt-1 text-sm text-gray-900">
                                @if($task->end_date)
                                    <div class="flex items-center">
                                        <span class="{{ $task->isOverdueByEndDate() ? 'text-red-600 font-medium' : '' }}">
                                            {{ $task->end_date->format('M d, Y') }}
                                        </span>
                                        @if($task->isOverdueByEndDate())
                                            <span class="ml-2 text-xs text-red-500">Overdue</span>
                                        @elseif($task->isActive())
                                            <span class="ml-2 text-xs text-green-500">Active</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">No end date</span>
                                @endif
                            </div>
                        </div>


                        <!-- Duration -->
                        @if($task->start_date && $task->end_date)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Duration</label>
                            <div class="mt-1 text-sm text-gray-900">
                                {{ $task->duration_in_days }} {{ $task->duration_in_days == 1 ? 'day' : 'days' }}
                            </div>
                        </div>
                        @endif

                        <!-- Created By -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Created By</label>
                            <div class="mt-1 text-sm text-gray-900">
                                {{ $task->createdBy->name }}
                            </div>
                        </div>

                        <!-- Created At -->
                        <div>
                            <label class="text-sm font-medium text-gray-500">Created At</label>
                            <div class="mt-1 text-sm text-gray-900">
                                {{ $task->created_at->format('M d, Y H:i') }}
                            </div>
                        </div>

                        <!-- Completed At -->
                        @if($task->completed_at)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Completed At</label>
                            <div class="mt-1 text-sm text-gray-900">
                                {{ $task->completed_at->format('M d, Y H:i') }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Danger Zone -->
                @can('delete task')
                <div class="bg-white rounded-xl shadow-sm border border-red-200 p-6">
                    <h3 class="text-lg font-semibold text-red-900 mb-4">Danger Zone</h3>
                    <p class="text-sm text-red-600 mb-4">Once you delete a task, there is no going back. Please be certain.</p>
                    <button wire:click="delete" 
                            onclick="return confirm('Are you sure you want to delete this task? This action cannot be undone.')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Task
                    </button>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>