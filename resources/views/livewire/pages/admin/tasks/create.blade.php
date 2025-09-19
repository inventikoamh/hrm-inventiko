<div>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="rounded-xl shadow-sm border p-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Create New Task</h1>
                    <p class="mt-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">Add a new task to the system</p>
                </div>
                <a href="{{ route('admin.tasks.index') }}" 
                   class="inline-flex items-center px-4 py-2 text-white text-sm font-medium rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-600 hover:bg-gray-700', 'bg-slate-700 hover:bg-slate-600') }}">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Tasks
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="rounded-xl shadow-sm border p-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
            <form wire:submit="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Title *</label>
                        <input type="text" wire:model="title" 
                               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }} @error('title') border-red-500 @enderror">
                        @error('title') <div class="text-sm text-red-600 mt-1 transition-colors duration-200">{{ $message }}</div> @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Description</label>
                        <textarea wire:model="description" rows="4" 
                                  class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900 placeholder-gray-500', 'border-slate-600 bg-slate-700 text-slate-100 placeholder-slate-400') }} @error('description') border-red-500 @enderror"
                                  placeholder="Enter task description..."></textarea>
                        @error('description') <div class="text-sm text-red-600 mt-1 transition-colors duration-200">{{ $message }}</div> @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Status *</label>
                        <select wire:model="status" 
                                class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }} @error('status') border-red-500 @enderror">
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status') <div class="text-sm text-red-600 mt-1 transition-colors duration-200">{{ $message }}</div> @enderror
                    </div>

                    <!-- Priority -->
                    <div>
                        <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Priority *</label>
                        <select wire:model="priority" 
                                class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }} @error('priority') border-red-500 @enderror">
                            @foreach($priorityOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('priority') <div class="text-sm text-red-600 mt-1 transition-colors duration-200">{{ $message }}</div> @enderror
                    </div>

                    <!-- Assigned To -->
                    <div>
                        <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Assigned To</label>
                        <select wire:model="assigned_to" 
                                class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }} @error('assigned_to') border-red-500 @enderror">
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('assigned_to') <div class="text-sm text-red-600 mt-1 transition-colors duration-200">{{ $message }}</div> @enderror
                    </div>

                    <!-- Project -->
                    <div>
                        <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Project</label>
                        <select wire:model="project_id" 
                                class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }} @error('project_id') border-red-500 @enderror">
                            <option value="">Select Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->title }}</option>
                            @endforeach
                        </select>
                        @error('project_id') <div class="text-sm text-red-600 mt-1 transition-colors duration-200">{{ $message }}</div> @enderror
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Start Date</label>
                        <input type="date" wire:model="start_date" 
                               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }} @error('start_date') border-red-500 @enderror">
                        @error('start_date') <div class="text-sm text-red-600 mt-1 transition-colors duration-200">{{ $message }}</div> @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">End Date</label>
                        <input type="date" wire:model="end_date" 
                               class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }} @error('end_date') border-red-500 @enderror">
                        @error('end_date') <div class="text-sm text-red-600 mt-1 transition-colors duration-200">{{ $message }}</div> @enderror
                    </div>

                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-600') }}">
                    <a href="{{ route('admin.tasks.index') }}" 
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700 bg-gray-100 hover:bg-gray-200', 'text-slate-300 bg-slate-700 hover:bg-slate-600') }}">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Create Task
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>