<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Spatie\Permission\Models\Permission;

new #[Layout('layouts.app')] class extends Component
{
    public string $name = '';

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ]);

        Permission::create(['name' => $this->name]);
        session()->flash('status', 'Permission created.');
        $this->redirectRoute('admin.permissions.index', navigate: true);
    }
}; ?>

<div>
    <h2 class="font-semibold text-xl leading-tight mb-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-800', 'text-slate-100') }}">Create Permission</h2>

    <div class="p-6 rounded shadow max-w-md transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Name</label>
                <input type="text" wire:model.live="name" class="mt-1 block w-full border rounded px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
                @error('name') <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600', 'text-red-400') }}">{{ $message }}</div> @enderror
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.permissions.index') }}" wire:navigate class="px-4 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700 hover:text-gray-900', 'text-slate-300 hover:text-slate-100') }}">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded transition-colors duration-200 hover:bg-indigo-700">Create</button>
            </div>
        </form>
    </div>
</div>


