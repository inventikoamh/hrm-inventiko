<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Leave Report</h1>
            <p class="text-gray-600">Overview of all employees' leave balances and usage</p>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Employees</label>
                    <input type="text" wire:model.live="search" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Search by name or email...">
                </div>
            </div>
        </div>

        <!-- Leave Report Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100" 
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
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Sick Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Casual Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Festival Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Privilege Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Emergency Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Used</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
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
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
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
                                                <span class="font-medium text-gray-900">{{ $used }}</span>
                                                <span class="text-gray-500">/ {{ $total }}</span>
                                            </div>
                                            
                                            <!-- Remaining -->
                                            <div class="text-xs">
                                                <span class="text-gray-600">Remaining: </span>
                                                <span class="font-medium {{ $remaining < 5 ? 'text-red-600' : ($remaining < 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                                    {{ $remaining }}
                                                </span>
                                            </div>
                                            
                                            <!-- Progress Bar -->
                                            @if($total > 0)
                                                <div class="w-full bg-gray-200 rounded-full h-2">
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
                                    <div class="text-sm font-medium text-gray-900">{{ $totalUsed }}</div>
                                    <div class="text-xs text-gray-500">of {{ $totalAllowed }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No employees found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
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
                <div class="bg-white shadow rounded-lg p-4">
                    <div class="text-sm font-medium text-gray-500">{{ $label }}</div>
                    <div class="mt-2">
                        <div class="text-2xl font-bold text-gray-900">{{ $totalUsed }}</div>
                        <div class="text-sm text-gray-500">of {{ $totalAllowed }}</div>
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">{{ $percentage }}% used</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>