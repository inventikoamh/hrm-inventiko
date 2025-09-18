<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ProjectFlow - Employee Management System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-2xl font-bold text-blue-600">ProjectFlow</h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ route('dashboard') }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition-colors">
                                Login
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                        Welcome to <span class="text-blue-200">ProjectFlow</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto">
                        Streamline your workforce management with our comprehensive employee management system
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a href="{{ route('dashboard') }}" 
                               class="bg-white text-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-colors">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="bg-white text-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-colors">
                                Get Started
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Powerful Features
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Everything you need to manage your team efficiently
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Attendance Management -->
                    <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Attendance Tracking</h3>
                        <p class="text-gray-600">Clock in/out with work status tracking, daily reports, and comprehensive attendance management.</p>
                    </div>

                    <!-- Leave Management -->
                    <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Leave Management</h3>
                        <p class="text-gray-600">Complete leave system with requests, approvals, balance tracking, and automated calculations.</p>
                    </div>

                    <!-- User Management -->
                    <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">User Management</h3>
                        <p class="text-gray-600">Role-based access control, user profiles, and comprehensive employee management system.</p>
                    </div>

                    <!-- Reports & Analytics -->
                    <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Reports & Analytics</h3>
                        <p class="text-gray-600">Detailed reports, leave analytics, and comprehensive data visualization for better insights.</p>
                    </div>

                    <!-- Role & Permissions -->
                    <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Security & Permissions</h3>
                        <p class="text-gray-600">Advanced role-based permissions, secure authentication, and comprehensive access control.</p>
                    </div>

                    <!-- Real-time Updates -->
                    <div class="bg-gray-50 p-8 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Real-time Updates</h3>
                        <p class="text-gray-600">Live updates, instant notifications, and real-time data synchronization across all devices.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Inventiko Section -->
        <div class="py-20 bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                        Developed by <span class="text-blue-400">Inventiko</span>
                    </h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                        Your trusted partner in digital innovation
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-2xl font-semibold text-white mb-6">
                            High-Quality 3D Solutions
                        </h3>
                        <p class="text-gray-300 mb-6 text-lg leading-relaxed">
                            Inventiko specializes in high-quality 3D modeling, photorealistic renders, and product animations. We help product brands stand out with visuals that impress, explain, and convert.
                        </p>
                        <p class="text-gray-300 mb-8 text-lg leading-relaxed">
                            Our goal is to deliver visually stunning, conversion-focused 3D content for product manufacturers—helping them shorten sales cycles, boost engagement, and elevate their digital presence.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <span class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-medium">
                                3D Modeling
                            </span>
                            <span class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-medium">
                                Photorealistic Renders
                            </span>
                            <span class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-medium">
                                Product Animations
                            </span>
                            <span class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-medium">
                                Digital Innovation
                            </span>
                        </div>
                    </div>
                    <div class="bg-gray-800 p-8 rounded-xl">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                                <span class="text-2xl font-bold text-white">I</span>
                            </div>
                            <h4 class="text-xl font-semibold text-white mb-4">Inventiko</h4>
                            <p class="text-gray-300 mb-6">
                                Transforming ideas into stunning visual experiences
                            </p>
                            <div class="space-y-3">
                                <div class="flex items-center text-gray-300">
                                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Professional 3D Services
                                </div>
                                <div class="flex items-center text-gray-300">
                                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Conversion-Focused Design
                                </div>
                                <div class="flex items-center text-gray-300">
                                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Digital Innovation
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="py-20 bg-blue-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Ready to Streamline Your Workforce?
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Join thousands of companies already using ProjectFlow to manage their teams efficiently.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="bg-white text-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-colors">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="bg-white text-blue-600 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-colors">
                            Get Started Now
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-white mb-4">ProjectFlow</h3>
                    <p class="text-gray-400 mb-6">
                        Comprehensive Employee Management System
                    </p>
                    <div class="border-t border-gray-800 pt-8">
                        <p class="text-gray-400">
                            © {{ date('Y') }} ProjectFlow. Developed by 
                            <span class="text-blue-400 font-semibold">Inventiko</span>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
