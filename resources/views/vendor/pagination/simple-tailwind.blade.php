@if ($paginator->hasPages())
    @php
        $isDark = auth()->check() && auth()->user()->getThemePreference() === 'dark';
        // Force debug - let's see what's happening
        $debugInfo = 'Auth: ' . (auth()->check() ? 'true' : 'false');
        if (auth()->check()) {
            $debugInfo .= ' | Theme: ' . auth()->user()->getThemePreference();
            $debugInfo .= ' | IsDark: ' . ($isDark ? 'true' : 'false');
        }
    @endphp
    <!-- Debug: {{ $debugInfo }} -->
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium cursor-default leading-5 rounded-md transition-colors duration-200 {{ $isDark ? 'text-slate-400 bg-slate-800 border-slate-600' : 'text-gray-500 bg-white border-gray-300' }}">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring transition ease-in-out duration-150 {{ $isDark ? 'text-slate-300 bg-slate-800 border-slate-600 hover:text-slate-400 focus:ring-slate-600 focus:border-blue-700 active:bg-slate-700 active:text-slate-300' : 'text-gray-700 bg-white border-gray-300 focus:ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700' }}">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring transition ease-in-out duration-150 {{ $isDark ? 'text-slate-300 bg-slate-800 border-slate-600 hover:text-slate-400 focus:ring-slate-600 focus:border-blue-700 active:bg-slate-700 active:text-slate-300' : 'text-gray-700 bg-white border-gray-300 focus:ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700' }}">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium cursor-default leading-5 rounded-md transition-colors duration-200 {{ $isDark ? 'text-slate-400 bg-slate-800 border-slate-600' : 'text-gray-500 bg-white border-gray-300' }}">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
