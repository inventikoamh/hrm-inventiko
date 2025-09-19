<div>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Create Client</h1>
            <p class="mt-2 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-400') }}">Add a new client to your system.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('admin.clients.index') }}" 
               class="block rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                Back to Clients
            </a>
        </div>
    </div>

    <form wire:submit="save" class="mt-8 space-y-6">
        <div class="shadow px-4 py-5 sm:rounded-lg sm:p-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Client Name -->
                <div>
                    <label for="client_name" class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Client Name *</label>
                    <input type="text" 
                           wire:model="client_name" 
                           id="client_name"
                           class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}">
                    @error('client_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Company Name *</label>
                    <input type="text" 
                           wire:model="company_name" 
                           id="company_name"
                           class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}">
                    @error('company_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Description</label>
                    <textarea wire:model="description" 
                              id="description"
                              rows="3"
                              placeholder="Enter client description..."
                              class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Email</label>
                    <input type="email" 
                           wire:model="email" 
                           id="email"
                           class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Mobile -->
                <div>
                    <label for="mobile" class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Mobile *</label>
                    <input type="text" 
                           wire:model="mobile" 
                           id="mobile"
                           placeholder="Enter mobile number"
                           class="mt-1 block w-full rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}">
                    @error('mobile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.clients.index') }}" 
               class="py-2 px-4 border rounded-md shadow-sm text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-700 hover:bg-gray-50', 'bg-slate-700 border-slate-600 text-slate-300 hover:bg-slate-600') }}">
                Cancel
            </a>
            <button type="submit" 
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Create Client
            </button>
        </div>
    </form>
</div>
