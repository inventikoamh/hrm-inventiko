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

    protected function paginationTheme()
    {
        return 'tailwind';
    }
}; ?>

<div>
    <h2 class="font-semibold text-xl leading-tight mb-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-800', 'text-slate-100') }}">Permissions</h2>

    @if (session('status'))
        <div class="mb-3 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-700', 'text-green-300') }}">{{ session('status') }}</div>
    @endif

    <div class="flex items-center justify-between mb-4">
        <input type="text" wire:model.live="search" placeholder="Search permissions..." class="border rounded px-3 py-2 w-64 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
        @can('create permission')
            <a href="{{ route('admin.permissions.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded transition-colors duration-200 hover:bg-indigo-700">Create Permission</a>
        @endcan
    </div>

    <div class="overflow-x-auto rounded shadow transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
        <table class="min-w-full text-left">
            <thead>
            <tr class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">
                <th class="px-3 py-2">Permission</th>
                <th class="px-3 py-2">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($permissions as $perm)
                <tr class="border-t transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-700') }}">
                    <td class="px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">{{ $perm->name }}</td>
                    <td class="px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-400', 'text-slate-500') }}">—</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $permissions->links() }}</div>
</div>


