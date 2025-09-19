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
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $profile_picture = null;
    public array $selectedRoles = [];
    public array $roles = [];
    public bool $generate_random_password = false;
    public bool $send_welcome_email = false;

    public function mount(): void
    {
        $this->roles = Role::pluck('name')->all();
    }

    public function generateRandomPassword(): void
    {
        $this->password = $this->generatePassword();
        $this->password_confirmation = $this->password;
    }

    public function updateWelcomeEmailOption(): void
    {
        // If generating random password, automatically suggest sending welcome email
        if ($this->generate_random_password) {
            $this->send_welcome_email = true;
        }
    }

    private function generatePassword(): string
    {
        $length = 12;
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $password = '';
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $password;
    }

    public function save(): void
    {
        try {
            $validated = $this->validate([
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Password::defaults()],
                'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
                'selectedRoles' => ['array'],
                'generate_random_password' => ['boolean'],
                'send_welcome_email' => ['boolean'],
            ]);

            // Generate random password if requested
            $password = $this->password;
            if ($this->generate_random_password) {
                $password = $this->generatePassword();
            }

            $userData = [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'password' => $password,
            ];

            // Handle profile picture upload
            if ($this->profile_picture) {
                $userData['profile_picture'] = $this->profile_picture->store('profile-pictures', 'public');
            }

            $user = User::create($userData);

            if (!empty($this->selectedRoles)) {
                $user->assignRole($this->selectedRoles);
            }

            // Send welcome email if requested
            if ($this->send_welcome_email) {
                try {
                    \App\Models\Setting::configureMailSettings();
                    
                    \Mail::send('emails.welcome-user', [
                        'user' => $user,
                        'password' => $password
                    ], function ($message) use ($user) {
                        $message->to($user->email, $user->getFullName())
                                ->subject('Welcome to ' . \App\Models\Setting::getAppName() . ' - Your Account Details');
                    });
                    
                    session()->flash('status', 'User created successfully and welcome email sent.');
                } catch (\Exception $e) {
                    session()->flash('status', 'User created successfully, but failed to send welcome email: ' . $e->getMessage());
                }
            } else {
                session()->flash('status', 'User created successfully.');
            }
            
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">First Name</label>
                    <input type="text" wire:model="first_name" class="mt-1 block w-full border rounded px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
                    @error('first_name') <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600', 'text-red-400') }}">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Last Name</label>
                    <input type="text" wire:model="last_name" class="mt-1 block w-full border rounded px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
                    @error('last_name') <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600', 'text-red-400') }}">{{ $message }}</div> @enderror
                </div>
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
                    <div class="mt-1 flex">
                        <input type="password" wire:model="password" class="flex-1 border rounded-l px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
                        <button type="button" wire:click="generateRandomPassword" class="px-3 py-2 border border-l-0 rounded-r transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50 border-gray-300 text-gray-700 hover:bg-gray-100', 'bg-slate-600 border-slate-600 text-slate-300 hover:bg-slate-500') }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password') <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600', 'text-red-400') }}">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Confirm Password</label>
                    <input type="password" wire:model="password_confirmation" class="mt-1 block w-full border rounded px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
                </div>
            </div>

            <!-- Password and Email Options -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-50 border-blue-200', 'bg-blue-900/20 border-blue-700') }}">
                <h3 class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-800', 'text-blue-200') }} mb-3">
                    🔐 Password & Email Options
                </h3>
                
                <div class="space-y-3">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="generate_random_password" wire:change="updateWelcomeEmailOption" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300', 'bg-slate-700 border-slate-600') }}" />
                        <div>
                            <span class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-800', 'text-blue-200') }}">Generate Random Password</span>
                            <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-600', 'text-blue-300') }}">Automatically generate a secure 12-character password</p>
                        </div>
                    </label>
                    
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="send_welcome_email" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300', 'bg-slate-700 border-slate-600') }}" />
                        <div>
                            <span class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-800', 'text-blue-200') }}">Send Welcome Email</span>
                            <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-600', 'text-blue-300') }}">Send login credentials and welcome message to the user</p>
                        </div>
                    </label>
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


