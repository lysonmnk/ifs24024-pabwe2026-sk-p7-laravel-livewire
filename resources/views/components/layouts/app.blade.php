<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi inventaris stok barang berbasis web untuk manajemen gudang yang efisien, cepat, dan aman.">
    <title>{{ $title ?? 'Stock Inventory Application' }} - PABWE 2026</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com" defer></script>
    <style>
        [x-cloak] { display: none !important; }
        html:has(.modal-scroll-lock),
        body:has(.modal-scroll-lock) {
            overflow: hidden !important;
            overscroll-behavior: none;
        }
    </style>
    @livewireStyles
</head>
<body class="h-full font-sans text-slate-800 antialiased" x-data="{ sidebarOpen: false }">
    @auth
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 bg-slate-900/60 z-40 md:hidden" 
             x-cloak></div>

        <!-- Sidebar (Left Fixed) -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 flex flex-col transition-transform duration-300 ease-in-out md:translate-x-0 shadow-sm">
            
            <!-- Brand / Logo -->
            <div class="h-16 flex items-center px-6 border-b border-slate-100 justify-between">
                <a href="{{ auth()->user()->isAdmin() ? route('admin.users') : route('stocks.index') }}" class="flex items-center space-x-2.5 font-bold text-lg text-blue-600 hover:text-blue-700 transition">
                    <span class="p-2 bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 text-white rounded-xl shadow-md shadow-blue-500/20 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </span>
                    <span class="text-slate-900 tracking-tight">Stock<span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent font-extrabold">App</span></span>
                </a>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-500 hover:text-slate-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- User Profile Summary in Sidebar -->
            <div class="p-4 mx-3 my-4 bg-slate-50 rounded-xl border border-slate-200/80">
                <div class="flex items-center space-x-3">
                    @if (auth()->user()->profile_photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists(auth()->user()->profile_photo_path))
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url(auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover shadow-sm flex-shrink-0 border border-slate-200">
                    @else
                        <div class="w-10 h-10 rounded-full {{ auth()->user()->isAdmin() ? 'bg-purple-700 text-white' : 'bg-blue-700 text-white' }} flex items-center justify-center font-extrabold text-sm shadow-sm flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-600 font-mono truncate">&#64;{{ auth()->user()->username }}</p>
                    </div>
                </div>
                <div class="mt-2.5 pt-2 border-t border-slate-200 flex items-center justify-between">
                    <span class="text-xs text-slate-600">Peran Akun:</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold {{ auth()->user()->isAdmin() ? 'bg-purple-100 text-purple-900 border border-purple-200' : 'bg-emerald-100 text-emerald-900 border border-emerald-200' }}">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 px-3 space-y-1 overflow-y-auto">
                <div class="px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-slate-600">
                    Menu Utama
                </div>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.users') }}" 
                       class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.*') ? 'text-blue-600' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>User Management</span>
                    </a>
                @endif

                <a href="{{ route('stocks.index') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('stocks.*') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('stocks.*') ? 'text-blue-600' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span>My Stocks</span>
                </a>

                <a href="{{ route('profile') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('profile') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('profile') ? 'text-blue-600' : 'text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span>Profil Saya</span>
                </a>
            </div>

            <!-- Logout Button -->
            <div class="p-3 border-t border-slate-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-semibold text-rose-700 hover:bg-rose-50 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="md:pl-64 flex flex-col flex-1 min-h-screen">
            <!-- Header Bar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-30">
                <div class="flex items-center space-x-3">
                    <button @click="sidebarOpen = true" class="md:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <span class="text-base sm:text-lg font-bold text-slate-900 tracking-tight">{{ $title ?? 'Dashboard' }}</span>
                </div>

                <div class="flex items-center space-x-3">
                    <span class="text-xs text-slate-600 font-mono hidden sm:inline">PABWE 2026</span>
                </div>
            </header>

            <!-- Page Slot Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <!-- Session Flash Messages -->
                @if (session()->has('success'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center justify-between shadow-sm">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-semibold">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 flex items-center justify-between shadow-sm">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-rose-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-sm font-semibold">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    @else
        <!-- Guest View Layout -->
        <main class="min-h-screen flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50">
            {{ $slot }}
        </main>
    @endauth

    @livewireScripts
</body>
</html>
