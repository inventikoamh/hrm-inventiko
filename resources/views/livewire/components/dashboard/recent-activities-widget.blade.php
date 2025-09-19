<div class="rounded-xl shadow-sm border p-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
    <div class="flex items-center mb-4">
        <div class="p-2.5 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100', 'bg-slate-700') }}">
            <svg class="w-5 h-5 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-base font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Recent Activities</h3>
            <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Latest updates across modules</p>
        </div>
    </div>
    
    <div class="space-y-3">
        <!-- Recent Leave Requests -->
        <div>
            <h4 class="text-xs font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }} mb-1.5">Recent Leave Requests</h4>
            <div class="space-y-1.5">
                @forelse($recentLeaves as $leave)
                    <div class="flex items-center justify-between p-2 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50', 'bg-slate-700') }}">
                        <div class="flex items-center">
                            <div class="w-1.5 h-1.5 bg-{{ $leave->status === 'pending' ? 'yellow' : ($leave->status === 'approved' ? 'green' : 'red') }}-500 rounded-full mr-2"></div>
                            <span class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ Str::limit($leave->user->name, 15) }}</span>
                        </div>
                        <span class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">{{ $leave->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">No recent leave requests</p>
                @endforelse
            </div>
        </div>
        
        <!-- Recent Projects -->
        <div>
            <h4 class="text-xs font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }} mb-1.5">Recent Projects</h4>
            <div class="space-y-1.5">
                @forelse($recentProjects as $project)
                    <div class="flex items-center justify-between p-2 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50', 'bg-slate-700') }}">
                        <div class="flex items-center">
                            <div class="w-1.5 h-1.5 bg-indigo-500 rounded-full mr-2"></div>
                            <span class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ Str::limit($project->title, 15) }}</span>
                        </div>
                        <span class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">{{ $project->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">No recent projects</p>
                @endforelse
            </div>
        </div>
        
        <!-- Recent Clients -->
        <div>
            <h4 class="text-xs font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }} mb-1.5">Recent Clients</h4>
            <div class="space-y-1.5">
                @forelse($recentClients as $client)
                    <div class="flex items-center justify-between p-2 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50', 'bg-slate-700') }}">
                        <div class="flex items-center">
                            <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2"></div>
                            <span class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ Str::limit($client->client_name, 15) }}</span>
                        </div>
                        <span class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">{{ $client->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">No recent clients</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
