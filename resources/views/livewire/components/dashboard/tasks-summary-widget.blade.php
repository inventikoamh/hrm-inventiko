<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center">
            <div class="p-2.5 bg-indigo-100 rounded-lg">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold text-gray-900">Tasks Summary</h3>
                <p class="text-xs text-gray-500">Task management overview</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xl font-bold text-gray-900">{{ $totalTasks }}</div>
            <div class="text-xs text-gray-500">Total Tasks</div>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-yellow-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-yellow-900">{{ $pendingTasks }}</div>
                    <div class="text-xs text-yellow-700">Pending</div>
                </div>
                <div class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-blue-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-blue-900">{{ $inProgressTasks }}</div>
                    <div class="text-xs text-blue-700">In Progress</div>
                </div>
                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-green-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-green-900">{{ $completedTasks }}</div>
                    <div class="text-xs text-green-700">Completed</div>
                </div>
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-red-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-red-900">{{ $overdueTasks }}</div>
                    <div class="text-xs text-red-700">Overdue</div>
                </div>
                <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
            </div>
        </div>
    </div>
</div>
