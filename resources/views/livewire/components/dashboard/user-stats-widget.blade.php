<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center">
            <div class="p-2.5 bg-blue-100 rounded-lg">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold text-gray-900">Users</h3>
                <p class="text-xs text-gray-500">User &nbsp; management</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xl font-bold text-gray-900">{{ $totalUsers }}</div>
            <div class="text-xs text-gray-500">Total Users</div>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-green-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-green-900">{{ $activeUsers }}</div>
                    <div class="text-xs text-green-700">Online Now</div>
                </div>
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-blue-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-blue-900">{{ $employeeUsers }}</div>
                    <div class="text-xs text-blue-700">Employee</div>
                </div>
                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-purple-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-purple-900">{{ $adminUsers }}</div>
                    <div class="text-xs text-purple-700">Admin</div>
                </div>
                <div class="w-1.5 h-1.5 bg-purple-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-orange-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-orange-900">{{ $activeToday }}</div>
                    <div class="text-xs text-orange-700">Active</div>
                </div>
                <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
            </div>
        </div>
    </div>
</div>
