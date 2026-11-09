<div class="relative z-10 max-w-[1680px] mx-auto flex flex-col gap-6">
    <!-- Top Hero Section: Title, Donut Progress Ring, 3 Giant Metrics -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 px-1 py-2">
        <div class="flex flex-wrap items-center gap-6 sm:gap-8">
            <h1 class="font-urbanist font-medium text-4xl sm:text-5xl lg:text-6xl text-white leading-[1.04] tracking-[-0.02em]">
                Sesi Stock Opname<br/><span class="text-white/90">&amp; Rekonsiliasi Fisik</span>
            </h1>
            <!-- Donut Progress Ring (98.4% Akurasi Fisik) -->
            <div class="flex items-center gap-3.5 pl-6 border-l border-white/20">
                <div class="relative w-16 h-16 flex items-center justify-center shrink-0">
                    <svg class="w-16 h-16 -rotate-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" fill="none" r="19" stroke="rgba(255,255,255,0.18)" stroke-width="3.5"></circle>
                        <circle cx="24" cy="24" fill="none" r="19" stroke="#8FBF5B" stroke-dasharray="119.38" stroke-dashoffset="1.91" stroke-linecap="round" stroke-width="3.5"></circle>
                    </svg>
                    <span class="absolute font-urbanist font-bold text-xs text-white">98.4%</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-semibold text-white/60 tracking-wider uppercase font-manrope">Akurasi Fisik</span>
                    <span class="font-urbanist text-sm font-bold text-[#8FBF5B]">Kesesuaian Rak</span>
                </div>
            </div>
        </div>

        <!-- 3 Giant Stats -->
        <div class="flex items-baseline gap-6 sm:gap-10 overflow-x-auto pb-2 lg:pb-0 shrink-0">
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Telah Dihitung &amp; Terverifikasi</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">1,240</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">SKU</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Variansi Nilai Buku</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-[#E2725B] leading-none">-1.8</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#E2725B] ml-1">Jt</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Butuh Otorisasi Selisih</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">14</span>
                    <span class="text-xl sm:text-2xl font-bold text-white/60 ml-1">Item</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Barcode Search Bar -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 px-1">
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
            <button wire:click="$set('rackFilter', 'all')" 
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ $rackFilter === 'all' ? 'bg-[#141414] text-white shadow-md border border-white/20' : 'text-white/80 border border-white/20 hover:bg-white/10' }}">
                Semua Rak
            </button>
            <button wire:click="$set('rackFilter', 'rak_a')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $rackFilter === 'rak_a' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Rak A (Sembako)
            </button>
            <button wire:click="$set('rackFilter', 'chiller')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $rackFilter === 'chiller' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Chiller Dingin
            </button>
        </div>

        <div class="relative flex-1 md:w-80">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-white/50 text-[18px]">barcode_scanner</span>
            <input wire:model.live.debounce.300ms="search" 
                   type="text" 
                   class="w-full h-11 pl-10 pr-4 rounded-full bg-black/40 border border-white/20 text-white placeholder-white/50 text-xs focus:outline-none focus:border-[#8FBF5B] transition-all" 
                   placeholder="Pindai barcode / cari SKU...">
        </div>
    </div>

    <!-- Main Bento Grid (Left ~68% vs Right ~32%) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        <!-- LEFT COLUMN: Opname Detail & Reconciliation Control (#141414) -->
        <div class="lg:col-span-8 bg-[#141414] rounded-[32px] p-6 sm:p-8 border border-white/10 shadow-2xl flex flex-col justify-between gap-6">
            @if($activeStock)
                @php
                    $diff = (int)$physicalInput - (int)$activeStock->quantity;
                @endphp
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-white/10 border border-white/15 flex items-center justify-center text-[#8FBF5B] shrink-0">
                            <span class="material-symbols-outlined text-[26px]">document_scanner</span>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-urbanist font-bold text-lg text-white tracking-tight truncate">
                                    {{ $activeStock->name }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full bg-[#8FBF5B]/20 text-[#8FBF5B] text-[11px] font-bold border border-[#8FBF5B]/30">
                                    {{ $activeStock->rack_location ?? 'Rak A-01' }}
                                </span>
                            </div>
                            <span class="text-xs text-white/60 mt-0.5">
                                SKU: {{ $activeStock->sku }} • Auditor: {{ auth()->user()->name }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <span class="px-3 py-1 rounded-full {{ $diff === 0 ? 'bg-[#8FBF5B]/20 text-[#8FBF5B]' : 'bg-[#E2725B]/20 text-[#E2725B]' }} text-xs font-bold border {{ $diff === 0 ? 'border-[#8FBF5B]/30' : 'border-[#E2725B]/30' }}">
                            {{ $diff === 0 ? 'Cocok (0 Selisih)' : ($diff > 0 ? "+{$diff} Unit Fisik Lebih" : "{$diff} Unit Fisik Kurang") }}
                        </span>
                    </div>
                </div>

                <!-- 3 Bento Input Panels -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-white/90">Stok Sistem (Buku)</span>
                            <div class="my-3">
                                <div class="flex items-baseline gap-1">
                                    <span class="font-urbanist text-4xl sm:text-5xl font-medium leading-none text-white tracking-tight">
                                        {{ $activeStock->quantity }}
                                    </span>
                                    <span class="text-xs text-white/60 font-medium">{{ $activeStock->unit }}</span>
                                </div>
                                <span class="text-xs text-white/50 block mt-2">Database Ledger Real-Time</span>
                            </div>
                        </div>
                        <span class="text-[11px] text-white/60">Snapshot sebelum audit</span>
                    </div>

                    <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-white/90">Hitungan Fisik Nyata</span>
                            <div class="my-3">
                                <input wire:model.live="physicalInput" 
                                       type="number" 
                                       min="0" 
                                       class="w-full h-12 px-3 rounded-xl bg-black/50 border border-white/20 text-white font-urbanist text-2xl font-bold focus:outline-none focus:border-[#8FBF5B]">
                                <span class="text-xs text-white/50 block mt-2">Hasil hitung timbangan / rak</span>
                            </div>
                        </div>
                        <span class="text-[11px] text-[#8FBF5B] font-bold">Input Langsung Barcode</span>
                    </div>

                    <div class="bg-[#8FBF5B] rounded-[22px] p-5 text-[#141414] flex flex-col justify-between shadow-lg">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold tracking-tight text-[#141414]">Variansi Selisih</span>
                                <span class="material-symbols-outlined text-[20px]">balance</span>
                            </div>
                            <div class="flex items-baseline gap-1 my-2">
                                <span class="font-urbanist text-4xl font-extrabold leading-none">
                                    {{ $diff >= 0 ? "+{$diff}" : $diff }}
                                </span>
                                <span class="text-xs font-bold">{{ $activeStock->unit }}</span>
                            </div>
                            <p class="text-[11px] font-medium leading-tight">
                                Selisih nilai: Rp {{ number_format($diff * $activeStock->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <span class="text-[11px] font-bold pt-2 border-t border-black/15">Audit Policy Otomatis</span>
                    </div>
                </div>

                <!-- Notes & Action -->
                <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="w-full sm:w-2/3">
                        <input wire:model="opnameNotes" 
                               type="text" 
                               placeholder="Catatan alasan selisih (misal: kemasan bocor di rak belakang)..." 
                               class="w-full h-11 px-4 rounded-full bg-black/40 border border-white/20 text-white placeholder-white/40 text-xs focus:outline-none focus:border-[#8FBF5B]">
                    </div>
                    <button wire:click="reconcile({{ $activeStock->id }})" 
                            type="button" 
                            class="h-12 px-8 rounded-full bg-[#8FBF5B] hover:brightness-105 text-[#141414] font-bold text-xs flex items-center justify-center gap-2 shadow-xl transition-all active:scale-95 shrink-0 cursor-pointer">
                        <span class="material-symbols-outlined text-[18px]">sync_alt</span>
                        <span>Rekonsiliasi Fisik &amp; Sinkron</span>
                    </button>
                </div>
            @else
                <div class="p-12 text-center text-white/50">
                    <p class="text-sm">Tidak ada barang yang dipilih untuk opname.</p>
                </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: Stack of Opname Queue Items (#F7F4EA) -->
        <div class="lg:col-span-4 flex flex-col gap-4">
            @forelse($items as $item)
                <div wire:click="selectStock({{ $item->id }})" 
                     class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-5 shadow-xl border border-black/5 cursor-pointer transition-all hover:brightness-95 {{ $selectedStockId === $item->id ? 'ring-2 ring-[#8FBF5B]' : '' }}">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-black/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[18px]">inventory</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-urbanist font-bold text-sm leading-tight">{{ $item->name }}</span>
                                <span class="text-[11px] text-[#6F6F66]">Lokasi: {{ $item->rack_location ?? 'Gudang Utama' }}</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-black/10 text-black text-[10px] font-bold">
                            {{ $item->sku }}
                        </span>
                    </div>

                    <div class="flex items-baseline justify-between mt-3 pt-2 border-t border-black/10">
                        <div class="flex items-baseline font-urbanist">
                            <span class="text-2xl font-bold leading-none">{{ $item->quantity }}</span>
                            <span class="text-xs font-semibold text-[#6F6F66] ml-1">{{ $item->unit }} buku</span>
                        </div>
                        <span class="text-xs font-semibold text-[#8FBF5B]">
                            Siap Audit
                        </span>
                    </div>
                </div>
            @empty
                <div class="bg-[#141414] rounded-[24px] p-8 border border-white/10 text-center text-white/50">
                    <p class="text-xs">Tidak ada barang ditemukan.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
