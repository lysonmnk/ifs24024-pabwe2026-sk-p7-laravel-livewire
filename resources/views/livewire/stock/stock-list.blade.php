<div class="bento-dashboard-bg bento-grain-overlay min-h-screen -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 text-white relative font-manrope selection:bg-[#8FBF5B] selection:text-black">
    <div class="relative z-10 max-w-[1400px] mx-auto flex flex-col gap-6 sm:gap-8 pb-12">

        <!-- A. TOP HEADER & TELEMETRY LIVE ACCENT -->
        <header class="w-full flex flex-col gap-4">
            <!-- Tiny series accent & Live Sync badge -->
            <div class="flex items-center justify-between px-2 text-[11px] font-semibold tracking-widest text-[#BBD8A0]/80 uppercase">
                <span class="inline-flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#E056FD]"></span>
                    <span>PRECISION BENTO SUITE</span>
                </span>
                <span class="flex items-center gap-2 font-normal tracking-normal text-xs text-[#E1EED3]/90 bg-black/30 backdrop-blur-md px-3 py-1 rounded-full border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-[#8FBF5B] animate-pulse"></span>
                    <span>Jakarta Hub 04 • Live Synced</span>
                </span>
            </div>

            <!-- Header Title & Telemetry Cards Row -->
            <section class="flex flex-col xl:flex-row xl:items-end justify-between gap-6 pt-2 pb-2">
                <!-- Kiri: Judul Raksasa & Donut Ratio Stok Aman -->
                <div class="flex flex-col lg:flex-row lg:items-center gap-6 lg:gap-8">
                    <div>
                        <h1 class="font-urbanist text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-[0.95]">
                            Manajemen<br/>
                            <span class="text-[#8FBF5B]">Stok Barang</span>
                        </h1>
                        <p class="text-xs sm:text-sm text-white/60 mt-2 font-medium">
                            Pantau inventaris pergudangan, mutasi real-time, dan status restock
                        </p>
                    </div>

                    <!-- Donut Ring Progress Kapsul -->
                    <div class="flex items-center gap-3.5 bg-black/35 backdrop-blur-xl border border-white/10 px-4 py-3 rounded-2xl w-fit shadow-xl">
                        <div class="relative w-14 h-14 flex items-center justify-center shrink-0">
                            <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" fill="none" r="14.5" stroke="rgba(255,255,255,0.15)" stroke-width="3"></circle>
                                <circle cx="18" cy="18" fill="none" r="14.5" stroke="#8FBF5B" 
                                    stroke-dasharray="{{ $telemetry['safe_stock_ratio'] }}, 100" 
                                    stroke-linecap="round" stroke-width="3"></circle>
                            </svg>
                            <span class="absolute font-urbanist text-xs font-extrabold text-white">
                                {{ $telemetry['safe_stock_ratio'] }}%
                            </span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-white leading-tight">Stok Aman</span>
                            <span class="text-xs text-[#BBD8A0] font-medium">
                                {{ $telemetry['safe_stock_ratio'] >= 80 ? 'Rasio Optimum' : 'Perlu Perhatian' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Kanan: 3 Metrik Statistik Horizontal Raksasa -->
                <div class="flex items-center gap-6 sm:gap-8 overflow-x-auto no-scrollbar pt-2 bg-black/30 backdrop-blur-xl border border-white/10 px-6 py-4 rounded-3xl shadow-xl">
                    <!-- Stat 1: Total Nilai Aset -->
                    <div class="flex flex-col shrink-0">
                        <span class="text-[11px] text-[#D0E4BE] font-medium tracking-wide uppercase">Total Nilai Aset</span>
                        <div class="flex items-baseline gap-1 mt-0.5">
                            <span class="font-urbanist text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-none">
                                {{ number_format($telemetry['total_asset_value'], 0, ',', '.') }}
                            </span>
                            <sup class="text-xs sm:text-sm font-bold text-[#8FBF5B] font-urbanist -top-3">Rp</sup>
                        </div>
                    </div>

                    <div class="w-px h-10 bg-white/20"></div>

                    <!-- Stat 2: Item Tersedia (SKU) -->
                    <div class="flex flex-col shrink-0">
                        <span class="text-[11px] text-[#D0E4BE] font-medium tracking-wide uppercase">Item Tersedia</span>
                        <div class="flex items-baseline gap-1 mt-0.5">
                            <span class="font-urbanist text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-none">
                                {{ $telemetry['total_items'] }}
                            </span>
                            <sup class="text-xs sm:text-sm font-bold text-[#C3D2AF] font-urbanist -top-3">SKU</sup>
                        </div>
                    </div>

                    <div class="w-px h-10 bg-white/20"></div>

                    <!-- Stat 3: Perlu Restock -->
                    <div class="flex flex-col shrink-0">
                        <span class="text-[11px] {{ $telemetry['need_restock_count'] > 0 ? 'text-[#FFAAA0]' : 'text-emerald-300' }} font-bold tracking-wide uppercase">Perlu Restock</span>
                        <div class="flex items-baseline gap-1 mt-0.5">
                            <span class="font-urbanist text-3xl sm:text-4xl lg:text-5xl font-extrabold {{ $telemetry['need_restock_count'] > 0 ? 'text-[#FFAAA0]' : 'text-emerald-400' }} leading-none">
                                {{ $telemetry['need_restock_count'] }}
                            </span>
                            <sup class="text-xs sm:text-sm font-bold {{ $telemetry['need_restock_count'] > 0 ? 'text-[#FFAAA0]' : 'text-emerald-400' }} font-urbanist -top-3">Item</sup>
                        </div>
                    </div>
                </div>
            </section>
        </header>

        <!-- B. BARIS FILTER & CONTROLS -->
        <section class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
            <!-- Filter Kategori Capsule Chips -->
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1">
                <button type="button" wire:click="setCategory('')"
                    class="px-5 py-2.5 rounded-full font-semibold text-xs sm:text-sm transition-all shrink-0 {{ $categoryFilter === '' && $statusFilter === '' ? 'bg-white text-black shadow-lg shadow-white/10 font-bold' : 'bg-black/40 hover:bg-black/60 text-white/80 hover:text-white border border-white/15 backdrop-blur-md' }}">
                    Semua
                </button>

                @php
                    $availableCats = array_unique(array_merge(['Sembako', 'Minuman', 'Bumbu', 'Alat Tulis', 'Snack'], $telemetry['categories'] ?? []));
                @endphp

                @foreach($availableCats as $cat)
                    <button type="button" wire:click="setCategory('{{ $cat }}')"
                        class="px-5 py-2.5 rounded-full font-semibold text-xs sm:text-sm transition-all shrink-0 {{ $categoryFilter === $cat ? 'bg-[#8FBF5B] text-black font-bold shadow-lg shadow-[#8FBF5B]/20' : 'bg-black/40 hover:bg-black/60 text-white/80 hover:text-white border border-white/15 backdrop-blur-md' }}">
                        {{ $cat }}
                    </button>
                @endforeach

                <button type="button" wire:click="$set('statusFilter', '{{ $statusFilter === 'out_of_stock' ? '' : 'out_of_stock' }}')"
                    class="px-5 py-2.5 rounded-full font-semibold text-xs sm:text-sm transition-all shrink-0 {{ $statusFilter === 'out_of_stock' ? 'bg-[#E2725B] text-white font-bold shadow-lg shadow-[#E2725B]/30' : 'bg-black/40 hover:bg-black/60 text-[#FFAAA0] border border-[#E2725B]/30 backdrop-blur-md' }}">
                    Habis / Kritis
                </button>
            </div>

            <!-- Search Bar Kapsul & Tombol Aksi -->
            <div class="flex items-center gap-2.5 flex-wrap sm:flex-nowrap">
                <!-- Search Input -->
                <div class="relative flex items-center flex-1 sm:w-72">
                    <span class="material-symbols-outlined absolute left-4 text-white/50 text-[18px]">search</span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Cari nama, SKU, supplier, rak..."
                        class="w-full h-11 pl-11 pr-9 bg-black/40 border border-white/15 rounded-full text-xs sm:text-sm text-white placeholder-white/40 focus:outline-none focus:border-[#8FBF5B] backdrop-blur-md transition-colors" />
                    <div wire:loading wire:target="search,categoryFilter,statusFilter" class="absolute right-3.5">
                        <svg class="animate-spin h-4 w-4 text-[#8FBF5B]" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Tombol + Tambah Stok (Lime Accent) -->
                <button type="button" wire:click="openCreateModal"
                    class="btn-interactive h-11 px-5 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] text-[#0A0A0A] font-bold text-xs sm:text-sm flex items-center gap-2 shadow-lg shadow-[#8FBF5B]/25 active:scale-95 transition-all shrink-0">
                    <span class="material-symbols-outlined text-[18px] font-bold">add</span>
                    <span>Tambah Stok</span>
                </button>

                <!-- Tombol AI Generator -->
                <button type="button" wire:click="openAiModal"
                    class="btn-interactive h-11 px-4 rounded-full bg-purple-600/80 hover:bg-purple-600 text-white font-semibold text-xs sm:text-sm flex items-center gap-1.5 border border-purple-400/30 backdrop-blur-md shadow-lg shadow-purple-600/20 active:scale-95 transition-all shrink-0"
                    title="Generate Stok dengan AI Gemini">
                    <span class="material-symbols-outlined text-[18px]">auto_awesome</span>
                    <span class="hidden sm:inline">AI Stock</span>
                </button>

                <!-- Tombol Dropdown Spreadsheet (Excel) -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" @click="open = !open"
                        class="w-11 h-11 rounded-full bg-black/40 hover:bg-black/60 border border-white/15 text-white flex items-center justify-center backdrop-blur-md transition-colors shadow-lg shrink-0"
                        title="Impor & Ekspor Excel">
                        <span class="material-symbols-outlined text-[18px]">table_view</span>
                    </button>

                    <div x-show="open" x-cloak
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 z-30 mt-2 w-52 origin-top-right rounded-2xl border border-white/15 bg-[#141414] py-2 shadow-2xl text-white">
                        <div class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-white/50">Spreadsheet</div>
                        <button type="button" wire:click="openImportModal" @click="open = false"
                            class="flex w-full items-center gap-2.5 px-3 py-2 text-xs font-semibold text-emerald-400 hover:bg-white/10 transition">
                            <span class="material-symbols-outlined text-[18px]">upload_file</span>
                            <span>Import File Excel</span>
                        </button>
                        <button type="button" wire:click="exportExcel" @click="open = false"
                            class="flex w-full items-center gap-2.5 px-3 py-2 text-xs font-semibold text-[#8FBF5B] hover:bg-white/10 transition">
                            <span class="material-symbols-outlined text-[18px]">download</span>
                            <span>Export File Excel</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- C. AREA UTAMA BENTO GRID (Kiri 68% Matte Black, Kanan 32% Cream Porcelain) -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            
            <!-- KOLOM KIRI (±68% - 8 Cols): HERO MATTE BLACK BENTO CARD -->
            <div class="lg:col-span-8 bg-[#141414] rounded-[32px] p-6 sm:p-8 flex flex-col justify-between shadow-2xl border border-white/10 relative">
                @if($featuredStock)
                    <!-- Baris Atas: Produk Info + Badge Lokasi & Aksi -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
                        <div class="flex items-center gap-4">
                            <!-- Foto bulat produk -->
                            <div class="w-16 h-16 rounded-full overflow-hidden bg-white/10 shrink-0 border-2 border-[#8FBF5B]/50 shadow-lg flex items-center justify-center">
                                @if($featuredStock->cover_image_path)
                                    <img src="{{ $featuredStock->coverImageUrl() }}" alt="{{ $featuredStock->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-tr from-[#2C4328] to-[#3E5B34] flex items-center justify-center text-[#8FBF5B]">
                                        <span class="material-symbols-outlined text-[28px]">inventory_2</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full bg-white/10 text-[10px] font-bold text-[#8FBF5B] uppercase">
                                        {{ $featuredStock->category ?? 'Sembako' }}
                                    </span>
                                    <span class="text-xs text-white/50 font-mono">{{ $featuredStock->sku ?? 'SKU-001' }}</span>
                                </div>
                                <h3 class="font-urbanist text-xl sm:text-2xl font-bold text-white tracking-tight mt-0.5">
                                    {{ $featuredStock->name }}
                                </h3>
                                <span class="text-xs sm:text-sm text-white/60 font-medium">
                                    {{ $featuredStock->rack_location ? $featuredStock->rack_location . ' • ' : '' }}Supplier: {{ $featuredStock->supplier ?? 'PB Sri Makmur' }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons: Detail, Edit, Quick Adjust -->
                        <div class="flex items-center gap-2 self-end sm:self-auto">
                            <a href="{{ route('stocks.show', $featuredStock) }}"
                                class="w-10 h-10 rounded-full bg-[#232323] hover:bg-[#303030] text-white/80 hover:text-white flex items-center justify-center transition-colors shadow-md"
                                title="Lihat Detail Lengkap">
                                <span class="material-symbols-outlined text-[18px]">open_in_full</span>
                            </a>
                            <button type="button" wire:click="openEditModal({{ $featuredStock->id }})"
                                class="w-10 h-10 rounded-full bg-[#232323] hover:bg-[#303030] text-white/80 hover:text-white flex items-center justify-center transition-colors shadow-md"
                                title="Ubah Stok Ini">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </button>
                        </div>
                    </div>

                    <!-- Timeline Stepper Alur Restock -->
                    <div class="py-6 w-full">
                        @php
                            $stage = $featuredStock->order_stage ?? 'ready';
                            $stageMap = ['ordered' => 1, 'verified' => 2, 'stored' => 3, 'ready' => 4];
                            $currentStageIdx = $stageMap[$stage] ?? 4;
                        @endphp
                        <div class="relative flex items-center justify-between">
                            <div class="absolute left-6 right-6 top-1/2 -translate-y-1/2 h-1 bg-white/10 z-0"></div>
                            <div class="absolute left-6 top-1/2 -translate-y-1/2 h-1 bg-[#8FBF5B] z-0 transition-all duration-500"
                                style="width: {{ ($currentStageIdx - 1) * 33.3 }}%;"></div>

                            <!-- Step 1: Pesan Agen -->
                            <div class="relative z-10 flex flex-col items-center gap-1.5">
                                <div class="w-8 h-8 rounded-full {{ $currentStageIdx >= 1 ? 'bg-[#8FBF5B] text-black font-bold' : 'bg-[#232323] text-white/40 border border-white/20' }} flex items-center justify-center shadow-md">
                                    <span class="material-symbols-outlined text-[16px] font-bold">check</span>
                                </div>
                                <span class="text-[11px] font-medium {{ $currentStageIdx >= 1 ? 'text-white' : 'text-white/40' }} text-center">Pesan Agen</span>
                            </div>

                            <!-- Step 2: Verifikasi Fisik -->
                            <div class="relative z-10 flex flex-col items-center gap-1.5">
                                <div class="w-8 h-8 rounded-full {{ $currentStageIdx >= 2 ? 'bg-[#8FBF5B] text-black font-bold' : 'bg-[#232323] text-white/40 border border-white/20' }} flex items-center justify-center shadow-md">
                                    <span class="material-symbols-outlined text-[16px] font-bold">
                                        {{ $currentStageIdx >= 2 ? 'check' : 'pending' }}
                                    </span>
                                </div>
                                <span class="text-[11px] font-medium {{ $currentStageIdx >= 2 ? 'text-white' : 'text-white/40' }} text-center">Verifikasi Fisik</span>
                            </div>

                            <!-- Step 3: Masuk Gudang -->
                            <div class="relative z-10 flex flex-col items-center gap-1.5">
                                <div class="w-8 h-8 rounded-full {{ $currentStageIdx >= 3 ? 'bg-[#8FBF5B] text-black font-bold' : 'bg-[#232323] text-white/40 border border-white/20' }} flex items-center justify-center shadow-md">
                                    <span class="material-symbols-outlined text-[16px] font-bold">
                                        {{ $currentStageIdx >= 3 ? 'check' : 'warehouse' }}
                                    </span>
                                </div>
                                <span class="text-[11px] font-medium {{ $currentStageIdx >= 3 ? 'text-white' : 'text-white/40' }} text-center">Masuk Gudang</span>
                            </div>

                            <!-- Step 4: Siap Jual -->
                            <div class="relative z-10 flex flex-col items-center gap-1.5">
                                <div class="w-8 h-8 rounded-full {{ $currentStageIdx >= 4 ? 'bg-[#8FBF5B] text-black font-bold' : 'bg-[#232323] text-white/40 border border-white/20' }} flex items-center justify-center shadow-md">
                                    <span class="material-symbols-outlined text-[16px] font-bold">storefront</span>
                                </div>
                                <span class="text-[11px] font-medium {{ $currentStageIdx >= 4 ? 'text-white' : 'text-white/40' }} text-center">Siap Jual</span>
                            </div>
                        </div>
                    </div>

                    <!-- 3 Modular Dark Panels -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-2">
                        <!-- Panel 1: Tanggal Mutasi Terakhir -->
                        <div class="bg-[#232323] rounded-[22px] p-5 flex flex-col justify-between border border-white/5">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-white/70">Waktu Terakhir</span>
                                <span class="text-[10px] font-medium text-[#8FBF5B]">{{ $featuredStock->updated_at->format('M Y') }}</span>
                            </div>
                            <div class="flex flex-col items-center justify-center py-2 text-center">
                                <span class="font-urbanist text-3xl font-extrabold text-white">
                                    {{ $featuredStock->updated_at->format('d') }}
                                </span>
                                <span class="text-xs text-[#8FBF5B] font-semibold mt-0.5">
                                    {{ $featuredStock->updated_at->format('l, H:i') }} WIB
                                </span>
                            </div>
                            <div class="text-[10px] text-white/50 text-center pt-2 border-t border-white/10">
                                Sinkronisasi otomatis sistem
                            </div>
                        </div>

                        <!-- Panel 2: Pemasok & Penawaran Harga -->
                        <div class="bg-[#232323] rounded-[22px] p-5 flex flex-col justify-between border border-white/5">
                            <div>
                                <span class="text-xs font-semibold text-white/70 block mb-2">Pemasok Utama</span>
                                <span class="px-3 py-1.5 rounded-full bg-white text-black text-xs font-bold inline-block shadow-sm">
                                    {{ $featuredStock->supplier ?? 'PB Sri Makmur' }}
                                </span>
                            </div>
                            <div class="mt-4 pt-3 border-t border-white/10 flex flex-col">
                                <span class="text-[10px] text-white/50 uppercase tracking-wider">Harga Penawaran / Unit</span>
                                <div class="flex items-baseline gap-1 mt-0.5">
                                    <span class="font-urbanist text-2xl font-bold text-white">
                                        {{ number_format($featuredStock->price ?? 0, 0, ',', '.') }}
                                    </span>
                                    <sup class="text-[10px] font-semibold text-[#8FBF5B] font-urbanist -top-2">Rp/{{ $featuredStock->unit }}</sup>
                                </div>
                            </div>
                        </div>

                        <!-- Panel 3: Kapasitas Gudang (Lime Green Card) -->
                        <div class="bg-[#8FBF5B] rounded-[22px] p-5 flex flex-col justify-between text-[#11230B] shadow-lg">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-bold uppercase tracking-wider">Distribusi Stok</span>
                                    <span class="material-symbols-outlined text-[18px]">warehouse</span>
                                </div>
                                <div class="flex items-end justify-between gap-2 h-16 pt-1 px-1">
                                    <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                        <span class="text-[9px] font-bold font-urbanist">35%</span>
                                        <div class="w-full bg-[#11230B]/20 rounded-t-md h-[55%] flex items-end">
                                            <div class="w-full bg-[#11230B] rounded-t-md h-full"></div>
                                        </div>
                                        <span class="text-[9px] font-semibold">Barat</span>
                                    </div>
                                    <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                        <span class="text-[9px] font-bold font-urbanist">50%</span>
                                        <div class="w-full bg-[#11230B]/20 rounded-t-md h-[75%] flex items-end">
                                            <div class="w-full bg-[#11230B] rounded-t-md h-full"></div>
                                        </div>
                                        <span class="text-[9px] font-semibold">Pusat</span>
                                    </div>
                                    <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                        <span class="text-[9px] font-bold font-urbanist">15%</span>
                                        <div class="w-full bg-[#11230B]/20 rounded-t-md h-[30%] flex items-end">
                                            <div class="w-full bg-[#11230B] rounded-t-md h-full"></div>
                                        </div>
                                        <span class="text-[9px] font-semibold">Timur</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 pt-2">
                                <span class="px-2 py-0.5 rounded-full bg-[#11230B]/15 text-[10px] font-semibold">Hub Jakarta</span>
                                <span class="px-2 py-0.5 rounded-full bg-[#11230B] text-white text-[10px] font-bold">Siap Kirim</span>
                            </div>
                        </div>
                    </div>

                    <!-- Baris Bawah Kartu: 4 Ringkasan Angka Besar + Tombol Centang Bulat -->
                    <div class="pt-6 mt-4 border-t border-white/10 flex flex-col md:flex-row items-start md:items-end justify-between gap-6">
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 sm:gap-8 flex-1">
                            <!-- Stok Saat Ini -->
                            <div class="flex flex-col">
                                <span class="text-xs text-white/50 font-medium">Stok Saat Ini</span>
                                <div class="flex items-baseline gap-0.5 mt-0.5">
                                    <span class="font-urbanist text-3xl sm:text-4xl font-extrabold text-white">
                                        {{ $featuredStock->quantity }}
                                    </span>
                                    <sup class="text-xs font-semibold text-[#8FBF5B] font-urbanist -top-3">{{ $featuredStock->unit }}</sup>
                                </div>
                            </div>

                            <!-- Batas Minimum -->
                            <div class="flex flex-col">
                                <span class="text-xs text-white/50 font-medium">Batas Minimum</span>
                                <div class="flex items-baseline gap-0.5 mt-0.5">
                                    <span class="font-urbanist text-3xl sm:text-4xl font-extrabold text-white/90">
                                        {{ str_pad((string)$featuredStock->min_stock, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                    <sup class="text-xs font-semibold text-white/60 font-urbanist -top-3">{{ $featuredStock->unit }}</sup>
                                </div>
                            </div>

                            <!-- Status Stok -->
                            <div class="flex flex-col">
                                <span class="text-xs text-white/50 font-medium">Status</span>
                                <div class="mt-1">
                                    @if($featuredStock->quantity <= 0)
                                        <span class="px-3 py-1 rounded-full bg-[#E2725B]/20 text-[#FFAAA0] border border-[#E2725B]/40 text-xs font-bold">
                                            Habis
                                        </span>
                                    @elseif($featuredStock->quantity <= $featuredStock->min_stock)
                                        <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/40 text-xs font-bold">
                                            Menipis
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-[#8FBF5B]/20 text-[#8FBF5B] border border-[#8FBF5B]/40 text-xs font-bold">
                                            Tersedia (Aman)
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Total Nilai Aset -->
                            <div class="flex flex-col">
                                <span class="text-xs text-white/50 font-medium">Total Nilai Aset</span>
                                <div class="flex items-baseline gap-0.5 mt-0.5">
                                    <span class="font-urbanist text-3xl sm:text-4xl font-extrabold text-[#8FBF5B]">
                                        {{ number_format(($featuredStock->quantity * ($featuredStock->price ?? 0)) / 1000, 0, ',', '.') }}
                                    </span>
                                    <sup class="text-xs font-semibold text-[#C3D2AF] font-urbanist -top-3">rb Rp</sup>
                                </div>
                            </div>
                        </div>

                        <!-- Pojok Kanan Bawah: Tombol Centang Bulat RAKSASA Lime -->
                        <button type="button" wire:click="openEditModal({{ $featuredStock->id }})"
                            class="w-16 h-16 rounded-full bg-[#8FBF5B] hover:bg-[#a1d469] text-[#0A0A0A] flex items-center justify-center shadow-xl shadow-[#8FBF5B]/30 hover:scale-105 active:scale-95 transition-all shrink-0 self-end"
                            title="Konfirmasi & Edit Item">
                            <span class="material-symbols-outlined text-[32px] font-black">check</span>
                        </button>
                    </div>
                @else
                    <div class="p-12 text-center flex flex-col items-center justify-center my-auto">
                        <span class="material-symbols-outlined text-[64px] text-white/30">inventory</span>
                        <h4 class="font-urbanist text-2xl font-bold text-white mt-4">Belum Ada Stok Barang</h4>
                        <p class="text-sm text-white/60 mt-1 max-w-sm">Mulai tambahkan produk inventaris baru atau buat katalog otomatis dengan AI Generator.</p>
                        <button type="button" wire:click="openCreateModal"
                            class="mt-6 px-6 py-3 rounded-full bg-[#8FBF5B] text-black font-bold text-sm shadow-lg hover:bg-[#9ecc67] transition">
                            + Tambah Stok Sekarang
                        </button>
                    </div>
                @endif
            </div>

            <!-- KOLOM KANAN (±32% - 4 Cols): 3 KARTU KREM BERTUMPUK (#F7F4EA) -->
            <div class="lg:col-span-4 flex flex-col gap-4">
                @if($alertStocks->isNotEmpty())
                    @foreach($alertStocks as $index => $alertItem)
                        @php
                            $isCritical = $alertItem->quantity <= 0;
                            $cardBorder = $isCritical ? 'border-l-4 border-[#E2725B]' : '';
                        @endphp
                        <div class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-5 sm:p-6 shadow-xl flex flex-col justify-between transition-all {{ $cardBorder }}">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full overflow-hidden bg-black/10 shrink-0 border border-black/10 shadow-sm flex items-center justify-center">
                                        @if($alertItem->cover_image_path)
                                            <img src="{{ $alertItem->coverImageUrl() }}" alt="{{ $alertItem->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="material-symbols-outlined {{ $isCritical ? 'text-[#E2725B]' : 'text-[#3E5B34]' }} text-[24px]">
                                                {{ $isCritical ? 'warning' : 'inventory_2' }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs text-[#52524E] font-medium leading-none">
                                            {{ $isCritical ? 'Habis / Perlu Restock' : 'Restock Rutin Pergudangan' }}
                                        </span>
                                        <h4 class="font-urbanist text-base sm:text-lg font-bold text-[#161616] mt-1 leading-tight">
                                            {{ $alertItem->name }}
                                        </h4>
                                    </div>
                                </div>

                                <!-- Pill Status / Toggle -->
                                @if($isCritical)
                                    <span class="px-2.5 py-1 rounded-full bg-[#E2725B]/20 text-[#B83E28] font-bold text-[10px] tracking-wide uppercase">
                                        Kritis
                                    </span>
                                @else
                                    <div class="inline-flex items-center bg-[#E5E1D3] p-1 rounded-full shadow-inner">
                                        <span class="w-6 h-6 rounded-full bg-[#8FBF5B] text-[#0A0A0A] flex items-center justify-center text-[12px] font-bold shadow-sm">✓</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-end justify-between mt-5 pt-3 border-t border-black/5">
                                <div class="flex flex-col">
                                    <span class="text-xs text-[#6B6960] font-medium">
                                        {{ $isCritical ? 'Status Peringatan' : 'Cadangan Logistik' }}
                                    </span>
                                    <span class="text-xs {{ $isCritical ? 'text-[#E2725B] font-bold' : 'text-slate-800 font-semibold' }}">
                                        {{ $isCritical ? 'Restock segera hari ini' : ($alertItem->rack_location ?? 'Gudang Utama') }}
                                    </span>
                                </div>
                                <div class="flex items-baseline gap-0.5">
                                    <span class="font-urbanist text-3xl font-extrabold {{ $isCritical ? 'text-[#E2725B]' : 'text-[#161616]' }}">
                                        {{ $alertItem->quantity }}
                                    </span>
                                    <sup class="text-xs font-bold {{ $isCritical ? 'text-[#E2725B]' : 'text-[#4B7322]' }} font-urbanist -top-2">
                                        {{ $alertItem->unit }}
                                    </sup>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Default Static Monitoring Cards when all stock is healthy -->
                    <div class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-6 shadow-xl flex flex-col justify-between">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[24px]">verified</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs text-[#52524E] font-medium leading-none">Monitoring Kesehatan Stok</span>
                                    <h4 class="font-urbanist text-lg font-bold text-[#161616] mt-1 leading-tight">Kondisi Inventaris Prima</h4>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-[#8FBF5B] text-black font-bold text-[10px]">100% Aman</span>
                        </div>
                        <div class="mt-4 pt-3 border-t border-black/5 text-xs text-[#52524E]">
                            Tidak ada barang dengan status kritis atau stok di bawah batas minimum saat ini.
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- D. LOWER SECTION: KATALOG INVENTARIS LAINNYA (BENTO CARDS VS TABLE TOGGLE) -->
        <section class="flex flex-col gap-4 pt-4">
            <!-- Header Section dengan Toggle Mode -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#8FBF5B]"></span>
                    <h3 class="font-urbanist text-xl sm:text-2xl font-bold text-white tracking-tight">Katalog Inventaris Lainnya</h3>
                    <span class="text-xs bg-white/10 px-2.5 py-0.5 rounded-full text-[#BBD8A0] font-mono">
                        {{ $stocks->total() }} SKU Terdaftar
                    </span>
                </div>

                <!-- Tombol Switch Bento vs Tabel -->
                <div class="inline-flex items-center bg-black/40 backdrop-blur-md border border-white/15 p-1 rounded-full shadow-lg self-start sm:self-auto">
                    <button type="button" wire:click="setViewMode('bento')"
                        class="px-4 py-1.5 rounded-full text-xs font-semibold flex items-center gap-1.5 transition-all {{ $viewMode === 'bento' ? 'bg-[#8FBF5B] text-black font-bold shadow-md' : 'text-white/70 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[16px]">grid_view</span>
                        <span>Bento Grid</span>
                    </button>
                    <button type="button" wire:click="setViewMode('table')"
                        class="px-4 py-1.5 rounded-full text-xs font-semibold flex items-center gap-1.5 transition-all {{ $viewMode === 'table' ? 'bg-[#8FBF5B] text-black font-bold shadow-md' : 'text-white/70 hover:text-white' }}">
                        <span class="material-symbols-outlined text-[16px]">table_chart</span>
                        <span>Tabel Standar</span>
                    </button>
                </div>
            </div>

            <!-- MODE 1: BENTO GRID VIEW -->
            @if($viewMode === 'bento')
                @if($stocks->isEmpty())
                    <div class="bg-black/30 backdrop-blur-md rounded-[28px] border border-white/10 p-12 text-center text-white/60">
                        <span class="material-symbols-outlined text-[48px] text-white/30">search_off</span>
                        <p class="font-urbanist text-lg font-bold text-white mt-2">Tidak ada barang yang cocok dengan filter</p>
                        <p class="text-xs text-white/50 mt-1">Coba sesuaikan kata kunci pencarian atau pilih kategori lain.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($stocks as $stock)
                            <div class="bg-black/40 backdrop-blur-md rounded-[24px] p-5 border border-white/10 hover:border-[#8FBF5B]/50 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 group shadow-xl">
                                <!-- Top: Image / Icon + Details -->
                                <div>
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-full overflow-hidden bg-white/5 shrink-0 border border-white/10 flex items-center justify-center">
                                                @if($stock->cover_image_path)
                                                    <img src="{{ $stock->coverImageUrl() }}" alt="{{ $stock->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full bg-[#2C4328] flex items-center justify-center text-[#8FBF5B]">
                                                        <span class="material-symbols-outlined text-[22px]">category</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex flex-col min-w-0">
                                                <h5 class="text-sm font-bold text-white group-hover:text-[#8FBF5B] transition-colors leading-tight truncate">
                                                    {{ $stock->name }}
                                                </h5>
                                                <span class="text-[11px] text-white/50 truncate">
                                                    {{ $stock->category ?? 'Umum' }} • {{ $stock->rack_location ?? 'Rak A-01' }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Status indicator badge -->
                                        @if($stock->quantity <= 0)
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#E2725B] shrink-0" title="Stok Habis"></span>
                                        @elseif($stock->quantity <= $stock->min_stock)
                                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 shrink-0" title="Stok Menipis"></span>
                                        @else
                                            <span class="w-2.5 h-2.5 rounded-full bg-[#8FBF5B] shrink-0" title="Stok Tersedia"></span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Middle: Quick Action Buttons -->
                                <div class="flex items-center gap-2 mt-4 pt-3 border-t border-white/10">
                                    <a href="{{ route('stocks.show', $stock) }}"
                                        class="flex-1 py-1 px-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-[11px] font-semibold text-center transition">
                                        Detail
                                    </a>
                                    <button type="button" wire:click="openEditModal({{ $stock->id }})"
                                        class="p-1.5 rounded-full bg-white/10 hover:bg-[#8FBF5B] hover:text-black text-white/80 transition"
                                        title="Ubah Data">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                    </button>
                                    <button type="button" wire:click="confirmDelete({{ $stock->id }})"
                                        class="p-1.5 rounded-full bg-white/10 hover:bg-rose-600 text-white/80 transition"
                                        title="Hapus Barang">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                    </button>
                                </div>

                                <!-- Bottom: Stock Quantity & Price -->
                                <div class="flex items-end justify-between mt-3 pt-2 border-t border-white/5">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] text-white/40 uppercase">Tersedia</span>
                                        <div class="flex items-baseline gap-0.5">
                                            <span class="font-urbanist text-2xl font-bold text-white">
                                                {{ $stock->quantity }}
                                            </span>
                                            <sup class="text-[10px] text-[#8FBF5B] font-urbanist -top-2">{{ $stock->unit }}</sup>
                                        </div>
                                    </div>
                                    <div class="flex items-baseline gap-0.5 text-right">
                                        <span class="font-urbanist text-lg font-bold text-white/90">
                                            {{ number_format($stock->price ?? 0, 0, ',', '.') }}
                                        </span>
                                        <sup class="text-[9px] text-[#C3D2AF] font-urbanist -top-1.5">Rp</sup>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            <!-- MODE 2: TABLE VIEW -->
            @else
                <div class="bg-[#141414] rounded-[24px] border border-white/10 shadow-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-white">
                            <thead class="bg-black/50 text-[11px] font-bold uppercase tracking-wider text-white/60 border-b border-white/10">
                                <tr>
                                    <th class="px-6 py-4">Nama Barang & SKU</th>
                                    <th class="px-6 py-4">Kategori & Rak</th>
                                    <th class="px-6 py-4">Supplier</th>
                                    <th class="px-6 py-4">Harga Satuan</th>
                                    <th class="px-6 py-4">Kuantitas</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($stocks as $stock)
                                    <tr class="hover:bg-white/5 transition">
                                        <td class="px-6 py-4 font-semibold text-white">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center shrink-0 text-[#8FBF5B] font-bold">
                                                    {{ strtoupper(substr($stock->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <a href="{{ route('stocks.show', $stock) }}" class="hover:text-[#8FBF5B] transition">
                                                        {{ $stock->name }}
                                                    </a>
                                                    <p class="text-xs text-white/40 font-mono">{{ $stock->sku ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-xs">
                                            <span class="px-2 py-0.5 rounded-full bg-white/10 text-white font-medium">
                                                {{ $stock->category ?? 'Umum' }}
                                            </span>
                                            <p class="text-white/40 mt-1">{{ $stock->rack_location ?? '-' }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-white/70">
                                            {{ $stock->supplier ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 font-urbanist font-bold text-white">
                                            Rp {{ number_format($stock->price ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="font-urbanist font-extrabold text-base text-white">
                                                {{ $stock->quantity }}
                                            </span>
                                            <span class="text-xs text-white/50">{{ $stock->unit }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($stock->quantity <= 0)
                                                <span class="px-2.5 py-1 rounded-full bg-[#E2725B]/20 text-[#FFAAA0] text-xs font-bold">Habis</span>
                                            @elseif($stock->quantity <= $stock->min_stock)
                                                <span class="px-2.5 py-1 rounded-full bg-amber-500/20 text-amber-300 text-xs font-bold">Menipis</span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-full bg-[#8FBF5B]/20 text-[#8FBF5B] text-xs font-bold">Tersedia</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="inline-flex items-center gap-1.5">
                                                <a href="{{ route('stocks.show', $stock) }}"
                                                    class="p-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-white transition" title="Lihat">
                                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                                </a>
                                                <button type="button" wire:click="openEditModal({{ $stock->id }})"
                                                    class="p-1.5 rounded-lg bg-white/10 hover:bg-[#8FBF5B] hover:text-black text-white transition" title="Edit">
                                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                                </button>
                                                <button type="button" wire:click="confirmDelete({{ $stock->id }})"
                                                    class="p-1.5 rounded-lg bg-white/10 hover:bg-rose-600 text-white transition" title="Hapus">
                                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-white/50">
                                            Tidak ada data stok yang ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Pagination -->
            <div class="mt-4">
                {{ $stocks->links() }}
            </div>
        </section>

        <!-- E. FOOTER ACCENT -->
        <footer class="w-full pt-8 pb-2 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-[#C3D2AF]/70 font-medium border-t border-white/10">
            <div>StockBarang Suite • Precision Bento Architecture</div>
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#8FBF5B]"></span>
                <span>Sistem Operasi Inventaris Berbasis Sentuhan • 2026</span>
            </div>
        </footer>
    </div>

    <!-- ========================================== -->
    <!-- MODAL 1: TAMBAH / UBAH STOK (STITCH SCREEN 4) -->
    <!-- ========================================== -->
    @if($showFormModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md overflow-y-auto"
            x-data @keydown.escape.window="$wire.closeFormModal()">
            <div class="bg-[#141414] border border-white/15 text-white rounded-[32px] w-full max-w-2xl p-6 sm:p-8 shadow-2xl relative my-8">
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#8FBF5B]">Form Inventaris</span>
                        <h2 class="font-urbanist text-2xl font-bold text-white mt-0.5">
                            {{ $editingStockId ? 'Ubah Data Stok Barang' : 'Tambah Stok Barang Baru' }}
                        </h2>
                    </div>
                    <button type="button" wire:click="closeFormModal"
                        class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <!-- Form Body -->
                <form wire:submit="saveStock" class="flex flex-col gap-5 mt-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nama Barang -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-white/70 mb-1">Nama Barang *</label>
                            <input type="text" wire:model="formName"
                                placeholder="Contoh: Beras Pandan Wangi 5kg"
                                class="w-full h-11 px-4 rounded-xl bg-[#232323] border border-white/10 text-white text-sm focus:outline-none focus:border-[#8FBF5B]" />
                            @error('formName') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- SKU -->
                        <div>
                            <label class="block text-xs font-semibold text-white/70 mb-1">SKU / Kode Barang</label>
                            <input type="text" wire:model="formSku"
                                placeholder="Contoh: STK-BRS-001"
                                class="w-full h-11 px-4 rounded-xl bg-[#232323] border border-white/10 text-white text-sm focus:outline-none focus:border-[#8FBF5B]" />
                            @error('formSku') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-xs font-semibold text-white/70 mb-1">Kategori Barang</label>
                            <input type="text" wire:model="formCategory"
                                placeholder="Sembako, Minuman, Bumbu, dll."
                                class="w-full h-11 px-4 rounded-xl bg-[#232323] border border-white/10 text-white text-sm focus:outline-none focus:border-[#8FBF5B]" />
                            @error('formCategory') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Pemasok / Supplier -->
                        <div>
                            <label class="block text-xs font-semibold text-white/70 mb-1">Pemasok / Supplier</label>
                            <input type="text" wire:model="formSupplier"
                                placeholder="Contoh: PB Sri Makmur"
                                class="w-full h-11 px-4 rounded-xl bg-[#232323] border border-white/10 text-white text-sm focus:outline-none focus:border-[#8FBF5B]" />
                            @error('formSupplier') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Lokasi Rak / Gudang -->
                        <div>
                            <label class="block text-xs font-semibold text-white/70 mb-1">Lokasi Rak / Penyimpanan</label>
                            <input type="text" wire:model="formRackLocation"
                                placeholder="Contoh: Rak A-02, Gudang Pusat"
                                class="w-full h-11 px-4 rounded-xl bg-[#232323] border border-white/10 text-white text-sm focus:outline-none focus:border-[#8FBF5B]" />
                            @error('formRackLocation') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Jumlah Stok & Stepper -->
                        <div>
                            <label class="block text-xs font-semibold text-white/70 mb-1">Jumlah Stok Fisik *</label>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="$wire.formQuantity = Math.max(0, parseInt($wire.formQuantity || 0) - 1)"
                                    class="w-11 h-11 rounded-xl bg-[#232323] hover:bg-white/15 text-white flex items-center justify-center font-bold text-lg">
                                    -
                                </button>
                                <input type="number" wire:model="formQuantity" min="0"
                                    class="flex-1 h-11 px-4 rounded-xl bg-[#232323] border border-white/10 text-white font-urbanist font-bold text-base text-center focus:outline-none focus:border-[#8FBF5B]" />
                                <button type="button" @click="$wire.formQuantity = parseInt($wire.formQuantity || 0) + 1"
                                    class="w-11 h-11 rounded-xl bg-[#8FBF5B] hover:bg-[#9ecc67] text-black flex items-center justify-center font-bold text-lg">
                                    +
                                </button>
                            </div>
                            @error('formQuantity') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Satuan -->
                        <div>
                            <label class="block text-xs font-semibold text-white/70 mb-1">Satuan Ukuran *</label>
                            <input type="text" wire:model="formUnit"
                                placeholder="pcs, kg, sak, box, rim"
                                class="w-full h-11 px-4 rounded-xl bg-[#232323] border border-white/10 text-white text-sm focus:outline-none focus:border-[#8FBF5B]" />
                            @error('formUnit') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Harga Satuan -->
                        <div>
                            <label class="block text-xs font-semibold text-white/70 mb-1">Harga Satuan (Rp)</label>
                            <input type="number" wire:model="formPrice" min="0" step="100"
                                placeholder="Contoh: 75000"
                                class="w-full h-11 px-4 rounded-xl bg-[#232323] border border-white/10 text-white font-urbanist text-sm focus:outline-none focus:border-[#8FBF5B]" />
                            @error('formPrice') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Batas Minimum Stok -->
                        <div>
                            <label class="block text-xs font-semibold text-white/70 mb-1">Batas Minimum Stok *</label>
                            <input type="number" wire:model="formMinStock" min="0"
                                class="w-full h-11 px-4 rounded-xl bg-[#232323] border border-white/10 text-white font-urbanist text-sm focus:outline-none focus:border-[#8FBF5B]" />
                            @error('formMinStock') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Alur Tahap Pesanan -->
                        <div>
                            <label class="block text-xs font-semibold text-white/70 mb-1">Alur Tahap Restock</label>
                            <select wire:model="formOrderStage"
                                class="w-full h-11 px-4 rounded-xl bg-[#232323] border border-white/10 text-white text-sm focus:outline-none focus:border-[#8FBF5B]">
                                <option value="ordered">Pesan Agen</option>
                                <option value="verified">Verifikasi Fisik</option>
                                <option value="stored">Masuk Gudang</option>
                                <option value="ready">Siap Jual</option>
                            </select>
                        </div>

                        <!-- Status Ketersediaan -->
                        <div>
                            <label class="block text-xs font-semibold text-white/70 mb-1">Status Ketersediaan *</label>
                            <select wire:model="formStatus"
                                class="w-full h-11 px-4 rounded-xl bg-[#232323] border border-white/10 text-white text-sm focus:outline-none focus:border-[#8FBF5B]">
                                <option value="available">Tersedia (Normal)</option>
                                <option value="low_stock">Menipis (Low Stock)</option>
                                <option value="out_of_stock">Habis (Out of Stock)</option>
                            </select>
                            @error('formStatus') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-white/70 mb-1">Deskripsi Tambahan</label>
                            <textarea wire:model="formDescription" rows="2"
                                placeholder="Catatan spesifikasi produk atau informasi batch..."
                                class="w-full p-3 rounded-xl bg-[#232323] border border-white/10 text-white text-sm focus:outline-none focus:border-[#8FBF5B]"></textarea>
                            @error('formDescription') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10">
                        <button type="button" wire:click="closeFormModal"
                            class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white font-semibold text-xs transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="btn-interactive px-6 py-2.5 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] text-black font-bold text-xs flex items-center gap-1.5 shadow-lg shadow-[#8FBF5B]/20 transition">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            <span>Simpan & Sinkronisasi Stok</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- ========================================== -->
    <!-- MODAL 2: AI STOCK GENERATOR -->
    <!-- ========================================== -->
    @if($showAiModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md overflow-y-auto"
            x-data @keydown.escape.window="$wire.closeAiModal()">
            <div class="bg-[#141414] border border-purple-500/30 text-white rounded-[32px] w-full max-w-2xl p-6 sm:p-8 shadow-2xl relative my-8">
                <!-- Header -->
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-600/30 border border-purple-500/40 text-purple-300 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">auto_awesome</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-purple-400">AI Intelligent Assistant</span>
                            <h2 class="font-urbanist text-2xl font-bold text-white">Generate Katalog Stok</h2>
                        </div>
                    </div>
                    <button type="button" wire:click="closeAiModal"
                        class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <!-- Prompt Input -->
                <div class="mt-6 flex flex-col gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-white/70 mb-1">Jelaskan Jenis Barang atau Sektor Usaha *</label>
                        <textarea wire:model="aiPrompt" rows="3"
                            placeholder="Contoh: Buatkan 5 stok barang sembako toko kelontong seperti minyak goreng, gula, tepung, telur, dan beras..."
                            class="w-full p-3.5 rounded-2xl bg-[#232323] border border-white/10 text-white text-sm focus:outline-none focus:border-purple-400"></textarea>
                        @error('aiPrompt') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <label class="text-xs text-white/70">Jumlah Item:</label>
                            <input type="number" wire:model="aiCount" min="1" max="10"
                                class="w-20 h-9 px-3 rounded-xl bg-[#232323] border border-white/10 text-white text-xs font-urbanist font-bold text-center" />
                        </div>

                        <button type="button" wire:click="generateWithAi" wire:loading.attr="disabled"
                            class="btn-interactive px-5 py-2.5 rounded-full bg-purple-600 hover:bg-purple-500 text-white font-bold text-xs flex items-center gap-2 shadow-lg shadow-purple-600/30 transition disabled:opacity-50">
                            <span wire:loading wire:target="generateWithAi" class="animate-spin material-symbols-outlined text-[16px]">progress_activity</span>
                            <span wire:loading.remove wire:target="generateWithAi" class="material-symbols-outlined text-[16px]">auto_awesome</span>
                            <span>Generate dengan AI</span>
                        </button>
                    </div>

                    @if($aiErrorMessage)
                        <div class="p-3 rounded-xl bg-rose-500/20 border border-rose-500/30 text-rose-200 text-xs">
                            {{ $aiErrorMessage }}
                        </div>
                    @endif

                    <!-- Shimmer Loader saat AI sedang generate -->
                    <div wire:loading wire:target="generateWithAi" class="flex flex-col gap-3 py-4">
                        <div class="shimmer-card rounded-2xl p-4 bg-[#232323] border border-white/5">
                            <div class="h-4 bg-white/20 rounded w-1/3 mb-2"></div>
                            <div class="h-3 bg-white/10 rounded w-2/3"></div>
                        </div>
                        <div class="shimmer-card rounded-2xl p-4 bg-[#232323] border border-white/5">
                            <div class="h-4 bg-white/20 rounded w-1/2 mb-2"></div>
                            <div class="h-3 bg-white/10 rounded w-3/4"></div>
                        </div>
                    </div>

                    <!-- AI Generated Items Preview -->
                    @if(!empty($aiGeneratedItems))
                        <div class="mt-4 pt-4 border-t border-white/10">
                            <span class="text-xs font-bold text-[#8FBF5B] block mb-2">Pilih Item yang Ingin Disimpan:</span>
                            <div class="flex flex-col gap-2 max-h-60 overflow-y-auto pr-1">
                                @foreach($aiGeneratedItems as $idx => $item)
                                    <label class="flex items-start gap-3 p-3 rounded-xl bg-[#232323] border border-white/5 cursor-pointer hover:bg-white/5 transition">
                                        <input type="checkbox" wire:model="aiSelectedIndices" value="{{ $idx }}"
                                            class="mt-1 rounded text-purple-600 focus:ring-purple-500" />
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-white">{{ $item['name'] }}</p>
                                            <p class="text-xs text-white/50">{{ $item['sku'] ?? 'No SKU' }} • {{ $item['quantity'] ?? 10 }} {{ $item['unit'] ?? 'pcs' }} • Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <button type="button" wire:click="saveAiGenerated"
                                class="mt-4 w-full py-3 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] text-black font-bold text-xs flex items-center justify-center gap-2 shadow-lg transition">
                                <span class="material-symbols-outlined text-[18px]">done_all</span>
                                <span>Simpan Item Terpilih ke Database</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================== -->
    <!-- MODAL 3: EXCEL IMPORT -->
    <!-- ========================================== -->
    @if($showImportModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
            x-data @keydown.escape.window="$wire.closeImportModal()">
            <div class="bg-[#141414] border border-white/15 text-white rounded-[32px] w-full max-w-lg p-6 sm:p-8 shadow-2xl relative">
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <h2 class="font-urbanist text-xl font-bold text-white">Import Data Excel (.xlsx / .csv)</h2>
                    <button type="button" wire:click="closeImportModal" class="w-8 h-8 rounded-full bg-white/10 text-white flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>

                <form wire:submit="importExcel" class="mt-6 flex flex-col gap-4">
                    <div class="border-2 border-dashed border-white/20 rounded-2xl p-8 text-center flex flex-col items-center justify-center hover:border-[#8FBF5B] transition">
                        <span class="material-symbols-outlined text-[40px] text-emerald-400 mb-2">upload_file</span>
                        <p class="text-xs text-white/70">Pilih file spreadsheet dengan format kolom: Nama, SKU, Kuantitas, Satuan, Harga, Batas Min.</p>
                        <input type="file" wire:model="importFile" class="mt-4 text-xs text-white/60" accept=".xlsx,.xls,.csv" />
                        @error('importFile') <span class="text-xs text-rose-400 mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" wire:click="closeImportModal" class="px-5 py-2.5 rounded-full bg-white/10 text-white text-xs font-semibold">
                            Batal
                        </button>
                        <button type="submit" wire:loading.attr="disabled"
                            class="px-6 py-2.5 rounded-full bg-emerald-500 hover:bg-emerald-400 text-black font-bold text-xs flex items-center gap-1.5 transition disabled:opacity-50">
                            <span wire:loading wire:target="importExcel" class="animate-spin material-symbols-outlined text-[16px]">progress_activity</span>
                            <span>Proses Import</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- ========================================== -->
    <!-- MODAL 4: DELETE CONFIRMATION -->
    <!-- ========================================== -->
    @if($confirmingStockDeletionId)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-md">
            <div class="bg-[#141414] border border-rose-500/30 text-white rounded-[28px] w-full max-w-md p-6 shadow-2xl text-center">
                <div class="w-14 h-14 rounded-full bg-rose-500/20 text-rose-400 mx-auto flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[32px]">warning</span>
                </div>
                <h3 class="font-urbanist text-xl font-bold text-white">Konfirmasi Hapus Barang</h3>
                <p class="text-xs text-white/60 mt-2">
                    Apakah Anda yakin ingin menghapus barang inventaris ini? Tindakan ini tidak dapat dibatalkan.
                </p>
                <div class="flex items-center justify-center gap-3 mt-6">
                    <button type="button" wire:click="cancelDelete"
                        class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white font-semibold text-xs transition">
                        Batal
                    </button>
                    <button type="button" wire:click="deleteStock"
                        class="px-5 py-2.5 rounded-full bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs shadow-lg shadow-rose-600/30 transition">
                        Ya, Hapus Sekarang
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
