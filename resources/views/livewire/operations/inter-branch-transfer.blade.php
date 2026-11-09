<div class="relative z-10 max-w-[1680px] mx-auto flex flex-col gap-6">
    <!-- Top Hero Section: Title, Donut Progress Ring, 3 Giant Metrics -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 px-1 py-2">
        <div class="flex flex-wrap items-center gap-6 sm:gap-8">
            <h1 class="font-urbanist font-medium text-4xl sm:text-5xl lg:text-6xl text-white leading-[1.04] tracking-[-0.02em]">
                Transfer Stok<br/><span class="text-white/90">Antar-Cabang &amp; Gudang</span>
            </h1>
            <!-- Donut Progress Ring (99.1% Mutasi Tuntas) -->
            <div class="flex items-center gap-3.5 pl-6 border-l border-white/20">
                <div class="relative w-16 h-16 flex items-center justify-center shrink-0">
                    <svg class="w-16 h-16 -rotate-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" fill="none" r="19" stroke="rgba(255,255,255,0.18)" stroke-width="3.5"></circle>
                        <circle cx="24" cy="24" fill="none" r="19" stroke="#8FBF5B" stroke-dasharray="119.38" stroke-dashoffset="1.07" stroke-linecap="round" stroke-width="3.5"></circle>
                    </svg>
                    <span class="absolute font-urbanist font-bold text-xs text-white">99%</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-semibold text-white/60 tracking-wider uppercase font-manrope">Akurasi</span>
                    <span class="font-urbanist text-sm font-bold text-[#8FBF5B]">99.1% Tuntas</span>
                </div>
            </div>
        </div>

        <!-- 3 Giant Stats -->
        <div class="flex items-baseline gap-6 sm:gap-10 overflow-x-auto pb-2 lg:pb-0 shrink-0">
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Muatan In-Transit</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">14.8</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">Ton</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Armada Aktif</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-[#8FBF5B] leading-none">06</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">Truk</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">On-Time SLA Cabang</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">98.9</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Action Bar -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 px-1">
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
            <button wire:click="$set('statusFilter', 'all')" 
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ $statusFilter === 'all' ? 'bg-[#141414] text-white shadow-md border border-white/20' : 'text-white/80 border border-white/20 hover:bg-white/10' }}">
                Semua Transfer
            </button>
            <button wire:click="$set('statusFilter', 'in_transit')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'in_transit' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Sedang Di Jalan (In-Transit)
            </button>
            <button wire:click="$set('statusFilter', 'persiapan')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'persiapan' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Persiapan Dok &amp; Muat
            </button>
            <button wire:click="$set('statusFilter', 'diterima')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'diterima' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Diterima Lengkap
            </button>
        </div>

        <div class="relative flex-1 md:w-80">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-white/50 text-[18px]">search</span>
            <input wire:model.live.debounce.300ms="search" 
                   type="text" 
                   class="w-full h-11 pl-10 pr-4 rounded-full bg-black/40 border border-white/20 text-white placeholder-white/50 text-xs focus:outline-none focus:border-[#8FBF5B] transition-all" 
                   placeholder="Cari transfer, cabang, armada...">
        </div>
    </div>

    <!-- Main Bento Grid (Left ~68% vs Right ~32%) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        <!-- LEFT COLUMN: Selected Transfer Detail (#141414) -->
        <div class="lg:col-span-8 bg-[#141414] rounded-[32px] p-6 sm:p-8 border border-white/10 shadow-2xl flex flex-col justify-between gap-6">
            @if($activeTransfer)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-white/10 border border-white/15 flex items-center justify-center text-[#8FBF5B] shrink-0">
                            <span class="material-symbols-outlined text-[26px]">rv_hookup</span>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-urbanist font-bold text-lg text-white tracking-tight truncate">
                                    {{ $activeTransfer['id'] }} • {{ $activeTransfer['from_branch'] }} ➔ {{ $activeTransfer['to_branch'] }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $activeTransfer['status'] === 'in_transit' ? 'bg-[#8FBF5B]/20 text-[#8FBF5B] border border-[#8FBF5B]/30' : ($activeTransfer['status'] === 'diterima' ? 'bg-white/10 text-white/80 border border-white/20' : 'bg-amber-500/20 text-amber-300 border border-amber-500/30') }}">
                                    {{ strtoupper($activeTransfer['status']) }}
                                </span>
                            </div>
                            <span class="text-xs text-white/60 mt-0.5">
                                {{ $activeTransfer['fleet'] }} • Driver: {{ $activeTransfer['driver'] }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <button wire:click="downloadSuratJalan('{{ $activeTransfer['id'] }}')" 
                                class="px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs text-white/90 hover:text-white hover:bg-white/20 transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">description</span>
                            <span>Surat Jalan</span>
                        </button>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="p-5 rounded-2xl bg-[#232323] border border-white/5">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-white/80">Perjalanan Logistik Antar Cabang</span>
                        <span class="font-urbanist text-sm font-bold text-[#8FBF5B]">
                            {{ $activeTransfer['progress'] }}
                        </span>
                    </div>
                    <div class="w-full h-3 rounded-full bg-black/40 overflow-hidden">
                        <div class="h-full rounded-full bg-[#8FBF5B] transition-all duration-500" style="width: {{ $activeTransfer['progress'] }};"></div>
                    </div>
                    <div class="flex items-center justify-between mt-2 text-xs text-white/50">
                        <span>Berangkat: {{ $activeTransfer['departure_time'] }}</span>
                        <span>Estimasi Tiba: {{ $activeTransfer['eta'] }}</span>
                    </div>
                </div>

                <!-- 3 Bento Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-white/90">Daftar Muatan Stok</span>
                            <p class="text-xs text-white font-medium mt-3 leading-relaxed">
                                {{ $activeTransfer['item_summary'] }}
                            </p>
                        </div>
                        <span class="text-[11px] text-[#8FBF5B] font-bold">Segel: {{ $activeTransfer['seal_number'] }}</span>
                    </div>

                    <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-white/90">Rute &amp; Tujuan</span>
                            <div class="my-2 text-xs text-white/80">
                                <div class="font-bold text-white mb-1">{{ $activeTransfer['to_branch'] }}</div>
                                <span class="text-white/50">Via Tol Jakarta-Cikampek KM 19</span>
                            </div>
                        </div>
                        <span class="text-[11px] text-white/50">GPS Tracker: Online Aktif</span>
                    </div>

                    <div class="bg-[#8FBF5B] rounded-[22px] p-5 text-[#141414] flex flex-col justify-between shadow-lg">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold tracking-tight text-[#141414]">Verifikasi Cabang Tujuan</span>
                                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                            </div>
                            <p class="text-xs font-medium text-[#141414]/90 mt-2 leading-relaxed">
                                Stok akan langsung terdebet dari gudang asal dan masuk ke ledger gudang cabang tujuan setelah konfirmasi.
                            </p>
                        </div>
                        <span class="text-[11px] font-bold pt-2 border-t border-black/15">SOP Transfer Cabang</span>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-3">
                    @if($activeTransfer['status'] !== 'diterima')
                        <button wire:click="confirmArrival('{{ $activeTransfer['id'] }}')" 
                                class="h-12 px-8 rounded-full bg-[#8FBF5B] hover:brightness-105 text-[#141414] font-bold text-xs flex items-center gap-2 shadow-xl transition-all active:scale-95">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                            <span>Konfirmasi Penerimaan Cabang Tujuan</span>
                        </button>
                    @else
                        <div class="px-5 py-2.5 rounded-full bg-[#8FBF5B]/20 text-[#8FBF5B] text-xs font-bold border border-[#8FBF5B]/40">
                            Stok Telah Diterima Lengkap di Cabang
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: Transfers List Stack (#F7F4EA) -->
        <div class="lg:col-span-4 flex flex-col gap-4">
            @foreach($transfers as $t)
                <div wire:click="selectTransfer('{{ $t['id'] }}')" 
                     class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-5 shadow-xl border border-black/5 cursor-pointer transition-all hover:brightness-95 {{ $activeTransfer['id'] === $t['id'] ? 'ring-2 ring-[#8FBF5B]' : '' }}">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-black/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[18px]">local_shipping</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-urbanist font-bold text-sm leading-tight">{{ $t['to_branch'] }}</span>
                                <span class="text-[11px] text-[#6F6F66]">{{ $t['id'] }}</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $t['status'] === 'in_transit' ? 'bg-[#3E5B34]/15 text-[#2c4323]' : ($t['status'] === 'diterima' ? 'bg-black/10 text-black' : 'bg-amber-500/20 text-amber-800') }}">
                            {{ $t['status'] }}
                        </span>
                    </div>

                    <div class="flex items-baseline justify-between mt-3 pt-2 border-t border-black/10">
                        <div class="flex items-baseline font-urbanist">
                            <span class="text-base font-bold leading-none text-[#161616] truncate max-w-[200px]">
                                {{ $t['item_summary'] }}
                            </span>
                        </div>
                        <span class="text-xs font-semibold text-[#8FBF5B]">
                            {{ $t['progress'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
