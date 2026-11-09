<div class="bento-dashboard-bg bento-grain-overlay min-h-screen -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 text-white relative font-manrope selection:bg-[#8FBF5B] selection:text-[#141414]">
    <div class="relative z-10 max-w-[1400px] mx-auto flex flex-col gap-6 sm:gap-8 pb-12">

        <!-- HERO SECTION -->
        <section class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 pt-2 pb-2">
            <div class="flex flex-col sm:flex-row sm:items-center gap-6 lg:gap-8">
                <!-- Judul Raksasa 2 Baris 56px Urbanist -->
                <h1 class="font-urbanist font-extrabold text-4xl sm:text-5xl lg:text-[60px] leading-[0.94] tracking-tight text-white m-0">
                    Laporan<br/>
                    <span class="text-[#8FBF5B]">Penjualan &amp; Laba</span>
                </h1>

                <!-- Donut Progress 92% Audit Terverifikasi -->
                <div class="flex items-center gap-3.5 pl-1 sm:border-l sm:border-white/20 sm:pl-7">
                    <div class="relative w-15 h-15 flex items-center justify-center shrink-0">
                        <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                            <path class="text-black/30" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3.5"></path>
                            <path class="text-[#8FBF5B]" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="92, 100" stroke-linecap="round" stroke-width="3.5"></path>
                        </svg>
                        <span class="absolute font-urbanist font-extrabold text-white text-xs">92%</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[11px] font-bold text-[#C8D7B4] uppercase tracking-wider font-urbanist">Audit Terverifikasi</span>
                        <span class="text-xs text-white/70">Rekonsiliasi Otomatis POS</span>
                    </div>
                </div>
            </div>

            <!-- 3 Angka Statistik Berderet Horizontal Raksasa -->
            <div class="grid grid-cols-3 gap-6 sm:gap-10 border-t lg:border-t-0 border-white/15 pt-4 lg:pt-0">
                <div>
                    <span class="block text-[11px] uppercase tracking-wider text-white/60 font-semibold mb-1">Total Omset</span>
                    <div class="font-urbanist font-extrabold text-3xl sm:text-[46px] text-white leading-none tracking-tight">
                        {{ number_format($omsetJt, 2, ',', '.') }}<sup class="text-sm sm:text-base font-bold text-[#8FBF5B] ml-1 uppercase">Jt</sup>
                    </div>
                    <span class="text-[11px] text-[#8FBF5B] font-semibold mt-1.5 block">+24.8% vs bulan lalu</span>
                </div>
                <div>
                    <span class="block text-[11px] uppercase tracking-wider text-white/60 font-semibold mb-1">Laba Bersih</span>
                    <div class="font-urbanist font-extrabold text-3xl sm:text-[46px] text-[#8FBF5B] leading-none tracking-tight">
                        {{ number_format($labaJt, 2, ',', '.') }}<sup class="text-sm sm:text-base font-bold text-white ml-1 uppercase">Jt</sup>
                    </div>
                    <span class="text-[11px] text-white/70 font-semibold mt-1.5 block">Margin 21.9% Bersih</span>
                </div>
                <div>
                    <span class="block text-[11px] uppercase tracking-wider text-white/60 font-semibold mb-1">Piutang / Bon</span>
                    <div class="font-urbanist font-extrabold text-3xl sm:text-[46px] text-[#E2725B] leading-none tracking-tight">
                        {{ number_format($piutangJt, 2, ',', '.') }}<sup class="text-sm sm:text-base font-bold text-white ml-1 uppercase">Jt</sup>
                    </div>
                    <span class="text-[11px] text-[#E2725B] font-semibold mt-1.5 block">8 Nota Aktif Berjalan</span>
                </div>
            </div>
        </section>

        <!-- BARIS FILTER & AKSI -->
        <section class="flex flex-wrap items-center justify-between gap-3 py-1">
            <!-- Filter Pills -->
            <div class="flex flex-wrap items-center gap-2">
                <button type="button"
                    wire:click="setPeriod('all')"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition-all {{ $periodFilter === 'all' ? 'bg-[#141414] text-white border border-white/25 shadow-md' : 'text-white/80 hover:text-white border border-white/20 bg-black/25 backdrop-blur-md' }}">
                    Semua Periode
                </button>
                <button type="button"
                    wire:click="setPeriod('today')"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition-all {{ $periodFilter === 'today' ? 'bg-[#141414] text-white border border-[#8FBF5B] shadow-md' : 'text-white/80 hover:text-white border border-white/20 bg-black/25 backdrop-blur-md' }}">
                    Hari Ini
                </button>
                <button type="button"
                    wire:click="setPeriod('week')"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition-all {{ $periodFilter === 'week' ? 'bg-[#141414] text-white border border-[#8FBF5B] shadow-md' : 'text-white/80 hover:text-white border border-white/20 bg-black/25 backdrop-blur-md' }}">
                    7 Hari Terakhir
                </button>
                <button type="button"
                    wire:click="setPeriod('month')"
                    class="px-4.5 py-2 rounded-full text-xs font-bold transition-all {{ $periodFilter === 'month' ? 'bg-[#141414] text-white border border-[#8FBF5B] shadow-md' : 'text-white/80 hover:text-white border border-white/20 bg-black/25 backdrop-blur-md' }}">
                    Bulan Ini (Okt 2026)
                </button>
                <button type="button"
                    wire:click="setPeriod('q3')"
                    class="px-4 py-2 rounded-full text-xs font-semibold transition-all {{ $periodFilter === 'q3' ? 'bg-[#141414] text-white border border-[#8FBF5B] shadow-md' : 'text-white/80 hover:text-white border border-white/20 bg-black/25 backdrop-blur-md' }}">
                    Kuartal 3
                </button>
            </div>

            <!-- Search + Action Button -->
            <div class="flex items-center gap-3">
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-3.5 text-white/40 text-[18px]">search</span>
                    <input 
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari nota, pelanggan, invoice..."
                        class="pl-9 pr-4 py-2 rounded-full bg-black/30 backdrop-blur-md border border-white/15 text-xs text-white placeholder-white/40 focus:outline-none focus:border-[#8FBF5B] w-64 shadow-inner" />
                </div>
                <button 
                    type="button"
                    wire:click="exportFinancialReport"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#8FBF5B] hover:brightness-105 active:scale-95 text-[#141414] font-urbanist font-extrabold text-xs tracking-wide shadow-lg transition-all cursor-pointer">
                    <span class="material-symbols-outlined text-[17px] font-bold">download</span>
                    <span>+ Unduh Laporan Excel / PDF</span>
                </button>
            </div>
        </section>

        <!-- GRID 2 KOLOM (Kiri ~68%, Kanan ~32%) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- KOLOM KIRI: SATU KARTU BENTO HITAM MATTE MASIF -->
            <div class="lg:col-span-8 bg-[#141414] text-white p-6 sm:p-8 rounded-[32px] shadow-2xl border border-white/10 flex flex-col gap-6 relative">
                <!-- Header Kartu -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-[#202020] border border-white/10 flex items-center justify-center text-[#8FBF5B]">
                            <span class="material-symbols-outlined text-[22px]">account_balance_wallet</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full bg-[#8FBF5B]/20 text-[#8FBF5B] border border-[#8FBF5B]/30 text-[10px] font-bold uppercase tracking-wider font-urbanist">
                                    Rekonsiliasi Kasir &amp; Arus Kas Real-Time
                                </span>
                            </div>
                            <h2 class="font-urbanist font-bold text-xl sm:text-2xl text-white tracking-tight mt-1">Audit Kas Harian &amp; Arus Margin Toko</h2>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Avatars Staf Akuntan -->
                        <div class="flex items-center -space-x-2">
                            <div class="w-7 h-7 rounded-full bg-[#353535] border-2 border-[#141414] text-[10px] flex items-center justify-center font-bold text-white">DS</div>
                            <div class="w-7 h-7 rounded-full bg-[#8FBF5B] border-2 border-[#141414] text-[10px] flex items-center justify-center font-bold text-[#141414]">BS</div>
                            <div class="w-7 h-7 rounded-full bg-[#474747] border-2 border-[#141414] text-[10px] flex items-center justify-center font-bold text-white">+2</div>
                        </div>
                        <!-- Tombol Action -->
                        <div class="flex items-center gap-1.5">
                            <button class="w-8 h-8 rounded-full bg-[#222222] hover:bg-[#333333] text-white/70 hover:text-white flex items-center justify-center transition-colors" type="button" title="Bagikan Ringkasan">
                                <span class="material-symbols-outlined text-[16px]">share</span>
                            </button>
                            <a href="{{ route('stocks.index') }}" class="w-8 h-8 rounded-full bg-[#222222] hover:bg-[#333333] text-white/70 hover:text-white flex items-center justify-center transition-colors" title="Buka Detail">
                                <span class="material-symbols-outlined text-[16px]">fullscreen</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Garis penghubung tipis dengan 3 titik centang bulat hijau lime -->
                <div class="relative flex items-center justify-between px-10 py-1">
                    <div class="absolute inset-x-10 top-1/2 -translate-y-1/2 h-[1px] bg-white/10"></div>
                    <div class="relative z-10 flex items-center gap-2 bg-[#141414] px-2">
                        <span class="w-5 h-5 rounded-full bg-[#8FBF5B] flex items-center justify-center text-[#141414] shadow-[0_0_10px_#8FBF5B] text-[10px] font-bold">
                            ✓
                        </span>
                        <span class="text-[11px] text-white/60 font-semibold">Audit Kalender</span>
                    </div>
                    <div class="relative z-10 flex items-center gap-2 bg-[#141414] px-2">
                        <span class="w-5 h-5 rounded-full bg-[#8FBF5B] flex items-center justify-center text-[#141414] shadow-[0_0_10px_#8FBF5B] text-[10px] font-bold">
                            ✓
                        </span>
                        <span class="text-[11px] text-white/60 font-semibold">Kanal Pembayaran</span>
                    </div>
                    <div class="relative z-10 flex items-center gap-2 bg-[#141414] px-2">
                        <span class="w-5 h-5 rounded-full bg-[#8FBF5B] flex items-center justify-center text-[#141414] shadow-[0_0_10px_#8FBF5B] text-[10px] font-bold">
                            ✓
                        </span>
                        <span class="text-[11px] text-white/60 font-semibold">Shift Cabang</span>
                    </div>
                </div>

                <!-- 3 Panel Gelap Berdampingan di Dalam Kartu -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Panel 1: Kalender Mini Audit Oktober -->
                    <div class="bg-[#1C1C1C] p-4 rounded-2xl border border-white/5 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-white/50">Audit Kasir</span>
                            <span class="text-xs font-bold text-white">Oktober 2026</span>
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-center text-[10px] my-2 text-white/40 font-medium font-mono">
                            <span class="text-white/70 font-bold">S</span>
                            <span class="text-white/70 font-bold">S</span>
                            <span class="text-white/70 font-bold">R</span>
                            <span class="text-white/70 font-bold">K</span>
                            <span class="text-white/70 font-bold">J</span>
                            <span class="text-[#8FBF5B] font-bold">S</span>
                            <span class="text-[#E2725B] font-bold">M</span>
                            <span class="text-white/30">26</span><span class="text-white/30">27</span><span class="text-white/30">28</span><span class="text-white/30">29</span><span class="text-white/30">30</span>
                            <span class="bg-[#8FBF5B]/20 text-[#8FBF5B] font-bold rounded">1</span>
                            <span class="bg-[#8FBF5B] text-[#141414] font-bold rounded">2</span>
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-white/50 pt-2 border-t border-white/5">
                            <span>Siklus Penutupan:</span>
                            <span class="text-[#8FBF5B] font-bold">Harian 23:59</span>
                        </div>
                    </div>

                    <!-- Panel 2: Proporsi Saluran Pembayaran -->
                    <div class="bg-[#1C1C1C] p-4 rounded-2xl border border-white/5 flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-white/50">Kanal Bayar</span>
                            <span class="text-[10px] text-[#8FBF5B] font-bold font-mono">100% OK</span>
                        </div>
                        <div class="flex flex-col gap-2 my-1">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-white/70">Tunai (Cash)</span>
                                <span class="font-bold text-white font-mono">58%</span>
                            </div>
                            <div class="w-full bg-black/40 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-[#8FBF5B] h-full rounded-full" style="width: 58%"></div>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-white/70">QRIS Dinamis</span>
                                <span class="font-bold text-[#C8D7B4] font-mono">32%</span>
                            </div>
                            <div class="w-full bg-black/40 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-[#C8D7B4] h-full rounded-full" style="width: 32%"></div>
                            </div>
                        </div>
                        <span class="text-[10px] text-white/40">10% Bon Toko berjalan</span>
                    </div>

                    <!-- Panel 3: Hijau Lime Laju Margin -->
                    <div class="bg-[#8FBF5B] text-[#141414] p-4 rounded-2xl flex flex-col justify-between shadow-md">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider">Performa Margin</span>
                            <span class="font-mono text-xs font-bold">+21.9%</span>
                        </div>
                        <div class="my-2">
                            <span class="text-[10px] uppercase font-bold opacity-80">Rata-rata Margin Harian</span>
                            <div class="font-urbanist font-extrabold text-2xl leading-tight">
                                Rp 1.080.000
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-[#141414]/15 text-[10px] font-bold">
                            <span>Efisiensi Pengadaan</span>
                            <span>Optimal ↑</span>
                        </div>
                    </div>
                </div>

                <!-- Tabel Transaksi Penjualan Finansial Toko -->
                <div class="flex flex-col divide-y divide-white/10">
                    <div class="pb-2 text-xs uppercase tracking-wider font-bold text-white/40 flex justify-between">
                        <span>Rincian Nota & Pelanggan</span>
                        <span>Nominal & Status</span>
                    </div>
                    @forelse($transactions as $t)
                        <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-white/[0.02] transition px-2 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#232323] flex items-center justify-center text-[#8FBF5B] shrink-0 border border-white/5">
                                    <span class="material-symbols-outlined text-[18px]">receipt</span>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="font-urbanist font-bold text-sm text-white truncate">{{ $t['customer'] }}</span>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase bg-white/10 text-white/80">
                                            {{ $t['payment_method'] }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-white/50 mt-0.5 font-mono">
                                        <span>{{ $t['ref_no'] }}</span>
                                        <span>•</span>
                                        <span>{{ $t['date'] }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between sm:justify-end gap-6 pl-12 sm:pl-0">
                                <div class="flex flex-col sm:text-right">
                                    <span class="font-urbanist font-bold text-base text-white">
                                        Rp {{ number_format($t['total'], 0, ',', '.') }}
                                    </span>
                                    <span class="text-[11px] text-[#8FBF5B] font-mono">
                                        +Rp {{ number_format($t['margin'], 0, ',', '.') }} Laba
                                    </span>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-urbanist font-bold uppercase tracking-wider shrink-0 {{ $t['status'] === 'Terekonsiliasi' ? 'bg-[#8FBF5B]/20 text-[#8FBF5B] border border-[#8FBF5B]/30' : 'bg-[#E2725B]/20 text-[#E2725B] border border-[#E2725B]/30' }}">
                                    {{ $t['status'] }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-white/50">
                            Tidak ada transaksi yang sesuai dengan pencarian.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- KOLOM KANAN: TUMPUKAN KARTU KREM PORSELEN (#F7F4EA) -->
            <div class="lg:col-span-4 flex flex-col gap-4">
                
                <!-- KARTU 1: Analisis Rasio Laba & Margin -->
                <section class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-6 shadow-xl flex flex-col justify-between gap-5 border border-[#161616]/10">
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#161616]/10 font-urbanist text-[11px] font-bold uppercase tracking-wider">
                                <span class="material-symbols-outlined text-[14px]">query_stats</span>
                                FINANSIAL RATIO
                            </span>
                            <span class="font-urbanist font-extrabold text-[11px] text-[#2C4328] uppercase tracking-wider bg-[#8FBF5B]/30 px-2.5 py-0.5 rounded-full">
                                HEALTHY
                            </span>
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <h3 class="font-urbanist font-extrabold text-xl text-[#161616] leading-tight">Analisis Margin Bersih</h3>
                            <span class="text-xs font-urbanist font-bold text-[#3E5B34]">Stabilitas Profitabilitas Toko</span>
                        </div>
                        <p class="text-xs text-[#6F6F66] leading-relaxed">
                            Rasio laba kotor terhadap omset berada di level 28.4% dengan margin bersih stabil pada 21.9%. Seluruh biaya operasional dan potongan diskon kasir telah terekonsiliasi otomatis.
                        </p>
                    </div>

                    <!-- Progress Laba Bersih -->
                    <div class="bg-black/5 p-3.5 rounded-2xl flex flex-col gap-2 border border-black/5">
                        <div class="flex items-center justify-between text-xs font-urbanist font-bold text-[#161616]">
                            <span>Gross Margin</span>
                            <span class="text-[#3E5B34] font-extrabold">28.4% (Sehat)</span>
                        </div>
                        <div class="w-full bg-black/10 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-[#3E5B34] h-full rounded-full" style="width: 82%"></div>
                        </div>
                        <span class="text-[10px] text-[#6F6F66]">
                            Target margin minimal kuartal 3 adalah 20.0%.
                        </span>
                    </div>
                </section>

                <!-- KARTU 2: Pengawasan Piutang & Buku Bon -->
                <section class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-6 shadow-xl flex flex-col gap-4 border border-[#161616]/10">
                    <div class="flex items-center justify-between">
                        <h4 class="font-urbanist font-extrabold text-base text-[#161616]">Pengawasan Piutang Bon</h4>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-[#E2725B]/20 text-[#E2725B] font-urbanist text-[10px] font-extrabold uppercase">
                            8 Nota Aktif
                        </span>
                    </div>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-start justify-between text-xs">
                            <div class="flex flex-col">
                                <span class="font-urbanist font-bold text-[#161616]">Depo Cakung</span>
                                <span class="text-[#6F6F66] text-[11px]">Jatuh tempo 3 hari lagi</span>
                            </div>
                            <span class="font-urbanist font-bold text-[#161616]">Rp 185.000</span>
                        </div>
                        <div class="flex items-start justify-between text-xs">
                            <div class="flex flex-col">
                                <span class="font-urbanist font-bold text-[#161616]">Kantin Sejahtera</span>
                                <span class="text-[#6F6F66] text-[11px]">Jatuh tempo 5 hari lagi</span>
                            </div>
                            <span class="font-urbanist font-bold text-[#161616]">Rp 620.000</span>
                        </div>
                    </div>
                    <a href="{{ route('stocks.index') }}" class="w-full py-2 rounded-full bg-[#161616] hover:bg-black text-white text-xs font-urbanist font-bold text-center transition">
                        Kelola Plafon Kredit
                    </a>
                </section>

                <!-- KARTU 3: Pusat Unduh Laporan Keuangan -->
                <section class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-6 shadow-xl flex items-center justify-between gap-3 border border-[#161616]/10">
                    <div class="flex flex-col">
                        <span class="text-[11px] text-[#6F6F66] uppercase tracking-wider font-semibold">Rekap Komprehensif</span>
                        <h5 class="font-urbanist font-extrabold text-base text-[#161616] leading-tight">Ekspor Finansial Toko</h5>
                    </div>
                    <button 
                        type="button"
                        wire:click="exportFinancialReport"
                        class="px-4 py-2 rounded-full bg-[#161616] hover:bg-black text-white font-urbanist text-xs font-bold flex items-center gap-1.5 shadow-md transition-all active:scale-95 shrink-0 cursor-pointer">
                        <span>CSV/Excel</span>
                        <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                    </button>
                </section>

            </div>
        </div>

    </div>
</div>
