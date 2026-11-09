<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi inventaris stok barang berbasis web untuk manajemen gudang yang efisien, cepat, dan aman.">
    <title>{{ $title ?? 'Stock Inventory Application' }} - PABWE 2026</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Urbanist:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Tailwind CSS loaded via Vite -->
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
<body class="h-full font-manrope text-white antialiased bg-[#3E5B34]" x-data="{ sidebarOpen: false }">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 bg-[#8FBF5B] text-[#141414] font-urbanist px-4 py-2 rounded-xl text-sm font-extrabold shadow-xl">Lewati ke konten utama</a>
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
             class="fixed inset-0 bg-black/80 backdrop-blur-sm z-40 md:hidden" 
             x-cloak></div>

        <!-- Sidebar (Left Fixed Dark Bento) -->
        <aside aria-label="Sidebar Menu" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-[#141414] border-r border-white/10 flex flex-col transition-transform duration-300 ease-in-out md:translate-x-0 shadow-2xl">
            
            <!-- Brand / Logo -->
            <div class="h-16 flex items-center px-6 border-b border-white/10 justify-between">
                <a href="{{ auth()->user()->isAdmin() ? route('admin.users') : route('stocks.index') }}" class="flex items-center space-x-3 font-bold text-lg text-white hover:opacity-90 transition">
                    <span class="w-9 h-9 rounded-full bg-[#8FBF5B] text-[#141414] font-urbanist font-extrabold text-base flex items-center justify-center shadow-lg shadow-[#8FBF5B]/20">
                        sb
                    </span>
                    <div class="flex flex-col">
                        <span class="font-urbanist font-extrabold tracking-tight text-white leading-none">Stock<span class="text-[#8FBF5B]">App</span></span>
                        <span class="text-[10px] font-manrope font-semibold text-white/50 tracking-widest uppercase mt-0.5">Dark Bento POS</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" aria-label="Tutup menu navigasi" class="md:hidden text-white/60 hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- User Profile Summary in Sidebar -->
            <div class="p-4 mx-3 my-4 bg-[#232323] rounded-2xl border border-white/10">
                <div class="flex items-center space-x-3">
                    @if (auth()->user()->profile_photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists(auth()->user()->profile_photo_path))
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url(auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover shadow-sm flex-shrink-0 border-2 border-[#8FBF5B]/40">
                    @else
                        <div class="w-10 h-10 rounded-full bg-[#8FBF5B] text-[#141414] flex items-center justify-center font-urbanist font-extrabold text-sm shadow-sm flex-shrink-0">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-white truncate font-urbanist">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white/60 font-mono truncate">&#64;{{ auth()->user()->username }}</p>
                    </div>
                </div>
                <div class="mt-2.5 pt-2 border-t border-white/10 flex items-center justify-between">
                    <span class="text-[11px] text-white/50 font-medium">Hak Akses:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-urbanist font-extrabold uppercase tracking-wider {{ auth()->user()->isAdmin() ? 'bg-purple-900/60 text-purple-200 border border-purple-400/30' : 'bg-[#8FBF5B]/20 text-[#8FBF5B] border border-[#8FBF5B]/30' }}">
                        {{ auth()->user()->isAdmin() ? 'ADMIN PUSAT' : 'MEMBER RETAIL' }}
                    </span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav aria-label="Menu Navigasi Utama" class="flex-1 px-3 space-y-4 overflow-y-auto">
                <!-- Section 1: Inventaris & Kasir -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-urbanist font-extrabold uppercase tracking-wider text-white/40">
                        Inventaris &amp; Kasir
                    </div>

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.users') }}" 
                           class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('admin.*') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                            <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('admin.*') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">admin_panel_settings</span>
                            <span>User Management</span>
                        </a>
                    @endif

                    <a href="{{ route('stocks.index') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('stocks.*') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('stocks.*') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">inventory_2</span>
                        <span>Stok Saya</span>
                    </a>

                    <a href="{{ route('pos.index') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('pos.*') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('pos.*') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">point_of_sale</span>
                        <span>Kasir POS</span>
                    </a>

                    <a href="{{ route('critical-stock.index') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('critical-stock.*') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('critical-stock.*') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">notification_important</span>
                        <span>Kedaluwarsa &amp; Kritis</span>
                    </a>

                    <a href="{{ route('mutations.index') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('mutations.*') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('mutations.*') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">history</span>
                        <span>Riwayat Mutasi</span>
                    </a>
                </div>

                <!-- Section 2: Logistik & Operasional Gudang -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-urbanist font-extrabold uppercase tracking-wider text-white/40">
                        Logistik &amp; Gudang
                    </div>

                    <a href="{{ route('purchase-orders.index') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('purchase-orders.*') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('purchase-orders.*') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">local_shipping</span>
                        <span>Purchase Order</span>
                    </a>

                    <a href="{{ route('stock-opname.index') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('stock-opname.*') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('stock-opname.*') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">document_scanner</span>
                        <span>Stock Opname</span>
                    </a>

                    <a href="{{ route('returns.index') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('returns.*') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('returns.*') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">assignment_return</span>
                        <span>Retur &amp; Klaim</span>
                    </a>

                    <a href="{{ route('stock-transfers.index') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('stock-transfers.*') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('stock-transfers.*') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">rv_hookup</span>
                        <span>Transfer Cabang</span>
                    </a>
                </div>

                <!-- Section 3: Keuangan & Bon -->
                <div class="space-y-1">
                    <div class="px-3 py-1 text-[10px] font-urbanist font-extrabold uppercase tracking-wider text-white/40">
                        Keuangan &amp; Akun
                    </div>

                    <a href="{{ route('debts.index') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('debts.*') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('debts.*') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">payments</span>
                        <span>Buku Bon (Piutang)</span>
                    </a>

                    <a href="{{ route('accounts-payable.index') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('accounts-payable.*') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('accounts-payable.*') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">receipt</span>
                        <span>Utang Vendor (AP)</span>
                    </a>

                    <a href="{{ route('reports.index') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('reports.*') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('reports.*') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">analytics</span>
                        <span>Laporan Penjualan</span>
                    </a>

                    <a href="{{ route('profile') }}" 
                       class="flex items-center space-x-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ request()->routeIs('profile') ? 'bg-[#8FBF5B] text-[#141414] shadow-md shadow-[#8FBF5B]/20 font-bold' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px] {{ request()->routeIs('profile') ? 'text-[#141414]' : 'text-[#8FBF5B]' }}">person</span>
                        <span>Profil Saya</span>
                    </a>
                </div>
            </nav>

            <!-- Logout Button -->
            <div class="p-3 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-rose-400 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 transition cursor-pointer">
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
            <header role="banner" class="h-16 bg-[#141414]/70 backdrop-blur-md border-b border-white/10 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-30">
                <div class="flex items-center space-x-3">
                    <button @click="sidebarOpen = true" aria-label="Buka menu navigasi" class="md:hidden p-2 rounded-lg text-white/70 hover:text-white hover:bg-white/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <span class="text-sm sm:text-base font-extrabold text-white tracking-tight font-urbanist">{{ $title ?? 'Dashboard' }}</span>
                </div>

                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-black/40 border border-white/10 text-[11px] font-mono text-white/70">
                        <span class="w-2 h-2 rounded-full bg-[#8FBF5B] animate-pulse"></span>
                        <span class="hidden sm:inline">PABWE 2026 • Live Sync</span>
                    </span>
                </div>
            </header>

            <!-- Page Slot Content -->
            <main id="main-content" role="main" class="flex-1 p-4 sm:p-6 lg:p-8">
                <!-- Session Flash Messages -->
                @if (session()->has('success'))
                    <div class="mb-6 p-4 rounded-2xl bg-[#8FBF5B]/15 border border-[#8FBF5B]/30 text-white flex items-center justify-between shadow-lg">
                        <div class="flex items-center space-x-3">
                            <span class="w-6 h-6 rounded-full bg-[#8FBF5B] text-[#141414] flex items-center justify-center font-bold text-xs shrink-0">✓</span>
                            <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="mb-6 p-4 rounded-2xl bg-[#E2725B]/15 border border-[#E2725B]/30 text-white flex items-center justify-between shadow-lg">
                        <div class="flex items-center space-x-3">
                            <span class="w-6 h-6 rounded-full bg-[#E2725B] text-[#141414] flex items-center justify-center font-bold text-xs shrink-0">!</span>
                            <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    @else
        <!-- Guest View Layout -->
        <main id="main-content" role="main" class="min-h-screen flex flex-col justify-center py-6 sm:py-12 px-3 sm:px-6 lg:px-8 bg-slate-50 dark:bg-slate-950 transition-colors duration-300 relative overflow-x-hidden overflow-y-auto">
            {{ $slot }}
        </main>
    @endauth

    @livewireScripts
</body>
</html>
