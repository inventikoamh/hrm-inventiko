<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

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
        
        // SMTP validation rules
        if ($request->has('mail_mailer')) {
            $rules['mail_mailer'] = 'required|string|in:smtp,sendmail,mailgun,ses,postmark,resend,log,array';
        }
        
        if ($request->has('mail_host')) {
            $rules['mail_host'] = 'required|string|max:255';
        }
        
        if ($request->has('mail_port')) {
            $rules['mail_port'] = 'required|integer|min:1|max:65535';
        }
        
        if ($request->has('mail_username')) {
            $rules['mail_username'] = 'nullable|string|max:255';
        }
        
        if ($request->has('mail_password')) {
            $rules['mail_password'] = 'nullable|string|max:255';
        }
        
        if ($request->has('mail_encryption')) {
            $rules['mail_encryption'] = 'nullable|string|in:tls,ssl,null';
        }
        
        if ($request->has('mail_from_address')) {
            $rules['mail_from_address'] = 'required|email|max:255';
        }
        
        if ($request->has('mail_from_name')) {
            $rules['mail_from_name'] = 'required|string|max:255';
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
        
        // Handle SMTP settings
        if ($request->has('mail_mailer')) {
            Setting::set('mail_mailer', $request->mail_mailer, 'string', 'mail', 'Mail Driver', 'The mail driver to use for sending emails');
        }
        
        if ($request->has('mail_host')) {
            Setting::set('mail_host', $request->mail_host, 'string', 'mail', 'SMTP Host', 'The SMTP server hostname');
        }
        
        if ($request->has('mail_port')) {
            Setting::set('mail_port', $request->mail_port, 'integer', 'mail', 'SMTP Port', 'The SMTP server port number');
        }
        
        if ($request->has('mail_username')) {
            Setting::set('mail_username', $request->mail_username, 'string', 'mail', 'SMTP Username', 'The SMTP username for authentication');
        }
        
        if ($request->has('mail_password')) {
            Setting::set('mail_password', $request->mail_password, 'string', 'mail', 'SMTP Password', 'The SMTP password for authentication');
        }
        
        if ($request->has('mail_encryption')) {
            Setting::set('mail_encryption', $request->mail_encryption, 'string', 'mail', 'SMTP Encryption', 'The encryption method for SMTP (tls, ssl, or null)');
        }
        
        if ($request->has('mail_from_address')) {
            Setting::set('mail_from_address', $request->mail_from_address, 'string', 'mail', 'From Email Address', 'The default email address to send emails from');
        }
        
        if ($request->has('mail_from_name')) {
            Setting::set('mail_from_name', $request->mail_from_name, 'string', 'mail', 'From Name', 'The default name to send emails from');
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
    
    public function testMail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email|max:255'
        ]);
        
        try {
            // Configure mail settings using the helper method
            $mailSettings = Setting::configureMailSettings();
            
            // Send test email
            Mail::raw('This is a test email from ProjectFlow CRM. If you receive this email, your SMTP configuration is working correctly!', function ($message) use ($request, $mailSettings) {
                $message->to($request->test_email)
                        ->subject('Test Email from ProjectFlow CRM')
                        ->from($mailSettings['mail_from_address'], $mailSettings['mail_from_name']);
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully to ' . $request->test_email
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test email: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function checkMailConfig()
    {
        try {
            $mailSettings = Setting::configureMailSettings();
            
            // Test SMTP connection
            if ($mailSettings['mail_mailer'] === 'smtp') {
                $connection = @fsockopen($mailSettings['mail_host'], $mailSettings['mail_port'], $errno, $errstr, 5);
                if (!$connection) {
                    throw new \Exception("Cannot connect to SMTP server {$mailSettings['mail_host']}:{$mailSettings['mail_port']} - $errstr ($errno)");
                }
                fclose($connection);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Mail configuration is valid',
                'settings' => $mailSettings
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Mail configuration error: ' . $e->getMessage()
            ], 500);
        }
    }
}