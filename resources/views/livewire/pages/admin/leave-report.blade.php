<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Leave Report</h1>
            <p class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">Overview of all employees' leave balances and usage</p>
        </div>

        <!-- Search and Filters -->
        <div class="shadow rounded-lg p-6 mb-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Search Employees</label>
                    <input type="text" wire:model.live="search" 
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}"
                           placeholder="Search by name or email...">
                </div>
            </div>
        </div>

        <!-- Leave Report Table -->
        <div class="shadow rounded-lg overflow-hidden transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('divide-gray-200', 'divide-slate-700') }}">
                    <thead class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50', 'bg-slate-700') }}">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:bg-gray-100', 'text-slate-300 hover:bg-slate-600') }}" 
                                wire:click="sortBy('name')">
                                Employee
                                @if($sortBy === 'name')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    @endif
                                @endif
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Sick Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Casual Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Festival Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Privilege Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Emergency Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Total Used</th>
                        </tr>
                    </thead>
                    <tbody class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white divide-gray-200', 'bg-slate-800 divide-slate-700') }}">
                        @forelse($users as $user)
                            <tr class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('hover:bg-gray-50', 'hover:bg-slate-700') }}">
                                <!-- Employee Info -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                <span class="text-sm font-medium text-white">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $user->name }}</div>
                                            <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Leave Balances for each type -->
                                @foreach(['sick', 'casual', 'festival', 'privilege', 'emergency'] as $type)
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $balance = $user->leaveBalances->where('leave_type', $type)->first();
                                            $used = $leaveCounts[$user->id][$type] ?? 0;
                                            $total = $balance ? $balance->total_allowed : 0;
                                            $remaining = $total - $used;
                                        @endphp
                                        
                                        <div class="space-y-1">
                                            <!-- Used/Total -->
                                            <div class="text-sm">
                                                <span class="font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $used }}</span>
                                                <span class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">/ {{ $total }}</span>
                                            </div>
                                            
                                            <!-- Remaining -->
                                            <div class="text-xs">
                                                <span class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">Remaining: </span>
                                                <span class="font-medium {{ $remaining < 5 ? 'text-red-600' : ($remaining < 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                                    {{ $remaining }}
                                                </span>
                                            </div>
                                            
                                            <!-- Progress Bar -->
                                            @if($total > 0)
                                                <div class="w-full rounded-full h-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-200', 'bg-slate-600') }}">
                                                    <div class="bg-blue-600 h-2 rounded-full" 
                                                         style="width: {{ min(100, ($used / $total) * 100) }}%"></div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                @endforeach

                                <!-- Total Used -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $totalUsed = array_sum($leaveCounts[$user->id]);
                                        $totalAllowed = $user->leaveBalances->sum('total_allowed');
                                    @endphp
                                    <div class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $totalUsed }}</div>
                                    <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">of {{ $totalAllowed }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">
                                    No employees found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 py-3 border-t sm:px-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
                {{ $users->links() }}
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-4">
            @foreach($leaveTypes as $type => $label)
                @php
                    $totalUsed = 0;
                    $totalAllowed = 0;
                    foreach($users as $user) {
                        $totalUsed += $leaveCounts[$user->id][$type] ?? 0;
                        $balance = $user->leaveBalances->where('leave_type', $type)->first();
                        $totalAllowed += $balance ? $balance->total_allowed : 0;
                    }
                    $percentage = $totalAllowed > 0 ? round(($totalUsed / $totalAllowed) * 100, 1) : 0;
                @endphp
                <div class="shadow rounded-lg p-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
                    <div class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">{{ $label }}</div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $totalUsed }}</div>
                        <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">of {{ $totalAllowed }}</div>
                        <div class="mt-2 w-full rounded-full h-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-200', 'bg-slate-600') }}">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="text-xs mt-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">{{ $percentage }}% used</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>