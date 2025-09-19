<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-900', 'text-slate-100') }}">Welcome Back</h2>
        <p class="mt-2 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">Sign in to your account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}" />
            <x-text-input wire:model="form.email" 
                         id="email" 
                         class="mt-2 block w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-600 border-slate-500 text-slate-100 placeholder-slate-400') }}" 
                         type="email" 
                         name="email" 
                         required 
                         autofocus 
                         autocomplete="username"
                         placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-700', 'text-slate-300') }}" />
            <x-text-input wire:model="form.password" 
                         id="password" 
                         class="mt-2 block w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300 text-gray-900 placeholder-gray-500', 'bg-slate-600 border-slate-500 text-slate-100 placeholder-slate-400') }}"
                         type="password"
                         name="password"
                         required 
                         autocomplete="current-password"
                         placeholder="Enter your password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" 
                       id="remember" 
                       type="checkbox" 
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('bg-white border-gray-300', 'bg-slate-600 border-slate-500') }}" 
                       name="remember">
                <span class="ml-2 text-sm transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-gray-600', 'text-slate-400') }}">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium transition-colors duration-200 {{ \App\Helpers\ThemeHelper::getThemeClassesWithTransition('text-indigo-600 hover:text-indigo-500', 'text-indigo-400 hover:text-indigo-300') }}" 
                   href="{{ route('password.request') }}" 
                   wire:navigate>
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div>
            <x-primary-button class="w-full justify-center py-3 text-base font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                {{ __('Sign In') }}
            </x-primary-button>
        </div>
    </form>
</div>
