<div class="rounded-xl shadow-sm border p-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center">
            <div class="p-2.5 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-indigo-100', 'bg-indigo-900/50') }}">
                <svg class="w-5 h-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-indigo-600', 'text-indigo-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Tasks Summary</h3>
                <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Task management overview</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $totalTasks }}</div>
            <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Total Tasks</div>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-3">
        <div class="rounded-lg p-2.5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-yellow-50', 'bg-yellow-900/20') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-yellow-900', 'text-yellow-300') }}">{{ $pendingTasks }}</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-yellow-700', 'text-yellow-400') }}">Pending</div>
                </div>
                <div class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="rounded-lg p-2.5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-50', 'bg-blue-900/20') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-900', 'text-blue-300') }}">{{ $inProgressTasks }}</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-700', 'text-blue-400') }}">In Progress</div>
                </div>
                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="rounded-lg p-2.5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-50', 'bg-green-900/20') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-900', 'text-green-300') }}">{{ $completedTasks }}</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-700', 'text-green-400') }}">Completed</div>
                </div>
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="rounded-lg p-2.5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-50', 'bg-red-900/20') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-900', 'text-red-300') }}">{{ $overdueTasks }}</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-700', 'text-red-400') }}">Overdue</div>
                </div>
                <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
            </div>
        </div>
    </div>
</div>
