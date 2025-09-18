@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
            <p class="mt-2 text-gray-600">Configure application settings, branding, and system preferences</p>
        </div>

        <!-- Settings Tabs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button onclick="showTab('general')" id="general-tab" class="tab-button active py-4 px-1 border-b-2 border-indigo-500 font-medium text-sm text-indigo-600">
                        General
                    </button>
                    <button onclick="showTab('branding')" id="branding-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Branding
                    </button>
                    <button onclick="showTab('theme')" id="theme-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Theme
                    </button>
                    <button onclick="showTab('attendance')" id="attendance-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Attendance
                    </button>
                    <button onclick="showTab('enums')" id="enums-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Enums
                    </button>
                    <button onclick="showTab('colors')" id="colors-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Colors
                    </button>
                </nav>
            </div>

            <div class="p-6">
                <!-- General Settings Tab -->
                <div id="general-content" class="tab-content">
                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="app_name" class="block text-sm font-medium text-gray-700 mb-2">Application Name</label>
                                <input type="text" id="app_name" name="app_name" value="{{ old('app_name', \App\Models\Setting::get('app_name', 'ProjectFlow')) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('app_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Branding Settings Tab -->
                <div id="branding-content" class="tab-content hidden">
                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <!-- Logo -->
                            <div>
                                <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                                <div class="space-y-4">
                                    @if(\App\Models\Setting::get('logo'))
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border">
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ Storage::url(\App\Models\Setting::get('logo')) }}" 
                                                     alt="Current Logo" 
                                                     class="h-16 w-auto object-contain rounded-lg shadow-sm">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Current Logo</p>
                                                    <p class="text-xs text-gray-500">Click to view full size</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('admin.settings.remove-file', 'logo') }}" 
                                               class="px-3 py-1 text-sm text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors">
                                                Remove
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" id="logo" name="logo" accept="image/*" 
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Upload a logo for your application (PNG, JPG, SVG, max 2MB)</p>
                            </div>

                            <!-- Favicon -->
                            <div>
                                <label for="favicon" class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                                <div class="space-y-4">
                                    @if(\App\Models\Setting::get('favicon'))
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border">
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ Storage::url(\App\Models\Setting::get('favicon')) }}" 
                                                     alt="Current Favicon" 
                                                     class="h-12 w-12 object-contain rounded-lg shadow-sm">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Current Favicon</p>
                                                    <p class="text-xs text-gray-500">16x16 or 32x32 recommended</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('admin.settings.remove-file', 'favicon') }}" 
                                               class="px-3 py-1 text-sm text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors">
                                                Remove
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" id="favicon" name="favicon" accept="image/*" 
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Upload a favicon for your application (ICO, PNG, JPG, max 1MB)</p>
                            </div>

                            <!-- Login Background -->
                            <div>
                                <label for="login_background" class="block text-sm font-medium text-gray-700 mb-2">Login Background</label>
                                <div class="space-y-4">
                                    @if(\App\Models\Setting::get('login_background'))
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border">
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ Storage::url(\App\Models\Setting::get('login_background')) }}" 
                                                     alt="Current Login Background" 
                                                     class="h-20 w-32 object-cover rounded-lg shadow-sm">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Current Login Background</p>
                                                    <p class="text-xs text-gray-500">Recommended: 1920x1080 or higher</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('admin.settings.remove-file', 'login_background') }}" 
                                               class="px-3 py-1 text-sm text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors">
                                                Remove
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" id="login_background" name="login_background" accept="image/*" 
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Upload a background image for the login page (PNG, JPG, SVG, max 5MB)</p>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Theme Settings Tab -->
                <div id="theme-content" class="tab-content hidden">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="theme_color" class="block text-sm font-medium text-gray-700 mb-2">Primary Theme Color</label>
                                <div class="flex items-center space-x-4">
                                    <input type="color" id="theme_color" name="theme_color" 
                                           value="{{ old('theme_color', \App\Models\Setting::get('theme_color', '#3B82F6')) }}" 
                                           class="h-10 w-20 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" id="theme_color_text" 
                                           value="{{ old('theme_color', \App\Models\Setting::get('theme_color', '#3B82F6')) }}" 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Choose the primary color for your application theme</p>
                                @error('theme_color')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Attendance Settings Tab -->
                <div id="attendance-content" class="tab-content hidden">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="late_clock_in_time" class="block text-sm font-medium text-gray-700 mb-2">Late Clock In Time</label>
                                <input type="time" id="late_clock_in_time" name="late_clock_in_time" 
                                       value="{{ old('late_clock_in_time', \App\Models\Setting::get('late_clock_in_time', '11:30')) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="mt-1 text-sm text-gray-500">Time after which clock in is considered late (24-hour format)</p>
                                @error('late_clock_in_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="auto_clock_out_time" class="block text-sm font-medium text-gray-700 mb-2">Auto Clock Out Time</label>
                                <input type="time" id="auto_clock_out_time" name="auto_clock_out_time" 
                                       value="{{ old('auto_clock_out_time', \App\Models\Setting::get('auto_clock_out_time', '23:59')) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="mt-1 text-sm text-gray-500">Time when users are automatically clocked out if not manually clocked out (24-hour format)</p>
                                @error('auto_clock_out_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Enums Settings Tab -->
                <div id="enums-content" class="tab-content hidden">
                    <form method="POST" action="{{ route('admin.settings.update-enums') }}">
                        @csrf
                        <div class="space-y-8">
                            @php
                                $enumTypes = [
                                    'task_priority' => 'Task Priority',
                                    'task_status' => 'Task Status', 
                                    'project_status' => 'Project Status',
                                    'client_status' => 'Client Status',
                                    'leave_type' => 'Leave Type',
                                    'attendance_status' => 'Attendance Status',
                                ];
                            @endphp

                            @foreach($enumTypes as $key => $label)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
                                    <div id="{{ $key }}-container">
                                        @php
                                            $values = \App\Models\Setting::getEnumValues($key);
                                        @endphp
                                        @foreach($values as $index => $value)
                                            <div class="flex items-center space-x-2 mb-2">
                                                <input type="text" name="{{ $key }}[]" value="{{ $value }}" 
                                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <button type="button" onclick="removeEnumValue('{{ $key }}', this)" 
                                                        class="px-3 py-2 text-red-600 hover:text-red-800">
                                                    Remove
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" onclick="addEnumValue('{{ $key }}')" 
                                            class="mt-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                        Add {{ $label }}
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Colors Settings Tab -->
                <div id="colors-content" class="tab-content hidden">
                    <form method="POST" action="{{ route('admin.settings.update-colors') }}">
                        @csrf
                        <div class="space-y-8">
                            @php
                                $colorTypes = [
                                    'task_priority' => 'Task Priority',
                                    'task_status' => 'Task Status', 
                                    'project_status' => 'Project Status',
                                    'client_status' => 'Client Status',
                                    'leave_type' => 'Leave Type',
                                    'attendance_status' => 'Attendance Status',
                                ];
                            @endphp

                            @foreach($colorTypes as $key => $label)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-4">{{ $label }} Colors</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @php
                                            $values = \App\Models\Setting::getEnumValues($key);
                                            $colors = \App\Models\Setting::getEnumColors($key);
                                        @endphp
                                        @foreach($values as $value)
                                            <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                                <div class="flex-shrink-0">
                                                    <div class="w-6 h-6 rounded-full border-2 border-gray-300" 
                                                         style="background-color: {{ \App\Models\Setting::getEnumColor($key, $value) }}"></div>
                                                </div>
                                                <div class="flex-1">
                                                    <label class="block text-sm font-medium text-gray-700">{{ $value }}</label>
                                                    <input type="color" 
                                                           name="{{ $key }}_colors[{{ $value }}]" 
                                                           value="{{ \App\Models\Setting::getEnumColor($key, $value) }}"
                                                           class="mt-1 w-full h-8 border border-gray-300 rounded cursor-pointer">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Save Colors
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-indigo-500', 'text-indigo-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.add('active', 'border-indigo-500', 'text-indigo-600');
    activeTab.classList.remove('border-transparent', 'text-gray-500');
}

function addEnumValue(enumType) {
    const container = document.getElementById(enumType + '-container');
    const div = document.createElement('div');
    div.className = 'flex items-center space-x-2 mb-2';
    div.innerHTML = `
        <input type="text" name="${enumType}[]" value="" 
               class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <button type="button" onclick="removeEnumValue('${enumType}', this)" 
                class="px-3 py-2 text-red-600 hover:text-red-800">
            Remove
        </button>
    `;
    container.appendChild(div);
}

function removeEnumValue(enumType, button) {
    button.parentElement.remove();
}

// Sync color picker with text input
document.getElementById('theme_color').addEventListener('input', function() {
    document.getElementById('theme_color_text').value = this.value;
});

document.getElementById('theme_color_text').addEventListener('input', function() {
    if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
        document.getElementById('theme_color').value = this.value;
    }
});
</script>
        </div>
    </div>
@endsection
