<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center">
            <div class="p-2.5 bg-indigo-100 rounded-lg">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold text-gray-900">Projects</h3>
                <p class="text-xs text-gray-500">Project management</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xl font-bold text-gray-900">{{ $totalProjects }}</div>
            <div class="text-xs text-gray-500">Total Projects</div>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-blue-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-blue-900">{{ $activeProjects }}</div>
                    <div class="text-xs text-blue-700">In Progress</div>
                </div>
                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-green-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-green-900">{{ $completedProjects }}</div>
                    <div class="text-xs text-green-700">Completed</div>
                </div>
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-yellow-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-yellow-900">{{ $plannedProjects }}</div>
                    <div class="text-xs text-yellow-700">Planned</div>
                </div>
                <div class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-red-50 rounded-lg p-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-red-900">{{ $onHoldProjects }}</div>
                    <div class="text-xs text-red-700">On Hold</div>
                </div>
                <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
            </div>
        </div>
    </div>
</div>
