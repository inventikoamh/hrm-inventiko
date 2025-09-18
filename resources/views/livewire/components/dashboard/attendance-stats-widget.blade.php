<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 h-full">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center">
            <div class="p-2.5 bg-orange-100 rounded-lg">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold text-gray-900">Today's Attendance</h3>
                <p class="text-xs text-gray-500">{{ now()->format('M d, Y') }}</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xl font-bold text-gray-900">{{ $presentToday }}/{{ $totalUsers }}</div>
            <div class="text-xs text-gray-500">Present/Total</div>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-3">
        <div class="bg-green-50 rounded-lg p-3">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-green-900">{{ $presentToday }}</div>
                    <div class="text-xs text-green-700">Present</div>
                </div>
                <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-yellow-50 rounded-lg p-3">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-yellow-900">{{ $lateToday }}</div>
                    <div class="text-xs text-yellow-700">Late</div>
                </div>
                <div class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-blue-50 rounded-lg p-3">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-blue-900">{{ $onlineNow }}</div>
                    <div class="text-xs text-blue-700">Online Now</div>
                </div>
                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="bg-red-50 rounded-lg p-3">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold text-red-900">{{ $absentToday }}</div>
                    <div class="text-xs text-red-700">Absent</div>
                </div>
                <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
            </div>
        </div>
    </div>
</div>
