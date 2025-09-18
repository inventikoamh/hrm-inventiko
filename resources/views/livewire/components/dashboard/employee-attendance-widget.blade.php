<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
    <div class="flex items-center mb-4">
        <div class="p-2.5 bg-indigo-100 rounded-lg">
            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-base font-semibold text-gray-900">Attendance</h3>
            <p class="text-xs text-gray-500">Clock in/out and track your work</p>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-3 p-2 bg-green-50 border border-green-200 rounded-lg text-green-700 text-xs">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-3 p-2 bg-red-50 border border-red-200 rounded-lg text-red-700 text-xs">{{ session('error') }}</div>
    @endif

    @if(auth()->user()->isOnLeave())
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-blue-800 text-sm font-medium">You are currently on leave</span>
            </div>
        </div>
    @else
        <div class="mb-4">
            <label class="block text-xs text-gray-700 mb-1">What are you working on?</label>
            <textarea wire:model.live="statusText" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Describe your current task..."></textarea>
            @error('statusText') <div class="text-xs text-red-600 mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="flex gap-2 mb-4">
            @if (!$active)
                <button wire:click="clockIn" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Clock In
                </button>
            @else
                <button wire:click="clockOut" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Clock Out
                </button>
            @endif
        </div>

        @if($active)
            <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-sm font-medium text-green-800">Currently Online</span>
                    </div>
                    <span class="text-xs text-green-600">{{ $active->clock_in_at->format('H:i') }}</span>
                </div>
            </div>
        @endif
    @endif

    <!-- Recent Activity -->
    <div>
        <h4 class="text-xs font-semibold text-gray-700 mb-2">Recent Activity</h4>
        <div class="space-y-1">
            @forelse($logs as $log)
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-1.5 h-1.5 bg-{{ $log->type === 'clock_in' ? 'green' : 'red' }}-500 rounded-full mr-2"></div>
                        <span class="text-xs text-gray-700">{{ ucfirst(str_replace('_', ' ', $log->type)) }}</span>
                    </div>
                    <span class="text-xs text-gray-500">{{ $log->logged_at->format('H:i') }}</span>
                </div>
            @empty
                <p class="text-xs text-gray-500">No recent activity</p>
            @endforelse
        </div>
    </div>
</div>
