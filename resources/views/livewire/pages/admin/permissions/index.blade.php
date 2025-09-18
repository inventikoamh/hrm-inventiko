<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

new #[Layout('layouts.app')] class extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // Permissions cannot be deleted

    public function with(): array
    {
        $permissions = Permission::query()
            ->when($this->search !== '', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('name')
            ->paginate(10);

        return compact('permissions');
    }
}; ?>

<div>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Permissions</h2>

    @if (session('status'))
        <div class="mb-3 text-green-700">{{ session('status') }}</div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <input type="text" wire:model.live="search" placeholder="Search permissions..." class="border rounded px-3 py-2 w-64" />
        @can('create permission')
            <a href="{{ route('admin.permissions.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded">Create Permission</a>
        @endcan
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-left">
            <thead>
            <tr class="text-gray-500 text-sm">
                <th class="px-3 py-2">Permission</th>
                <th class="px-3 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($permissions as $perm)
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $perm->name }}</td>
                    <td class="px-3 py-2 text-gray-400">—</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $permissions->links() }}</div>
</div>


