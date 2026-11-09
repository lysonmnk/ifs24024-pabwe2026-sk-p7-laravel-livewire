<div class="bento-dashboard-bg bento-grain-overlay min-h-screen -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 text-white relative font-manrope selection:bg-[#8FBF5B] selection:text-black">
    <div class="relative z-10 max-w-[1400px] mx-auto flex flex-col gap-6 sm:gap-8 pb-12">

        <!-- A. TOP HEADER NAVIGATION -->
        <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-white/10">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.users') }}"
                    class="group inline-flex items-center gap-2 px-4 py-2 rounded-full bg-black/40 hover:bg-black/60 border border-white/15 text-white/90 hover:text-white text-xs sm:text-sm font-medium backdrop-blur-md transition-all shadow-md">
                    <span class="material-symbols-outlined text-[18px] text-[#8FBF5B] transition-transform group-hover:-translate-x-1">arrow_back</span>
                    <span>Kembali ke Daftar Pengguna</span>
                </a>

                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-black/40 border border-white/15 backdrop-blur-md text-xs font-semibold text-white/90">
                    <span class="w-2 h-2 rounded-full bg-[#8FBF5B] animate-pulse"></span>
                    <span>Inspeksi Multi-Tenant</span>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <button type="button" wire:click="exportExcel" wire:loading.attr="disabled"
                    class="btn-interactive inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] text-[#0A0A0A] font-bold text-xs sm:text-sm shadow-lg shadow-[#8FBF5B]/25 active:scale-95 transition-all">
                    <span wire:loading.remove wire:target="exportExcel" class="material-symbols-outlined text-[18px] font-bold">download</span>
                    <svg wire:loading wire:target="exportExcel" class="animate-spin h-4 w-4 text-black" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span wire:loading.remove wire:target="exportExcel">Export Excel Stok Ini</span>
                    <span wire:loading wire:target="exportExcel">Mengekspor...</span>
                </button>
            </div>
        </header>

        <!-- B. USER IDENTITY HERO BANNER & TELEMETRY STATS -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
            <!-- User Info Left Deck -->
            <div class="lg:col-span-5 flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-[#1E3A12] border-2 border-[#8FBF5B]/40 flex items-center justify-center text-[#8FBF5B] font-urbanist font-extrabold text-2xl shadow-xl shrink-0">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="px-2.5 py-0.5 rounded-full bg-[#8FBF5B]/20 text-[#8FBF5B] font-urbanist text-[11px] font-bold border border-[#8FBF5B]/30 uppercase">
                            {{ ucfirst($user->role) }}
                        </span>
                        <span class="text-xs font-mono text-white/50">&#64;{{ $user->username }}</span>
                    </div>
                    <h1 class="font-urbanist text-2xl sm:text-3xl font-extrabold text-white tracking-tight mt-1 leading-tight">
                        {{ $user->name }}
                    </h1>
                    <p class="text-xs text-white/60 font-mono mt-0.5">
                        {{ $user->email }} • ID: SB-USR-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}
                    </p>
                    <div class="mt-2 inline-flex items-center gap-1.5 text-[11px] font-semibold text-[#8FBF5B] bg-[#141414] px-3 py-1 rounded-full border border-white/10 w-fit">
                        <span class="material-symbols-outlined text-[15px]">lock</span>
                        <span>Mode Lihat Saja (Read-Only Admin Guard)</span>
                    </div>
                </div>
            </div>

            <!-- 3 Horizontal Telemetry Cards Right -->
            <div class="lg:col-span-7 flex flex-wrap sm:flex-nowrap items-center justify-between gap-4 bg-black/35 backdrop-blur-xl border border-white/10 rounded-[28px] p-5 shadow-2xl">
                <!-- Total SKU -->
                <div class="flex flex-col">
                    <span class="text-[10px] text-white/60 uppercase tracking-wider font-semibold">Total Item User</span>
                    <div class="flex items-baseline gap-1 mt-0.5">
                        <span class="font-urbanist text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-none">
                            {{ $telemetry['total_sku'] ?? 0 }}
                        </span>
                        <sup class="font-urbanist font-bold text-xs text-[#C8D7B4] -top-2">SKU</sup>
                    </div>
                </div>

                <div class="w-px h-10 bg-white/15"></div>

                <!-- Total Nilai Aset User -->
                <div class="flex flex-col">
                    <span class="text-[10px] text-white/60 uppercase tracking-wider font-semibold">Total Nilai Aset</span>
                    <div class="flex items-baseline gap-1 mt-0.5">
                        <span class="font-urbanist text-3xl sm:text-4xl lg:text-5xl font-extrabold text-[#8FBF5B] leading-none">
                            {{ number_format($telemetry['total_asset_value'] ?? 0, 0, ',', '.') }}
                        </span>
                        <sup class="font-urbanist font-bold text-xs text-white -top-2">Rp</sup>
                    </div>
                </div>

                <div class="w-px h-10 bg-white/15"></div>

                <!-- Rasio Stok Aman -->
                <div class="flex flex-col">
                    <span class="text-[10px] text-white/60 uppercase tracking-wider font-semibold">Rasio Stok Aman</span>
                    <div class="flex items-baseline gap-1 mt-0.5">
                        <span class="font-urbanist text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-none">
                            {{ $telemetry['safe_ratio'] ?? 100 }}%
                        </span>
                        <sup class="font-urbanist font-bold text-xs text-[#8FBF5B] -top-2">Rasio</sup>
                    </div>
                </div>
            </div>
        </section>

        <!-- C. BARIS FILTER & PENCARIAN -->
        <section class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            <!-- Status Filter Chips -->
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
                <button type="button" wire:click="$set('statusFilter', '')"
                    class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all shrink-0 {{ $statusFilter === '' ? 'bg-white text-black font-bold shadow-md' : 'bg-black/40 hover:bg-black/60 text-white/80 hover:text-white border border-white/15 backdrop-blur-md' }}">
                    Semua Status
                </button>
                @foreach ($statuses as $st)
                    <button type="button" wire:click="$set('statusFilter', '{{ $st->value }}')"
                        class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all shrink-0 {{ $statusFilter === $st->value ? 'bg-[#8FBF5B] text-black font-bold shadow-md shadow-[#8FBF5B]/20' : 'bg-black/40 hover:bg-black/60 text-white/80 hover:text-white border border-white/15 backdrop-blur-md' }}">
                        {{ $st->label() }}
                    </button>
                @endforeach
            </div>

            <!-- Search Bar Debounced -->
            <div class="relative w-full sm:w-80">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-white/50 text-[18px]">search</span>
                <input id="admin-search-stock" type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama, SKU, supplier, rak..."
                    class="w-full h-11 pl-11 pr-9 bg-black/40 border border-white/15 text-white placeholder:text-white/40 text-xs sm:text-sm rounded-full outline-none focus:border-[#8FBF5B] backdrop-blur-md transition-all" />
                <div wire:loading wire:target="search,statusFilter" class="absolute right-3.5 top-3">
                    <svg class="animate-spin h-4 w-4 text-[#8FBF5B]" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </div>
            </div>
        </section>

        <!-- D. BENTO INSPECTION TABLE CARD -->
        <section class="bg-[#141414] rounded-[32px] p-6 sm:p-8 shadow-2xl border border-white/10 flex flex-col gap-6">
            <div class="flex items-center justify-between pb-3 border-b border-white/10 flex-wrap gap-2">
                <div class="flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-[#8FBF5B] text-[22px]">inventory_2</span>
                    <h2 class="font-urbanist font-bold text-xl text-white">Inventaris Terdaftar Pengguna</h2>
                </div>
                <span class="text-xs text-white/50 font-mono">Total {{ $stocks->total() }} Barang Ditemukan</span>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-white/10 bg-[#1C1C1C]">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr class="bg-black/40 border-b border-white/10 text-white/60 font-semibold uppercase text-[11px]">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Nama Barang / SKU</th>
                            <th class="py-3 px-4">Kategori &amp; Rak</th>
                            <th class="py-3 px-4">Kuantitas</th>
                            <th class="py-3 px-4">Harga Pokok</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Didaftarkan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse ($stocks as $index => $item)
                            @php
                                $stEnum = $item->status instanceof \App\Features\Stock\Enums\StockStatus ? $item->status : \App\Features\Stock\Enums\StockStatus::tryFrom($item->status);
                            @endphp
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="py-3.5 px-4 text-white/50 font-mono text-xs">
                                    {{ $stocks->firstItem() + $index }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-bold text-white text-sm">{{ $item->name }}</div>
                                    <div class="text-[11px] font-mono text-white/50">{{ $item->sku ?: 'No SKU' }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-xs">
                                    <span class="text-white/80 font-medium">{{ $item->category ?: 'Umum' }}</span>
                                    <span class="text-white/40 block text-[11px]">{{ $item->rack_location ? 'Rak ' . $item->rack_location : '-' }}</span>
                                </td>
                                <td class="py-3.5 px-4 font-urbanist font-bold text-white text-base">
                                    {{ $item->quantity }} <span class="text-xs text-white/50 font-normal font-manrope">{{ $item->unit }}</span>
                                </td>
                                <td class="py-3.5 px-4 font-mono text-white/90">
                                    {{ $item->price !== null ? 'Rp ' . number_format($item->price, 0, ',', '.') : '-' }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if ($item->quantity <= 0)
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#E2725B]/20 text-[#FFAAA0] border border-[#E2725B]/30">
                                            Habis
                                        </span>
                                    @elseif ($item->quantity <= $item->min_stock)
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">
                                            Menipis
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#8FBF5B]/20 text-[#8FBF5B] border border-[#8FBF5B]/30">
                                            Tersedia
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-white/50 text-xs">
                                    {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-white/50">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-white/30">inventory</span>
                                    <p class="text-sm">Pengguna ini belum memiliki data stok barang yang sesuai filter.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div class="pt-4 border-t border-white/10 flex items-center justify-between flex-wrap gap-3">
                <span class="text-xs text-white/50">
                    Menampilkan <strong class="text-white">{{ $stocks->count() }}</strong> dari <strong class="text-white">{{ $stocks->total() }}</strong> item
                </span>
                <div class="bento-pagination">
                    {{ $stocks->links() }}
                </div>
            </div>
        </section>

    </div>
</div>
