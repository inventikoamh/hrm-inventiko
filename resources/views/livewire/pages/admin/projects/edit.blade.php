<div>
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold text-gray-900">Edit Project</h1>
            <p class="mt-2 text-sm text-gray-700">Update project details and settings.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('admin.projects.index') }}" 
               class="block rounded-md bg-gray-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                Back to Projects
            </a>
        </div>
    </div>

    <form wire:submit="save" class="mt-8 space-y-6">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <!-- Project Title -->
                <div class="sm:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700">Project Title *</label>
                    <input type="text" 
                           wire:model="title" 
                           id="title"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="sm:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea wire:model="description" 
                              id="description"
                              rows="4"
                              placeholder="Enter project description..."
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Estimated Start Date -->
                <div>
                    <label for="estimated_start_date" class="block text-sm font-medium text-gray-700">Estimated Start Date *</label>
                    <input type="date" 
                           wire:model="estimated_start_date" 
                           id="estimated_start_date"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('estimated_start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Estimated Days -->
                <div>
                    <label for="estimated_days" class="block text-sm font-medium text-gray-700">Estimated Days *</label>
                    <input type="number" 
                           wire:model="estimated_days" 
                           id="estimated_days"
                           min="1"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('estimated_days') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Project Lead -->
                <div>
                    <label for="project_lead_id" class="block text-sm font-medium text-gray-700">Project Lead *</label>
                    <select wire:model="project_lead_id" 
                            id="project_lead_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Select Project Lead</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('project_lead_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Client -->
                <div>
                    <label for="client_id" class="block text-sm font-medium text-gray-700">Client</label>
                    <select wire:model="client_id" 
                            id="client_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Select Client (Optional)</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->display_name }}</option>
                        @endforeach
                    </select>
                    @error('client_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Team Members -->
                <div>
                    <label for="team_members" class="block text-sm font-medium text-gray-700">Team Members</label>
                    <select wire:model="team_members" 
                            id="team_members"
                            multiple
                            size="5"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Hold Ctrl/Cmd to select multiple members</p>
                    @error('team_members') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Project Budget -->
                <div>
                    <label for="project_budget" class="block text-sm font-medium text-gray-700">Project Budget</label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <select wire:model="currency" 
                                class="inline-flex items-center px-3 py-2 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-700 text-sm font-medium focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 appearance-none"
                                style="background-image: none; -webkit-appearance: none; -moz-appearance: none;">
                            @foreach($currencies as $code => $name)
                                <option value="{{ $code }}">{{ $code }}</option>
                            @endforeach
                        </select>
                        <input type="text" 
                               wire:model="project_budget" 
                               id="project_budget"
                               placeholder="0.00"
                               class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 sm:text-sm [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                    </div>
                    @error('project_budget') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Priority -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                    <select wire:model="priority" 
                            id="priority"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        @foreach($priorities as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('priority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select wire:model="status" 
                            id="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.projects.index') }}" 
               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Cancel
            </a>
            <button type="submit" 
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Update Project
            </button>
        </div>
    </form>
</div>