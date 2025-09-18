<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Leave Balance Management</h1>
            <p class="text-gray-600">Manage leave allowances for each employee</p>
        </div>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search -->
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

        <!-- Employees Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Sick Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Casual Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Festival Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Privilege Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Emergency Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
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
                                        @endphp
                                        
                                        @if($balance)
                                            <div class="space-y-1">
                                                <div class="text-sm">
                                                    <span class="font-medium text-gray-900">{{ $balance->total_allowed }}</span>
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    Used: {{ $balance->used }}
                                                </div>
                                                <div class="text-xs">
                                                    <span class="text-gray-600">Remaining: </span>
                                                    <span class="font-medium {{ $balance->remaining < 5 ? 'text-red-600' : ($balance->remaining < 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                                        {{ $balance->remaining }}
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-sm text-gray-500">-</span>
                                        @endif
                                    </td>
                                @endforeach

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <button wire:click="selectUser({{ $user->id }})" 
                                            class="text-blue-600 hover:text-blue-900">
                                        Manage
                                    </button>
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
    </div>

    <!-- Edit Modal -->
    @if($showEditModal && $selectedUser)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" 
             x-data="{ show: @entangle('showEditModal') }" 
             x-show="show" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0">
            
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-4 border-b">
                        <h3 class="text-lg font-medium text-gray-900">
                            Manage Leave Balances - {{ $selectedUser->name }}
                        </h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="mt-4 space-y-6">
                        @foreach($leaveTypes as $type => $label)
                            <div class="border rounded-lg p-4">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">{{ $label }}</h4>
                                
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Total Allowed</label>
                                        <input type="number" 
                                               wire:model.live="editingBalances.{{ $type }}.total_allowed"
                                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               min="0">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Used</label>
                                        <input type="number" 
                                               value="{{ $editingBalances[$type]['used'] ?? 0 }}"
                                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md bg-gray-100"
                                               readonly>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Remaining</label>
                                        <input type="number" 
                                               value="{{ ($editingBalances[$type]['total_allowed'] ?? 0) - ($editingBalances[$type]['used'] ?? 0) }}"
                                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md bg-gray-100"
                                               readonly>
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <button wire:click="updateBalance('{{ $type }}')" 
                                            class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Update {{ $label }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                        <button wire:click="closeModal" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200">
                            Close
                        </button>
                        <button wire:click="updateAllBalances" 
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                            Update All Balances
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>