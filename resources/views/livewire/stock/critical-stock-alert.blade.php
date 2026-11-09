<div class="relative z-10 max-w-[1680px] mx-auto flex flex-col gap-6">
    <!-- Top Hero Section: Title, Donut Progress Ring, 3 Giant Metrics -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 px-1 py-2">
        <div class="flex flex-wrap items-center gap-6 sm:gap-8">
            <h1 class="font-urbanist font-medium text-4xl sm:text-5xl lg:text-6xl text-white leading-[1.04] tracking-[-0.02em]">
                Pusat Peringatan<br/><span class="text-white/90">Kedaluwarsa &amp; Kritis</span>
            </h1>
            <!-- Donut Progress Ring (92% Tingkat Aman FEFO) -->
            <div class="flex items-center gap-3.5 pl-6 border-l border-white/20">
                <div class="relative w-16 h-16 flex items-center justify-center shrink-0">
                    <svg class="w-16 h-16 -rotate-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" fill="none" r="19" stroke="rgba(255,255,255,0.18)" stroke-width="3.5"></circle>
                        <circle cx="24" cy="24" fill="none" r="19" stroke="#8FBF5B" stroke-dasharray="119.38" stroke-dashoffset="9.55" stroke-linecap="round" stroke-width="3.5"></circle>
                    </svg>
                    <span class="absolute font-urbanist font-bold text-base text-white">92%</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-semibold text-white/60 tracking-wider uppercase font-manrope">Tingkat Aman</span>
                    <span class="font-urbanist text-sm font-bold text-[#8FBF5B]">Kepatuhan FEFO</span>
                </div>
            </div>
        </div>

        <!-- 3 Giant Stats -->
        <div class="flex items-baseline gap-6 sm:gap-10 overflow-x-auto pb-2 lg:pb-0 shrink-0">
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Potensi Nilai Terselamatkan</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">18,450</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">Jt</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Mendekati Expired (&lt;30 Hari)</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">42</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">SKU</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Kritis Tindakan Hari Ini</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-[#E2725B] leading-none">06</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#E2725B] ml-1">Batch</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Action Bar -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 px-1">
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
            <button wire:click="filterBy('all')" 
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ $filter === 'all' ? 'bg-[#141414] text-white shadow-md border border-white/20' : 'text-white/80 border border-white/20 hover:bg-white/10' }}">
                Semua
            </button>
            <button wire:click="filterBy('critical')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $filter === 'critical' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Stok Kritis (&le;5) <span class="ml-1 text-[#E2725B] font-bold">Alert</span>
            </button>
            <button wire:click="filterBy('low_stock')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $filter === 'low_stock' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Stok Menipis (&le;10)
            </button>
        </div>

        <div class="relative flex-1 md:w-80">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-white/50 text-[18px]">search</span>
            <input wire:model.live.debounce.300ms="search" 
                   type="text" 
                   class="w-full h-11 pl-10 pr-4 rounded-full bg-black/40 border border-white/20 text-white placeholder-white/50 text-xs focus:outline-none focus:border-[#8FBF5B] transition-all" 
                   placeholder="Cari Batch, Produk, SKU, Rak...">
        </div>
    </div>

    <!-- Main Bento Grid (Left ~68% vs Right ~32%) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        <!-- LEFT COLUMN: Active Critical Batch Detail (#141414) -->
        <div class="lg:col-span-8 bg-[#141414] rounded-[32px] p-6 sm:p-8 border border-white/10 shadow-2xl flex flex-col justify-between gap-6">
            @if($activeStock)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-white/10 border border-white/15 flex items-center justify-center text-[#8FBF5B] shrink-0">
                            <span class="material-symbols-outlined text-[26px]">liquor</span>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-urbanist font-bold text-lg text-white tracking-tight truncate">
                                    {{ $activeStock->name }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full bg-white/10 text-white/80 text-[11px] font-bold border border-white/15">
                                    {{ $activeStock->sku }}
                                </span>
                            </div>
                            <span class="text-xs text-white/60 mt-0.5">
                                Lokasi: {{ $activeStock->rack_location ?? 'Rak Pendingin A-01' }} • Status: {{ $activeStock->status->value ?? 'available' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <span class="px-3 py-1 rounded-full bg-[#E2725B]/20 text-[#E2725B] text-xs font-bold border border-[#E2725B]/40 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#E2725B] animate-pulse"></span>
                            <span>FEFO Prioritas</span>
                        </span>
                    </div>
                </div>

                <!-- 3 Bento Info Panels -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-white/90">Sisa Stok Fisik</span>
                            <div class="my-3">
                                <div class="flex items-baseline gap-1">
                                    <span class="font-urbanist text-4xl sm:text-5xl font-medium leading-none text-white tracking-tight">
                                        {{ $activeStock->quantity }}
                                    </span>
                                    <span class="text-xs text-white/60 font-medium">{{ $activeStock->unit }}</span>
                                </div>
                                <span class="text-xs text-white/50 block mt-2">Batas Minimum: {{ $activeStock->min_stock ?? 5 }} {{ $activeStock->unit }}</span>
                            </div>
                        </div>
                        <div class="w-full py-2 px-3 rounded-full bg-white/10 text-white/80 text-[11px] flex items-center justify-between">
                            <span>Status Gudang</span>
                            <span class="text-[#8FBF5B] font-bold">Siap Display</span>
                        </div>
                    </div>

                    <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-white/90">Nilai Aset Risiko</span>
                            <div class="my-3">
                                <div class="flex items-baseline gap-1">
                                    <span class="font-urbanist text-3xl sm:text-4xl font-bold leading-none text-[#8FBF5B]">
                                        Rp {{ number_format($activeStock->quantity * $activeStock->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <span class="text-xs text-white/50 block mt-2">Harga: Rp {{ number_format($activeStock->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <div class="w-full py-2 px-3 rounded-full bg-[#E2725B]/15 text-[#E2725B] text-[11px] flex items-center justify-between">
                            <span>Risiko Margin</span>
                            <span class="font-bold">Potensi Loss</span>
                        </div>
                    </div>

                    <div class="bg-[#8FBF5B] rounded-[22px] p-5 text-[#141414] flex flex-col justify-between shadow-lg">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold tracking-tight text-[#141414]">Rekomendasi Tindakan</span>
                                <span class="material-symbols-outlined text-[20px]">bolt</span>
                            </div>
                            <p class="text-xs font-medium text-[#141414]/80 mt-3 leading-relaxed">
                                Pindahkan batch ini ke etalase kasir terdepan dan pasang bundling promo potongan 15% untuk mempercepat perputaran barang.
                            </p>
                        </div>
                        <span class="text-[11px] font-bold pt-2 border-t border-black/15">FEFO Golden Rule Active</span>
                    </div>
                </div>

                <!-- Bottom Action Controls -->
                <div class="pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span class="text-xs text-white/60">
                        Terakhir diverifikasi oleh QC Inspector: <strong>{{ auth()->user()->name }}</strong>
                    </span>
                    <div class="flex items-center gap-3">
                        <button wire:click="applyClearanceDiscount({{ $activeStock->id }})" 
                                class="px-5 h-12 rounded-full border border-white/20 text-white font-bold text-xs hover:bg-white/10 active:scale-95 transition-all">
                            Aktifkan Flash Sale
                        </button>
                        <button wire:click="executeFefoBatch({{ $activeStock->id }})" 
                                class="px-6 h-12 rounded-full bg-[#8FBF5B] text-[#141414] font-bold text-xs flex items-center gap-2 shadow-lg hover:brightness-105 active:scale-95 transition-all">
                            <span class="material-symbols-outlined text-[18px]">bolt</span>
                            <span>Eksekusi Batch FEFO</span>
                        </button>
                    </div>
                </div>
            @else
                <div class="p-12 text-center text-white/50">
                    <p class="text-sm">Tidak ada stok yang memenuhi kriteria kritis saat ini.</p>
                </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: Stack of Nearing Expiry Items (#F7F4EA) -->
        <div class="lg:col-span-4 flex flex-col gap-4">
            @forelse($items as $item)
                <div wire:click="selectStock({{ $item->id }})" 
                     class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-5 shadow-xl border border-black/5 cursor-pointer transition-all hover:brightness-95 {{ $selectedStockId === $item->id ? 'ring-2 ring-[#8FBF5B]' : '' }}">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-black/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[18px]">warning</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-urbanist font-bold text-sm leading-tight">{{ $item->name }}</span>
                                <span class="text-[11px] text-[#6F6F66]">SKU: {{ $item->sku }}</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-[#E2725B]/20 text-[#E2725B] text-[10px] font-bold">
                            {{ $item->quantity <= 5 ? 'Stok Kritis' : 'FEFO' }}
                        </span>
                    </div>

                    <div class="flex items-baseline justify-between mt-3 pt-2 border-t border-black/10">
                        <div class="flex items-baseline font-urbanist">
                            <span class="text-2xl font-bold leading-none">{{ $item->quantity }}</span>
                            <span class="text-xs font-semibold text-[#6F6F66] ml-1">{{ $item->unit }}</span>
                        </div>
                        <span class="text-xs font-bold text-[#E2725B]">
                            {{ $item->quantity <= 5 ? 'Sisa Sedikit' : 'Perlu Rotasi' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="bg-[#141414] rounded-[24px] p-8 border border-white/10 text-center text-white/50">
                    <p class="text-xs">Semua stok dalam kondisi aman.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
