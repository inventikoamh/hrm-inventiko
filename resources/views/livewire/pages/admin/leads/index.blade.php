<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Manage Leads</h2>
        <a href="{{ route('admin.leads.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Lead
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Filters</h3>
            <button wire:click="resetFilters" 
                    class="text-sm text-gray-600 hover:text-gray-800 underline">
                Reset All Filters
            </button>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" 
                       wire:model.live="search" 
                       placeholder="Search leads..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">All Statuses</option>
                    <option value="new_lead">New Lead</option>
                    <option value="initial_contact">Initial Contact</option>
                    <option value="qualification_call">Qualification Call</option>
                    <option value="proposal_sent">Proposal Sent</option>
                    <option value="converted">Converted to Client</option>
                    <option value="on_hold">On Hold</option>
                    <option value="dead">Lead Lost</option>
                </select>
            </div>

            <!-- Product Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Type</label>
                <input type="text" 
                       wire:model.live="productType" 
                       placeholder="Filter by product type..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>

            <!-- Date Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                <select wire:model.live="dateRange" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="">All Time</option>
                    <option value="today">Today</option>
                    <option value="this_week">This Week</option>
                    <option value="this_month">This Month</option>
                    <option value="last_week">Last Week</option>
                    <option value="last_month">Last Month</option>
                    <option value="last_30_days">Last 30 Days</option>
                    <option value="last_90_days">Last 90 Days</option>
                </select>
            </div>

            <!-- Sort By -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select wire:model.live="sortBy" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="created_at">Created Date</option>
                    <option value="name">Name</option>
                    <option value="email">Email</option>
                    <option value="budget">Budget</option>
                    <option value="status">Status</option>
                </select>
            </div>

            <!-- Sort Direction -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Order</label>
                <select wire:model.live="sortDirection" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="desc">Newest First</option>
                    <option value="asc">Oldest First</option>
                </select>
            </div>

            <!-- Per Page -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Per Page</label>
                <select wire:model.live="perPage" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        <!-- Results Count -->
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    Showing {{ $leads->count() }} of {{ $leads->total() }} leads
                </p>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">
                        Sorted by {{ ucfirst(str_replace('_', ' ', $sortBy)) }} 
                        ({{ $sortDirection === 'desc' ? 'Newest First' : 'Oldest First' }})
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Leads Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($leads as $lead)
                        <tr class="hover:bg-gray-50 cursor-pointer" wire:click="openViewModal({{ $lead->id }})">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $lead->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $lead->getStatusColor() }}">
                                    {{ \App\Models\Lead::getStatuses()[$lead->status] ?? $lead->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $lead->created_at->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $lead->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" wire:click.stop>
                                <div class="flex flex-wrap items-center gap-2">
                                    @if($lead->canBePromoted() && auth()->user()->can('update lead status'))
                                        @php
                                            $nextStatus = $lead->getNextStatus();
                                            $statusLabels = \App\Models\Lead::getStatuses();
                                            $nextStatusLabel = $statusLabels[$nextStatus] ?? $nextStatus;
                                        @endphp
                                        <button wire:click="openPromoteModal({{ $lead->id }}, '{{ $nextStatus }}')" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                            </svg>
                                            Promote
                                        </button>
                                    @endif

                                    @if($lead->status === \App\Models\Lead::STATUS_ON_HOLD && auth()->user()->can('update lead status'))
                                        <button wire:click="unholdLead({{ $lead->id }})" 
                                                onclick="return confirm('Are you sure you want to remove this lead from HOLD?')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 rounded-md hover:bg-green-200 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Unhold
                                        </button>
                                    @elseif($lead->status === \App\Models\Lead::STATUS_DEAD && auth()->user()->can('update lead status'))
                                        <button wire:click="undeadLead({{ $lead->id }})" 
                                                onclick="return confirm('Are you sure you want to restore this lead from LOST status?')"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 rounded-md hover:bg-green-200 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Restore
                                        </button>
                                    @elseif(!in_array($lead->status, [\App\Models\Lead::STATUS_CONVERTED]) && auth()->user()->can('update lead status'))
                                        <button wire:click="openHoldModal({{ $lead->id }})" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            Hold
                                        </button>

                                        <button wire:click="openLostModal({{ $lead->id }})" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-md hover:bg-red-200 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Lost
                                        </button>
                                    @endif

                                    <a href="{{ route('admin.leads.edit', $lead) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-md hover:bg-yellow-200 transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    @if($lead->converted_to_client)
                                        <span class="text-green-600 text-xs font-medium bg-green-100 px-2 py-1 rounded-full">
                                            Client
                                        </span>
                                    @endif
                                    <button wire:click="delete({{ $lead->id }})" 
                                            onclick="return confirm('Are you sure you want to delete this lead?')"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-md hover:bg-red-200 transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No leads found</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new lead.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($leads->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $leads->links() }}
            </div>
        @endif
    </div>

    <!-- Convert to Client Modal -->
    @if($showConvertModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeConvertModal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Convert Lead to Client</h3>
                        <button wire:click="closeConvertModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    @if($selectedLead)
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Converting lead:</p>
                            <p class="font-medium text-gray-900">{{ $selectedLead->name }}</p>
                            <p class="text-sm text-gray-600">{{ $selectedLead->email }}</p>
                        </div>
                    @endif

                    <form wire:submit="convertToClient" class="space-y-4">
                        <div>
                            <label for="companyName" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                            <input type="text" 
                                   id="companyName"
                                   wire:model="companyName" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Enter company name">
                            @error('companyName') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description"
                                      wire:model="description" 
                                      rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Enter client description (optional)"></textarea>
                            @error('description') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" 
                                    wire:click="closeConvertModal"
                                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                                Convert to Client
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- View Lead Modal -->
    @if($showViewModal && $selectedLead)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeViewModal">
            <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-7xl shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Lead Details</h3>
                        <button wire:click="closeViewModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Lead Details -->
                        <div class="lg:col-span-1 bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Lead Details</h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Name</label>
                                    <p class="text-sm text-gray-900">{{ $selectedLead->name }}</p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Email</label>
                                    <p class="text-sm text-gray-900">{{ $selectedLead->email }}</p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Mobile</label>
                                    <p class="text-sm text-gray-900">{{ $selectedLead->mobile }}</p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Product Type</label>
                                    <p class="text-sm text-gray-900">{{ $selectedLead->product_type }}</p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Budget</label>
                                    <p class="text-sm text-gray-900">{{ $selectedLead->budget }}</p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Start</label>
                                    <p class="text-sm text-gray-900">{{ $selectedLead->start }}</p>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Created</label>
                                    <p class="text-sm text-gray-900">{{ $selectedLead->created_at->format('M d, Y H:i') }}</p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500">Status</label>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $selectedLead->getStatusColor() }}">
                                            {{ \App\Models\Lead::getStatuses()[$selectedLead->status] ?? $selectedLead->status }}
                                        </span>
                                    </div>
                                </div>

                                @if($selectedLead->converted_to_client)
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Converted to Client
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="lg:col-span-2 bg-gray-50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Remarks & Notes</h4>
                            
                            <!-- Add Remark Form -->
                            @can('add lead remark')
                            <div class="mb-6 p-4 bg-white rounded-lg border">
                                <form wire:submit="addRemark">
                                    <div class="mb-3">
                                        <label for="remark" class="block text-sm font-medium text-gray-700 mb-2">Add Remark</label>
                                        <textarea wire:model="remark" 
                                                  id="remark"
                                                  rows="4" 
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                  placeholder="Add a remark or note about this lead..."></textarea>
                                        @error('remark') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                                    </div>
                                    <button type="submit" 
                                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg text-sm font-medium">
                                        Add Remark
                                    </button>
                                </form>
                            </div>
                            @else
                            <div class="mb-6 p-4 bg-gray-100 rounded-lg border text-center">
                                <p class="text-sm text-gray-500">You don't have permission to add remarks to leads.</p>
                            </div>
                            @endcan

                            <!-- Remarks List -->
                            <div class="space-y-3 max-h-96 overflow-y-auto">
                                @forelse($remarks as $remark)
                                    <div class="border border-gray-200 rounded-lg p-3 bg-white">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="text-sm text-gray-900 mb-2 whitespace-pre-wrap">{{ $remark->remark }}</div>
                                                <div class="flex items-center text-xs text-gray-500">
                                                    <span>{{ $remark->user->name }}</span>
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $remark->created_at->format('M d, Y H:i') }}</span>
                                                </div>
                                            </div>
                                            <button wire:click="deleteRemark({{ $remark->id }})" 
                                                    onclick="return confirm('Are you sure you want to delete this remark?')"
                                                    class="text-red-600 hover:text-red-900 ml-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No remarks yet</h3>
                                        <p class="mt-1 text-xs text-gray-500">Add the first remark to track this lead's progress.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Promote Lead Modal -->
    @if($showPromoteModal && $selectedLead)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closePromoteModal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Promote Lead Status</h3>
                        <button wire:click="closePromoteModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    @if($selectedLead)
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Promoting lead:</p>
                            <p class="font-medium text-gray-900">{{ $selectedLead->name }}</p>
                            <p class="text-sm text-gray-600">From: {{ \App\Models\Lead::getStatuses()[$selectedLead->status] ?? $selectedLead->status }}</p>
                            <p class="text-sm text-gray-600">To: {{ \App\Models\Lead::getStatuses()[$targetStatus] ?? $targetStatus }}</p>
                        </div>
                    @endif

                    @if($targetStatus === \App\Models\Lead::STATUS_CONVERTED)
                        <!-- Conversion Form -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="text-sm text-yellow-800 font-medium">Converting to Client</p>
                            </div>
                            <p class="text-sm text-yellow-700 mt-1">This will convert the lead to a client. Please provide client details below.</p>
                        </div>

                        <form wire:submit="promoteLead" class="space-y-4">
                            <div>
                                <label for="promoteDescription" class="block text-sm font-medium text-gray-700 mb-2">Conversion Notes *</label>
                                <textarea id="promoteDescription"
                                          wire:model="promoteDescription" 
                                          rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Add notes about this conversion..."></textarea>
                                @error('promoteDescription') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="flex justify-end gap-3 pt-4">
                                <button type="button" 
                                        wire:click="closePromoteModal"
                                        class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                                    Convert to Client
                                </button>
                            </div>
                        </form>
                    @else
                        <!-- Regular Promotion Form -->
                        <form wire:submit="promoteLead" class="space-y-4">
                            <div>
                                <label for="promoteDescription" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                                <textarea id="promoteDescription"
                                          wire:model="promoteDescription" 
                                          rows="4" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Add details about this status promotion..."></textarea>
                                @error('promoteDescription') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="flex justify-end gap-3 pt-4">
                                <button type="button" 
                                        wire:click="closePromoteModal"
                                        class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                                    Promote Status
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Hold Lead Modal -->
    @if($showHoldModal && $selectedLead)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeHoldModal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Mark Lead as On Hold</h3>
                        <button wire:click="closeHoldModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    @if($selectedLead)
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600">Marking lead as on hold:</p>
                            <p class="font-medium text-gray-900">{{ $selectedLead->name }}</p>
                            <p class="text-sm text-gray-600">Current Status: {{ \App\Models\Lead::getStatuses()[$selectedLead->status] ?? $selectedLead->status }}</p>
                        </div>
                    @endif

                    <form wire:submit="markAsOnHold" class="space-y-4">
                        <div>
                            <label for="holdDescription" class="block text-sm font-medium text-gray-700 mb-2">Reason for Hold *</label>
                            <textarea id="holdDescription"
                                      wire:model="holdDescription" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Please provide a reason for putting this lead on hold..."></textarea>
                            @error('holdDescription') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" 
                                    wire:click="closeHoldModal"
                                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm font-medium transition-colors">
                                Mark as On Hold
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Lost Lead Modal -->
    @if($showLostModal && $selectedLead)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeLostModal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Mark Lead as Lost</h3>
                        <button wire:click="closeLostModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    @if($selectedLead)
                        <div class="mb-4 p-3 bg-red-50 rounded-lg border border-red-200">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <p class="text-sm text-red-800 font-medium">Warning: This action cannot be undone</p>
                            </div>
                            <p class="text-sm text-red-700 mt-1">Marking lead as lost:</p>
                            <p class="font-medium text-red-900">{{ $selectedLead->name }}</p>
                            <p class="text-sm text-red-600">Current Status: {{ \App\Models\Lead::getStatuses()[$selectedLead->status] ?? $selectedLead->status }}</p>
                        </div>
                    @endif

                    <form wire:submit="markAsDead" class="space-y-4">
                        <div>
                            <label for="lostDescription" class="block text-sm font-medium text-gray-700 mb-2">Reason for Loss *</label>
                            <textarea id="lostDescription"
                                      wire:model="lostDescription" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                      placeholder="Please provide a reason for marking this lead as lost..."></textarea>
                            @error('lostDescription') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" 
                                    wire:click="closeLostModal"
                                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors">
                                Mark as Lost
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
