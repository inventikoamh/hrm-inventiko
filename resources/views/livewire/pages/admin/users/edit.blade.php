<?php

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

new #[Layout('layouts.app')] class extends Component
{
    use WithFileUploads;
    public User $user;
    public string $name = '';
    public string $email = '';
    public $profile_picture = null;
    public array $selectedRoles = [];
    public array $roles = [];

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->roles = Role::pluck('name')->all();
        $this->selectedRoles = $user->getRoleNames()->toArray();
    }

    public function save(): void
    {
        try {
            $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user->id)],
                'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'selectedRoles' => ['array']
            ]);

            $updateData = [
                'name' => $this->name,
                'email' => $this->email,
            ];

            // Handle profile picture upload
            if ($this->profile_picture) {
                // Delete old profile picture if exists
                if ($this->user->profile_picture) {
                    \Storage::disk('public')->delete($this->user->profile_picture);
                }
                $updateData['profile_picture'] = $this->profile_picture->store('profile-pictures', 'public');
            }

            $this->user->update($updateData);
            $this->user->syncRoles($this->selectedRoles);

            session()->flash('status', 'User updated successfully.');
            
            // Use redirect instead of redirectRoute to prevent issues
            $this->redirect(route('admin.users.index'), navigate: true);
            
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while updating the user: ' . $e->getMessage());
        }
    }
}; ?>

<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Edit User</h2>

    <div class="bg-white p-6 rounded shadow max-w-2xl">
        @can('edit user')
        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" wire:model="name" class="mt-1 block w-full border rounded px-3 py-2" />
                @error('name') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" wire:model="email" class="mt-1 block w-full border rounded px-3 py-2" />
                @error('email') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                <div class="mt-1">
                    <!-- Current Profile Picture -->
                    <div class="flex items-center space-x-4 mb-4">
                        @if($user->profile_picture)
                            <img src="{{ $user->profile_picture_url }}" alt="Current Profile" class="h-20 w-20 rounded-full object-cover border-2 border-gray-300">
                        @else
                            <img src="{{ $user->getDefaultProfilePicture() }}" alt="Default Profile" class="h-20 w-20 rounded-full object-cover border-2 border-gray-300">
                        @endif
                        <div>
                            <p class="text-sm text-gray-600">Current profile picture</p>
                        </div>
                    </div>
                    
                    <!-- File Upload -->
                    <div>
                        <input type="file" 
                               wire:model="profile_picture" 
                               accept="image/*" 
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                        <p class="mt-1 text-xs text-gray-500">
                            Maximum file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF
                        </p>
                        @error('profile_picture') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                    </div>
                </div>
                
                <!-- Simple Preview -->
                @if ($profile_picture)
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">New Profile Picture</h4>
                        <img src="{{ $profile_picture->temporaryUrl() }}" alt="Preview" class="h-20 w-20 rounded-full object-cover border-2 border-gray-300">
                    </div>
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Assign Roles</label>
                <div class="mt-2 space-y-2">
                    @foreach($roles as $role)
                        <label class="flex items-center gap-2">
                            <input type="checkbox" value="{{ $role }}" wire:model="selectedRoles" />
                            <span>{{ $role }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.users.index') }}" wire:navigate class="px-4 py-2">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
            </div>
        </form>
        @endcan
    </div>
</div>


