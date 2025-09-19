<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <div class="shadow rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
            <div class="px-6 py-4 border-b transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-700') }}">
                <h2 class="text-xl font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">
                    @if($isResubmit)
                        Resubmit Leave Request
                    @else
                        Edit Leave Request
                    @endif
                </h2>
                <p class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">
                    @if($isResubmit)
                        Resubmit your rejected leave request with additional notes
                    @else
                        Update your pending leave request
                    @endif
                </p>
            </div>

            <form wire:submit="update" class="p-6 space-y-6">
                @if (session()->has('success'))
                    <div class="px-4 py-3 rounded transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-100 border border-green-400 text-green-700', 'bg-green-900/20 border border-green-800 text-green-300') }}">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="px-4 py-3 rounded transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-red-100 border border-red-400 text-red-700', 'bg-red-900/20 border border-red-800 text-red-300') }}">
                        {{ session('error') }}
                    </div>
                @endif

                @if($isResubmit)
                    <div class="border rounded-md p-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-yellow-50 border-yellow-200', 'bg-yellow-900/20 border-yellow-800') }}">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <span class="font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-yellow-800', 'text-yellow-300') }}">This request was previously rejected. You can resubmit it with additional notes.</span>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Leave Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">
                            Leave Type <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="type" id="type" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900', 'bg-slate-700 border-slate-600 text-slate-100') }}">
                            <option value="">Select leave type...</option>
                            @foreach($leaveTypes as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Total Days Display -->
                    <div class="flex items-center">
                        @if($start_date && $end_date)
                            <div class="border rounded-md p-4 w-full transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-50 border-blue-200', 'bg-blue-900/20 border-blue-800') }}">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-800', 'text-blue-300') }}">
                                        Total Working Days (Mon-Sat): <span class="font-bold text-lg">{{ $total_days }}</span>
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">
                            Start Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" wire:model.live="start_date" id="start_date" 
                               class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900', 'bg-slate-700 border-slate-600 text-slate-100') }}">
                        @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">
                            End Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" wire:model.live="end_date" id="end_date" 
                               class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900', 'bg-slate-700 border-slate-600 text-slate-100') }}">
                        @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Reason -->
                <div>
                    <label for="reason" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">
                        Reason for Leave <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="reason" id="reason" rows="4" 
                              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}"
                              placeholder="Please provide a detailed reason for your leave request..."></textarea>
                    @error('reason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-sm mt-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Minimum 10 characters required</p>
                </div>

                @if($isResubmit)
                    <!-- Resubmit Note -->
                    <div>
                        <label for="resubmitNote" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">
                            Additional Note for Resubmission
                        </label>
                        <textarea wire:model="resubmitNote" id="resubmitNote" rows="3" 
                                  class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}"
                                  placeholder="Add any additional notes for resubmission (optional)..."></textarea>
                        @error('resubmitNote') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        <p class="text-sm mt-1 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">This note will be added to your reason</p>
                    </div>
                @endif

                <!-- Submit Button -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('employee.my-leave-requests') }}" 
                       class="px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 inline-block transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 text-gray-700 hover:bg-gray-50', 'border-slate-600 text-slate-300 hover:bg-slate-700') }}">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                        @if($isResubmit)
                            Resubmit Request
                        @else
                            Update Request
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>