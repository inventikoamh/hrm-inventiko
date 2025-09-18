<?php

use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

new #[Layout('layouts.app')] class extends Component
{
    use WithFileUploads;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $profile_picture = null;
    public array $selectedRoles = [];
    public array $roles = [];

    public function mount(): void
    {
        $this->roles = Role::pluck('name')->all();
    }

    public function save(): void
    {
        try {
            $validated = $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Password::defaults()],
                'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'selectedRoles' => ['array'],
            ]);

            $userData = [
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
            ];

            // Handle profile picture upload
            if ($this->profile_picture) {
                $userData['profile_picture'] = $this->profile_picture->store('profile-pictures', 'public');
            }

            $user = User::create($userData);

            if (!empty($this->selectedRoles)) {
                $user->assignRole($this->selectedRoles);
            }

            session()->flash('status', 'User created successfully.');
            
            // Use redirect instead of redirectRoute to prevent issues
            $this->redirect(route('admin.users.index'), navigate: true);
            
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while creating the user: ' . $e->getMessage());
        }
    }
}; ?>

<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Create User</h2>

    <div class="bg-white p-6 rounded shadow max-w-2xl">
        @if (session('status'))
            <div class="mb-3 text-green-700">{{ session('status') }}</div>
        @endif

        <form wire:submit="save" class="space-y-4">
            @can('create user')
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
                    <input type="file" 
                           wire:model="profile_picture" 
                           accept="image/*" 
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    <p class="mt-1 text-xs text-gray-500">
                        Maximum file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF
                    </p>
                    @error('profile_picture') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                </div>
                
                <!-- Simple Preview -->
                @if ($profile_picture)
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Preview</h4>
                        <img src="{{ $profile_picture->temporaryUrl() }}" alt="Preview" class="h-20 w-20 rounded-full object-cover border-2 border-gray-300">
                    </div>
                @endif
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" wire:model="password" class="mt-1 block w-full border rounded px-3 py-2" />
                    @error('password') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" wire:model="password_confirmation" class="mt-1 block w-full border rounded px-3 py-2" />
                </div>
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
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Create</button>
            </div>
        </form>
            @endcan
    </div>
</div>


