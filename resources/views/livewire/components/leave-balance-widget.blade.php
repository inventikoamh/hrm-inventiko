<div class="rounded-xl shadow-sm border p-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">My Leave Balances</h3>
        <a href="{{ route('employee.my-leave-requests') }}" 
           class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-600 hover:text-blue-800', 'text-blue-400 hover:text-blue-300') }}">
            View Requests
        </a>
    </div>
    
    <div class="space-y-4">
        @foreach($leaveBalances as $balance)
            <div class="border rounded-lg p-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200 hover:bg-gray-50', 'border-slate-600 hover:bg-slate-700') }}">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $balance->type_name }}</h4>
                    <span class="text-xs px-2 py-1 rounded-full {{ $balance->status_badge }}">
                        {{ $balance->usage_percentage }}% used
                    </span>
                </div>
                
                <div class="space-y-2">
                    <!-- Progress Bar -->
                    <div class="w-full rounded-full h-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-200', 'bg-slate-600') }}">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                             style="width: {{ min(100, $balance->usage_percentage) }}%"></div>
                    </div>
                    
                    <!-- Balance Details -->
                    <div class="flex justify-between text-sm">
                        <div class="flex space-x-4">
                            <span class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">
                                Used: <span class="font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $balance->used }}</span>
                            </span>
                            <span class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">
                                Total: <span class="font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $balance->total_allowed }}</span>
                            </span>
                        </div>
                        <span class="font-medium {{ $balance->remaining < 5 ? 'text-red-600' : ($balance->remaining < 10 ? 'text-yellow-600' : 'text-green-600') }}">
                            {{ $balance->remaining }} remaining
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Quick Actions -->
    <div class="mt-6 pt-4 border-t transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-600') }}">
        <div class="flex space-x-3">
            <a href="{{ route('employee.leave-request') }}" 
               class="flex-1 bg-blue-600 text-white text-center px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">
                Request Leave
            </a>
            <a href="{{ route('employee.my-leave-requests') }}" 
               class="flex-1 text-center px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 text-gray-700 hover:bg-gray-200', 'bg-slate-700 text-slate-300 hover:bg-slate-600') }}">
                My Requests
            </a>
        </div>
    </div>
</div>