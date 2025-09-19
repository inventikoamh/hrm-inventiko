<div class="p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">My Leave Requests</h2>
                    <p class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">View and track your leave requests</p>
                </div>
                <a href="{{ route('employee.leave-request') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                    Request Leave
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Search</label>
                    <input type="text" wire:model.live="search" 
                           class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}"
                           placeholder="Search by reason...">
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
            </div>
            
            <!-- Quick Action Buttons -->
            <div class="mt-4 flex flex-wrap gap-2">
                <button wire:click="$set('statusFilter', 'pending')" 
                        class="px-3 py-1 text-xs rounded-full transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-yellow-100 text-yellow-800 hover:bg-yellow-200', 'bg-yellow-900/30 text-yellow-300 hover:bg-yellow-900/40') }}">
                    Show Pending
                </button>
                <button wire:click="$set('statusFilter', 'rejected')" 
                        class="px-3 py-1 text-xs rounded-full transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-100 text-red-800 hover:bg-red-200', 'bg-red-900/30 text-red-300 hover:bg-red-900/40') }}">
                    Show Rejected
                </button>
                <button wire:click="$set('statusFilter', 'approved')" 
                        class="px-3 py-1 text-xs rounded-full transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-100 text-green-800 hover:bg-green-200', 'bg-green-900/30 text-green-300 hover:bg-green-900/40') }}">
                    Show Approved
                </button>
                <button wire:click="$set('statusFilter', '')" 
                        class="px-3 py-1 text-xs rounded-full transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 text-gray-800 hover:bg-gray-200', 'bg-slate-700 text-slate-300 hover:bg-slate-600') }}">
                    Show All
                </button>
            </div>
        </div>

        <!-- Leave Requests Table -->
        <div class="shadow rounded-lg overflow-hidden transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('divide-gray-200', 'divide-slate-700') }}">
                    <thead class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50', 'bg-slate-700') }}">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Days</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Reason</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Admin Remark</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Requested</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-300') }}">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white divide-gray-200', 'bg-slate-800 divide-slate-700') }}">
                        @forelse($leaveRequests as $request)
                            <tr class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('hover:bg-gray-50', 'hover:bg-slate-700') }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $request->type_name }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                                        {{ $request->start_date->format('M d, Y') }} - {{ $request->end_date->format('M d, Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $request->total_days }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $request->status_badge }}">
                                        {{ ucfirst($request->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm max-w-xs truncate transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}" title="{{ $request->reason }}">
                                        {{ $request->reason }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($request->admin_remark)
                                        <div class="text-sm max-w-xs truncate transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}" title="{{ $request->admin_remark }}">
                                            {{ $request->admin_remark }}
                                        </div>
                                    @else
                                        <span class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $request->created_at->format('M d, Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if($request->status === 'pending')
                                            <a href="{{ route('employee.edit-leave-request', $request->id) }}" 
                                               class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-600 hover:text-blue-900', 'text-blue-400 hover:text-blue-300') }}">
                                                Edit
                                            </a>
                                        @elseif($request->status === 'rejected')
                                            <a href="{{ route('employee.edit-leave-request', $request->id) }}" 
                                               class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-600 hover:text-green-900', 'text-green-400 hover:text-green-300') }}">
                                                Resubmit
                                            </a>
                                        @else
                                            <span class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">
                                    No leave requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-3 border-t transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-700') }}">
                {{ $leaveRequests->links() }}
            </div>
        </div>
    </div>
</div>