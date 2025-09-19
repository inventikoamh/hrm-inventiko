<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Leave Balance Management</h1>
            <p class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">Manage leave allowances for each employee</p>
        </div>

        @if (session()->has('success'))
            <div class="px-4 py-3 rounded mb-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-100 border border-green-400 text-green-700', 'bg-green-900/20 border border-green-800 text-green-300') }}">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search -->
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

        <!-- Employees Table -->
        <div class="shadow rounded-lg overflow-hidden transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('divide-gray-200', 'divide-slate-700') }}">
                    <thead class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50', 'bg-slate-700') }}">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Employee</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Sick Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Casual Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Festival Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Privilege Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Emergency Leave</th>
                            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Actions</th>
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
                                        @endphp
                                        
                                        @if($balance)
                                            <div class="space-y-1">
                                                <div class="text-sm">
                                                    <span class="font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $balance->total_allowed }}</span>
                                                </div>
                                                <div class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">
                                                    Used: {{ $balance->used }}
                                                </div>
                                                <div class="text-xs">
                                                    <span class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">Remaining: </span>
                                                    <span class="font-medium {{ $balance->remaining < 5 ? 'text-red-600' : ($balance->remaining < 10 ? 'text-yellow-600' : 'text-green-600') }}">
                                                        {{ $balance->remaining }}
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">-</span>
                                        @endif
                                    </td>
                                @endforeach

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <button wire:click="selectUser({{ $user->id }})" 
                                            class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-600 hover:text-blue-900', 'text-blue-400 hover:text-blue-300') }}">
                                        Manage
                                    </button>
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
            
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300', 'bg-slate-800 border-slate-700') }}">
                <div class="mt-3">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between pb-4 border-b transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-700') }}">
                        <h3 class="text-lg font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                            Manage Leave Balances - {{ $selectedUser->name }}
                        </h3>
                        <button wire:click="closeModal" class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-400 hover:text-gray-600', 'text-slate-400 hover:text-slate-300') }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="mt-4 space-y-6">
                        @foreach($leaveTypes as $type => $label)
                            <div class="border rounded-lg p-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-700') }}">
                                <h4 class="text-sm font-medium mb-3 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $label }}</h4>
                                
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium mb-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Total Allowed</label>
                                        <input type="number" 
                                               wire:model.live="editingBalances.{{ $type }}.total_allowed"
                                               class="w-full px-3 py-2 text-sm border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900', 'bg-slate-700 border-slate-600 text-slate-100') }}"
                                               min="0">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-medium mb-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Used</label>
                                        <input type="number" 
                                               value="{{ $editingBalances[$type]['used'] ?? 0 }}"
                                               class="w-full px-3 py-2 text-sm border rounded-md transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 border-gray-300 text-gray-900', 'bg-slate-600 border-slate-600 text-slate-300') }}"
                                               readonly>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-xs font-medium mb-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Remaining</label>
                                        <input type="number" 
                                               value="{{ ($editingBalances[$type]['total_allowed'] ?? 0) - ($editingBalances[$type]['used'] ?? 0) }}"
                                               class="w-full px-3 py-2 text-sm border rounded-md transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 border-gray-300 text-gray-900', 'bg-slate-600 border-slate-600 text-slate-300') }}"
                                               readonly>
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <button wire:click="updateBalance('{{ $type }}')" 
                                            class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors duration-200">
                                        Update {{ $label }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-700') }}">
                        <button wire:click="closeModal" 
                                class="px-4 py-2 text-sm font-medium border rounded-md transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700 bg-gray-100 border-gray-300 hover:bg-gray-200', 'text-slate-300 bg-slate-700 border-slate-600 hover:bg-slate-600') }}">
                            Close
                        </button>
                        <button wire:click="updateAllBalances" 
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 transition-colors duration-200">
                            Update All Balances
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>