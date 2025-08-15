<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'QE Deployment') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <!-- CSRF Token Setup -->
        <script>
            // Ensure CSRF token is available for all AJAX requests
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
            
            // Set up axios CSRF token
            if (window.axios) {
                window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
            }
            
            // Debug CSRF token
            console.log('CSRF Token:', window.Laravel.csrfToken);
            console.log('Meta CSRF Token:', document.head.querySelector('meta[name="csrf-token"]')?.content);
        </script>
        
        <style>
            .sidebar {
                transition: transform 0.3s ease-in-out;
            }
            .sidebar.closed {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
                        @media (min-width: 1024px) {
                .sidebar {
                    transform: translateX(0) !important;
                }
            }
            
            /* Ensure pagination stays white */
            .pagination,
            .pagination *,
            nav[role="navigation"],
            nav[role="navigation"] *,
            [class*="pagination"] {
                background-color: white !important;
                color: #374151 !important;
            }
            
            /* Specific pagination text */
            .pagination p,
            nav[role="navigation"] p {
                background-color: transparent !important;
                color: #374151 !important;
            }
            
            /* Pagination buttons */
            .pagination a,
            .pagination span,
            nav[role="navigation"] a,
            nav[role="navigation"] span {
                background-color: white !important;
                border-color: #d1d5db !important;
                color: #374151 !important;
            }
            
            .pagination a:hover,
            nav[role="navigation"] a:hover {
                background-color: #f3f4f6 !important;
                color: #374151 !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
            <!-- Sidebar -->
            <div class="sidebar fixed lg:static inset-y-0 left-0 z-50 w-64 shadow-lg
                bg-gradient-to-b from-red-600 via-red-500 to-red-400"
                 :class="sidebarOpen ? 'open' : 'closed'">
                
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between h-16 px-6 bg-gradient-to-r from-red-700 to-red-600 border-b border-red-500">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <div class="ml-3">
                            <h1 class="text-lg font-semibold text-white">QE Deployment</h1>
                            <p class="text-xs text-red-100">
                                @if(auth()->user()->isPed())
                                    PED System
                                @else
                                    Mitra System
                                @endif
                            </p>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-red-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- User Info -->
                <div class="px-6 py-4 border-b border-red-400">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-400 to-red-300 rounded-full flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-red-100">
                                @if(auth()->user()->isPed())
                                    PED
                                @else
                                    Mitra
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    @if(auth()->user()->isPed())
                        <!-- PED Navigation -->
                        <a href="{{ route('ped.dashboard') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium text-red-100 rounded-lg hover:bg-gradient-to-r hover:from-red-500 hover:to-red-400 hover:text-white transition-all duration-200 {{ request()->routeIs('ped.dashboard') ? 'bg-gradient-to-r from-red-500 to-red-400 text-white shadow-md' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"/>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('ped.index') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium text-red-100 rounded-lg hover:bg-gradient-to-r hover:from-red-500 hover:to-red-400 hover:text-white transition-all duration-200 {{ request()->routeIs('ped.index') ? 'bg-gradient-to-r from-red-500 to-red-400 text-white shadow-md' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Dokumen Proyek
                        </a>

                        <a href="{{ route('ped.notifications') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium text-red-100 rounded-lg hover:bg-gradient-to-r hover:from-red-500 hover:to-red-400 hover:text-white transition-all duration-200 {{ request()->routeIs('ped.notifications') ? 'bg-gradient-to-r from-red-500 to-red-400 text-white shadow-md' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.19 4.19A2 2 0 006 3h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                            </svg>
                            Notifikasi
                        </a>
                    @else
                        <!-- Mitra Navigation -->
                        <a href="{{ route('mtra.dashboard') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium text-red-100 rounded-lg hover:bg-gradient-to-r hover:from-red-500 hover:to-red-400 hover:text-white transition-all duration-200 {{ request()->routeIs('mtra.dashboard') ? 'bg-gradient-to-r from-red-500 to-red-400 text-white shadow-md' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"/>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('mtra.index') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium text-red-100 rounded-lg hover:bg-gradient-to-r hover:from-red-500 hover:to-red-400 hover:text-white transition-all duration-200 {{ request()->routeIs('mtra.index') ? 'bg-gradient-to-r from-red-500 to-red-400 text-white shadow-md' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            Project Mitra
                        </a>

                        <a href="{{ route('mtra.create') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium text-red-100 rounded-lg hover:bg-gradient-to-r hover:from-red-500 hover:to-red-400 hover:text-white transition-all duration-200 {{ request()->routeIs('mtra.create') ? 'bg-gradient-to-r from-red-500 to-red-400 text-white shadow-md' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Project
                        </a>
                    @endif
                </nav>

                <!-- Logout -->
                <div class="px-4 py-4 border-t border-red-400">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 text-red-100 hover:bg-gradient-to-r hover:from-red-500 hover:to-red-400 hover:text-white">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col lg:ml-0">
                <!-- Top Navigation -->
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <!-- Page Title -->
                        <div class="flex-1 lg:ml-0">
                            <h1 class="text-xl font-semibold text-gray-900">
                                @yield('page-title', 'QE Deployment Mitra')
                            </h1>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-red-100 to-red-50 text-red-800 border border-red-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                @if(auth()->user()->isPed())
                                    PED
                                @else
                                    Mitra
                                @endif
                            </span>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-gray-100">
                    <div class="py-6">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>

        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 lg:hidden"></div>
    </body>
</html>
