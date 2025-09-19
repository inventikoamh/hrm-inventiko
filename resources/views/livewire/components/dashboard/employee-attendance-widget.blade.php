<div class="rounded-xl shadow-sm border p-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
    <div class="flex items-center mb-4">
        <div class="p-2.5 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-indigo-100', 'bg-indigo-900/50') }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-indigo-600', 'text-indigo-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-base font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Attendance</h3>
            <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Clock in/out and track your work</p>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-3 p-2 rounded-lg text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-50 border-green-200 text-green-700', 'bg-green-900/20 border-green-800 text-green-300') }} border">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-3 p-2 rounded-lg text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-50 border-red-200 text-red-700', 'bg-red-900/20 border-red-800 text-red-300') }} border">{{ session('error') }}</div>
    @endif

    @if(auth()->user()->isOnLeave())
        <div class="mb-4 p-3 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-50 border-blue-200', 'bg-blue-900/20 border-blue-800') }} border">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-500', 'text-blue-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-800', 'text-blue-300') }}">You are currently on leave</span>
            </div>
        </div>
    @else
        <div class="mb-4">
            <label class="block text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }} mb-1">What are you working on?</label>
            <textarea wire:model.live="statusText" rows="2" class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" placeholder="Describe your current task..."></textarea>
            @error('statusText') <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600', 'text-red-400') }} mt-1">{{ $message }}</div> @enderror
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
            <div class="rounded-lg p-3 mb-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-50 border-green-200', 'bg-green-900/20 border-green-800') }} border">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-800', 'text-green-300') }}">Currently Online</span>
                    </div>
                    <span class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-600', 'text-green-400') }}">{{ $active->clock_in_at->format('H:i') }}</span>
                </div>
            </div>
        @endif
    @endif

    <!-- Recent Activity -->
    <div>
        <h4 class="text-xs font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }} mb-2">Recent Activity</h4>
        <div class="space-y-1">
            @forelse($logs as $log)
                <div class="flex items-center justify-between p-2 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50', 'bg-slate-700') }}">
                    <div class="flex items-center">
                        <div class="w-1.5 h-1.5 bg-{{ $log->type === 'clock_in' ? 'green' : 'red' }}-500 rounded-full mr-2"></div>
                        <span class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ ucfirst(str_replace('_', ' ', $log->type)) }}</span>
                    </div>
                    <span class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">{{ $log->logged_at->format('H:i') }}</span>
                </div>
            @empty
                <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">No recent activity</p>
            @endforelse
        </div>
    </div>
</div>
