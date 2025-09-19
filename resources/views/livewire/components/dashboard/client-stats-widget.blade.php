<div class="rounded-xl shadow-sm border p-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
    <div class="flex items-start justify-between mb-4">
        <div class="flex items-center">
            <div class="p-2.5 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-emerald-100', 'bg-emerald-900/50') }}">
                <svg class="w-5 h-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-emerald-600', 'text-emerald-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Clients</h3>
                <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Client management</p>
            </div>
        </div>
        <div class="text-right">
            <div class="text-xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $totalClients }}</div>
            <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Total Clients</div>
        </div>
    </div>
    
    <div class="grid grid-cols-2 gap-3">
        <div class="rounded-lg p-2.5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-emerald-50', 'bg-emerald-900/20') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-emerald-900', 'text-emerald-300') }}">{{ $clientsWithProjects }}</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-emerald-700', 'text-emerald-400') }}">With Projects</div>
                </div>
                <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="rounded-lg p-2.5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-50', 'bg-blue-900/20') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-900', 'text-blue-300') }}">{{ $clientsThisMonth }}</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-700', 'text-blue-400') }}">New</div>
                </div>
                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="rounded-lg p-2.5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-purple-50', 'bg-purple-900/20') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-purple-900', 'text-purple-300') }}">{{ $totalLeads }}</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-purple-700', 'text-purple-400') }}">Total Leads</div>
                </div>
                <div class="w-1.5 h-1.5 bg-purple-500 rounded-full"></div>
            </div>
        </div>
        
        <div class="rounded-lg p-2.5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-orange-50', 'bg-orange-900/20') }}">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-orange-900', 'text-orange-300') }}">{{ $leadsToday }}</div>
                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-orange-700', 'text-orange-400') }}">Leads Today</div>
                </div>
                <div class="w-1.5 h-1.5 bg-orange-500 rounded-full"></div>
            </div>
        </div>
    </div>
</div>
