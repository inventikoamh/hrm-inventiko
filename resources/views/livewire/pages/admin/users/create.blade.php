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
    <h2 class="font-semibold text-xl leading-tight mb-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-800', 'text-slate-100') }}">Create User</h2>

    <div class="p-6 rounded shadow max-w-2xl transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
        @if (session('status'))
            <div class="mb-3 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-700', 'text-green-300') }}">{{ session('status') }}</div>
        @endif

        <form wire:submit="save" class="space-y-4">
            @can('create user')
            <div>
                <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Name</label>
                <input type="text" wire:model="name" class="mt-1 block w-full border rounded px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
                @error('name') <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600', 'text-red-400') }}">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Email</label>
                <input type="email" wire:model="email" class="mt-1 block w-full border rounded px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
                @error('email') <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600', 'text-red-400') }}">{{ $message }}</div> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Profile Picture</label>
                <div class="mt-1">
                    <input type="file" 
                           wire:model="profile_picture" 
                           accept="image/*" 
                           class="block w-full text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100', 'text-slate-300 file:bg-slate-700 file:text-slate-100 hover:file:bg-slate-600') }} file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold" />
                    <p class="mt-1 text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">
                        Maximum file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF
                    </p>
                    @error('profile_picture') <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600', 'text-red-400') }}">{{ $message }}</div> @enderror
                </div>
                
                <!-- Simple Preview -->
                @if ($profile_picture)
                    <div class="mt-4">
                        <h4 class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }} mb-2">Preview</h4>
                        <img src="{{ $profile_picture->temporaryUrl() }}" alt="Preview" class="h-20 w-20 rounded-full object-cover border-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300', 'border-slate-600') }}">
                    </div>
                @endif
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Password</label>
                    <input type="password" wire:model="password" class="mt-1 block w-full border rounded px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
                    @error('password') <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600', 'text-red-400') }}">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Confirm Password</label>
                    <input type="password" wire:model="password_confirmation" class="mt-1 block w-full border rounded px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Assign Roles</label>
                <div class="mt-2 space-y-2">
                    @foreach($roles as $role)
                        <label class="flex items-center gap-2">
                            <input type="checkbox" value="{{ $role }}" wire:model="selectedRoles" class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-indigo-600', 'bg-slate-700 border-slate-600 text-indigo-600') }}" />
                            <span class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ $role }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.users.index') }}" wire:navigate class="px-4 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700 hover:text-gray-900', 'text-slate-300 hover:text-slate-100') }}">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded transition-colors duration-200 hover:bg-indigo-700">Create</button>
            </div>
        </form>
            @endcan
    </div>
</div>


