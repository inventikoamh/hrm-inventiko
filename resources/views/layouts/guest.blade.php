<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ \App\Models\Setting::getAppName() }}</title>
        
        @if(\App\Models\Setting::getFavicon())
            <link rel="icon" type="image/x-icon" href="{{ Storage::url(\App\Models\Setting::getFavicon()) }}">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Left Column - Background Image -->
            <div class="hidden lg:flex lg:w-1/2 relative">
                @if(\App\Models\Setting::getLoginBackground())
                    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
                         style="background-image: url('{{ Storage::url(\App\Models\Setting::getLoginBackground()) }}');">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-black/30"></div>
                    </div>
                @else
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-black/10"></div>
                    </div>
                @endif
                
                <!-- Logo and Branding -->
                <div class="relative z-10 flex flex-col justify-center items-center text-white p-12 w-full">
                    <div class="text-center">
                        @if(\App\Models\Setting::getLogo())
                            <div class="mb-4 inline-block p-3 bg-white/10 backdrop-blur-sm rounded-xl shadow-2xl">
                                <img src="{{ Storage::url(\App\Models\Setting::getLogo()) }}" 
                                     alt="{{ \App\Models\Setting::getAppName() }}" 
                                     class="h-12 w-auto">
                            </div>
                        @else
                            <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mx-auto mb-4 shadow-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <h1 class="text-4xl font-bold mb-4 text-white drop-shadow-2xl">{{ \App\Models\Setting::getAppName() }}</h1>
                        <p class="text-xl text-white/95 drop-shadow-lg max-w-md mx-auto leading-relaxed">Welcome to your project management dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Right Column - Login Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center px-6 py-12 bg-gray-50">
                <div class="w-full max-w-md">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden text-center mb-8">
                        @if(\App\Models\Setting::getLogo())
                            <img src="{{ Storage::url(\App\Models\Setting::getLogo()) }}" 
                                 alt="{{ \App\Models\Setting::getAppName() }}" 
                                 class="h-16 w-auto mx-auto mb-4">
                        @else
                            <div class="w-16 h-16 bg-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        @endif
                        <h1 class="text-2xl font-bold text-gray-900">{{ \App\Models\Setting::getAppName() }}</h1>
                    </div>

                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
