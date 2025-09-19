<div class="rounded-xl shadow-sm border p-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
    <div class="flex items-center mb-4">
        <div class="p-2.5 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-indigo-100', 'bg-indigo-900/50') }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-indigo-600', 'text-indigo-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-base font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Quick Actions</h3>
            <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Frequently used actions</p>
        </div>
    </div>
    
    <div class="grid grid-cols-4 gap-3">
        @can('create user')
        <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center p-3 rounded-lg transition-colors {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-50 hover:bg-blue-100', 'bg-blue-900/20 hover:bg-blue-900/30') }}">
            <svg class="w-5 h-5 mb-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-600', 'text-blue-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span class="text-xs font-medium text-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-800', 'text-blue-300') }}">Add User</span>
        </a>
        @endcan
        
        @can('add project')
        <a href="{{ route('admin.projects.create') }}" class="flex flex-col items-center p-3 rounded-lg transition-colors {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-indigo-50 hover:bg-indigo-100', 'bg-indigo-900/20 hover:bg-indigo-900/30') }}">
            <svg class="w-5 h-5 mb-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-indigo-600', 'text-indigo-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <span class="text-xs font-medium text-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-indigo-800', 'text-indigo-300') }}">New Project</span>
        </a>
        @endcan
        
        @can('create client')
        <a href="{{ route('admin.clients.create') }}" class="flex flex-col items-center p-3 rounded-lg transition-colors {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-emerald-50 hover:bg-emerald-100', 'bg-emerald-900/20 hover:bg-emerald-900/30') }}">
            <svg class="w-5 h-5 mb-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-emerald-600', 'text-emerald-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span class="text-xs font-medium text-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-emerald-800', 'text-emerald-300') }}">Add Client</span>
        </a>
        @endcan
        
        @can('create lead')
        <a href="{{ route('admin.leads.create') }}" class="flex flex-col items-center p-3 rounded-lg transition-colors {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-orange-50 hover:bg-orange-100', 'bg-orange-900/20 hover:bg-orange-900/30') }}">
            <svg class="w-5 h-5 mb-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-orange-600', 'text-orange-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <span class="text-xs font-medium text-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-orange-800', 'text-orange-300') }}">Add Lead</span>
        </a>
        @endcan
        
        @can('create task')
        <a href="{{ route('admin.tasks.create') }}" class="flex flex-col items-center p-3 rounded-lg transition-colors {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-purple-50 hover:bg-purple-100', 'bg-purple-900/20 hover:bg-purple-900/30') }}">
            <svg class="w-5 h-5 mb-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-purple-600', 'text-purple-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            <span class="text-xs font-medium text-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-purple-800', 'text-purple-300') }}">New Task</span>
        </a>
        @endcan
        
        @can('create role')
        <a href="{{ route('admin.roles.create') }}" class="flex flex-col items-center p-3 rounded-lg transition-colors {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-pink-50 hover:bg-pink-100', 'bg-pink-900/20 hover:bg-pink-900/30') }}">
            <svg class="w-5 h-5 mb-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-pink-600', 'text-pink-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            <span class="text-xs font-medium text-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-pink-800', 'text-pink-300') }}">New Role</span>
        </a>
        @endcan
        
        @can('create permission')
        <a href="{{ route('admin.permissions.create') }}" class="flex flex-col items-center p-3 rounded-lg transition-colors {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-teal-50 hover:bg-teal-100', 'bg-teal-900/20 hover:bg-teal-900/30') }}">
            <svg class="w-5 h-5 mb-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-teal-600', 'text-teal-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
            </svg>
            <span class="text-xs font-medium text-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-teal-800', 'text-teal-300') }}">New Permission</span>
        </a>
        @endcan
        
        @can('manage leave balances')
        <a href="{{ route('admin.leave-balance-management') }}" class="flex flex-col items-center p-3 rounded-lg transition-colors {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-amber-50 hover:bg-amber-100', 'bg-amber-900/20 hover:bg-amber-900/30') }}">
            <svg class="w-5 h-5 mb-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-amber-600', 'text-amber-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            <span class="text-xs font-medium text-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-amber-800', 'text-amber-300') }}">Leave Balance</span>
        </a>
        @endcan
    </div>
</div>
