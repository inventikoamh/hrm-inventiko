<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 h-full">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center">
            <div class="p-2.5 bg-blue-100 rounded-lg">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold text-gray-900">Work Summary</h3>
                <p class="text-xs text-gray-500">Your work hours and status</p>
            </div>
        </div>
    </div>
    
    <div class="space-y-3">
        <!-- Today's Work Hours -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-3 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-blue-900">
                        @php
                            if ($todayHours > 0) {
                                $totalMinutes = round($todayHours * 60);
                                $hours = floor($totalMinutes / 60);
                                $minutes = $totalMinutes % 60;
                                echo sprintf('%02d:%02d', $hours, $minutes);
                            } else {
                                echo '00:00';
                            }
                        @endphp
                    </div>
                    <div class="text-xs text-blue-700">Today</div>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <span class="text-xs text-blue-700 font-medium">Hours</span>
                </div>
            </div>
        </div>

        <!-- This Week's Work Hours -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-3 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold text-green-900">
                        @php
                            if ($weekHours > 0) {
                                $totalMinutes = round($weekHours * 60);
                                $hours = floor($totalMinutes / 60);
                                $minutes = $totalMinutes % 60;
                                echo sprintf('%02d:%02d', $hours, $minutes);
                            } else {
                                echo '00:00';
                            }
                        @endphp
                    </div>
                    <div class="text-xs text-green-700">This Week</div>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-xs text-green-700 font-medium">Hours</span>
                </div>
            </div>
        </div>
        
        <!-- Leave Status -->
        <div class="bg-gray-50 rounded-lg p-2.5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium text-gray-900">Leave Status</div>
                    <div class="text-xs text-gray-600">
                        @if($pendingLeaves > 0 || $approvedLeaves > 0)
                            {{ $pendingLeaves > 0 ? $pendingLeaves . ' Pending' : '' }}{{ $pendingLeaves > 0 && $approvedLeaves > 0 ? ', ' : '' }}{{ $approvedLeaves > 0 ? 'On Leave' : '' }}
                        @else
                            No Active Leaves
                        @endif
                    </div>
                </div>
                <div class="flex gap-2">
                    @if($pendingLeaves > 0)
                        <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">{{ $pendingLeaves }}</span>
                    @endif
                    @if($approvedLeaves > 0)
                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">✓</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
