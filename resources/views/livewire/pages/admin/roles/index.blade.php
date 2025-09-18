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
}; ?>

<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Roles</h2>

    @if (session('status'))
        <div class="mb-3 text-green-700">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-3 text-red-700">{{ session('error') }}</div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <input type="text" wire:model.live="search" placeholder="Search roles..." class="border rounded px-3 py-2 w-64" />
        @can('create role')
            <a href="{{ route('admin.roles.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded">Create Role</a>
        @endcan
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-left">
            <thead>
            <tr class="text-gray-500 text-sm">
                <th class="px-3 py-2">Role</th>
                <th class="px-3 py-2">Permissions</th>
                <th class="px-3 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($roles as $role)
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $role->name }}</td>
                    <td class="px-3 py-2">{{ $role->permissions->pluck('name')->implode(', ') ?: '—' }}</td>
                    <td class="px-3 py-2 space-x-2">
                        @can('view roles')
                            <a href="{{ route('admin.roles.edit', $role) }}" wire:navigate class="text-indigo-600">Edit</a>
                        @endcan
                        @can('delete roles')
                            <button wire:click="delete({{ $role->id }})" class="text-red-600">Delete</button>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $roles->links() }}</div>
</div>


