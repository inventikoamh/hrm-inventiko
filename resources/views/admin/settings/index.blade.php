@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Settings</h1>
            <p class="mt-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">Configure application settings, branding, and system preferences</p>
        </div>

        <!-- Settings Tabs -->
        <div class="rounded-xl shadow-sm border transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-200', 'bg-slate-800 border-slate-700') }}">
            <div class="border-b transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-200', 'border-slate-600') }}">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button onclick="showTab('general')" id="general-tab" class="tab-button active py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-indigo-500 text-indigo-600', 'border-indigo-400 text-indigo-400') }}">
                        General
                    </button>
                    <button onclick="showTab('branding')" id="branding-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:text-gray-700 hover:border-gray-300', 'text-slate-400 hover:text-slate-300 hover:border-slate-500') }}">
                        Branding
                    </button>
                    <button onclick="showTab('theme')" id="theme-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:text-gray-700 hover:border-gray-300', 'text-slate-400 hover:text-slate-300 hover:border-slate-500') }}">
                        Theme
                    </button>
                    <button onclick="showTab('attendance')" id="attendance-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:text-gray-700 hover:border-gray-300', 'text-slate-400 hover:text-slate-300 hover:border-slate-500') }}">
                        Attendance
                    </button>
                    <button onclick="showTab('enums')" id="enums-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:text-gray-700 hover:border-gray-300', 'text-slate-400 hover:text-slate-300 hover:border-slate-500') }}">
                        Enums
                    </button>
                    <button onclick="showTab('colors')" id="colors-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:text-gray-700 hover:border-gray-300', 'text-slate-400 hover:text-slate-300 hover:border-slate-500') }}">
                        Colors
                    </button>
                    <button onclick="showTab('system')" id="system-tab" class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500 hover:text-gray-700 hover:border-gray-300', 'text-slate-400 hover:text-slate-300 hover:border-slate-500') }}">
                        System
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
                                <label for="app_name" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Application Name</label>
                                <input type="text" id="app_name" name="app_name" value="{{ old('app_name', \App\Models\Setting::get('app_name', 'ProjectFlow')) }}" 
                                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}">
                                @error('app_name')
                                    <p class="mt-1 text-sm text-red-600 transition-colors duration-200">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
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
                                <label for="logo" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Logo</label>
                                <div class="space-y-4">
                                    @if(\App\Models\Setting::get('logo'))
                                        <div class="flex items-center justify-between p-4 rounded-lg border transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50 border-gray-200', 'bg-slate-700 border-slate-600') }}">
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ Storage::url(\App\Models\Setting::get('logo')) }}" 
                                                     alt="Current Logo" 
                                                     class="h-16 w-auto object-contain rounded-lg shadow-sm">
                                                <div>
                                                    <p class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Current Logo</p>
                                                    <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Click to view full size</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('admin.settings.remove-file', 'logo') }}" 
                                               class="px-3 py-1 text-sm text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors duration-200">
                                                Remove
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" id="logo" name="logo" accept="image/*" 
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <p class="mt-1 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Upload a logo for your application (PNG, JPG, SVG, max 2MB)</p>
                            </div>

                            <!-- Favicon -->
                            <div>
                                <label for="favicon" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Favicon</label>
                                <div class="space-y-4">
                                    @if(\App\Models\Setting::get('favicon'))
                                        <div class="flex items-center justify-between p-4 rounded-lg border transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50 border-gray-200', 'bg-slate-700 border-slate-600') }}">
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ Storage::url(\App\Models\Setting::get('favicon')) }}" 
                                                     alt="Current Favicon" 
                                                     class="h-12 w-12 object-contain rounded-lg shadow-sm">
                                                <div>
                                                    <p class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Current Favicon</p>
                                                    <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">16x16 or 32x32 recommended</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('admin.settings.remove-file', 'favicon') }}" 
                                               class="px-3 py-1 text-sm text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors duration-200">
                                                Remove
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" id="favicon" name="favicon" accept="image/*" 
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <p class="mt-1 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Upload a favicon for your application (ICO, PNG, JPG, max 1MB)</p>
                            </div>

                            <!-- Login Background -->
                            <div>
                                <label for="login_background" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Login Background</label>
                                <div class="space-y-4">
                                    @if(\App\Models\Setting::get('login_background'))
                                        <div class="flex items-center justify-between p-4 rounded-lg border transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50 border-gray-200', 'bg-slate-700 border-slate-600') }}">
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ Storage::url(\App\Models\Setting::get('login_background')) }}" 
                                                     alt="Current Login Background" 
                                                     class="h-20 w-32 object-cover rounded-lg shadow-sm">
                                                <div>
                                                    <p class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Current Login Background</p>
                                                    <p class="text-xs transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Recommended: 1920x1080 or higher</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('admin.settings.remove-file', 'login_background') }}" 
                                               class="px-3 py-1 text-sm text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition-colors duration-200">
                                                Remove
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" id="login_background" name="login_background" accept="image/*" 
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                </div>
                                <p class="mt-1 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Upload a background image for the login page (PNG, JPG, SVG, max 5MB)</p>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
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
                                <label for="theme_color" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Primary Theme Color</label>
                                <div class="flex items-center space-x-4">
                                    <input type="color" id="theme_color" name="theme_color" 
                                           value="{{ old('theme_color', \App\Models\Setting::get('theme_color', '#3B82F6')) }}" 
                                           class="h-10 w-20 border rounded-lg cursor-pointer transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300', 'border-slate-600') }}">
                                    <input type="text" id="theme_color_text" 
                                           value="{{ old('theme_color', \App\Models\Setting::get('theme_color', '#3B82F6')) }}" 
                                           class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}">
                                </div>
                                <p class="mt-1 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Choose the primary color for your application theme</p>
                                @error('theme_color')
                                    <p class="mt-1 text-sm text-red-600 transition-colors duration-200">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
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
                                <label for="late_clock_in_time" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Late Clock In Time</label>
                                <input type="time" id="late_clock_in_time" name="late_clock_in_time" 
                                       value="{{ old('late_clock_in_time', \App\Models\Setting::get('late_clock_in_time', '11:30')) }}" 
                                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}">
                                <p class="mt-1 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Time after which clock in is considered late (24-hour format)</p>
                                @error('late_clock_in_time')
                                    <p class="mt-1 text-sm text-red-600 transition-colors duration-200">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="auto_clock_out_time" class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">Auto Clock Out Time</label>
                                <input type="time" id="auto_clock_out_time" name="auto_clock_out_time" 
                                       value="{{ old('auto_clock_out_time', \App\Models\Setting::get('auto_clock_out_time', '23:59')) }}" 
                                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}">
                                <p class="mt-1 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-500', 'text-slate-400') }}">Time when users are automatically clocked out if not manually clocked out (24-hour format)</p>
                                @error('auto_clock_out_time')
                                    <p class="mt-1 text-sm text-red-600 transition-colors duration-200">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
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
                                    <label class="block text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ $label }}</label>
                                    <div id="{{ $key }}-container">
                                        @php
                                            $values = \App\Models\Setting::getEnumValues($key);
                                        @endphp
                                        @foreach($values as $index => $value)
                                            <div class="flex items-center space-x-2 mb-2">
                                                <input type="text" name="{{ $key }}[]" value="{{ $value }}" 
                                                       class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300 bg-white text-gray-900', 'border-slate-600 bg-slate-700 text-slate-100') }}">
                                                <button type="button" onclick="removeEnumValue('{{ $key }}', this)" 
                                                        class="px-3 py-2 text-red-600 hover:text-red-800 transition-colors duration-200">
                                                    Remove
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" onclick="addEnumValue('{{ $key }}')" 
                                            class="mt-2 px-4 py-2 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-100 text-gray-700 hover:bg-gray-200', 'bg-slate-700 text-slate-300 hover:bg-slate-600') }}">
                                        Add {{ $label }}
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
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
                                    <label class="block text-sm font-medium mb-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ $label }} Colors</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @php
                                            $values = \App\Models\Setting::getEnumValues($key);
                                            $colors = \App\Models\Setting::getEnumColors($key);
                                        @endphp
                                        @foreach($values as $value)
                                            <div class="flex items-center space-x-3 p-3 rounded-lg transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50', 'bg-slate-700') }}">
                                                <div class="flex-shrink-0">
                                                    <div class="w-6 h-6 rounded-full border-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300', 'border-slate-600') }}" 
                                                         style="background-color: {{ \App\Models\Setting::getEnumColor($key, $value) }}"></div>
                                                </div>
                                                <div class="flex-1">
                                                    <label class="block text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}">{{ $value }}</label>
                                                    <input type="color" 
                                                           name="{{ $key }}_colors[{{ $value }}]" 
                                                           value="{{ \App\Models\Setting::getEnumColor($key, $value) }}"
                                                           class="mt-1 w-full h-8 border rounded cursor-pointer transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('border-gray-300', 'border-slate-600') }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-200">
                                Save Colors
                            </button>
                        </div>
                    </form>
                </div>

                <!-- System Settings Tab -->
                <div id="system-content" class="tab-content hidden">
                    <div class="space-y-6">
                        <!-- Migration Section -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-yellow-50 border-yellow-200', 'bg-yellow-900/20 border-yellow-700') }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-yellow-800', 'text-yellow-200') }}">
                                        Database Migration
                                    </h3>
                                    <div class="mt-2 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-yellow-700', 'text-yellow-300') }}">
                                        <p>Run database migrations to update your database schema. This is useful when deploying updates to your server.</p>
                                    </div>
                                    <div class="mt-4">
                                        <button type="button" onclick="runMigration()" 
                                                id="migration-btn"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-yellow-800 bg-yellow-100 hover:bg-yellow-200', 'text-yellow-200 bg-yellow-800 hover:bg-yellow-700') }}">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Run Migrations
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Migration Output -->
                        <div id="migration-output" class="hidden">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50 border-gray-200', 'bg-slate-800 border-slate-600') }}">
                                <h4 class="text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Migration Output:</h4>
                                <pre id="migration-result" class="text-xs font-mono whitespace-pre-wrap overflow-x-auto transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}"></pre>
                            </div>
                        </div>

                        <!-- Storage Link Section -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-blue-50 border-blue-200', 'bg-blue-900/20 border-blue-700') }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm8 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V8zm0 4a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1v-2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-800', 'text-blue-200') }}">
                                        Storage Link
                                    </h3>
                                    <div class="mt-2 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-700', 'text-blue-300') }}">
                                        <p>Create a symbolic link from public/storage to storage/app/public. This is required for file uploads and image display to work properly.</p>
                                    </div>
                                    <div class="mt-4">
                                        <button type="button" onclick="linkStorage()" 
                                                id="storage-btn"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-blue-800 bg-blue-100 hover:bg-blue-200', 'text-blue-200 bg-blue-800 hover:bg-blue-700') }}">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                            Link Storage
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Storage Link Output -->
                        <div id="storage-output" class="hidden">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50 border-gray-200', 'bg-slate-800 border-slate-600') }}">
                                <h4 class="text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Storage Link Output:</h4>
                                <pre id="storage-result" class="text-xs font-mono whitespace-pre-wrap overflow-x-auto transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}"></pre>
                            </div>
                        </div>

                        <!-- File Permissions Section -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-green-50 border-green-200', 'bg-green-900/20 border-green-700') }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-800', 'text-green-200') }}">
                                        Fix File Permissions
                                    </h3>
                                    <div class="mt-2 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-700', 'text-green-300') }}">
                                        <p>Fix file permissions for storage directory. This resolves 403 Forbidden errors when accessing uploaded files like profile pictures.</p>
                                    </div>
                                    <div class="mt-4">
                                        <button type="button" onclick="fixPermissions()" 
                                                id="permissions-btn"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-green-800 bg-green-100 hover:bg-green-200', 'text-green-200 bg-green-800 hover:bg-green-700') }}">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Fix Permissions
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Permissions Output -->
                        <div id="permissions-output" class="hidden">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50 border-gray-200', 'bg-slate-800 border-slate-600') }}">
                                <h4 class="text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Permissions Fix Output:</h4>
                                <pre id="permissions-result" class="text-xs font-mono whitespace-pre-wrap overflow-x-auto transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}"></pre>
                            </div>
                        </div>

                        <!-- Storage Status Section -->
                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-6 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-purple-50 border-purple-200', 'bg-purple-900/20 border-purple-700') }}">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-purple-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-purple-800', 'text-purple-200') }}">
                                        Check Storage Status
                                    </h3>
                                    <div class="mt-2 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-purple-700', 'text-purple-300') }}">
                                        <p>Check the current status of storage link and file accessibility. This helps diagnose why files might not be accessible via web.</p>
                                    </div>
                                    <div class="mt-4">
                                        <button type="button" onclick="checkStorageStatus()" 
                                                id="status-btn"
                                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-purple-800 bg-purple-100 hover:bg-purple-200', 'text-purple-200 bg-purple-800 hover:bg-purple-700') }}">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Check Status
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Storage Status Output -->
                        <div id="status-output" class="hidden">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-gray-50 border-gray-200', 'bg-slate-800 border-slate-600') }}">
                                <h4 class="text-sm font-medium mb-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Storage Status Output:</h4>
                                <pre id="status-result" class="text-xs font-mono whitespace-pre-wrap overflow-x-auto transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}"></pre>
                            </div>
                        </div>
                    </div>
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

function runMigration() {
    const btn = document.getElementById('migration-btn');
    const output = document.getElementById('migration-output');
    const result = document.getElementById('migration-result');
    
    // Disable button and show loading
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Running Migrations...
    `;
    
    // Show output area
    output.classList.remove('hidden');
    result.textContent = 'Starting migration...';
    
    // Make API call
    fetch('{{ route("admin.migrate") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            result.textContent = data.output || 'Migrations completed successfully!';
            result.className = result.className.replace('text-red-600', 'text-green-600');
            if (!result.className.includes('text-green-600')) {
                result.className += ' text-green-600';
            }
        } else {
            result.textContent = 'Error: ' + data.message;
            result.className = result.className.replace('text-green-600', 'text-red-600');
            if (!result.className.includes('text-red-600')) {
                result.className += ' text-red-600';
            }
        }
    })
    .catch(error => {
        result.textContent = 'Error: ' + error.message;
        result.className = result.className.replace('text-green-600', 'text-red-600');
        if (!result.className.includes('text-red-600')) {
            result.className += ' text-red-600';
        }
    })
    .finally(() => {
        // Re-enable button
        btn.disabled = false;
        btn.innerHTML = `
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Run Migrations
        `;
    });
}

function linkStorage() {
    const btn = document.getElementById('storage-btn');
    const output = document.getElementById('storage-output');
    const result = document.getElementById('storage-result');
    
    // Disable button and show loading
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Linking Storage...
    `;
    
    // Show output area
    output.classList.remove('hidden');
    result.textContent = 'Starting storage link...';
    
    // Make API call
    fetch('{{ route("admin.storage-link") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            result.textContent = data.output || 'Storage linked successfully!';
            result.className = result.className.replace('text-red-600', 'text-green-600');
            if (!result.className.includes('text-green-600')) {
                result.className += ' text-green-600';
            }
        } else {
            result.textContent = 'Error: ' + data.message;
            result.className = result.className.replace('text-green-600', 'text-red-600');
            if (!result.className.includes('text-red-600')) {
                result.className += ' text-red-600';
            }
        }
    })
    .catch(error => {
        result.textContent = 'Error: ' + error.message;
        result.className = result.className.replace('text-green-600', 'text-red-600');
        if (!result.className.includes('text-red-600')) {
            result.className += ' text-red-600';
        }
    })
    .finally(() => {
        // Re-enable button
        btn.disabled = false;
        btn.innerHTML = `
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
            </svg>
            Link Storage
        `;
    });
}

function fixPermissions() {
    const btn = document.getElementById('permissions-btn');
    const output = document.getElementById('permissions-output');
    const result = document.getElementById('permissions-result');
    
    // Disable button and show loading
    btn.disabled = true;
    btn.innerHTML = `
        <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Fixing Permissions...
    `;
    
    // Show output area
    output.classList.remove('hidden');
    result.textContent = 'Starting permissions fix...';
    
    // Make API call
    fetch('{{ route("admin.fix-permissions") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            result.textContent = data.output || 'Permissions fixed successfully!';
            result.className = result.className.replace('text-red-600', 'text-green-600');
            if (!result.className.includes('text-green-600')) {
                result.className += ' text-green-600';
            }
        } else {
            result.textContent = 'Error: ' + data.message;
            result.className = result.className.replace('text-green-600', 'text-red-600');
            if (!result.className.includes('text-red-600')) {
                result.className += ' text-red-600';
            }
        }
    })
    .catch(error => {
        result.textContent = 'Error: ' + error.message;
        result.className = result.className.replace('text-green-600', 'text-red-600');
        if (!result.className.includes('text-red-600')) {
            result.className += ' text-red-600';
        }
    })
    .finally(() => {
        // Re-enable button
        btn.disabled = false;
        btn.innerHTML = `
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Fix Permissions
        `;
    });
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

// Auto-refresh page when theme changes
document.addEventListener('DOMContentLoaded', function() {
    const themeRadios = document.querySelectorAll('input[name="theme_mode"]');
    const themeLabels = document.querySelectorAll('label[for*="theme_mode"]');
    let isProcessing = false;
    let lastChange = 0;
    
    themeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked && !isProcessing && Date.now() - lastChange > 500) {
                isProcessing = true;
                lastChange = Date.now();
                // Show loading state
                themeLabels.forEach(label => {
                    label.style.opacity = '0.5';
                    label.style.pointerEvents = 'none';
                });
                
                // Add loading indicator
                const loadingDiv = document.createElement('div');
                loadingDiv.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                loadingDiv.innerHTML = '<div class="bg-white rounded-lg p-6 flex items-center space-x-3"><div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div><span class="text-gray-700">Applying theme...</span></div>';
                document.body.appendChild(loadingDiv);
                
                // Submit the form to save the theme preference
                const form = this.closest('form');
                if (form) {
                    // Create a temporary form submission
                    const formData = new FormData(form);
                    formData.set('theme_mode', this.value);
                    
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(() => {
                        // Small delay to ensure the theme preference is saved
                        setTimeout(() => {
                            window.location.reload();
                        }, 100);
                    }).catch(error => {
                        console.error('Error saving theme preference:', error);
                        // Remove loading indicator
                        document.body.removeChild(loadingDiv);
                        // Reset theme labels
                        themeLabels.forEach(label => {
                            label.style.opacity = '1';
                            label.style.pointerEvents = 'auto';
                        });
                        isProcessing = false;
                        // Still reload the page even if there's an error
                        setTimeout(() => {
                            window.location.reload();
                        }, 100);
                    });
                }
            }
        });
    });
});
</script>
        </div>
    </div>
@endsection
