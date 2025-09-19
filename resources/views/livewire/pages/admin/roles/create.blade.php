<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

new #[Layout('layouts.app')] class extends Component
{
    public string $name = '';
    public array $selectedPermissions = [];
    public array $permissions = [];

    public function mount(): void
    {
        $this->permissions = Permission::orderBy('name')->pluck('name')->all();
    }

    public function getPermissionGroups(): array
    {
        $allPermissions = Permission::orderBy('name')->get();
        
        $groups = [
            'User Management' => [],
            'Role & Permission Management' => [],
            'Leave Management' => [],
            'Project Management' => [],
            'Client Management' => [],
            'Lead Management' => [],
            'Task Management' => []
        ];

        foreach ($allPermissions as $permission) {
            $name = $permission->name;
            
            if (str_contains($name, 'user') && !str_contains($name, 'leave')) {
                $groups['User Management'][] = $permission;
            } elseif (str_contains($name, 'role') || str_contains($name, 'permission')) {
                $groups['Role & Permission Management'][] = $permission;
            } elseif (str_contains($name, 'leave') || str_contains($name, 'approve') || str_contains($name, 'attendance')) {
                $groups['Leave Management'][] = $permission;
            } elseif (str_contains($name, 'project')) {
                $groups['Project Management'][] = $permission;
            } elseif (str_contains($name, 'client')) {
                $groups['Client Management'][] = $permission;
            } elseif (str_contains($name, 'lead') || str_contains($name, 'convert') || str_contains($name, 'remark')) {
                $groups['Lead Management'][] = $permission;
            } elseif (str_contains($name, 'task') || str_contains($name, 'assign') || str_contains($name, 'complete')) {
                $groups['Task Management'][] = $permission;
            }
        }

        return $groups;
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'selectedPermissions' => ['array']
        ]);

        $role = Role::create(['name' => $this->name]);
        if (!empty($this->selectedPermissions)) {
            $role->givePermissionTo($this->selectedPermissions);
        }

        session()->flash('status', 'Role created.');
        $this->redirectRoute('admin.roles.index', navigate: true);
    }
}; ?>

<div>
    <h2 class="font-semibold text-xl leading-tight mb-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-800', 'text-slate-100') }}">Create Role</h2>

    <div class="p-6 rounded shadow max-w-2xl transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white', 'bg-slate-800') }}">
        @can('create role')
        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Name</label>
                <input type="text" wire:model.live="name" class="mt-1 block w-full border rounded px-3 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-700 border-slate-600 text-slate-100 placeholder-slate-400') }}" />
                @error('name') <div class="text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-red-600', 'text-red-400') }}">{{ $message }}</div> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }} mb-4">Permissions</label>
                <div class="space-y-6">
                    @foreach($this->getPermissionGroups() as $groupName => $permissions)
                        @if(count($permissions) > 0)
                            <div class="border rounded-lg p-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-600') }}">
                                <h3 class="text-lg font-semibold mb-3 flex items-center transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-800', 'text-slate-100') }}">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $groupName }}
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach($permissions as $permission)
                                        <label class="flex items-center gap-3 p-2 rounded-md transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('hover:bg-gray-50', 'hover:bg-slate-700') }}">
                                            <input type="checkbox" 
                                                   value="{{ $permission->name }}" 
                                                   wire:model.live="selectedPermissions"
                                                   class="w-4 h-4 text-indigo-600 rounded focus:ring-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300', 'bg-slate-700 border-slate-600') }}" />
                                            <span class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ ucwords(str_replace('_', ' ', $permission->name)) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.roles.index') }}" wire:navigate class="px-4 py-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700 hover:text-gray-900', 'text-slate-300 hover:text-slate-100') }}">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded transition-colors duration-200 hover:bg-indigo-700">Create</button>
            </div>
        </form>
        @endcan
    </div>
</div>


