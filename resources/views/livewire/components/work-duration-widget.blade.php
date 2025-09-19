<div class="rounded-xl shadow-sm border p-5 h-full transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}" 
     x-data="{ 
         duration: '{{ $workDuration }}',
         refreshInterval: null,
         timerInterval: null,
         init() {
             this.startTimer();
             
             // Auto-refresh every 30 seconds when clocked in
             if ({{ $isClockedIn ? 'true' : 'false' }}) {
                 this.refreshInterval = setInterval(() => {
                     @this.call('refreshDuration');
                 }, 30000);
             }
         },
         startTimer() {
             if (this.timerInterval) {
                 clearInterval(this.timerInterval);
             }
             
             if ({{ $isClockedIn ? 'true' : 'false' }} && '{{ $clockInTime }}') {
                 const clockIn = new Date('{{ $clockInTime }}');
                 
                 const updateDuration = () => {
                     const now = new Date();
                     const diffMs = now - clockIn;
                     const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
                     const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
                     const diffSeconds = Math.floor((diffMs % (1000 * 60)) / 1000);
                     
                     this.duration = String(diffHours).padStart(2, '0') + ':' + 
                                     String(diffMinutes).padStart(2, '0') + ':' + 
                                     String(diffSeconds).padStart(2, '0');
                 }
                 
                 updateDuration();
                 this.timerInterval = setInterval(updateDuration, 1000);
             }
         },
         destroy() {
             if (this.refreshInterval) {
                 clearInterval(this.refreshInterval);
             }
             if (this.timerInterval) {
                 clearInterval(this.timerInterval);
             }
         }
     }"
     x-init="
         // Restart timer when Livewire updates
         $wire.on('attendance-updated', () => {
             setTimeout(() => {
                 this.startTimer();
             }, 100);
         });
     ">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center">
            <div class="p-2.5 rounded-lg transition-colors duration-200 {{ $isClockedIn ? (\App\Helpers\ThemeHelper::isDarkMode() ? 'bg-emerald-900/50' : 'bg-emerald-100') : (\App\Helpers\ThemeHelper::isDarkMode() ? 'bg-slate-700' : 'bg-gray-100') }}">
                <svg class="w-5 h-5 transition-colors duration-200 {{ $isClockedIn ? (\App\Helpers\ThemeHelper::isDarkMode() ? 'text-emerald-400' : 'text-emerald-600') : (\App\Helpers\ThemeHelper::isDarkMode() ? 'text-slate-400' : 'text-gray-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Work Duration</h3>
                <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Today's work time</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xl font-bold transition-colors duration-200 {{ $isClockedIn ? (\App\Helpers\ThemeHelper::isDarkMode() ? 'text-emerald-400' : 'text-emerald-600') : (\App\Helpers\ThemeHelper::isDarkMode() ? 'text-slate-400' : 'text-gray-500') }}">
                {{ $isClockedIn ? 'Active' : 'Inactive' }}
            </div>
            <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Status</div>
        </div>
    </div>
    
    <div class="space-y-3">
        <!-- Current Session Duration -->
        <div class="rounded-lg p-3 border transition-colors duration-200 {{ $isClockedIn ? (\App\Helpers\ThemeHelper::isDarkMode() ? 'bg-gradient-to-r from-emerald-900/20 to-green-900/20 border-emerald-800' : 'bg-gradient-to-r from-emerald-50 to-green-50 border-emerald-200') : (\App\Helpers\ThemeHelper::isDarkMode() ? 'bg-gradient-to-r from-slate-700 to-slate-600 border-slate-600' : 'bg-gradient-to-r from-gray-50 to-gray-100 border-gray-200') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold transition-colors duration-200 {{ $isClockedIn ? (\App\Helpers\ThemeHelper::isDarkMode() ? 'text-emerald-300' : 'text-emerald-900') : (\App\Helpers\ThemeHelper::isDarkMode() ? 'text-slate-400' : 'text-gray-600') }}" 
                         x-text="duration">
                        {{ $workDuration }}
                    </div>
                    <div class="text-xs transition-colors duration-200 {{ $isClockedIn ? (\App\Helpers\ThemeHelper::isDarkMode() ? 'text-emerald-400' : 'text-emerald-700') : (\App\Helpers\ThemeHelper::isDarkMode() ? 'text-slate-500' : 'text-gray-500') }}">
                        @if($isClockedIn && $clockInTime)
                            Current Session • Clocked in at {{ \Carbon\Carbon::parse($clockInTime)->format('h:i A') }}
                        @else
                            {{ $isClockedIn ? 'Current Session' : 'Not Clocked In' }}
                        @endif
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    @if($isClockedIn)
                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="text-xs font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-emerald-700', 'text-emerald-400') }}">Live</span>
                    @else
                        <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                        <span class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Offline</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Today's Summary -->
        <div class="rounded-lg p-2.5 border transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50 border-gray-200', 'bg-slate-700 border-slate-600') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                        Today's Total
                    </div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">
                        {{ now()->format('M d, Y') }}
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                        {{ $this->getTodayTotalDuration() }}
                    </div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">
                        Work Time
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
