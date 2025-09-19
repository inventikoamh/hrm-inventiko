<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

new #[Layout('layouts.app')] class extends Component
{
    use WithPagination;

    public string $search = '';
    public array $roles = [];
    public ?int $editingUserId = null;
    public array $editingRoles = [];

    public function mount(): void
    {
        $this->roles = Role::pluck('name')->all();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function editRoles(int $userId): void
    {
        $this->editingUserId = $userId;
        $user = User::findOrFail($userId);
        $this->editingRoles = $user->getRoleNames()->toArray();
    }

    public function saveRoles(): void
    {
        if (!$this->editingUserId) return;
        $user = User::findOrFail($this->editingUserId);
        $user->syncRoles($this->editingRoles);
        $this->editingUserId = null;
        $this->editingRoles = [];
        session()->flash('status', 'Roles updated.');
    }

    public function delete(int $userId): void
    {
        if (auth()->id() === $userId) {
            session()->flash('error', 'You cannot delete yourself.');
            return;
        }
        User::findOrFail($userId)->delete();
        session()->flash('status', 'User deleted.');
        $this->resetPage();
    }
    public function with(): array
    {
        $users = User::query()
            ->when($this->search !== '', function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByDesc('id')
            ->paginate(10);

        return [
            'users' => $users,
        ];
    }

    protected function paginationTheme()
    {
        return 'tailwind';
    }
}; ?>

<div>
    <h2 class="font-semibold text-xl leading-tight mb-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-800', 'text-slate-100') }}">Manage Users</h2>

    <div class="p-4 rounded shadow transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
        @if (session('status'))
            <div class="mb-3 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-700', 'text-green-300') }}">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-3 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-700', 'text-red-300') }}">{{ session('error') }}</div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <input type="text" wire:model.live="search" placeholder="Search users..." class="border rounded px-3 py-2 w-64 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
            @can('create user')
                <a href="{{ route('admin.users.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded transition-colors duration-200 hover:bg-indigo-700">Create User</a>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                <tr class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">
                    <th class="px-3 py-2">User</th>
                    <th class="px-3 py-2">Email</th>
                    <th class="px-3 py-2">Roles</th>
                    <th class="px-3 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="border-t transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-700') }}">
                        <td class="px-3 py-2">
                            <div class="flex items-center space-x-3">
                                @if($user->profile_picture)
                                    <img src="{{ $user->profile_picture_url }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <img src="{{ $user->getDefaultProfilePicture() }}" alt="{{ $user->name }}" class="h-10 w-10 rounded-full object-cover">
                                @endif
                                <div>
                                    <div class="font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ $user->email }}</td>
                        <td class="px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ $user->getRoleNames()->implode(', ') ?: '—' }}</td>
                        <td class="px-3 py-2 space-x-2">
                            @can('edit user')
                                <a href="{{ route('admin.users.edit', $user) }}" wire:navigate class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-600 hover:text-blue-800', 'text-blue-400 hover:text-blue-300') }}">Edit</a>
                            @endcan
                            @can('delete user')
                                <button wire:click="delete({{ $user->id }})" class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600 hover:text-red-800', 'text-red-400 hover:text-red-300') }}">Delete</button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $users->links() }}</div>
    </div>

    <x-modal name="edit-roles" :show="$editingUserId !== null" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Assign Roles</h2>
            <div class="mt-4 space-y-2">
                @foreach($roles as $role)
                    <label class="flex items-center gap-2">
                        <input type="checkbox" value="{{ $role }}" wire:model.live="editingRoles" class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-indigo-600', 'bg-slate-700 border-slate-600 text-indigo-600') }}" />
                        <span class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ $role }}</span>
                    </label>
                @endforeach
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <button class="px-4 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700 hover:text-gray-900', 'text-slate-300 hover:text-slate-100') }}" wire:click="$set('editingUserId', null)">Cancel</button>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded transition-colors duration-200 hover:bg-indigo-700" wire:click="saveRoles">Save</button>
            </div>
        </div>
    </x-modal>
    
</div>


