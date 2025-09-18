<div>
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <a href="{{ route('admin.leads.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="text-2xl font-bold text-gray-900">{{ $lead->name }}</h2>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.leads.edit', $lead) }}" 
               class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Lead
            </a>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Lead Details -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Lead Details</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Name</label>
                        <p class="text-sm text-gray-900">{{ $lead->name }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="text-sm text-gray-900">{{ $lead->email }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Mobile</label>
                        <p class="text-sm text-gray-900">{{ $lead->mobile }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Product Type</label>
                        <p class="text-sm text-gray-900">{{ $lead->product_type }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Budget</label>
                        <p class="text-sm text-gray-900">{{ $lead->budget }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Start</label>
                        <p class="text-sm text-gray-900">{{ $lead->start }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-500">Created</label>
                        <p class="text-sm text-gray-900">{{ $lead->created_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Remarks Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Remarks & Notes</h3>
                
                <!-- Add Remark Form -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <form wire:submit="addRemark">
                        <div class="mb-3">
                            <label for="remark" class="block text-sm font-medium text-gray-700 mb-2">Add Remark</label>
                            <textarea wire:model="remark" 
                                      id="remark"
                                      rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Add a remark or note about this lead..."></textarea>
                            @error('remark') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Add Remark
                        </button>
                    </form>
                </div>

                <!-- Remarks List -->
                <div class="space-y-4">
                    @forelse($remarks as $remark)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm text-gray-900 mb-2">{{ $remark->remark }}</p>
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
                            <p class="mt-1 text-sm text-gray-500">Add the first remark to track this lead's progress.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
