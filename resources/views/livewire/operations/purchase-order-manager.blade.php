<div class="relative z-10 max-w-[1680px] mx-auto flex flex-col gap-6">
    <!-- Top Hero Section: Title, Donut Progress Ring, 3 Giant Metrics -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 px-1 py-2">
        <div class="flex flex-wrap items-center gap-6 sm:gap-8">
            <h1 class="font-urbanist font-medium text-4xl sm:text-5xl lg:text-6xl text-white leading-[1.04] tracking-[-0.02em]">
                Purchase Order<br/><span class="text-white/90">&amp; Penerimaan Barang</span>
            </h1>
            <!-- Donut Progress Ring (85%) -->
            <div class="flex items-center gap-3.5 pl-6 border-l border-white/20">
                <div class="relative w-16 h-16 flex items-center justify-center shrink-0">
                    <svg class="w-16 h-16 -rotate-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" fill="none" r="19" stroke="rgba(255,255,255,0.18)" stroke-width="3.5"></circle>
                        <circle cx="24" cy="24" fill="none" r="19" stroke="#8FBF5B" stroke-dasharray="119.38" stroke-dashoffset="17.9" stroke-linecap="round" stroke-width="3.5"></circle>
                    </svg>
                    <span class="absolute font-urbanist font-bold text-base text-white">85%</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-semibold text-white/60 tracking-wider uppercase font-manrope">PO Tervalidasi</span>
                    <span class="font-urbanist text-sm font-bold text-[#8FBF5B]">189 / 222 Berkas</span>
                </div>
            </div>
        </div>

        <!-- 3 Giant Stats with Superscript Units -->
        <div class="flex items-baseline gap-6 sm:gap-10 overflow-x-auto pb-2 lg:pb-0 shrink-0">
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Total Nilai Order Bulan Ini</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">142,800</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">Jt</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Dalam Pengiriman Armada</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">28</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">PO</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Akurasi Fisik vs Surat Jalan</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">98.6</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Row & Search Action -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 px-1">
        <!-- Filter Chips -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
            <button wire:click="filterStatus('all')" 
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ $statusFilter === 'all' ? 'bg-[#141414] text-white shadow-md border border-white/20' : 'text-white/80 border border-white/20 hover:bg-white/10' }}">
                Semua PO
            </button>
            <button wire:click="filterStatus('menunggu_truk')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'menunggu_truk' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Menunggu Truk Tiba <span class="ml-1 text-white/60">12</span>
            </button>
            <button wire:click="filterStatus('pengecekan_fisik')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'pengecekan_fisik' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Pengecekan Fisik <span class="ml-1 text-white/60">7</span>
            </button>
            <button wire:click="filterStatus('diterima_lengkap')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'diterima_lengkap' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Diterima Lengkap
            </button>
            <button wire:click="filterStatus('selisih_klaim')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'selisih_klaim' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Selisih / Klaim <span class="ml-1 text-[#E2725B] font-bold">2</span>
            </button>
        </div>

        <!-- Search -->
        <div class="relative flex-1 md:w-80">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-white/50 text-[18px]">search</span>
            <input wire:model.live.debounce.300ms="search" 
                   type="text" 
                   class="w-full h-11 pl-10 pr-4 rounded-full bg-black/40 border border-white/20 text-white placeholder-white/50 text-xs focus:outline-none focus:border-[#8FBF5B] transition-all" 
                   placeholder="Cari No. PO / Supplier / Produk...">
        </div>
    </div>

    <!-- Main Bento 2-Column Grid (Left ~68% vs Right ~32%) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        <!-- LEFT COLUMN (Massive Dark Matte Card #141414) -->
        <div class="lg:col-span-8 bg-[#141414] rounded-[32px] p-6 sm:p-8 border border-white/10 shadow-2xl flex flex-col justify-between gap-6">
            <!-- Header Row: Truck Info, Title, Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-white/10 border border-white/15 flex items-center justify-center text-[#8FBF5B] shrink-0">
                        <span class="material-symbols-outlined text-[26px]">local_shipping</span>
                    </div>
                    <div class="flex flex-col min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-urbanist font-bold text-lg text-white tracking-tight truncate">
                                #{{ $activePo['id'] }} • {{ $activePo['supplier'] }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full bg-[#8FBF5B]/20 text-[#8FBF5B] text-[11px] font-bold border border-[#8FBF5B]/30">
                                {{ $activePo['priority'] }}
                            </span>
                        </div>
                        <span class="text-xs text-white/60 mt-0.5">
                            {{ $activePo['truck'] }} • Driver: {{ $activePo['driver'] }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <button wire:click="downloadEDO('{{ $activePo['id'] }}')" 
                            class="px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs text-white/90 hover:text-white hover:bg-white/20 transition-all flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">description</span>
                        <span>e-DO</span>
                    </button>
                </div>
            </div>

            <!-- Stepper Tracking Line -->
            <div class="py-2">
                <div class="relative flex items-center justify-between">
                    <div class="absolute left-10 right-10 top-1/2 -translate-y-1/2 h-[2px] bg-white/15 z-0"></div>
                    <div class="absolute left-10 {{ $activePo['status'] === 'diterima_lengkap' ? 'right-10' : ($activePo['status'] === 'pengecekan_fisik' ? 'w-1/2' : 'w-0') }} top-1/2 -translate-y-1/2 h-[2px] bg-[#8FBF5B] z-0 transition-all duration-500"></div>

                    <!-- Step 1: Truk Tiba -->
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full bg-[#8FBF5B] text-[#141414] flex items-center justify-center shadow-lg font-bold">
                            <span class="material-symbols-outlined text-[18px]">check</span>
                        </div>
                        <span class="text-xs font-semibold text-white mt-2">Truk Tiba</span>
                        <span class="text-[11px] text-white/50">{{ $activePo['arrival_time'] }}</span>
                    </div>

                    <!-- Step 2: Pengecekan Fisik & QC -->
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full {{ in_array($activePo['status'], ['pengecekan_fisik', 'diterima_lengkap']) ? 'bg-[#8FBF5B] text-[#141414] ring-4 ring-[#8FBF5B]/30' : 'bg-[#232323] text-white/40 border border-white/20' }} flex items-center justify-center shadow-lg">
                            <span class="material-symbols-outlined text-[18px]">
                                {{ $activePo['status'] === 'diterima_lengkap' ? 'check' : 'hourglass_top' }}
                            </span>
                        </div>
                        <span class="text-xs font-semibold {{ in_array($activePo['status'], ['pengecekan_fisik', 'diterima_lengkap']) ? 'text-[#8FBF5B]' : 'text-white/50' }} mt-2">Pengecekan Fisik &amp; QC</span>
                        <span class="text-[11px] text-white/70">{{ $activePo['received_qty'] }}/{{ $activePo['ordered_qty'] }} Selesai dihitung</span>
                    </div>

                    <!-- Step 3: Masuk Stok Gudang -->
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full {{ $activePo['status'] === 'diterima_lengkap' ? 'bg-[#8FBF5B] text-[#141414] shadow-lg' : 'bg-[#232323] border border-white/25 text-white/40' }} flex items-center justify-center">
                            <span class="material-symbols-outlined text-[16px]">inventory_2</span>
                        </div>
                        <span class="text-xs font-semibold {{ $activePo['status'] === 'diterima_lengkap' ? 'text-white' : 'text-white/50' }} mt-2">Masuk Stok Gudang</span>
                        <span class="text-[11px] text-white/40">{{ $activePo['status'] === 'diterima_lengkap' ? 'Stok Terupdate' : 'Menunggu ACC' }}</span>
                    </div>
                </div>
            </div>

            <!-- 3 Side-by-Side Bento Panels -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Panel 1: Jadwal & Dok -->
                <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-semibold text-white/90">Jadwal Tiba &amp; Bongkar</span>
                            <span class="font-urbanist text-xs font-bold text-[#8FBF5B]">PABWE 2026</span>
                        </div>
                        <div class="flex flex-col gap-2 my-2">
                            <div class="flex justify-between text-xs text-white/70">
                                <span>Waktu Tiba:</span>
                                <span class="font-bold text-white">{{ $activePo['arrival_time'] }}</span>
                            </div>
                            <div class="flex justify-between text-xs text-white/70">
                                <span>Lokasi Dok:</span>
                                <span class="font-bold text-[#8FBF5B]">{{ $activePo['dock'] }}</span>
                            </div>
                            <div class="flex justify-between text-xs text-white/70">
                                <span>Kemasan:</span>
                                <span class="font-bold text-white">{{ $activePo['packaging'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-[11px] text-white/60">
                        <span>Status Jadwal:</span>
                        <span class="text-[#8FBF5B] font-bold">On-Schedule</span>
                    </div>
                </div>

                <!-- Panel 2: Kesesuaian Muatan -->
                <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                    <div>
                        <span class="text-xs font-semibold text-white/90">Kesesuaian Muatan</span>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            <span class="px-2.5 py-1 rounded-full bg-white/10 text-white text-[11px] border border-white/10 font-bold">
                                {{ $activePo['item_name'] }}
                            </span>
                        </div>
                        <div class="my-3">
                            <div class="flex items-baseline gap-1.5">
                                <span class="font-urbanist text-4xl sm:text-5xl font-medium leading-none text-white tracking-tight">
                                    {{ $activePo['received_qty'] }}
                                </span>
                                <span class="text-xs text-white/60 font-medium">/{{ $activePo['ordered_qty'] }} {{ $activePo['unit'] }}</span>
                            </div>
                            <div class="flex items-center justify-between mt-2 text-xs">
                                <span class="text-white/60">Dipesan: {{ $activePo['ordered_qty'] }}</span>
                                <span class="text-[#8FBF5B] font-bold">Diterima: {{ $activePo['received_qty'] }}</span>
                            </div>
                        </div>
                    </div>
                    @if($activePo['damaged_qty'] > 0)
                        <div class="w-full py-2 px-3 rounded-full bg-[#E2725B]/15 border border-[#E2725B]/30 flex items-center justify-between text-[#E2725B] text-[11px]">
                            <span>Selisih: {{ $activePo['damaged_qty'] }} {{ $activePo['unit'] }} (Bocor/Rusak)</span>
                            <span class="font-bold underline cursor-pointer">BAP Klaim</span>
                        </div>
                    @else
                        <div class="w-full py-2 px-3 rounded-full bg-[#8FBF5B]/15 border border-[#8FBF5B]/30 flex items-center justify-between text-[#8FBF5B] text-[11px]">
                            <span>Muatan Sempurna: 100% Cocok</span>
                            <span class="font-bold">Lengkap</span>
                        </div>
                    @endif
                </div>

                <!-- Panel 3: Kapasitas Rak Gudang (Solid Lime #8FBF5B) -->
                <div class="bg-[#8FBF5B] rounded-[22px] p-5 text-[#141414] flex flex-col justify-between shadow-lg">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold tracking-tight text-[#141414]">Kapasitas Rak Gudang</span>
                            <span class="material-symbols-outlined text-[20px] text-[#141414]">warehouse</span>
                        </div>
                        <!-- Vertical Bar Chart -->
                        <div class="flex items-end justify-around gap-3 h-24 my-2">
                            <div class="flex flex-col items-center gap-1 w-1/3 h-full justify-end">
                                <span class="font-urbanist text-[11px] font-bold">90%</span>
                                <div class="w-full bg-[#141414] rounded-t-lg" style="height: 82%;"></div>
                                <span class="text-[10px] font-bold truncate w-full text-center">Pallet A</span>
                            </div>
                            <div class="flex flex-col items-center gap-1 w-1/3 h-full justify-end">
                                <span class="font-urbanist text-[11px] font-bold">65%</span>
                                <div class="w-full bg-[#141414] rounded-t-lg" style="height: 56%;"></div>
                                <span class="text-[10px] font-bold truncate w-full text-center">Transit</span>
                            </div>
                            <div class="flex flex-col items-center gap-1 w-1/3 h-full justify-end">
                                <span class="font-urbanist text-[11px] font-bold">30%</span>
                                <div class="w-full bg-[#141414] rounded-t-lg" style="height: 28%;"></div>
                                <span class="text-[10px] font-bold truncate w-full text-center">Chiller</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-[11px] font-bold pt-2 border-t border-black/15">
                        <span>Sisa Kuota: 18 Pallet</span>
                        <span class="underline">Denah Rak</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Numbers & Verification Button -->
            <div class="pt-6 border-t border-white/10 flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <div class="flex flex-col">
                        <span class="text-[11px] text-white/50 uppercase tracking-wider">Total Diterima</span>
                        <div class="flex items-baseline font-urbanist mt-1">
                            <span class="text-3xl font-bold leading-none text-white">{{ $activePo['received_qty'] }}</span>
                            <span class="text-xs font-semibold text-[#8FBF5B] ml-1">{{ $activePo['unit'] }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[11px] text-white/50 uppercase tracking-wider">Selisih Rusak</span>
                        <div class="flex items-baseline font-urbanist mt-1">
                            <span class="text-3xl font-bold leading-none {{ $activePo['damaged_qty'] > 0 ? 'text-[#E2725B]' : 'text-white/40' }}">{{ sprintf('%02d', $activePo['damaged_qty']) }}</span>
                            <span class="text-xs font-semibold text-[#E2725B]/80 ml-1">{{ $activePo['unit'] }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[11px] text-white/50 uppercase tracking-wider">Faktur Tagihan</span>
                        <div class="flex items-baseline font-urbanist mt-1">
                            <span class="text-3xl font-bold leading-none text-white">{{ $activePo['invoice_amount'] }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[11px] text-white/50 uppercase tracking-wider">Syarat Bayar</span>
                        <div class="flex items-baseline font-urbanist mt-1">
                            <span class="text-3xl font-bold leading-none text-white">{{ $activePo['payment_terms'] }}</span>
                        </div>
                    </div>
                </div>

                @if($activePo['status'] !== 'diterima_lengkap')
                    <button wire:click="verifyAndReceive('{{ $activePo['id'] }}')" 
                            type="button" 
                            class="h-14 px-8 rounded-full bg-[#8FBF5B] hover:brightness-105 text-[#141414] font-bold text-sm flex items-center justify-center gap-2.5 shadow-xl transition-all active:scale-95 shrink-0 cursor-pointer">
                        <span class="material-symbols-outlined text-[22px]">task_alt</span>
                        <span>Verifikasi &amp; Tambah ke Stok</span>
                    </button>
                @else
                    <div class="h-14 px-8 rounded-full bg-[#8FBF5B]/20 border border-[#8FBF5B]/40 text-[#8FBF5B] font-bold text-sm flex items-center justify-center gap-2.5 shadow-inner shrink-0">
                        <span class="material-symbols-outlined text-[22px]">verified</span>
                        <span>Telah Selesai Diverifikasi</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT COLUMN: Stack of Porcelain Cream Cards #F7F4EA -->
        <div class="lg:col-span-4 flex flex-col gap-4">
            @foreach($orders as $po)
                <div wire:click="selectPo('{{ $po['id'] }}')" 
                     class="rounded-[24px] p-6 shadow-xl border cursor-pointer transition-all {{ $activePo['id'] === $po['id'] ? 'ring-2 ring-[#8FBF5B]' : '' }} {{ $po['status'] === 'selisih_klaim' ? 'bg-[#FDE9E5] text-[#161616] border-[#E2725B]/30' : 'bg-[#F7F4EA] text-[#161616] border-black/5' }}">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full {{ $po['status'] === 'selisih_klaim' ? 'bg-[#E2725B]/20 text-[#E2725B]' : 'bg-black/10 text-black' }} flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[20px]">
                                    {{ $po['status'] === 'selisih_klaim' ? 'warning' : 'grain' }}
                                </span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-urbanist font-bold text-base leading-tight">{{ $po['item_name'] }}</span>
                                <span class="text-xs text-[#6F6F66]">{{ $po['supplier'] }}</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $po['status'] === 'selisih_klaim' ? 'bg-[#E2725B]/20 text-[#E2725B]' : 'bg-[#3E5B34]/15 text-[#2c4323]' }}">
                            {{ $po['id'] }}
                        </span>
                    </div>

                    <div class="flex items-baseline justify-between mt-3">
                        <div class="flex items-baseline font-urbanist">
                            <span class="text-4xl font-bold leading-none tracking-tight">{{ $po['ordered_qty'] }}</span>
                            <span class="text-xs font-semibold text-[#6F6F66] ml-1">{{ $po['unit'] }}</span>
                        </div>
                        <span class="text-xs font-medium text-[#6F6F66]">
                            {{ $po['dock'] }} • {{ $po['arrival_time'] }}
                        </span>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 mt-3 border-t border-black/10">
                        @if($po['status'] === 'menunggu_truk')
                            <button wire:click.stop="startUnloading('{{ $po['id'] }}')" 
                                    class="px-4 py-1.5 rounded-full bg-[#8FBF5B] text-[#141414] font-bold text-xs flex items-center gap-1 hover:brightness-105 active:scale-95 transition-all">
                                <span class="material-symbols-outlined text-[16px]">add</span>
                                <span>Mulai Bongkar</span>
                            </button>
                        @elseif($po['status'] === 'selisih_klaim')
                            <span class="text-xs font-bold text-[#E2725B]">Klaim BAP Aktif</span>
                        @else
                            <span class="text-xs font-semibold text-[#8FBF5B]">
                                {{ $po['status'] === 'diterima_lengkap' ? 'Lengkap di Rak' : 'Proses QC' }}
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
