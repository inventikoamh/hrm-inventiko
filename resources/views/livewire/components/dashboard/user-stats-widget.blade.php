<div class="rounded-xl shadow-sm border p-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center">
            <div class="p-2.5 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100', 'bg-blue-900/50') }}">
                <svg class="w-5 h-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-600', 'text-blue-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Users</h3>
                <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">User &nbsp; management</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $totalUsers }}</div>
            <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Total Users</div>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-3">
        <div class="rounded-lg p-2.5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-50', 'bg-green-900/20') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-900', 'text-green-300') }}">{{ $activeUsers }}</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-700', 'text-green-400') }}">Online Now</div>
                </div>
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="rounded-lg p-2.5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-50', 'bg-blue-900/20') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-900', 'text-blue-300') }}">{{ $employeeUsers }}</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-700', 'text-blue-400') }}">Employee</div>
                </div>
                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="rounded-lg p-2.5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-purple-50', 'bg-purple-900/20') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-purple-900', 'text-purple-300') }}">{{ $adminUsers }}</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-purple-700', 'text-purple-400') }}">Admin</div>
                </div>
                <div class="w-1.5 h-1.5 bg-purple-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="rounded-lg p-2.5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-orange-50', 'bg-orange-900/20') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-orange-900', 'text-orange-300') }}">{{ $activeToday }}</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-orange-700', 'text-orange-400') }}">Active</div>
                </div>
                <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
            </div>
        </div>
    </div>
</div>
