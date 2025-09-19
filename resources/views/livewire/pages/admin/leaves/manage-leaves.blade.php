<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Manage Leaves</h2>
                    <p class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">View and manage all leave requests</p>
                </div>
                <a href="{{ route('admin.leaves.mark') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                    Mark Leave
                </a>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="px-4 py-3 rounded mb-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-100 border border-green-400 text-green-700', 'bg-green-900/20 border border-green-800 text-green-300') }}">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="px-4 py-3 rounded mb-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-100 border border-red-400 text-red-700', 'bg-red-900/20 border border-red-800 text-red-300') }}">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="shadow rounded-lg p-6 mb-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Search</label>
                    <input type="text" wire:model.live="search" 
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}"
                           placeholder="Search by name or email...">
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Status</label>
                    <select wire:model.live="statusFilter" 
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900', 'bg-slate-700 border-slate-600 text-slate-100') }}">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Type Filter -->
                <div>
                    <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Leave Type</label>
                    <select wire:model.live="typeFilter" 
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900', 'bg-slate-700 border-slate-600 text-slate-100') }}">
                        <option value="">All Types</option>
                        @foreach($leaveTypes as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Source Filter -->
                <div>
                    <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Source</label>
                    <select wire:model.live="sourceFilter" 
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900', 'bg-slate-700 border-slate-600 text-slate-100') }}">
                        <option value="">All Sources</option>
                        @foreach($sources as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- User Filter -->
                <div>
                    <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">User</label>
                    <select wire:model.live="userFilter" 
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900', 'bg-slate-700 border-slate-600 text-slate-100') }}">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Leaves Table -->
        <div class="shadow rounded-lg overflow-hidden transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('divide-gray-200', 'divide-slate-700') }}">
                    <thead class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50', 'bg-slate-700') }}">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Days</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Source</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Approved By</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white divide-gray-200', 'bg-slate-800 divide-slate-700') }}">
                        @forelse($leaves as $leave)
                            <tr class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('hover:bg-gray-50', 'hover:bg-slate-700') }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $leave->user->name }}</div>
                                        <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">{{ $leave->user->email }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $leave->type_name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                                        {{ $leave->start_date->format('M d, Y') }} - {{ $leave->end_date->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $leave->total_days }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $leave->source_badge }}">
                                        {{ $leave->source_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $leave->status_badge }}">
                                        {{ ucfirst($leave->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($leave->approver)
                                        <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $leave->approver->name }}</div>
                                        <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">{{ $leave->approved_at->format('M d, Y H:i') }}</div>
                                    @else
                                        <span class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if($leave->status === 'pending')
                                            <button wire:click="approve({{ $leave->id }})" 
                                                    class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-600 hover:text-green-900', 'text-green-400 hover:text-green-300') }}"
                                                    onclick="return confirm('Are you sure you want to approve this leave?')">
                                                Approve
                                            </button>
                                            <button wire:click="reject({{ $leave->id }})" 
                                                    class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600 hover:text-red-900', 'text-red-400 hover:text-red-300') }}"
                                                    onclick="return confirm('Are you sure you want to reject this leave?')">
                                                Reject
                                            </button>
                                        @endif
                                        
                                        @can('delete leaves')
                                            <button wire:click="delete({{ $leave->id }})" 
                                                    class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600 hover:text-red-900', 'text-red-400 hover:text-red-300') }}"
                                                    onclick="return confirm('Are you sure you want to delete this leave?')">
                                                Delete
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">
                                    No leaves found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-3 border-t transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-700') }}">
                {{ $leaves->links() }}
            </div>
        </div>
    </div>
</div>