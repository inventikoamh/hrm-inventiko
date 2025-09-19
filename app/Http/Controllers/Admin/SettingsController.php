<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('label')->get()->groupBy('group');
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Determine which form is being submitted based on the fields present
        $rules = [];
        
        if ($request->has('app_name')) {
            $rules['app_name'] = 'required|string|max:255';
        }
        
        if ($request->has('theme_color')) {
            $rules['theme_color'] = 'required|string|regex:/^#[0-9A-Fa-f]{6}$/';
        }
        
        if ($request->has('late_clock_in_time')) {
            $rules['late_clock_in_time'] = 'required|string|date_format:H:i';
        }
        
        if ($request->has('auto_clock_out_time')) {
            $rules['auto_clock_out_time'] = 'required|string|date_format:H:i';
        }
        
        if ($request->hasFile('logo')) {
            $rules['logo'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }
        
        if ($request->hasFile('favicon')) {
            $rules['favicon'] = 'image|mimes:ico,png,jpg,jpeg,gif,svg|max:1024';
        }
        
        if ($request->hasFile('login_background')) {
            $rules['login_background'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:5120';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update settings based on what's present in the request
        if ($request->has('app_name')) {
            Setting::set('app_name', $request->app_name, 'string', 'general', 'Application Name', 'The display name of the application');
        }
        
        if ($request->has('theme_color')) {
            Setting::set('theme_color', $request->theme_color, 'string', 'theme', 'Theme Color', 'Primary color for the application theme');
        }
        
        if ($request->has('theme_mode')) {
            // Update user's theme preference instead of global setting
            if (auth()->check()) {
                auth()->user()->setThemePreference($request->theme_mode);
            }
        }
        
        if ($request->has('late_clock_in_time')) {
            Setting::set('late_clock_in_time', $request->late_clock_in_time, 'string', 'attendance', 'Late Clock In Time', 'Time after which clock in is considered late (24-hour format)');
        }
        
        if ($request->has('auto_clock_out_time')) {
            Setting::set('auto_clock_out_time', $request->auto_clock_out_time, 'string', 'attendance', 'Auto Clock Out Time', 'Time when users are automatically clocked out if not manually clocked out (24-hour format)');
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('settings', 'public');
            Setting::set('logo', $logoPath, 'file', 'branding', 'Logo', 'Application logo');
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('settings', 'public');
            Setting::set('favicon', $faviconPath, 'file', 'branding', 'Favicon', 'Application favicon');
        }

        // Handle login background upload
        if ($request->hasFile('login_background')) {
            $loginBgPath = $request->file('login_background')->store('settings', 'public');
            Setting::set('login_background', $loginBgPath, 'file', 'branding', 'Login Background', 'Background image for login page');
        }

        // Clear all settings cache
        Setting::clearCache();

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    public function updateEnums(Request $request)
    {
        $enumTypes = [
            'task_priority' => 'Task Priority',
            'task_status' => 'Task Status',
            'project_status' => 'Project Status',
            'client_status' => 'Client Status',
            'leave_type' => 'Leave Type',
            'attendance_status' => 'Attendance Status',
        ];

        foreach ($enumTypes as $key => $label) {
            if ($request->has($key)) {
                $values = array_filter($request->input($key, []));
                Setting::setEnumValues($key, $values);
            }
        }

        // Clear all settings cache
        Setting::clearCache();

        return redirect()->back()->with('success', 'Enum values updated successfully!');
    }

    public function updateColors(Request $request)
    {
        $colorTypes = [
            'task_priority' => 'Task Priority',
            'task_status' => 'Task Status',
            'project_status' => 'Project Status',
            'client_status' => 'Client Status',
            'leave_type' => 'Leave Type',
            'attendance_status' => 'Attendance Status',
        ];

        foreach ($colorTypes as $key => $label) {
            if ($request->has($key . '_colors')) {
                $colors = $request->input($key . '_colors', []);
                // Filter out empty values and validate hex colors
                $validColors = [];
                foreach ($colors as $enumValue => $color) {
                    if (!empty($color) && preg_match('/^#[0-9A-Fa-f]{6}$/', $color)) {
                        $validColors[$enumValue] = $color;
                    }
                }
                Setting::setEnumColors($key, $validColors);
            }
        }

        // Clear all settings cache
        Setting::clearCache();

        return redirect()->back()->with('success', 'Enum colors updated successfully!');
    }

    public function removeFile($type)
    {
        $setting = Setting::where('key', $type)->first();
        
        if ($setting && $setting->value) {
            Storage::disk('public')->delete($setting->value);
            $setting->update(['value' => null]);
            Setting::clearCache();
        }

        return redirect()->back()->with('success', ucfirst(str_replace('_', ' ', $type)) . ' removed successfully!');
    }
}