<div>
    <!-- Toggle Button -->
    <button wire:click="toggleModal" 
            class="flex items-center space-x-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $active ? \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-50 text-red-700 hover:bg-red-100 border border-red-200', 'bg-red-900/20 text-red-300 hover:bg-red-900/30 border border-red-700') : \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200', 'bg-emerald-900/20 text-emerald-300 hover:bg-emerald-900/30 border border-emerald-700') }}">
        @if($active)
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Clock Out</span>
        @else
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>Clock In</span>
        @endif
    </button>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" 
         x-data="{ open: true }"
         x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50" wire:click="closeModal"></div>
        
        <!-- Modal Content -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative rounded-xl shadow-xl max-w-md w-full mx-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95">
                
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-600') }}">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 rounded-lg transition-colors duration-200 {{ $active ? (\App\Helpers\ThemeHelper::isDarkMode() ? 'bg-red-900/50' : 'bg-red-100') : (\App\Helpers\ThemeHelper::isDarkMode() ? 'bg-emerald-900/50' : 'bg-emerald-100') }}">
                            <svg class="w-5 h-5 transition-colors duration-200 {{ $active ? (\App\Helpers\ThemeHelper::isDarkMode() ? 'text-red-400' : 'text-red-600') : (\App\Helpers\ThemeHelper::isDarkMode() ? 'text-emerald-400' : 'text-emerald-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                                {{ $active ? 'Clock Out' : 'Clock In' }}
                            </h3>
                            <p class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">
                                {{ $active ? 'End your work session' : 'Start your work session' }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="closeModal" class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-400 hover:text-gray-600', 'text-slate-400 hover:text-slate-300') }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6">
                    @if(auth()->user()->isOnLeave())
                        <div class="mb-4 p-4 rounded-lg border transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-50 border-blue-200', 'bg-blue-900/20 border-blue-800') }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-500', 'text-blue-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-800', 'text-blue-300') }}">You are currently on leave</span>
                            </div>
                        </div>
                    @else
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">
                                Work Status
                            </label>
                            <textarea wire:model.live="statusText" 
                                      rows="3" 
                                      class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900 placeholder-gray-500', 'border-slate-600 bg-slate-700 text-slate-100 placeholder-slate-400') }}" 
                                      placeholder="What are you working on? (e.g., Working on project documentation, Client meeting, Code review, etc.)"></textarea>
                            @error('statusText') 
                                <div class="text-sm mt-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600', 'text-red-400') }}">{{ $message }}</div> 
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-3">
                            <button wire:click="closeModal" 
                                    class="flex-1 px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700 bg-gray-100 hover:bg-gray-200', 'text-slate-300 bg-slate-700 hover:bg-slate-600') }}">
                                Cancel
                            </button>
                            @if($active)
                                <button wire:click="clockOut" 
                                        x-on:click="setTimeout(() => { window.location.reload(); }, 1000)"
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors">
                                    Clock Out
                                </button>
                            @else
                                <button wire:click="clockIn" 
                                        x-on:click="setTimeout(() => { window.location.reload(); }, 1000)"
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg transition-colors">
                                    Clock In
                                </button>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Flash Messages -->
    @if (session('status'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             class="fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg border transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-50 border-green-200 text-green-800', 'bg-green-900/20 border-green-800 text-green-300') }}"
             x-init="setTimeout(() => show = false, 3000)">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-500', 'text-green-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('status') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform translate-y-2"
             class="fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg border transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-50 border-red-200 text-red-800', 'bg-red-900/20 border-red-800 text-red-300') }}"
             x-init="setTimeout(() => show = false, 3000)">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-500', 'text-red-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif
</div>
