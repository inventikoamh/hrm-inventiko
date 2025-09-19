<div class="relative" x-data="{ open: false, refreshing: false, lastClick: 0 }">
    <!-- Theme Toggle Button -->
    <button @click="open = !open" 
            :disabled="refreshing"
            class="flex items-center justify-center w-10 h-10 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 hover:bg-gray-200 text-gray-700', 'bg-slate-700 hover:bg-slate-600 text-slate-300') }}"
            :class="{ 'opacity-50 cursor-not-allowed': refreshing }">
        <!-- Light Icon -->
        <svg x-show="!open || '{{ $currentTheme }}' === 'light'" 
             class="w-5 h-5" 
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        
        <!-- Dark Icon -->
        <svg x-show="!open || '{{ $currentTheme }}' === 'dark'" 
             class="w-5 h-5" 
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
        
        
        <!-- Loading Spinner -->
        <svg x-show="refreshing" 
             class="w-5 h-5 animate-spin" 
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-48 rounded-md shadow-lg z-50 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border border-gray-200', 'bg-slate-800 border border-slate-700') }}">
        <div class="py-1">
            <!-- Light Theme -->
            <button wire:click="setTheme('light')" 
                    @click="if (!refreshing && Date.now() - lastClick > 500) { refreshing = true; open = false; lastClick = Date.now(); }"
                    class="flex items-center w-full px-4 py-2 text-sm transition-colors duration-200 {{ $currentTheme === 'light' ? (\App\Helpers\ThemeHelper::isDarkMode() ? 'bg-slate-700 text-slate-100' : 'bg-gray-100 text-gray-900') : (\App\Helpers\ThemeHelper::isDarkMode() ? 'text-slate-300 hover:bg-slate-700 hover:text-slate-100' : 'text-gray-700 hover:bg-gray-100') }}">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Light
                @if($currentTheme === 'light')
                    <svg class="w-4 h-4 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </button>
            
            <!-- Dark Theme -->
            <button wire:click="setTheme('dark')" 
                    @click="if (!refreshing && Date.now() - lastClick > 500) { refreshing = true; open = false; lastClick = Date.now(); }"
                    class="flex items-center w-full px-4 py-2 text-sm transition-colors duration-200 {{ $currentTheme === 'dark' ? (\App\Helpers\ThemeHelper::isDarkMode() ? 'bg-slate-700 text-slate-100' : 'bg-gray-100 text-gray-900') : (\App\Helpers\ThemeHelper::isDarkMode() ? 'text-slate-300 hover:bg-slate-700 hover:text-slate-100' : 'text-gray-700 hover:bg-gray-100') }}">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                </svg>
                Dark
                @if($currentTheme === 'dark')
                    <svg class="w-4 h-4 ml-auto" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </button>
        </div>
    </div>
</div>
