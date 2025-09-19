<div>
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.leads.index') }}" class="mr-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600 hover:text-gray-900', 'text-slate-400 hover:text-slate-300') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <h2 class="text-2xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Create Lead</h2>
    </div>

    <div class="rounded-lg shadow-sm border p-6 max-w-2xl transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
        <form wire:submit="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Name *</label>
                    <input type="text" 
                           id="name"
                           wire:model="name" 
                           class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}"
                           placeholder="Enter lead name">
                    @error('name') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label for="mobile" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Mobile *</label>
                    <input type="text" 
                           id="mobile"
                           wire:model="mobile" 
                           class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}"
                           placeholder="Enter mobile number">
                    @error('mobile') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Email *</label>
                <input type="email" 
                       id="email"
                       wire:model="email" 
                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}"
                       placeholder="Enter email address">
                @error('email') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="product_type" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Product Type *</label>
                    <input type="text" 
                           id="product_type"
                           wire:model="product_type" 
                           class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}"
                           placeholder="Enter product type">
                    @error('product_type') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label for="budget" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Budget *</label>
                    <input type="text" 
                           id="budget"
                           wire:model="budget" 
                           class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}"
                           placeholder="Enter budget">
                    @error('budget') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div>
                <label for="start" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Start *</label>
                <input type="text" 
                       id="start"
                       wire:model="start" 
                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}"
                       placeholder="Enter start information">
                @error('start') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-600') }}">
                <a href="{{ route('admin.leads.index') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700 bg-gray-100 hover:bg-gray-200', 'text-slate-300 bg-slate-700 hover:bg-slate-600') }}">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 text-white rounded-lg text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-indigo-600 hover:bg-indigo-700', 'bg-indigo-600 hover:bg-indigo-700') }}">
                    Create Lead
                </button>
            </div>
        </form>
    </div>
</div>
