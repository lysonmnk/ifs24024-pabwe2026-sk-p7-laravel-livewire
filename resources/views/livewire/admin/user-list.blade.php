<div class="bento-dashboard-bg bento-grain-overlay min-h-screen -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 text-white relative font-manrope selection:bg-[#8FBF5B] selection:text-black">
    <div class="relative z-10 max-w-[1400px] mx-auto flex flex-col gap-6 sm:gap-8 pb-12">

        <!-- A. TOP HEADER NAVIGATION -->
        <header class="w-full flex items-center justify-between flex-wrap gap-4 pb-2 border-b border-white/10">
            <!-- Kiri: Penanda seri & Monogram -->
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-white/10 text-xs font-semibold text-white/90">
                    <span class="w-2 h-2 rounded-full bg-[#8FBF5B] animate-pulse"></span>
                    <span>D 09/90 • Live Sync</span>
                </div>
                <div class="w-10 h-10 rounded-full bg-[#141414] border border-white/15 flex items-center justify-center shadow-lg">
                    <span class="font-urbanist font-extrabold text-lg text-[#8FBF5B] tracking-tight">sb.</span>
                </div>
                <span class="text-xs font-semibold text-white/70 uppercase tracking-widest hidden sm:inline">Admin Network Console</span>
            </div>

            <!-- Kanan: User Profile Badge Admin & Settings -->
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2.5 bg-black/40 backdrop-blur-md border border-white/10 py-1 pl-1.5 pr-4 rounded-full">
                    <div class="w-8 h-8 rounded-full bg-[#8FBF5B] text-[#141414] flex items-center justify-center font-bold text-xs">
                        <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-xs font-semibold text-white leading-tight">{{ auth()->user()->name }}</span>
                        <span class="text-[10px] text-[#8FBF5B] font-bold uppercase tracking-wider">ADMIN PUSAT</span>
                    </div>
                </div>

                <a href="{{ route('profile') }}" class="w-10 h-10 rounded-full bg-black/40 backdrop-blur-md border border-white/10 flex items-center justify-center text-white/80 hover:text-white transition-colors" title="Pengaturan Akun">
                    <span class="material-symbols-outlined text-[19px]">settings</span>
                </a>
            </div>
        </header>

        <!-- B. HERO SECTION: JUDUL & 3 METRIK STATISTIK RAKSASA (STITCH SCREEN 6) -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center pt-2">
            <!-- Kiri: Judul 2 Baris Raksasa -->
            <div class="lg:col-span-5 flex flex-col gap-1.5">
                <div class="flex items-center gap-2 text-xs text-[#C8D7B4] uppercase tracking-wider font-semibold">
                    <span class="w-2 h-2 rounded-full bg-[#8FBF5B]"></span>
                    <span>Konsol Manajemen Multi-Tenant</span>
                </div>
                <h1 class="font-urbanist font-extrabold text-4xl sm:text-5xl lg:text-6xl leading-[1.02] tracking-tight text-white">
                    Daftar Pengguna<br/>
                    <span class="text-[#C8D7B4]">/ Admin Jaringan</span>
                </h1>
                <p class="text-xs sm:text-sm text-white/60 mt-1 font-medium">
                    Pantau mitra toko terdaftar, kepatuhan audit inventaris, dan hak akses multi-tenant
                </p>
            </div>

            <!-- Kanan: Donut Progress 100% & 3 Statistik Raksasa -->
            <div class="lg:col-span-7 flex flex-wrap sm:flex-nowrap items-center justify-between gap-4 bg-black/35 backdrop-blur-xl border border-white/10 rounded-[28px] p-5 shadow-2xl">
                <!-- Donut Progress 100% Status Audit -->
                <div class="flex items-center gap-3.5 pr-4 border-r border-white/10 shrink-0">
                    <div class="relative w-14 h-14 flex items-center justify-center">
                        <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                            <circle cx="18" cy="18" fill="none" r="14.5" stroke="rgba(255,255,255,0.15)" stroke-width="3.5"></circle>
                            <circle cx="18" cy="18" fill="none" r="14.5" stroke="#8FBF5B" stroke-dasharray="100, 100" stroke-linecap="round" stroke-width="3.5"></circle>
                        </svg>
                        <span class="absolute font-urbanist text-xs text-white font-extrabold">100%</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] uppercase tracking-wider text-white/60 font-semibold">Status Audit</span>
                        <span class="font-urbanist font-bold text-sm text-[#8FBF5B]">Tersinkron</span>
                    </div>
                </div>

                <!-- 3 Angka Statistik Raksasa Horizontal -->
                <div class="flex items-center justify-around flex-1 gap-4 overflow-x-auto no-scrollbar">
                    <!-- Stat 1: Mitra Cabang -->
                    <div class="flex flex-col">
                        <span class="text-[10px] text-white/60 uppercase tracking-wider font-semibold">Mitra Cabang</span>
                        <div class="flex items-baseline gap-1 mt-0.5">
                            <span class="font-urbanist font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white leading-none">
                                {{ $telemetry['total_stores'] ?? 0 }}
                            </span>
                            <sup class="font-urbanist font-bold text-xs text-[#8FBF5B] -top-2 sm:-top-4">Toko</sup>
                        </div>
                    </div>

                    <div class="w-px h-10 bg-white/15"></div>

                    <!-- Stat 2: Total Item SKU -->
                    <div class="flex flex-col">
                        <span class="text-[10px] text-white/60 uppercase tracking-wider font-semibold">Total Item</span>
                        <div class="flex items-baseline gap-1 mt-0.5">
                            <span class="font-urbanist font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white leading-none">
                                {{ number_format($telemetry['total_sku_count'] ?? 0, 0, ',', '.') }}
                            </span>
                            <sup class="font-urbanist font-bold text-xs text-[#C8D7B4] -top-2 sm:-top-4">SKU</sup>
                        </div>
                    </div>

                    <div class="w-px h-10 bg-white/15"></div>

                    <!-- Stat 3: Total Nilai Aset -->
                    <div class="flex flex-col">
                        <span class="text-[10px] text-white/60 uppercase tracking-wider font-semibold">Rp Aset Stok</span>
                        <div class="flex items-baseline gap-1 mt-0.5">
                            @php
                                $val = $telemetry['total_network_asset_value'] ?? 0;
                                $displayVal = $val >= 1000000000 ? number_format($val / 1000000000, 2, ',', '.') : number_format($val / 1000000, 1, ',', '.');
                                $unitTag = $val >= 1000000000 ? 'Miliar' : 'Juta';
                            @endphp
                            <span class="font-urbanist font-extrabold text-3xl sm:text-4xl lg:text-5xl text-[#8FBF5B] leading-none">
                                {{ $displayVal }}
                            </span>
                            <sup class="font-urbanist font-bold text-xs text-white -top-2 sm:-top-4">{{ $unitTag }}</sup>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- C. BARIS FILTER & KONTROL (KAPSUL CHIPS & LIVE SEARCH) -->
        <section class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 pt-1">
            <!-- Chip Kapsul Filter Peran -->
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
                <button type="button" wire:click="setRole('')"
                    class="px-5 py-2.5 rounded-full font-urbanist text-xs sm:text-sm font-bold transition-all shrink-0 {{ $roleFilter === '' ? 'bg-white text-black shadow-lg shadow-white/10' : 'bg-black/40 hover:bg-black/60 text-white/80 hover:text-white border border-white/15 backdrop-blur-md' }}">
                    Semua Anggota ({{ $telemetry['total_users'] ?? 0 }})
                </button>

                <button type="button" wire:click="setRole('member')"
                    class="px-5 py-2.5 rounded-full font-urbanist text-xs sm:text-sm font-bold transition-all shrink-0 {{ $roleFilter === 'member' ? 'bg-[#8FBF5B] text-black shadow-lg shadow-[#8FBF5B]/20' : 'bg-black/40 hover:bg-black/60 text-white/80 hover:text-white border border-white/15 backdrop-blur-md' }}">
                    Pemilik Toko ({{ $telemetry['total_stores'] ?? 0 }})
                </button>

                <button type="button" wire:click="setRole('admin')"
                    class="px-5 py-2.5 rounded-full font-urbanist text-xs sm:text-sm font-bold transition-all shrink-0 {{ $roleFilter === 'admin' ? 'bg-[#C8D7B4] text-black shadow-lg shadow-[#C8D7B4]/20' : 'bg-black/40 hover:bg-black/60 text-white/80 hover:text-white border border-white/15 backdrop-blur-md' }}">
                    Admin Jaringan ({{ $telemetry['admin_count'] ?? 0 }})
                </button>
            </div>

            <!-- Search Bar & Switch View Mode -->
            <div class="flex items-center gap-2.5 flex-1 lg:max-w-xl">
                <!-- Search Input Debounced -->
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-white/50 text-[18px]">search</span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Cari toko, nama pemilik, email, username..."
                        class="w-full h-11 pl-11 pr-9 bg-black/40 border border-white/15 text-white placeholder:text-white/40 text-xs sm:text-sm rounded-full outline-none focus:border-[#8FBF5B] backdrop-blur-md transition-all" />
                    <div wire:loading wire:target="search,roleFilter" class="absolute right-3.5 top-3">
                        <svg class="animate-spin h-4 w-4 text-[#8FBF5B]" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Mode View Toggle (Bento Grid vs Table) -->
                <div class="flex items-center p-1 rounded-full bg-black/40 border border-white/15 backdrop-blur-md">
                    <button type="button" wire:click="setViewMode('bento')"
                        class="p-2 rounded-full transition-all {{ $viewMode === 'bento' ? 'bg-[#8FBF5B] text-black' : 'text-white/60 hover:text-white' }}"
                        title="Tampilan Bento Cards">
                        <span class="material-symbols-outlined text-[18px]">grid_view</span>
                    </button>
                    <button type="button" wire:click="setViewMode('table')"
                        class="p-2 rounded-full transition-all {{ $viewMode === 'table' ? 'bg-[#8FBF5B] text-black' : 'text-white/60 hover:text-white' }}"
                        title="Tampilan Tabel Standar">
                        <span class="material-symbols-outlined text-[18px]">table_rows</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- D. MAIN 2-COLUMN BENTO GRID (Kiri 68% / Kanan 32%) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- ================= KOLOM KIRI (68% - lg:col-span-8): DIREKTORI ANGGOTA ================= -->
            <div class="lg:col-span-8 bg-[#141414] rounded-[32px] p-6 sm:p-8 shadow-2xl border border-white/10 flex flex-col gap-6">

                <!-- Header Baris Atas Kartu: Title + Batch #441 Badge + Live Indicators -->
                <div class="flex items-center justify-between pb-4 border-b border-white/10 flex-wrap gap-3">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-[#8FBF5B] shadow-[0_0_12px_#8FBF5B] animate-pulse"></span>
                        <h2 class="font-urbanist font-bold text-xl sm:text-2xl text-white tracking-tight">
                            Direktori Anggota Toko Terverifikasi
                        </h2>
                    </div>

                    <!-- Badge Tenant Batch Sync -->
                    <div class="flex items-center gap-2 bg-[#232323] px-3.5 py-1.5 rounded-full border border-white/10">
                        <span class="text-xs font-urbanist font-extrabold text-[#C8D7B4] tracking-wide uppercase">
                            MULTI-TENANT NODE • 100% SLA
                        </span>
                    </div>
                </div>

                <!-- 3 Panel Status Internal Modular (Akses Tenant, Ruang DB, Audit Kepatuhan) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <!-- (1) Akses Tenant -->
                    <div class="bg-[#232323] rounded-2xl p-4 flex flex-col justify-between border border-white/5">
                        <div class="flex items-center justify-between text-white/60 text-[11px] font-semibold uppercase tracking-wider mb-2">
                            <span>Akses Tenant</span>
                            <span class="material-symbols-outlined text-[16px] text-[#8FBF5B]">shield_person</span>
                        </div>
                        <div class="flex flex-col gap-1.5 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-white/80">Super Admin</span>
                                <span class="font-urbanist font-bold text-white bg-black/40 px-2 py-0.5 rounded-full">{{ $telemetry['admin_count'] ?? 1 }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-white/80">Pemilik Toko</span>
                                <span class="font-urbanist font-bold text-[#8FBF5B] bg-black/40 px-2 py-0.5 rounded-full">{{ $telemetry['total_stores'] ?? 0 }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-white/80">Total User</span>
                                <span class="font-urbanist font-bold text-white/70 bg-black/40 px-2 py-0.5 rounded-full">{{ $telemetry['total_users'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- (2) Ruang DB Tenant -->
                    <div class="bg-[#232323] rounded-2xl p-4 flex flex-col justify-between border border-white/5">
                        <div class="flex items-center justify-between text-[11px] uppercase tracking-wider text-white/60 font-semibold">
                            <span>Kapasitas Database</span>
                            <span class="font-urbanist font-bold text-[#8FBF5B] text-xs">29.6%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-black/50 overflow-hidden my-2">
                            <div class="h-full bg-[#8FBF5B] rounded-full" style="width: 29.6%"></div>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-white/60">
                            <span>Terdistribusi SQLite</span>
                            <span class="text-[#C8D7B4] font-semibold">Sistem Stabil</span>
                        </div>
                    </div>

                    <!-- (3) Panel Hijau Lime: Audit Kepatuhan -->
                    <div class="bg-[#8FBF5B] text-[#141414] rounded-2xl p-4 flex flex-col justify-between shadow-md">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-urbanist font-bold uppercase tracking-wider">Audit Kepatuhan</span>
                            <span class="font-urbanist font-extrabold text-base leading-none">99.8%</span>
                        </div>
                        <!-- Mini Regional Bar Chart -->
                        <div class="flex items-end justify-between gap-2 h-10 pt-1 px-1">
                            <div class="flex flex-col items-center flex-1 gap-0.5">
                                <div class="w-full bg-[#141414] rounded-t h-8"></div>
                                <span class="text-[9px] font-urbanist font-extrabold">JKT</span>
                            </div>
                            <div class="flex flex-col items-center flex-1 gap-0.5">
                                <div class="w-full bg-[#141414] rounded-t h-6"></div>
                                <span class="text-[9px] font-urbanist font-extrabold">SBY</span>
                            </div>
                            <div class="flex flex-col items-center flex-1 gap-0.5">
                                <div class="w-full bg-[#141414] rounded-t h-7"></div>
                                <span class="text-[9px] font-urbanist font-extrabold">BDG</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAMPILAN USER (BENTO CARDS GRID VS TABEL) -->
                @if ($viewMode === 'bento')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse ($users as $user)
                            <article class="bg-[#232323] rounded-2xl p-5 flex flex-col justify-between gap-4 border border-white/5 hover:border-[#8FBF5B]/40 transition-all group shadow-md">
                                <div class="flex flex-col gap-3">
                                    <!-- User Header: Avatar, Name, Role Badge -->
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-12 h-12 rounded-full bg-[#1E3A12] border-2 border-[#8FBF5B]/30 flex items-center justify-center text-[#8FBF5B] font-urbanist font-bold text-lg shrink-0">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <h3 class="font-urbanist font-bold text-base text-white truncate group-hover:text-[#8FBF5B] transition-colors">
                                                    {{ $user->name }}
                                                </h3>
                                                <span class="text-xs text-white/60 font-mono truncate">
                                                    &#64;{{ $user->username }}
                                                </span>
                                            </div>
                                        </div>

                                        <span class="px-2.5 py-0.5 rounded-full {{ $user->isAdmin() ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : 'bg-[#8FBF5B]/20 text-[#8FBF5B] border border-[#8FBF5B]/30' }} font-urbanist text-[11px] font-bold flex items-center gap-1.5 shrink-0">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $user->isAdmin() ? 'bg-purple-400' : 'bg-[#8FBF5B]' }}"></span>
                                            <span>{{ ucfirst($user->role) }}</span>
                                        </span>
                                    </div>

                                    <!-- User Email & Identifier -->
                                    <div class="text-white/50 text-xs font-mono truncate">
                                        {{ $user->email }} • ID: SB-USR-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                                    </div>

                                    <!-- 2-Col Mini Metric Tile -->
                                    <div class="bg-[#141414] rounded-xl p-3 grid grid-cols-2 gap-2 border border-white/5">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] text-white/50 uppercase tracking-wider font-semibold">Stok Aktif</span>
                                            <div class="flex items-baseline gap-1">
                                                <span class="font-urbanist font-extrabold text-xl text-white">
                                                    {{ $user->stocks_count }}
                                                </span>
                                                <sup class="text-[10px] font-urbanist font-bold text-white/60">SKU</sup>
                                            </div>
                                        </div>

                                        <div class="flex flex-col">
                                            <span class="text-[10px] text-white/50 uppercase tracking-wider font-semibold">Toko</span>
                                            <div class="flex items-baseline gap-1">
                                                <span class="font-urbanist font-bold text-xs text-[#8FBF5B] truncate">
                                                    {{ $user->isAdmin() ? 'Admin Pusat' : 'Mitra Retail' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bottom Action Row -->
                                <div class="flex items-center justify-between pt-2 border-t border-white/5">
                                    <span class="text-[11px] text-white/50 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[15px]">calendar_today</span>
                                        <span>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</span>
                                    </span>

                                    <a href="{{ route('admin.users.stocks', $user->id) }}"
                                        class="btn-interactive px-4 py-1.5 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] text-[#141414] font-urbanist text-xs font-extrabold flex items-center gap-1.5 shadow-md active:scale-95 transition-all">
                                        <span>Lihat Stok</span>
                                        <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div class="col-span-2 py-12 text-center text-white/50">
                                <span class="material-symbols-outlined text-4xl mb-2 text-white/30">person_off</span>
                                <p class="text-sm">Tidak ada data pengguna yang sesuai dengan kriteria pencarian.</p>
                            </div>
                        @endforelse
                    </div>
                @else
                    <!-- TAMPILAN TABEL STANDAR TERINTEGRASI -->
                    <div class="overflow-x-auto rounded-2xl border border-white/10 bg-[#1C1C1C]">
                        <table class="w-full text-left border-collapse text-xs sm:text-sm">
                            <thead>
                                <tr class="bg-black/40 border-b border-white/10 text-white/60 font-semibold uppercase text-[11px]">
                                    <th class="py-3 px-4">Pengguna</th>
                                    <th class="py-3 px-4">Email</th>
                                    <th class="py-3 px-4">Peran</th>
                                    <th class="py-3 px-4 text-center">Stok Terdaftar</th>
                                    <th class="py-3 px-4">Bergabung</th>
                                    <th class="py-3 px-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="py-3.5 px-4">
                                            <div class="font-bold text-white">{{ $user->name }}</div>
                                            <div class="text-[11px] font-mono text-white/50">&#64;{{ $user->username }}</div>
                                        </td>
                                        <td class="py-3.5 px-4 text-white/70 font-mono">{{ $user->email }}</td>
                                        <td class="py-3.5 px-4">
                                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $user->isAdmin() ? 'bg-purple-500/20 text-purple-300' : 'bg-[#8FBF5B]/20 text-[#8FBF5B]' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-center font-bold font-urbanist text-white text-base">
                                            {{ $user->stocks_count }} <span class="text-xs text-white/40 font-normal">SKU</span>
                                        </td>
                                        <td class="py-3.5 px-4 text-white/50 text-xs">
                                            {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                        </td>
                                        <td class="py-3.5 px-4 text-right">
                                            <a href="{{ route('admin.users.stocks', $user->id) }}"
                                                class="btn-interactive inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] text-black font-urbanist text-xs font-bold shadow transition-all">
                                                <span>Lihat Stok</span>
                                                <span class="material-symbols-outlined text-[15px]">visibility</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-10 text-center text-white/50">
                                            Tidak ada data pengguna yang ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif

                <!-- Pagination Baris Bawah -->
                <div class="pt-4 border-t border-white/10 flex items-center justify-between flex-wrap gap-3">
                    <span class="text-xs text-white/50">
                        Menampilkan <strong class="text-white">{{ $users->count() }}</strong> dari <strong class="text-white">{{ $users->total() }}</strong> pengguna terdaftar
                    </span>
                    <div class="bento-pagination">
                        {{ $users->links() }}
                    </div>
                </div>

            </div>

            <!-- ================= KOLOM KANAN (32% - lg:col-span-4): STACKED CREAM CARDS ================= -->
            <div class="lg:col-span-4 flex flex-col gap-5">

                <!-- KARTU 1: PENGAWASAN IZIN & KEAMANAN (AUDIT POLICY 2.4) -->
                <section class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-6 shadow-xl flex flex-col justify-between gap-5 border border-black/5">
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/10 font-urbanist text-[11px] font-bold uppercase tracking-wider">
                                <span class="material-symbols-outlined text-[14px]">lock</span>
                                AUDIT POLICY 2.4
                            </span>
                            <span class="font-urbanist font-extrabold text-[11px] text-[#2C4328] uppercase tracking-wider bg-[#8FBF5B]/40 px-2.5 py-0.5 rounded-full">
                                READ-ONLY GUARD
                            </span>
                        </div>
                        <div>
                            <h3 class="font-urbanist font-extrabold text-xl text-[#161616] leading-tight">
                                Pengawasan Izin &amp; Keamanan
                            </h3>
                            <span class="text-xs font-urbanist font-bold text-[#2C4328] block mt-0.5">
                                Hak Akses Read-Only Terjamin
                            </span>
                        </div>
                        <p class="text-xs font-manrope text-[#52524E] leading-relaxed">
                            Admin pusat hanya memiliki hak pantau. Dilarang melakukan manipulasi, penambahan, maupun penghapusan stok anggota secara sepihak untuk menjaga kepatuhan audit dan integritas pembukuan masing-masing mitra.
                        </p>
                    </div>

                    <!-- Kotak Enkripsi Status Cloud Sync -->
                    <div class="bg-black/5 p-3.5 rounded-2xl flex flex-col gap-2 border border-black/5">
                        <div class="flex items-center justify-between text-xs font-urbanist font-bold text-[#161616]">
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-[#2C4328]">encrypted</span>
                                Status Enkripsi
                            </span>
                            <span class="text-[#2C4328] font-extrabold">AES-256 Cloud Sync</span>
                        </div>
                        <div class="w-full bg-black/10 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-[#3E5B34] h-full rounded-full" style="width: 100%"></div>
                        </div>
                        <span class="text-[11px] text-[#52524E]">
                            Seluruh mutasi tercatat dengan audit log terenkripsi &amp; terlindungi sistem.
                        </span>
                    </div>
                </section>

                <!-- KARTU 2: AKTIVITAS AUDIT TERBARU (LIVE SYNC) -->
                <section class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-6 shadow-xl flex flex-col gap-4 border border-black/5">
                    <div class="flex items-center justify-between">
                        <h4 class="font-urbanist font-extrabold text-lg text-[#161616]">Aktivitas Audit Terbaru</h4>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#8FBF5B]/30 text-[#2C4328] font-urbanist text-[11px] font-extrabold uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#2C4328] animate-ping"></span>
                            Live Sync
                        </span>
                    </div>

                    <div class="flex flex-col gap-3">
                        <div class="flex items-start gap-2.5 text-xs">
                            <span class="w-2 h-2 rounded-full bg-[#8FBF5B] mt-1.5 shrink-0"></span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-urbanist font-bold text-[#161616]">Sinkronisasi Multi-Tenant Otomatis</span>
                                <span class="text-[#52524E] text-[11px]">Node Jakarta-01 • Status Normal</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 text-xs">
                            <span class="w-2 h-2 rounded-full bg-[#8FBF5B] mt-1.5 shrink-0"></span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-urbanist font-bold text-[#161616]">Verifikasi Rekonsiliasi Database</span>
                                <span class="text-[#52524E] text-[11px]">Integritas Foreign Key Cocok 100%</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 text-xs">
                            <span class="w-2 h-2 rounded-full bg-[#C8D7B4] mt-1.5 shrink-0"></span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-urbanist font-bold text-[#161616]">Pengawasan Hak Akses Terisolasi</span>
                                <span class="text-[#52524E] text-[11px]">Ownership Policy Guard Aktif</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- KARTU 3: PUSAT BANTUAN & INTEGRASI POS MITRA -->
                <section class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-6 shadow-xl flex items-center justify-between gap-3 border border-black/5">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-[#52524E] uppercase tracking-wider font-semibold">Integrasi Cloud &amp; POS</span>
                        <h5 class="font-urbanist font-extrabold text-base text-[#161616] leading-tight">
                            Pusat Bantuan Mitra
                        </h5>
                    </div>
                    <a href="{{ route('profile') }}"
                        class="btn-interactive px-4 py-2 rounded-full bg-[#161616] hover:bg-black text-white font-urbanist text-xs font-bold flex items-center gap-1.5 shadow-md active:scale-95 transition-all shrink-0">
                        <span>Profil Admin</span>
                        <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                    </a>
                </section>

            </div>

        </div>

        <!-- E. FOOTER KAPSUL MELAYANG -->
        <footer class="w-full mt-2">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 px-6 py-3.5 rounded-full bg-black/40 backdrop-blur-md border border-white/10 text-white/70 text-xs font-manrope">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#8FBF5B] animate-pulse"></span>
                    <span>Cloud Sync: Terhubung Real-Time (99.98% High SLA) • Multi-Tenant Node Jakarta-01</span>
                </div>
                <div class="font-urbanist font-bold uppercase tracking-wider text-white/50 text-[11px]">
                    StockBarang Studio • Precision Bento Stock Asset System
                </div>
            </div>
        </footer>

    </div>
</div>
