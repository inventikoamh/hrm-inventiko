<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset email
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'No account found with this email address.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Configure mail settings
            Setting::configureMailSettings();

            // Get user first to ensure they exist
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return redirect()->back()
                    ->withErrors(['email' => 'No account found with this email address.'])
                    ->withInput();
            }

            // Generate reset token
            $token = Str::random(64);
            $email = $request->email;

            // Store token in database
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $email],
                [
                    'email' => $email,
                    'token' => Hash::make($token),
                    'created_at' => now()
                ]
            );

            // Send reset email
            Mail::send('emails.password-reset', [
                'user' => $user,
                'token' => $token,
                'resetUrl' => route('password.reset', ['token' => $token, 'email' => $email])
            ], function ($message) use ($email, $user) {
                $message->to($email, $user->getFullName())
                        ->subject('Reset Your Password - ' . Setting::getAppName());
            });

            return redirect()->back()->with('success', 'Password reset link has been sent to your email address.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['email' => 'Unable to send reset email. Please try again later.'])
                ->withInput();
        }
    }

    /**
     * Show the reset password form
     */
    public function showResetForm(Request $request, $token = null)
    {
        $email = $request->query('email');
        
        if (!$token || !$email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid reset link.']);
        }

        // Verify token exists and is not expired (24 hours)
        $tokenRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('created_at', '>', now()->subHours(24))
            ->first();

        if (!$tokenRecord || !Hash::check($token, $tokenRecord->token)) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid or expired reset link.']);
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * Reset the password
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.exists' => 'No account found with this email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Verify token
            $tokenRecord = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->where('created_at', '>', now()->subHours(24))
                ->first();

            if (!$tokenRecord || !Hash::check($request->token, $tokenRecord->token)) {
                return redirect()->back()
                    ->withErrors(['token' => 'Invalid or expired reset link.'])
                    ->withInput();
            }

            // Update password
            $user = User::where('email', $request->email)->first();
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            // Delete token
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return redirect()->route('login')
                ->with('success', 'Your password has been reset successfully. You can now login with your new password.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['email' => 'Unable to reset password. Please try again later.'])
                ->withInput();
        }
    }
}