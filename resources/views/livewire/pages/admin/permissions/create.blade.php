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
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">Create Permission</h2>

    <div class="bg-white p-6 rounded shadow max-w-md">
        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" wire:model.live="name" class="mt-1 block w-full border rounded px-3 py-2" />
                @error('name') <div class="text-sm text-red-600">{{ $message }}</div> @enderror
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.permissions.index') }}" wire:navigate class="px-4 py-2">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Create</button>
            </div>
        </form>
    </div>
</div>


