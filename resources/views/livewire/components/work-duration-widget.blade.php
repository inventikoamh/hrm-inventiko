<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 h-full" 
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
            <div class="p-2.5 {{ $isClockedIn ? 'bg-emerald-100' : 'bg-gray-100' }} rounded-lg">
                <svg class="w-5 h-5 {{ $isClockedIn ? 'text-emerald-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold text-gray-900">Work Duration</h3>
                <p class="text-xs text-gray-500">Today's work time</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xl font-bold {{ $isClockedIn ? 'text-emerald-600' : 'text-gray-500' }}">
                {{ $isClockedIn ? 'Active' : 'Inactive' }}
            </div>
            <div class="text-xs text-gray-500">Status</div>
        </div>
    </div>
    
    <div class="space-y-3">
        <!-- Current Session Duration -->
        <div class="bg-gradient-to-r {{ $isClockedIn ? 'from-emerald-50 to-green-50' : 'from-gray-50 to-gray-100' }} rounded-lg p-3 border {{ $isClockedIn ? 'border-emerald-200' : 'border-gray-200' }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-2xl font-bold {{ $isClockedIn ? 'text-emerald-900' : 'text-gray-600' }}" 
                         x-text="duration">
                        {{ $workDuration }}
                    </div>
                    <div class="text-xs {{ $isClockedIn ? 'text-emerald-700' : 'text-gray-500' }}">
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
                        <span class="text-xs text-emerald-700 font-medium">Live</span>
                    @else
                        <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                        <span class="text-xs text-gray-500">Offline</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Today's Summary -->
        <div class="bg-gray-50 rounded-lg p-2.5 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm font-medium text-gray-900">
                        Today's Total
                    </div>
                    <div class="text-xs text-gray-600">
                        {{ now()->format('M d, Y') }}
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-semibold text-gray-900">
                        {{ $this->getTodayTotalDuration() }}
                    </div>
                    <div class="text-xs text-gray-500">
                        Work Time
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
