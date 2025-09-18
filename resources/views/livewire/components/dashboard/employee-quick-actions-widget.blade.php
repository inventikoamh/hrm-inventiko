<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
    <div class="flex items-center mb-4">
        <div class="p-2.5 bg-purple-100 rounded-lg">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-base font-semibold text-gray-900">Quick Actions</h3>
            <p class="text-xs text-gray-500">Common tasks and shortcuts</p>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-2">
        @can('view leaves')
        <a href="{{ route('employee.leave-request') }}" class="flex items-center p-2.5 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
            <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span class="text-xs font-medium text-blue-800">Request Leave</span>
        </a>
        @endcan
        
        @can('view leaves')
        <a href="{{ route('employee.leave-requests') }}" class="flex items-center p-2.5 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <span class="text-xs font-medium text-green-800">My Leaves</span>
        </a>
        @endcan
        
        <a href="{{ route('profile') }}" class="flex items-center p-2.5 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
            <svg class="w-4 h-4 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-xs font-medium text-purple-800">Profile</span>
        </a>
        
        <a href="{{ route('logout') }}" class="flex items-center p-2.5 bg-red-50 hover:bg-red-100 rounded-lg transition-colors" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <svg class="w-4 h-4 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span class="text-xs font-medium text-red-800">Logout</span>
        </a>
    </div>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>
