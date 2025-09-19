<div class="rounded-xl shadow-sm border p-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
    <div class="flex items-center mb-4">
        <div class="p-2.5 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-purple-100', 'bg-purple-900/50') }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-purple-600', 'text-purple-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-base font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Quick Actions</h3>
            <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Common tasks and shortcuts</p>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-2">
        @can('view leaves')
        <a href="{{ route('employee.leave-request') }}" class="flex items-center p-2.5 rounded-lg transition-colors {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-50 hover:bg-blue-100', 'bg-blue-900/20 hover:bg-blue-900/30') }}">
            <svg class="w-4 h-4 mr-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-600', 'text-blue-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="text-xs font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-800', 'text-blue-300') }}">Request Leave</span>
        </a>
        @endcan
        
        @can('view leaves')
        <a href="{{ route('employee.leave-requests') }}" class="flex items-center p-2.5 rounded-lg transition-colors {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-50 hover:bg-green-100', 'bg-green-900/20 hover:bg-green-900/30') }}">
            <svg class="w-4 h-4 mr-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-600', 'text-green-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <span class="text-xs font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-800', 'text-green-300') }}">My Leaves</span>
        </a>
        @endcan
        
        <a href="{{ route('profile') }}" class="flex items-center p-2.5 rounded-lg transition-colors {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-purple-50 hover:bg-purple-100', 'bg-purple-900/20 hover:bg-purple-900/30') }}">
            <svg class="w-4 h-4 mr-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-purple-600', 'text-purple-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-xs font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-purple-800', 'text-purple-300') }}">Profile</span>
        </a>
        
        <a href="{{ route('logout') }}" class="flex items-center p-2.5 rounded-lg transition-colors {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-50 hover:bg-red-100', 'bg-red-900/20 hover:bg-red-900/30') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg class="w-4 h-4 mr-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600', 'text-red-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span class="text-xs font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-800', 'text-red-300') }}">Logout</span>
        </a>
    </div>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>
