<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

new #[Layout('layouts.app')] class extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $roleId): void
    {
        $role = Role::findOrFail($roleId);
        if ($role->name === 'admin') {
            session()->flash('error', 'Cannot delete admin role.');
            return;
        }
        $role->delete();
        session()->flash('status', 'Role deleted.');
    }

    public function with(): array
    {
        $roles = Role::query()
            ->when($this->search !== '', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('name')
            ->paginate(10);

        return compact('roles');
    }

    protected function paginationTheme()
    {
        return 'tailwind';
    }
}; ?>

<div>
    <h2 class="font-semibold text-xl leading-tight mb-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-800', 'text-slate-100') }}">Roles</h2>

    @if (session('status'))
        <div class="mb-3 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-700', 'text-green-300') }}">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-3 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-700', 'text-red-300') }}">{{ session('error') }}</div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <input type="text" wire:model.live="search" placeholder="Search roles..." class="border rounded px-3 py-2 w-64 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
        @can('create role')
            <a href="{{ route('admin.roles.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded transition-colors duration-200 hover:bg-indigo-700">Create Role</a>
        @endcan
    </div>

    <div class="overflow-x-auto rounded shadow transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
        <table class="min-w-full text-left">
            <thead>
            <tr class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">
                <th class="px-3 py-2">Role</th>
                <th class="px-3 py-2">Permissions</th>
                <th class="px-3 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr class="border-t transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-700') }}">
                    <td class="px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $role->name }}</td>
                    <td class="px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ $role->permissions->pluck('name')->implode(', ') ?: '—' }}</td>
                    <td class="px-3 py-2 space-x-2">
                        @can('view roles')
                            <a href="{{ route('admin.roles.edit', $role) }}" wire:navigate class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-indigo-600 hover:text-indigo-800', 'text-indigo-400 hover:text-indigo-300') }}">Edit</a>
                        @endcan
                        @can('delete roles')
                            <button wire:click="delete({{ $role->id }})" class="transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600 hover:text-red-800', 'text-red-400 hover:text-red-300') }}">Delete</button>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $roles->links() }}</div>
</div>


