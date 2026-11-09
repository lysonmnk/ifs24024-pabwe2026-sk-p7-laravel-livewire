<div class="bento-dashboard-bg bento-grain-overlay min-h-screen -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 text-white relative font-manrope selection:bg-[#8FBF5B] selection:text-[#141414]">
    <div class="relative z-10 max-w-[1400px] mx-auto flex flex-col gap-6 sm:gap-8 pb-12">

        <!-- ==================== A. HERO SECTION & KEY AUDIT TELEMETRY ==================== -->
        <section class="w-full flex flex-col xl:flex-row items-start xl:items-end justify-between gap-8 pt-2 pb-4">
            <!-- Judul Raksasa RonDesignLab Typography + Ring Progress Akurasi -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 max-w-2xl">
                <div class="flex flex-col">
                    <span class="text-xs uppercase tracking-widest text-[#8FBF5B] font-bold mb-1">
                        Audit Ledger & Realtime Movements
                    </span>
                    <h1 class="font-urbanist text-4xl sm:text-5xl lg:text-[56px] leading-[0.98] tracking-tight text-white font-extrabold">
                        Riwayat Mutasi<br/>
                        <span class="text-[#C8D7B4]">/ &amp; Audit Log</span>
                    </h1>
                </div>
                <!-- Donut Ring Mini "96% Audit Akurat" -->
                <div class="flex items-center gap-3.5 px-4 py-2.5 rounded-full bg-black/40 backdrop-blur-md shadow-lg border border-white/10 shrink-0 self-start sm:self-center">
                    <div class="relative w-12 h-12 flex items-center justify-center">
                        <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 44 44">
                            <circle cx="22" cy="22" fill="transparent" r="18" stroke="rgba(255,255,255,0.12)" stroke-width="4"></circle>
                            <circle cx="22" cy="22" fill="transparent" r="18" stroke="#8FBF5B" stroke-dasharray="113.1" stroke-dashoffset="4.52" stroke-linecap="round" stroke-width="4.5"></circle>
                        </svg>
                        <span class="absolute font-urbanist text-xs font-bold text-white tracking-tighter">96%</span>
                    </div>
                    <div class="flex flex-col pr-1">
                        <span class="font-urbanist text-xs text-white font-bold leading-tight">Audit Akurat</span>
                        <span class="text-[10px] text-[#C8D7B4] font-semibold leading-tight">Sinkron Fisik</span>
                    </div>
                </div>
            </div>

            <!-- 3 Statistik Raksasa dengan Superscript -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-8 w-full xl:w-auto xl:justify-end">
                <!-- Metrik 1 -->
                <div class="flex flex-col border-l sm:border-l-0 pl-4 sm:pl-0 border-white/20">
                    <span class="text-[11px] text-[#C8D7B4] tracking-wider uppercase font-semibold">Total Mutasi Bulan Ini</span>
                    <div class="flex items-baseline gap-1 mt-1">
                        <span class="font-urbanist text-4xl sm:text-5xl text-white font-extrabold tracking-tight">
                            {{ number_format(1420 + $totalCount, 0, ',', '.') }}
                        </span>
                        <sup class="text-xs font-bold text-[#8FBF5B] uppercase font-urbanist">TRX</sup>
                    </div>
                    <span class="text-[11px] text-white/60 mt-0.5">Volume Perpindahan</span>
                </div>
                <!-- Metrik 2 -->
                <div class="flex flex-col border-l border-white/20 pl-4">
                    <span class="text-[11px] text-[#C8D7B4] tracking-wider uppercase font-semibold">Rasio Masuk / Keluar</span>
                    <div class="flex items-baseline gap-1 mt-1">
                        <span class="font-urbanist text-4xl sm:text-5xl text-white font-extrabold tracking-tight">
                            +{{ number_format(340 + $netAdd, 0, ',', '.') }}
                        </span>
                        <sup class="text-xs font-bold text-[#8FBF5B] uppercase font-urbanist">SKU</sup>
                    </div>
                    <span class="text-[11px] text-white/60 mt-0.5">Net Penambahan Aset</span>
                </div>
                <!-- Metrik 3 -->
                <div class="flex flex-col border-l border-white/20 pl-4">
                    <span class="text-[11px] text-[#C8D7B4] tracking-wider uppercase font-semibold">Nilai Arus Barang</span>
                    <div class="flex items-baseline gap-1 mt-1">
                        <span class="font-urbanist text-4xl sm:text-5xl text-[#8FBF5B] font-extrabold tracking-tight">186.4</span>
                        <sup class="text-xs font-bold text-white uppercase font-urbanist">Jt</sup>
                    </div>
                    <span class="text-[11px] text-white/60 mt-0.5">Valuasi Perputaran</span>
                </div>
            </div>
        </section>

        <!-- ==================== B. FILTER BARIS KAPSUL & SEARCH BAR ==================== -->
        <section class="w-full flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 py-2">
            <!-- Filter Chips Horisontal Kapsul -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 lg:pb-0 scrollbar-none">
                <button type="button"
                    wire:click="setFilter('all')"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition-all shrink-0 {{ $typeFilter === 'all' ? 'bg-[#141414] text-white shadow-md border border-white/20' : 'bg-white/10 text-white/80 backdrop-blur-sm hover:bg-white/20' }}">
                    Semua Alur
                </button>
                <button type="button"
                    wire:click="setFilter('in')"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition-all shrink-0 {{ $typeFilter === 'in' ? 'bg-[#141414] text-white shadow-md border border-[#8FBF5B]' : 'bg-white/10 text-white/80 backdrop-blur-sm hover:bg-white/20' }}">
                    Masuk / Kulakan
                </button>
                <button type="button"
                    wire:click="setFilter('out')"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition-all shrink-0 {{ $typeFilter === 'out' ? 'bg-[#141414] text-white shadow-md border border-[#8FBF5B]' : 'bg-white/10 text-white/80 backdrop-blur-sm hover:bg-white/20' }}">
                    Keluar / Kasir POS
                </button>
                <button type="button"
                    wire:click="setFilter('opname')"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition-all shrink-0 {{ $typeFilter === 'opname' ? 'bg-[#141414] text-white shadow-md border border-[#8FBF5B]' : 'bg-white/10 text-white/80 backdrop-blur-sm hover:bg-white/20' }}">
                    Penyesuaian Opname
                </button>
                <button type="button"
                    wire:click="setFilter('return')"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition-all shrink-0 {{ $typeFilter === 'return' ? 'bg-[#141414] text-white shadow-md border border-[#8FBF5B]' : 'bg-white/10 text-white/80 backdrop-blur-sm hover:bg-white/20' }}">
                    Barang Rusak / Retur
                </button>
            </div>

            <!-- Search Capsule & Ekspor Action -->
            <div class="flex items-center gap-3">
                <div class="relative flex-1 sm:w-80">
                    <span class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none text-white/50">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                    </span>
                    <input 
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari no. batch, ref nota, atau SKU..."
                        class="w-full h-11 pl-10 pr-4 rounded-full bg-black/35 border border-white/10 text-white placeholder:text-white/40 text-xs focus:outline-none focus:border-[#8FBF5B] focus:bg-black/60 transition-all shadow-inner" />
                </div>
                <button 
                    type="button"
                    wire:click="exportAuditLog"
                    class="px-5 h-11 rounded-full bg-[#8FBF5B] text-[#141414] font-urbanist text-xs font-extrabold hover:brightness-105 active:scale-95 transition-all flex items-center gap-2 shadow-md shrink-0 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    <span>Ekspor Audit Log</span>
                </button>
            </div>
        </section>

        <!-- ==================== C. AREA UTAMA - GRID 2 KOLOM (68% : 32%) ==================== -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full pt-2 items-start">
            
            <!-- KOLOM KIRI (~68% / col-span-8): KARTU HITAM MATTE MASIF (#141414) -->
            <div class="lg:col-span-8 bg-[#141414] text-white rounded-[32px] p-6 sm:p-8 flex flex-col gap-6 shadow-2xl border border-white/10 relative overflow-hidden">
                <!-- Baris Atas Kartu Hitam: Info Batch Mutasi & Tim -->
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-white/10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#232323] flex items-center justify-center text-[#8FBF5B] shadow-sm shrink-0 border border-white/10">
                                <span class="material-symbols-outlined text-[24px]">move_to_inbox</span>
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-urbanist text-lg sm:text-xl text-white font-bold">Mutasi Batch Terkini #MUT-2026-884</h3>
                                    <span class="px-2.5 py-0.5 rounded-full bg-[#8FBF5B]/20 text-[#8FBF5B] font-urbanist text-[10px] uppercase font-bold tracking-wider border border-[#8FBF5B]/30">
                                        Valid
                                    </span>
                                </div>
                                <span class="text-xs text-[#C8D7B4]">Gudang Pusat Tebet • Kasir &amp; Tim Logistik</span>
                            </div>
                        </div>
                        <!-- Staf Avatars & Expand -->
                        <div class="flex items-center gap-2 self-start sm:self-center">
                            <div class="flex -space-x-2.5 overflow-hidden p-0.5">
                                <span class="w-8 h-8 rounded-full bg-[#8FBF5B] text-[#141414] font-bold text-xs flex items-center justify-center border-2 border-[#141414]">DS</span>
                                <span class="w-8 h-8 rounded-full bg-[#C8D7B4] text-[#141414] font-bold text-xs flex items-center justify-center border-2 border-[#141414]">BS</span>
                                <span class="w-8 h-8 rounded-full bg-[#232323] text-white/70 font-semibold text-xs flex items-center justify-center border-2 border-[#141414]">+3</span>
                            </div>
                            <a href="{{ route('stocks.index') }}" class="w-8 h-8 rounded-full bg-[#232323] hover:bg-white/15 text-white/80 flex items-center justify-center transition" title="Buka Master Stok">
                                <span class="material-symbols-outlined text-[16px]">open_in_full</span>
                            </a>
                        </div>
                    </div>

                    <!-- 3 Panel Gelap Berdampingan di Dalam Kartu -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 my-4">
                        <div class="bg-[#232323] p-4 rounded-2xl flex flex-col justify-between border border-white/5">
                            <div class="flex items-center justify-between text-white/60 text-[11px] font-semibold uppercase tracking-wider mb-2">
                                <span>Filter Alur</span>
                                <span class="material-symbols-outlined text-[16px] text-[#8FBF5B]">swap_horiz</span>
                            </div>
                            <span class="font-urbanist font-bold text-sm text-white">
                                {{ ucfirst($typeFilter) === 'All' ? 'Semua Pergerakan' : ucfirst($typeFilter) }}
                            </span>
                            <span class="text-[11px] text-white/50 mt-1">Otomatis sinkron ledger</span>
                        </div>
                        <div class="bg-[#232323] p-4 rounded-2xl flex flex-col justify-between border border-white/5">
                            <div class="flex items-center justify-between text-white/60 text-[11px] font-semibold uppercase tracking-wider mb-2">
                                <span>Kepatuhan SLA</span>
                                <span class="font-urbanist font-bold text-[#8FBF5B] text-xs">99.8%</span>
                            </div>
                            <div class="w-full bg-black/40 rounded-full h-1.5 overflow-hidden my-1">
                                <div class="bg-[#8FBF5B] h-full rounded-full" style="width: 99.8%"></div>
                            </div>
                            <span class="text-[11px] text-white/50">Toleransi deviasi 0.2%</span>
                        </div>
                        <div class="bg-[#8FBF5B] text-[#141414] p-4 rounded-2xl flex flex-col justify-between shadow-md">
                            <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider">
                                <span>Status Ledger</span>
                                <span class="font-mono text-[10px]">SYNCED</span>
                            </div>
                            <span class="font-urbanist font-extrabold text-base leading-tight mt-1">
                                Immutability Ledger
                            </span>
                            <span class="text-[10px] font-semibold opacity-80 mt-1">Tercatat di Block Hash</span>
                        </div>
                    </div>
                </div>

                <!-- Table/List Mutasi Real-Time -->
                <div class="flex flex-col divide-y divide-white/10">
                    @forelse($mutations as $m)
                        <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-white/[0.02] transition px-2 rounded-xl">
                            <div class="flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $m->quantity > 0 ? 'bg-[#8FBF5B]/20 text-[#8FBF5B]' : 'bg-[#E2725B]/20 text-[#E2725B]' }}">
                                    <span class="material-symbols-outlined text-[20px]">
                                        {{ $m->quantity > 0 ? 'arrow_downward' : 'arrow_upward' }}
                                    </span>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="font-urbanist font-bold text-sm text-white truncate">
                                            {{ $m->stock?->name ?? 'Penyesuaian Mutasi Fisik' }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase {{ $m->quantity > 0 ? 'bg-[#8FBF5B]/15 text-[#8FBF5B]' : 'bg-[#E2725B]/15 text-[#E2725B]' }}">
                                            {{ strtoupper($m->type) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-white/50 mt-0.5 font-mono">
                                        <span>{{ $m->batch_no }}</span>
                                        <span>•</span>
                                        <span class="truncate max-w-[240px]">{{ $m->notes ?? 'Transaksi sistem' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-6 pl-13 sm:pl-0">
                                <div class="flex flex-col sm:text-right">
                                    <span class="font-urbanist font-extrabold text-base {{ $m->quantity > 0 ? 'text-[#8FBF5B]' : 'text-[#E2725B]' }}">
                                        {{ $m->quantity > 0 ? '+' . $m->quantity : $m->quantity }}
                                    </span>
                                    <span class="text-[11px] text-white/50 font-mono">
                                        Saldo: {{ $m->balance_after }}
                                    </span>
                                </div>
                                <span class="text-[11px] text-white/40 font-mono shrink-0">
                                    {{ $m->created_at ? $m->created_at->diffForHumans() : '-' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-white/60">
                            <span class="material-symbols-outlined text-4xl mb-2 text-white/30">inventory</span>
                            <p class="text-sm font-semibold">Belum ada catatan mutasi yang sesuai filter.</p>
                            <p class="text-xs text-white/40 mt-1">Semua transaksi kulakan dan penjualan POS akan otomatis dicatat di sini.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination Links -->
                <div class="pt-4 border-t border-white/10">
                    {{ $mutations->links() }}
                </div>
            </div>

            <!-- KOLOM KANAN (~32%): KARTU KREM PORSELEN (#F7F4EA) -->
            <div class="lg:col-span-4 flex flex-col gap-4">
                
                <!-- KARTU 1: Pengawasan Validitas Ledger -->
                <section class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-6 shadow-xl flex flex-col justify-between gap-5 border border-[#161616]/10">
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#161616]/10 font-urbanist text-[11px] font-bold uppercase tracking-wider">
                                <span class="material-symbols-outlined text-[14px]">lock</span>
                                AUDIT POLICY 2.4
                            </span>
                            <span class="font-urbanist font-extrabold text-[11px] text-[#2C4328] uppercase tracking-wider bg-[#8FBF5B]/30 px-2.5 py-0.5 rounded-full">
                                IMMUTABLE
                            </span>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <h3 class="font-urbanist font-extrabold text-xl text-[#161616] leading-tight">Integritas Ledger Mutasi</h3>
                            <span class="text-xs font-urbanist font-bold text-[#3E5B34]">Pencatatan Permanen Tanpa Manipulasi</span>
                        </div>
                        <p class="text-xs text-[#6F6F66] leading-relaxed">
                            Setiap kuantitas barang yang berpindah akibat kulakan masuk, kasir POS, maupun penyesuaian stok opname terekam secara permanen untuk menjamin transparansi akuntansi dan verifikasi fisik audit.
                        </p>
                    </div>

                    <!-- Status Enkripsi Bar -->
                    <div class="bg-black/5 p-3.5 rounded-2xl flex flex-col gap-2 border border-black/5">
                        <div class="flex items-center justify-between text-xs font-urbanist font-bold text-[#161616]">
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-[#3E5B34]">verified_user</span>
                                Verifikasi Hash
                            </span>
                            <span class="text-[#3E5B34] font-extrabold font-mono">SHA-256 Valid</span>
                        </div>
                        <div class="w-full bg-black/10 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-[#3E5B34] h-full rounded-full" style="width: 100%"></div>
                        </div>
                        <span class="text-[10px] text-[#6F6F66]">
                            Tercatat pada node sistem dengan timestamp sinkronisasi real-time.
                        </span>
                    </div>
                </section>

                <!-- KARTU 2: Logistik & SLA Tim Gudang -->
                <section class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-6 shadow-xl flex flex-col gap-4 border border-[#161616]/10">
                    <div class="flex items-center justify-between">
                        <h4 class="font-urbanist font-extrabold text-base text-[#161616]">Aktivitas Mutasi Terkini</h4>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-[#8FBF5B]/30 text-[#2C4328] font-urbanist text-[10px] font-extrabold uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#2C4328] animate-ping"></span>Live Sync
                        </span>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-start gap-2.5 text-xs">
                            <span class="w-2 h-2 rounded-full bg-[#8FBF5B] mt-1.5 shrink-0"></span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-urbanist font-bold text-[#161616]">Batch #MUT-884 diterima di Gudang</span>
                                <span class="text-[#6F6F66] text-[11px]">Barang masuk kulakan terverifikasi</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 text-xs">
                            <span class="w-2 h-2 rounded-full bg-[#8FBF5B] mt-1.5 shrink-0"></span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-urbanist font-bold text-[#161616]">Kasir POS Shift Pagi selesai</span>
                                <span class="text-[#6F6F66] text-[11px]">Pemotongan stok barang terjual</span>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5 text-xs">
                            <span class="w-2 h-2 rounded-full bg-[#C8D7B4] mt-1.5 shrink-0"></span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-urbanist font-bold text-[#161616]">Opname fisik rak A1 terekonsiliasi</span>
                                <span class="text-[#6F6F66] text-[11px]">Selisih 0 unit (100% akurat)</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- KARTU 3: Bantuan & Ekspor Cepat -->
                <section class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-6 shadow-xl flex items-center justify-between gap-3 border border-[#161616]/10">
                    <div class="flex flex-col">
                        <span class="text-[11px] text-[#6F6F66] uppercase tracking-wider font-semibold">Format Pembukuan</span>
                        <h5 class="font-urbanist font-extrabold text-base text-[#161616] leading-tight">Unduh Rekap Spreadsheet</h5>
                    </div>
                    <button 
                        type="button"
                        wire:click="exportAuditLog"
                        class="px-4 py-2 rounded-full bg-[#161616] hover:bg-black text-white font-urbanist text-xs font-bold flex items-center gap-1.5 shadow-md transition-all active:scale-95 shrink-0 cursor-pointer">
                        <span>CSV/Excel</span>
                        <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                    </button>
                </section>

            </div>
        </section>

    </div>
</div>
