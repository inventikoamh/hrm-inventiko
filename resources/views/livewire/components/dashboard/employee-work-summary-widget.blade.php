<div class="rounded-xl shadow-sm border p-5 h-full transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center">
            <div class="p-2.5 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-100', 'bg-blue-900/50') }}">
                <svg class="w-5 h-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-600', 'text-blue-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Work Summary</h3>
                <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Your work hours and status</p>
            </div>
        </div>
    </div>
    
    <div class="space-y-3">
        <!-- Today's Work Hours -->
        <div class="rounded-lg p-3 border transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200', 'bg-gradient-to-r from-blue-900/20 to-indigo-900/20 border-blue-800') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-900', 'text-blue-300') }}">
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
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-700', 'text-blue-400') }}">Today</div>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <span class="text-xs font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-700', 'text-blue-400') }}">Hours</span>
                </div>
            </div>
        </div>

        <!-- This Week's Work Hours -->
        <div class="rounded-lg p-3 border transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gradient-to-r from-green-50 to-emerald-50 border-green-200', 'bg-gradient-to-r from-green-900/20 to-emerald-900/20 border-green-800') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-900', 'text-green-300') }}">
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
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-700', 'text-green-400') }}">This Week</div>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    <span class="text-xs font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-700', 'text-green-400') }}">Hours</span>
                </div>
            </div>
        </div>
        
        <!-- Leave Status -->
        <div class="rounded-lg p-2.5 border transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50 border-gray-200', 'bg-slate-700 border-slate-600') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Leave Status</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">
                        @if($pendingLeaves > 0 || $approvedLeaves > 0)
                            {{ $pendingLeaves > 0 ? $pendingLeaves . ' Pending' : '' }}{{ $pendingLeaves > 0 && $approvedLeaves > 0 ? ', ' : '' }}{{ $approvedLeaves > 0 ? 'On Leave' : '' }}
                        @else
                            No Active Leaves
                        @endif
                    </div>
                </div>
                <div class="flex gap-2">
                    @if($pendingLeaves > 0)
                        <span class="text-xs px-2 py-1 rounded-full transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-yellow-100 text-yellow-800', 'bg-yellow-900/50 text-yellow-300') }}">{{ $pendingLeaves }}</span>
                    @endif
                    @if($approvedLeaves > 0)
                        <span class="text-xs px-2 py-1 rounded-full transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-100 text-green-800', 'bg-green-900/50 text-green-300') }}">✓</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
