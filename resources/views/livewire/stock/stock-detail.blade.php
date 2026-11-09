<div class="bento-dashboard-bg bento-grain-overlay min-h-screen -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 text-white relative font-manrope selection:bg-[#8FBF5B] selection:text-black">
    <div class="relative z-10 max-w-[1400px] mx-auto flex flex-col gap-6 sm:gap-8 pb-12">

        <!-- Flash Notification -->
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                class="flex items-center justify-between p-4 rounded-2xl bg-[#8FBF5B]/20 border border-[#8FBF5B]/40 text-[#8FBF5B] backdrop-blur-md shadow-lg">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[22px]">check_circle</span>
                    <span class="text-sm font-semibold text-white">{{ session('success') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-white/60 hover:text-white">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show"
                class="flex items-center justify-between p-4 rounded-2xl bg-rose-500/20 border border-rose-500/40 text-rose-300 backdrop-blur-md shadow-lg">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[22px]">error</span>
                    <span class="text-sm font-semibold text-white">{{ session('error') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-white/60 hover:text-white">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>
        @endif

        <!-- TOP NAVIGATION & ACTION HEADER (STITCH SCREEN 2) -->
        <header class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-2 border-b border-white/10">
            <div class="flex flex-col gap-2">
                <!-- Navigation Pills & Badges -->
                <div class="flex items-center gap-2.5 flex-wrap">
                    <a href="{{ route('stocks.index') }}"
                        class="group inline-flex items-center gap-2 px-4 py-2 rounded-full bg-black/40 hover:bg-black/60 border border-white/15 text-white/90 hover:text-white text-xs sm:text-sm font-medium backdrop-blur-md transition-all shadow-md">
                        <span class="material-symbols-outlined text-[18px] text-[#8FBF5B] transition-transform group-hover:-translate-x-1">arrow_back</span>
                        <span>Kembali ke Stok Saya</span>
                    </a>

                    <!-- Interactive SKU Chip with Click-to-Copy -->
                    <div x-data="{ copied: false }" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-black/40 border border-white/15 backdrop-blur-md text-xs font-mono text-white/80">
                        <span class="text-[#8FBF5B] font-bold">SKU:</span>
                        <span>{{ $stock->sku ?: 'No SKU' }}</span>
                        @if($stock->sku)
                            <button type="button" @click="navigator.clipboard.writeText('{{ $stock->sku }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="text-white/50 hover:text-[#8FBF5B] transition-colors ml-1" title="Salin SKU">
                                <span class="material-symbols-outlined text-[14px]" x-show="!copied">content_copy</span>
                                <span class="material-symbols-outlined text-[14px] text-[#8FBF5B]" x-show="copied" x-cloak>check</span>
                            </button>
                        @endif
                    </div>

                    <!-- Status Pill Badge -->
                    @php
                        $stEnum = $stock->status instanceof \App\Features\Stock\Enums\StockStatus ? $stock->status : \App\Features\Stock\Enums\StockStatus::tryFrom($stock->status);
                    @endphp
                    @if($stock->quantity <= 0)
                        <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#E2725B]/20 border border-[#E2725B]/40 text-[#FFAAA0] text-xs font-bold uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-[#E2725B] animate-ping"></span>
                            <span>Stok Habis</span>
                        </div>
                    @elseif($stock->quantity <= $stock->min_stock)
                        <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-amber-500/20 border border-amber-500/40 text-amber-300 text-xs font-bold uppercase tracking-wider">
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                            <span>Stok Menipis</span>
                        </div>
                    @else
                        <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#8FBF5B]/20 border border-[#8FBF5B]/40 text-[#8FBF5B] text-xs font-bold uppercase tracking-wider">
                            <span class="material-symbols-outlined text-[15px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span>Tersedia</span>
                        </div>
                    @endif

                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 text-white/70 text-xs font-medium">
                        Kategori: <strong class="text-white ml-1">{{ $stock->category ?: 'Umum' }}</strong>
                    </div>
                </div>

                <!-- Product Giant Title -->
                <div class="mt-1">
                    <h1 class="font-urbanist text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        {{ $stock->name }}
                    </h1>
                    <p class="text-xs sm:text-sm text-white/60 mt-1 font-medium">
                        Pembaruan fisik terakhir: <span class="text-white/90 font-semibold">{{ $stock->updated_at ? $stock->updated_at->diffForHumans() : '-' }}</span>
                        • Lokasi Rak: <span class="text-[#8FBF5B] font-semibold">{{ $stock->rack_location ?: '-' }}</span>
                        • Supplier: <span class="text-white/90 font-semibold">{{ $stock->supplier ?: '-' }}</span>
                    </p>
                </div>
            </div>

            <!-- Quick Action Bar -->
            <div class="flex items-center gap-2.5 flex-wrap self-start lg:self-center">
                <!-- Cetak Barcode Button -->
                <button type="button" wire:click="toggleBarcodeModal"
                    class="btn-interactive inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-black/40 hover:bg-black/60 border border-white/15 text-white/90 hover:text-white text-xs sm:text-sm font-semibold backdrop-blur-md shadow-md transition-all">
                    <span class="material-symbols-outlined text-[18px] text-[#8FBF5B]">qr_code_2</span>
                    <span>Cetak Barcode</span>
                </button>

                <!-- Bagikan Link Button -->
                <button type="button" x-data="{ shared: false }"
                    @click="navigator.clipboard.writeText(window.location.href); shared = true; setTimeout(() => shared = false, 2500)"
                    class="btn-interactive inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-black/40 hover:bg-black/60 border border-white/15 text-white/90 hover:text-white text-xs sm:text-sm font-semibold backdrop-blur-md shadow-md transition-all">
                    <span class="material-symbols-outlined text-[18px]" x-show="!shared">share</span>
                    <span class="material-symbols-outlined text-[18px] text-[#8FBF5B]" x-show="shared" x-cloak>check</span>
                    <span x-text="shared ? 'Tautan Disalin!' : 'Bagikan Log'"></span>
                </button>

                <!-- Edit Stok Button -->
                <button type="button" wire:click="openEditModal"
                    class="btn-interactive inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] text-[#0A0A0A] font-bold text-xs sm:text-sm shadow-lg shadow-[#8FBF5B]/25 active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-[18px] font-bold">edit</span>
                    <span>Edit Stok</span>
                </button>

                <!-- Hapus Stok Button -->
                <button type="button" wire:click="confirmDeleteStock"
                    class="btn-interactive inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full bg-rose-500/20 hover:bg-rose-500/30 border border-rose-500/30 text-rose-300 hover:text-white text-xs sm:text-sm font-semibold transition-all">
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                    <span>Hapus</span>
                </button>
            </div>
        </header>

        <!-- MAIN BENTO 2-COLUMN GRID (KIRI 65% / KANAN 35%) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- LEFT COLUMN (8 Kolom / ±65%) -->
            <div class="lg:col-span-8 flex flex-col gap-6">

                <!-- BENTO 1: COVER IMAGE & TELEMETRI VISUAL -->
                <div class="rounded-[32px] bg-[#141414] p-6 sm:p-8 border border-white/10 shadow-2xl relative overflow-hidden flex flex-col gap-4">
                    <input type="file" wire:model="coverPhoto" id="coverPhotoInput" accept="image/*" class="hidden">

                    <div class="relative w-full h-80 sm:h-96 rounded-2xl overflow-hidden bg-gradient-to-tr from-[#1E3A12] via-[#2A441E] to-[#141414] border border-white/10 group shadow-inner">
                        @if ($stock->cover_image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($stock->cover_image_path))
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($stock->cover_image_path) }}?v={{ time() }}"
                                alt="{{ $stock->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-center p-6 bg-gradient-to-b from-[#20361A]/40 to-[#141414]">
                                <div class="w-16 h-16 rounded-2xl bg-white/10 border border-white/15 flex items-center justify-center text-[#8FBF5B] mb-3 shadow-lg">
                                    <span class="material-symbols-outlined text-[36px]">image</span>
                                </div>
                                <h3 class="font-urbanist text-lg font-bold text-white">Belum Ada Cover Gambar</h3>
                                <p class="text-xs text-white/50 mt-1 max-w-sm">
                                    Unggah foto produk atau label kemasan untuk mempermudah identifikasi inventaris di gudang.
                                </p>
                                <button type="button" onclick="document.getElementById('coverPhotoInput').click()"
                                    class="btn-interactive mt-4 px-5 py-2.5 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] text-[#0A0A0A] text-xs font-bold flex items-center gap-2 shadow-lg shadow-[#8FBF5B]/20 transition-all">
                                    <span class="material-symbols-outlined text-[18px]">upload</span>
                                    <span>Unggah Gambar Cover</span>
                                </button>
                            </div>
                        @endif

                        <!-- Gradient Scrim for Contrast -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>

                        <!-- Top Overlay Badges -->
                        <div class="absolute top-4 left-4 flex items-center gap-2">
                            <span class="px-3.5 py-1 rounded-full bg-black/60 backdrop-blur-md text-white text-[11px] font-semibold flex items-center gap-1.5 border border-white/10 shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-[#8FBF5B] animate-pulse"></span>
                                <span>Foto Utama Katalog</span>
                            </span>
                            <span class="px-3 py-1 rounded-full bg-black/60 backdrop-blur-md text-white/60 text-[11px] font-mono border border-white/10">
                                {{ $stock->unit ? strtoupper($stock->unit) : 'UNIT' }} • ID #{{ $stock->id }}
                            </span>
                        </div>

                        <!-- Bottom Action Deck inside Cover -->
                        <div class="absolute bottom-4 inset-x-4 flex items-center justify-between flex-wrap gap-2 z-10">
                            <div class="flex items-center gap-2 bg-black/70 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/15">
                                <span class="material-symbols-outlined text-[#8FBF5B] text-[18px]">verified</span>
                                <span class="text-xs text-white font-medium">Terverifikasi Sistem Inventaris Gudang</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="button" onclick="document.getElementById('coverPhotoInput').click()"
                                    class="btn-interactive inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-black/70 hover:bg-black/90 border border-white/20 text-white text-xs font-semibold backdrop-blur-md shadow-md transition-all"
                                    title="Ganti Foto Cover">
                                    <span class="material-symbols-outlined text-[16px] text-[#8FBF5B]">upload</span>
                                    <span>{{ $stock->cover_image_path ? 'Ganti Cover' : 'Unggah Cover' }}</span>
                                </button>

                                @if($stock->cover_image_path)
                                    <button type="button" wire:click="confirmDeleteCover"
                                        class="btn-interactive inline-flex items-center gap-1.5 px-3 py-2 rounded-full bg-rose-500/30 hover:bg-rose-500/50 border border-rose-500/40 text-rose-200 text-xs font-semibold backdrop-blur-md transition-all"
                                        title="Hapus Cover">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                        <span>Hapus</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Thumbnail Strip & Info Tag -->
                    <div class="flex items-center justify-between flex-wrap gap-3 pt-1">
                        <div class="flex items-center gap-2.5">
                            <div class="w-12 h-12 rounded-xl bg-white/10 border-2 border-[#8FBF5B] overflow-hidden flex items-center justify-center shadow-md">
                                @if($stock->cover_image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($stock->cover_image_path))
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($stock->cover_image_path) }}" alt="Thumb" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-[20px] text-[#8FBF5B]">image</span>
                                @endif
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white/40">
                                <span class="material-symbols-outlined text-[20px]">inventory_2</span>
                            </div>
                            <div class="w-12 h-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white/40">
                                <span class="material-symbols-outlined text-[20px]">shelves</span>
                            </div>
                            <button type="button" onclick="document.getElementById('coverPhotoInput').click()"
                                class="w-12 h-12 rounded-xl bg-white/5 hover:bg-white/10 border border-dashed border-white/20 flex items-center justify-center text-white/60 hover:text-white transition-colors"
                                title="Tambah Angle Foto">
                                <span class="material-symbols-outlined text-[20px]">add_photo_alternate</span>
                            </button>
                        </div>

                        <div class="text-right">
                            <span class="text-[11px] text-white/50 block font-mono">Format Didukung: JPG, PNG, WEBP (Maks 5MB)</span>
                            <span class="text-[11px] text-[#8FBF5B] font-semibold">Tersinkronisasi ke Aplikasi Kasir POS Toko</span>
                        </div>
                    </div>
                </div>

                <!-- BENTO 2: EDITOR DESKRIPSI & SPESIFIKASI (MARKDOWN PREVIEW & RAW) -->
                <div x-data="{ tab: 'preview' }" class="rounded-[32px] bg-[#141414] p-6 sm:p-8 border border-white/10 shadow-2xl flex flex-col gap-4">
                    <div class="flex items-center justify-between flex-wrap gap-3 pb-3 border-b border-white/10">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[#8FBF5B] text-[24px]">subject</span>
                            <div>
                                <h2 class="font-urbanist text-xl sm:text-2xl font-bold text-white tracking-tight">Deskripsi & Spesifikasi Produk</h2>
                                <span class="text-xs text-white/50">Dokumentasi teknis inventaris dalam format Markdown</span>
                            </div>
                        </div>

                        <!-- Markdown Tab Switcher -->
                        <div class="flex items-center p-1 rounded-full bg-black/40 border border-white/15">
                            <button type="button" @click="tab = 'preview'"
                                :class="tab === 'preview' ? 'bg-[#8FBF5B] text-black font-bold shadow-md' : 'text-white/70 hover:text-white'"
                                class="px-4 py-1.5 rounded-full text-xs font-semibold transition-all">
                                Rendered Preview
                            </button>
                            <button type="button" @click="tab = 'raw'"
                                :class="tab === 'raw' ? 'bg-[#8FBF5B] text-black font-bold shadow-md' : 'text-white/70 hover:text-white'"
                                class="px-4 py-1.5 rounded-full text-xs font-semibold transition-all">
                                Markdown Raw
                            </button>
                        </div>
                    </div>

                    <!-- Rendered Preview Tab Content -->
                    <div x-show="tab === 'preview'" class="flex flex-col gap-4">
                        <div class="p-5 rounded-2xl bg-[#1C1C1C] border border-white/5 leading-relaxed text-sm text-white/90">
                            @if(!empty($stock->description))
                                <div class="prose prose-invert max-w-none text-white/90 prose-headings:font-urbanist prose-headings:text-white prose-a:text-[#8FBF5B] prose-strong:text-white prose-code:text-[#8FBF5B]">
                                    {!! \Illuminate\Support\Str::markdown($stock->description) !!}
                                </div>
                            @else
                                <div class="py-4 text-center text-white/50 italic">
                                    Belum ada deskripsi untuk stok barang ini. Beralih ke tab <strong>"Markdown Raw"</strong> atau klik tombol <strong>"Edit Stok"</strong> untuk melengkapi spesifikasi.
                                </div>
                            @endif
                        </div>

                        <!-- Structured Specifications Sub-Bento Cards (Stitch Screen 2) -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 pt-2">
                            <!-- Card 1: Karakteristik Produk -->
                            <div class="p-4 rounded-2xl bg-[#232323] border border-white/5 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-2 text-[#8FBF5B] mb-2.5">
                                        <span class="material-symbols-outlined text-[18px]">grain</span>
                                        <span class="text-xs font-bold text-white uppercase tracking-wider">Karakteristik Produk</span>
                                    </div>
                                    <div class="space-y-2 text-xs text-white/70">
                                        <div class="flex justify-between">
                                            <span>Kategori:</span>
                                            <span class="text-white font-semibold">{{ $stock->category ?: 'Umum' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Satuan Unit:</span>
                                            <span class="text-white font-semibold">{{ $stock->unit }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Tahap Alur:</span>
                                            <span class="text-[#8FBF5B] font-semibold uppercase">{{ $stock->order_stage ?: 'Ready' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2: Identifikasi & Sertifikasi -->
                            <div class="p-4 rounded-2xl bg-[#232323] border border-white/5 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-2 text-[#8FBF5B] mb-2.5">
                                        <span class="material-symbols-outlined text-[18px]">verified_user</span>
                                        <span class="text-xs font-bold text-white uppercase tracking-wider">Identifikasi Sistem</span>
                                    </div>
                                    <div class="space-y-2 text-xs text-white/70">
                                        <div class="flex justify-between">
                                            <span>Nomor SKU:</span>
                                            <span class="text-white font-mono font-semibold">{{ $stock->sku ?: '-' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>ID Barang:</span>
                                            <span class="text-white font-mono">#{{ $stock->id }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Status:</span>
                                            <span class="text-[#8FBF5B] font-semibold">{{ $stEnum?->label() ?? ucfirst($stock->status) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 3: Instruksi Pergudangan -->
                            <div class="p-4 rounded-2xl bg-[#232323] border border-white/5 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center gap-2 text-[#8FBF5B] mb-2.5">
                                        <span class="material-symbols-outlined text-[18px]">shelves</span>
                                        <span class="text-xs font-bold text-white uppercase tracking-wider">Instruksi Gudang</span>
                                    </div>
                                    <div class="space-y-2 text-xs text-white/70">
                                        <div class="flex justify-between">
                                            <span>Nomor Rak:</span>
                                            <span class="text-white font-semibold">{{ $stock->rack_location ?: '-' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Rotasi Batch:</span>
                                            <span class="text-[#8FBF5B] font-semibold">FIFO Ketat</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Batas Aman:</span>
                                            <span class="text-white font-semibold">{{ $stock->min_stock }} {{ $stock->unit }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Markdown Raw Editor Tab Content -->
                    <div x-show="tab === 'raw'" x-cloak class="flex flex-col gap-3">
                        <textarea wire:model.defer="description" rows="10"
                            placeholder="Tulis deskripsi atau spesifikasi barang menggunakan Markdown format..."
                            class="w-full bg-[#1C1C1C] border border-white/15 rounded-2xl p-4 text-xs sm:text-sm font-mono text-white placeholder-white/30 focus:outline-none focus:border-[#8FBF5B] transition-colors resize-y leading-relaxed"></textarea>

                        <div class="flex items-center justify-between flex-wrap gap-2 pt-1">
                            <span class="text-xs text-white/50 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-[#8FBF5B]"></span>
                                <span>Mendukung sintaks Markdown (heading, list, table, bold, link)</span>
                            </span>
                            <button type="button" wire:click="saveDescription"
                                class="btn-interactive inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] text-[#0A0A0A] text-xs font-bold shadow-lg shadow-[#8FBF5B]/20 transition-all">
                                <span class="material-symbols-outlined text-[18px]">save</span>
                                <span>Simpan Perubahan Deskripsi</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- BENTO 3: RIWAYAT MUTASI STOK TERBARU (STITCH SCREEN 2) -->
                <div class="rounded-[32px] bg-[#141414] p-6 sm:p-8 border border-white/10 shadow-2xl flex flex-col gap-4">
                    <div class="flex items-center justify-between pb-3 border-b border-white/10">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[#8FBF5B] text-[24px]">history</span>
                            <div>
                                <h2 class="font-urbanist text-xl sm:text-2xl font-bold text-white tracking-tight">Riwayat Mutasi Stok Terbaru</h2>
                                <span class="text-xs text-white/50">3 pergerakan inventaris paling akhir</span>
                            </div>
                        </div>
                        <a href="{{ route('stocks.index') }}" class="inline-flex items-center gap-1 text-xs font-semibold text-[#8FBF5B] hover:underline">
                            <span>Katalog Utama</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>

                    <div class="space-y-3">
                        <!-- Movement 1: Batch Pemutakhiran Terkini -->
                        <div class="p-4 rounded-2xl bg-[#232323] border border-white/5 flex items-center justify-between gap-4 flex-wrap hover:bg-white/5 transition-colors">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-full bg-[#8FBF5B]/20 text-[#8FBF5B] flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">update</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-white">Pembaruan Fisik Terakhir</span>
                                        <span class="px-2.5 py-0.5 rounded-full bg-white/10 text-white/70 text-[10px] font-mono">SYS-SYNC</span>
                                    </div>
                                    <span class="text-xs text-white/60">
                                        Status: {{ $stEnum?->label() ?? ucfirst($stock->status) }} • Diperbarui {{ $stock->updated_at ? $stock->updated_at->format('d M Y, H:i') : '-' }} WIB
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 ml-auto text-right">
                                <div>
                                    <span class="font-urbanist text-lg font-bold text-[#8FBF5B]">{{ $stock->quantity }} {{ $stock->unit }}</span>
                                    <span class="block text-[10px] text-white/50">Saldo Fisik Aktif</span>
                                </div>
                            </div>
                        </div>

                        <!-- Movement 2: Registrasi / Pendaftaran Stok Awal -->
                        <div class="p-4 rounded-2xl bg-[#232323] border border-white/5 flex items-center justify-between gap-4 flex-wrap hover:bg-white/5 transition-colors">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">inventory</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-white">Pendaftaran Master Inventaris</span>
                                        <span class="px-2.5 py-0.5 rounded-full bg-white/10 text-white/70 text-[10px] font-mono">{{ $stock->sku ?: 'SKU-NEW' }}</span>
                                    </div>
                                    <span class="text-xs text-white/60">
                                        Didaftarkan ke sistem pada {{ $stock->created_at ? $stock->created_at->format('d M Y, H:i') : '-' }} WIB
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 ml-auto text-right">
                                <div>
                                    <span class="font-urbanist text-sm font-semibold text-white/80">ID #{{ $stock->id }}</span>
                                    <span class="block text-[10px] text-white/50">Terdata di Database</span>
                                </div>
                            </div>
                        </div>

                        <!-- Movement 3: Status Rekonsiliasi & Ambang Minimum -->
                        <div class="p-4 rounded-2xl bg-[#232323] border border-white/5 flex items-center justify-between gap-4 flex-wrap hover:bg-white/5 transition-colors">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">health_and_safety</span>
                                </div>
                                <div class="flex flex-col">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-white">Ambang Batas Pengamanan Stok</span>
                                        <span class="px-2.5 py-0.5 rounded-full bg-white/10 text-white/70 text-[10px] font-mono">SAFETY-LEVEL</span>
                                    </div>
                                    <span class="text-xs text-white/60">
                                        Batas restock: {{ $stock->min_stock }} {{ $stock->unit }} • Rasio: {{ $bufferRatio }}%
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 ml-auto text-right">
                                <div>
                                    <span class="font-urbanist text-sm font-bold {{ $bufferRatio >= 100 ? 'text-[#8FBF5B]' : 'text-amber-400' }}">
                                        {{ $bufferRatio >= 100 ? 'Aman' : 'Perhatian' }}
                                    </span>
                                    <span class="block text-[10px] text-white/50">Tingkat Risiko</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN (4 Kolom / ±35%) -->
            <div class="lg:col-span-4 flex flex-col gap-6">

                <!-- BENTO KANAN 1: HERO METRIC KUANTITAS FISIK AKTIF -->
                <div class="rounded-[32px] bg-[#141414] p-6 sm:p-7 border border-white/10 shadow-2xl flex flex-col relative overflow-hidden">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-white/60">Kuantitas Fisik Aktif</span>
                        <span class="w-2.5 h-2.5 rounded-full bg-[#8FBF5B] animate-pulse"></span>
                    </div>

                    <!-- Giant Stock Counter -->
                    <div class="flex items-baseline gap-2 my-2">
                        <span class="font-urbanist text-5xl sm:text-6xl font-extrabold tracking-tight text-white leading-none">
                            {{ $stock->quantity }}
                        </span>
                        <span class="font-urbanist text-2xl font-bold text-[#8FBF5B]">
                            {{ $stock->unit }}
                        </span>
                        <span class="text-[11px] text-white/50 ml-auto">
                            @ {{ $stock->unit }} Terdata
                        </span>
                    </div>

                    <!-- Stepper Controller Buttons (+1 / -1) -->
                    <div class="flex items-center gap-2.5 mt-3 mb-5">
                        <button type="button" wire:click="adjustQuantity(-1)"
                            class="w-12 h-12 rounded-2xl bg-[#232323] hover:bg-[#2d2d2d] active:scale-95 text-white flex items-center justify-center transition-all shadow-md"
                            title="Kurang 1 {{ $stock->unit }}">
                            <span class="material-symbols-outlined text-[24px]">remove</span>
                        </button>
                        <div class="flex-1 py-2 px-3 rounded-2xl bg-[#1C1C1C] text-center border border-white/5">
                            <span class="text-[10px] text-white/50 uppercase block">Penyesuaian Cepat</span>
                            <span class="text-xs font-bold text-white">± 1 {{ $stock->unit }}</span>
                        </div>
                        <button type="button" wire:click="adjustQuantity(1)"
                            class="w-12 h-12 rounded-2xl bg-[#232323] hover:bg-[#2d2d2d] active:scale-95 text-white flex items-center justify-center transition-all shadow-md"
                            title="Tambah 1 {{ $stock->unit }}">
                            <span class="material-symbols-outlined text-[24px]">add</span>
                        </button>
                    </div>

                    <!-- Commercial Metas Box -->
                    <div class="p-4 rounded-2xl bg-[#1C1C1C] border border-white/5 flex flex-col gap-3 mb-5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-white/60">Harga Jual Pokok</span>
                            <span class="font-bold text-white font-mono">
                                {{ $stock->price !== null ? 'Rp ' . number_format($stock->price, 0, ',', '.') : '-' }}
                                <span class="text-white/40 font-normal">/ {{ $stock->unit }}</span>
                            </span>
                        </div>
                        <div class="w-full h-px bg-white/10"></div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-white/60">Estimasi Total Nilai</span>
                            <span class="font-bold text-[#8FBF5B] font-mono text-sm">
                                Rp {{ number_format($totalAssetValue, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="w-full h-px bg-white/10"></div>
                        <div class="flex items-center justify-between text-xs">
                            <div class="flex items-center gap-1.5 text-white/60">
                                <span class="material-symbols-outlined text-[15px] text-amber-400">warning</span>
                                <span>Batas Minimum Stok</span>
                            </div>
                            <span class="font-bold text-white bg-white/10 px-2.5 py-0.5 rounded-full font-mono">
                                {{ $stock->min_stock }} {{ $stock->unit }}
                            </span>
                        </div>
                    </div>

                    <!-- Primary Full-Width Action Button -->
                    <button type="button" wire:click="openEditModal"
                        class="btn-interactive w-full py-3.5 px-6 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] active:scale-95 text-[#0A0A0A] font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-[#8FBF5B]/25 transition-all">
                        <span class="material-symbols-outlined text-[20px] font-bold">tune</span>
                        <span>Ubah Data Master Stok</span>
                    </button>
                </div>

                <!-- BENTO KANAN 2: STATUS OTOMATIS SISTEM & SUPPLIER -->
                <div class="rounded-[32px] bg-[#141414] p-6 sm:p-7 border border-white/10 shadow-2xl flex flex-col gap-4">
                    <div class="flex items-center justify-between pb-2 border-b border-white/10">
                        <span class="font-urbanist text-lg font-bold text-white">Status Otomatis Sistem</span>
                        <span class="material-symbols-outlined text-[#8FBF5B] text-[22px]">smart_toy</span>
                    </div>

                    <!-- Buffer Rate & Health Visual Indicator -->
                    <div class="p-4 rounded-2xl bg-[#1C1C1C] border border-white/5 flex flex-col gap-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-[10px] text-white/50 uppercase tracking-wider block">Rasio Buffer Gudang</span>
                                <div class="flex items-baseline gap-2 mt-0.5">
                                    <span class="font-urbanist text-3xl font-extrabold text-[#8FBF5B]">
                                        {{ $bufferRatio }}%
                                    </span>
                                    <span class="text-xs font-semibold {{ $bufferRatio >= 100 ? 'text-[#8FBF5B]' : 'text-amber-400' }}">
                                        ({{ $bufferRatio >= 100 ? 'Sangat Aman' : ($bufferRatio >= 50 ? 'Waspada' : 'Kritis') }})
                                    </span>
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-[#8FBF5B]/15 flex items-center justify-center text-[#8FBF5B]">
                                <span class="material-symbols-outlined text-[22px]">health_and_safety</span>
                            </div>
                        </div>

                        <!-- Progress Bar Indicator -->
                        <div class="w-full bg-white/10 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-[#8FBF5B] h-2.5 rounded-full transition-all duration-500"
                                style="width: {{ min(100, max(5, $bufferRatio)) }}%;"></div>
                        </div>

                        <div class="flex items-center justify-between text-white/60 text-[11px] pt-1">
                            <span>Estimasi persediaan:</span>
                            <span class="text-white font-semibold">Cukup ~{{ $estimatedDays }} Hari Kerja</span>
                        </div>
                    </div>

                    <!-- Supplier Information Tile -->
                    <div class="p-4 rounded-2xl bg-[#1C1C1C] border border-white/5 flex flex-col gap-2">
                        <span class="text-[10px] text-white/50 uppercase tracking-wider">Mitra Pemasok Utama</span>
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-[#8FBF5B] shrink-0">
                                <span class="material-symbols-outlined text-[20px]">corporate_fare</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-white">{{ $stock->supplier ?: 'PB Sri Makmur' }}</span>
                                <span class="text-[11px] text-white/60">Lead Time: 1 - 2 Hari Kerja</span>
                                <span class="text-[10px] text-[#8FBF5B] font-semibold uppercase mt-0.5">
                                    Tahap Alur: {{ $stock->order_stage ?: 'Ready' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone Action -->
                    <div class="pt-1">
                        <button type="button" wire:click="confirmDeleteStock"
                            class="btn-interactive w-full py-3 px-4 rounded-full bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/25 text-rose-300 hover:text-rose-200 text-xs font-semibold flex items-center justify-center gap-2 transition-all">
                            <span class="material-symbols-outlined text-[18px]">delete_outline</span>
                            <span>Hapus Barang dari Katalog</span>
                        </button>
                    </div>
                </div>

                <!-- BENTO KANAN 3: LOKASI FISIK GUDANG & DENAH RAK (LIME CARD) -->
                <div class="rounded-[32px] bg-[#8FBF5B] p-6 sm:p-7 shadow-2xl text-[#11230B] flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-bold uppercase tracking-wider">Lokasi Fisik Gudang</span>
                            <span class="material-symbols-outlined text-[20px]">warehouse</span>
                        </div>

                        <div class="flex items-baseline gap-2 mb-3">
                            <span class="font-urbanist text-3xl sm:text-4xl font-extrabold text-[#0D1D09]">
                                {{ $stock->rack_location ?: 'RAK-A1' }}
                            </span>
                            <span class="text-xs font-bold uppercase opacity-80">Bin #04</span>
                        </div>

                        <!-- Visual Rack Grid Representation -->
                        <div class="grid grid-cols-3 gap-1.5 p-2 bg-[#11230B]/15 rounded-xl mb-3">
                            <div class="h-6 rounded bg-[#11230B]/20 flex items-center justify-center text-[9px] font-bold">A-01</div>
                            <div class="h-6 rounded bg-[#11230B] text-white flex items-center justify-center text-[9px] font-bold shadow-sm">
                                {{ $stock->rack_location ? substr($stock->rack_location, 0, 4) : 'A-02' }}
                            </div>
                            <div class="h-6 rounded bg-[#11230B]/20 flex items-center justify-center text-[9px] font-bold">A-03</div>
                            <div class="h-6 rounded bg-[#11230B]/20 flex items-center justify-center text-[9px] font-bold">B-01</div>
                            <div class="h-6 rounded bg-[#11230B]/20 flex items-center justify-center text-[9px] font-bold">B-02</div>
                            <div class="h-6 rounded bg-[#11230B]/20 flex items-center justify-center text-[9px] font-bold">B-03</div>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-[#11230B]/20 text-[11px] font-medium flex items-center justify-between">
                        <span>Aksesibilitas Rak Terbuka</span>
                        <span class="font-bold">Siap Ambil (Pick & Pack)</span>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- MODAL EDIT STOK (STITCH SCREEN 4 - DARK BENTO) -->
    @if ($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md overflow-y-auto"
            x-data @keydown.escape.window="$wire.closeEditModal()">
            <div class="relative w-full max-w-2xl bg-[#141414] rounded-[32px] border border-white/15 p-6 sm:p-8 shadow-2xl text-white my-8">
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-[#8FBF5B] text-black flex items-center justify-center">
                            <span class="material-symbols-outlined text-[22px] font-bold">edit</span>
                        </div>
                        <div>
                            <h3 class="font-urbanist text-2xl font-bold text-white tracking-tight">Ubah Data Stok Barang</h3>
                            <p class="text-xs text-white/50">Perbarui rincian inventaris, harga, dan spesifikasi gudang</p>
                        </div>
                    </div>
                    <button type="button" wire:click="closeEditModal" class="w-9 h-9 rounded-full bg-white/5 hover:bg-white/15 text-white/60 hover:text-white flex items-center justify-center transition-colors">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <form wire:submit.prevent="saveStock" class="mt-6 flex flex-col gap-4">
                    <!-- Nama Barang -->
                    <div>
                        <label class="block text-xs font-semibold text-white/80 uppercase tracking-wider mb-1.5">
                            Nama Barang <span class="text-rose-400">*</span>
                        </label>
                        <input type="text" wire:model.defer="name"
                            class="w-full h-11 px-4 bg-[#232323] border border-white/15 rounded-2xl text-sm text-white placeholder-white/30 focus:outline-none focus:border-[#8FBF5B]" />
                        @error('name') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Baris 2: SKU & Kategori -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-white/80 uppercase tracking-wider mb-1.5">
                                Kode SKU
                            </label>
                            <input type="text" wire:model.defer="sku"
                                class="w-full h-11 px-4 bg-[#232323] border border-white/15 rounded-2xl text-sm font-mono text-white placeholder-white/30 focus:outline-none focus:border-[#8FBF5B]" />
                            @error('sku') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-white/80 uppercase tracking-wider mb-1.5">
                                Kategori
                            </label>
                            <input type="text" wire:model.defer="category" list="editCategoryOptions"
                                class="w-full h-11 px-4 bg-[#232323] border border-white/15 rounded-2xl text-sm text-white placeholder-white/30 focus:outline-none focus:border-[#8FBF5B]" />
                            <datalist id="editCategoryOptions">
                                <option value="Sembako"></option>
                                <option value="Minuman"></option>
                                <option value="Bumbu"></option>
                                <option value="Alat Tulis"></option>
                                <option value="Snack"></option>
                            </datalist>
                            @error('category') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Baris 3: Supplier & Lokasi Rak -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-white/80 uppercase tracking-wider mb-1.5">
                                Pemasok / Supplier
                            </label>
                            <input type="text" wire:model.defer="supplier"
                                class="w-full h-11 px-4 bg-[#232323] border border-white/15 rounded-2xl text-sm text-white placeholder-white/30 focus:outline-none focus:border-[#8FBF5B]" />
                            @error('supplier') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-white/80 uppercase tracking-wider mb-1.5">
                                Lokasi Rak Gudang
                            </label>
                            <input type="text" wire:model.defer="rack_location" placeholder="misal: RAK-A1"
                                class="w-full h-11 px-4 bg-[#232323] border border-white/15 rounded-2xl text-sm text-white placeholder-white/30 focus:outline-none focus:border-[#8FBF5B]" />
                            @error('rack_location') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Baris 4: Jumlah, Batas Min, Satuan -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-white/80 uppercase tracking-wider mb-1.5">
                                Jumlah Stok <span class="text-rose-400">*</span>
                            </label>
                            <input type="number" min="0" wire:model.defer="quantity"
                                class="w-full h-11 px-4 bg-[#232323] border border-white/15 rounded-2xl text-sm text-white focus:outline-none focus:border-[#8FBF5B]" />
                            @error('quantity') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-white/80 uppercase tracking-wider mb-1.5">
                                Batas Minimum <span class="text-rose-400">*</span>
                            </label>
                            <input type="number" min="0" wire:model.defer="min_stock"
                                class="w-full h-11 px-4 bg-[#232323] border border-white/15 rounded-2xl text-sm text-white focus:outline-none focus:border-[#8FBF5B]" />
                            @error('min_stock') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-white/80 uppercase tracking-wider mb-1.5">
                                Satuan <span class="text-rose-400">*</span>
                            </label>
                            <input type="text" wire:model.defer="unit"
                                class="w-full h-11 px-4 bg-[#232323] border border-white/15 rounded-2xl text-sm text-white focus:outline-none focus:border-[#8FBF5B]" />
                            @error('unit') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Baris 5: Harga & Tahap Alur -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-white/80 uppercase tracking-wider mb-1.5">
                                Harga Pokok (Rp)
                            </label>
                            <input type="number" min="0" step="100" wire:model.defer="price"
                                class="w-full h-11 px-4 bg-[#232323] border border-white/15 rounded-2xl text-sm text-white focus:outline-none focus:border-[#8FBF5B]" />
                            @error('price') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-white/80 uppercase tracking-wider mb-1.5">
                                Tahap Restock
                            </label>
                            <select wire:model.defer="order_stage"
                                class="w-full h-11 px-4 bg-[#232323] border border-white/15 rounded-2xl text-sm text-white focus:outline-none focus:border-[#8FBF5B]">
                                <option value="ordered">Pesan Agen</option>
                                <option value="verified">Verifikasi Fisik</option>
                                <option value="stored">Masuk Gudang</option>
                                <option value="ready">Siap Jual</option>
                            </select>
                        </div>
                    </div>

                    <!-- Deskripsi Markdown -->
                    <div>
                        <label class="block text-xs font-semibold text-white/80 uppercase tracking-wider mb-1.5">
                            Deskripsi & Spesifikasi (Markdown)
                        </label>
                        <textarea wire:model.defer="description" rows="4"
                            class="w-full p-4 bg-[#232323] border border-white/15 rounded-2xl text-sm font-mono text-white placeholder-white/30 focus:outline-none focus:border-[#8FBF5B] resize-y"></textarea>
                    </div>

                    <!-- Tombol Aksi Modal -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10 mt-2">
                        <button type="button" wire:click="closeEditModal"
                            class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs sm:text-sm font-semibold transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="btn-interactive px-6 py-2.5 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] text-[#0A0A0A] text-xs sm:text-sm font-bold shadow-lg shadow-[#8FBF5B]/25 transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- MODAL CETAK BARCODE (SCREEN 2) -->
    @if ($showBarcodeModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
            x-data @keydown.escape.window="$wire.toggleBarcodeModal()">
            <div class="relative w-full max-w-md bg-[#141414] rounded-[32px] border border-white/15 p-6 sm:p-8 shadow-2xl text-white">
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#8FBF5B] text-[24px]">qr_code_scanner</span>
                        <h3 class="font-urbanist text-xl font-bold text-white">Label Barcode Produk</h3>
                    </div>
                    <button type="button" wire:click="toggleBarcodeModal" class="w-8 h-8 rounded-full bg-white/5 hover:bg-white/15 text-white/60 hover:text-white flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>

                <!-- Printable Label Card Container -->
                <div id="printableBarcodeArea" class="bg-white text-black p-6 rounded-2xl mt-6 text-center shadow-lg border border-slate-300">
                    <h4 class="font-urbanist text-lg font-black leading-tight">{{ $stock->name }}</h4>
                    <p class="text-[11px] text-slate-600 mt-0.5">Kategori: {{ $stock->category ?: 'Umum' }} • Rak: {{ $stock->rack_location ?: '-' }}</p>

                    <!-- SVG Barcode Simulation (Code128) -->
                    <div class="my-4 flex items-center justify-center px-4">
                        <svg class="w-full h-16" viewBox="0 0 200 60" preserveAspectRatio="none">
                            <rect width="200" height="60" fill="#ffffff"/>
                            <rect x="10" y="5" width="3" height="40" fill="#000000"/>
                            <rect x="15" y="5" width="2" height="40" fill="#000000"/>
                            <rect x="20" y="5" width="5" height="40" fill="#000000"/>
                            <rect x="28" y="5" width="2" height="40" fill="#000000"/>
                            <rect x="33" y="5" width="4" height="40" fill="#000000"/>
                            <rect x="40" y="5" width="2" height="40" fill="#000000"/>
                            <rect x="45" y="5" width="6" height="40" fill="#000000"/>
                            <rect x="54" y="5" width="3" height="40" fill="#000000"/>
                            <rect x="60" y="5" width="2" height="40" fill="#000000"/>
                            <rect x="65" y="5" width="5" height="40" fill="#000000"/>
                            <rect x="73" y="5" width="3" height="40" fill="#000000"/>
                            <rect x="79" y="5" width="2" height="40" fill="#000000"/>
                            <rect x="84" y="5" width="4" height="40" fill="#000000"/>
                            <rect x="91" y="5" width="3" height="40" fill="#000000"/>
                            <rect x="97" y="5" width="2" height="40" fill="#000000"/>
                            <rect x="102" y="5" width="5" height="40" fill="#000000"/>
                            <rect x="110" y="5" width="3" height="40" fill="#000000"/>
                            <rect x="116" y="5" width="2" height="40" fill="#000000"/>
                            <rect x="121" y="5" width="4" height="40" fill="#000000"/>
                            <rect x="128" y="5" width="6" height="40" fill="#000000"/>
                            <rect x="137" y="5" width="2" height="40" fill="#000000"/>
                            <rect x="142" y="5" width="3" height="40" fill="#000000"/>
                            <rect x="148" y="5" width="5" height="40" fill="#000000"/>
                            <rect x="156" y="5" width="2" height="40" fill="#000000"/>
                            <rect x="161" y="5" width="4" height="40" fill="#000000"/>
                            <rect x="168" y="5" width="2" height="40" fill="#000000"/>
                            <rect x="173" y="5" width="5" height="40" fill="#000000"/>
                            <rect x="181" y="5" width="3" height="40" fill="#000000"/>
                            <rect x="187" y="5" width="3" height="40" fill="#000000"/>
                        </svg>
                    </div>

                    <div class="font-mono text-sm font-black tracking-widest">{{ $stock->sku ?: 'SKU-' . str_pad($stock->id, 6, '0', STR_PAD_LEFT) }}</div>
                    <div class="font-urbanist text-base font-extrabold text-emerald-800 mt-1">
                        {{ $stock->price ? 'Rp ' . number_format($stock->price, 0, ',', '.') : 'Harga Belum Ditentukan' }}
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <button type="button" wire:click="toggleBarcodeModal" class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-semibold">
                        Tutup
                    </button>
                    <button type="button" onclick="window.print()" class="btn-interactive px-5 py-2.5 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] text-[#0A0A0A] text-xs font-bold flex items-center gap-2 shadow-lg shadow-[#8FBF5B]/20">
                        <span class="material-symbols-outlined text-[18px]">print</span>
                        <span>Cetak Label Sekarang</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL KONFIRMASI HAPUS STOK -->
    @if ($confirmingStockDeletion)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
            x-data @keydown.escape.window="$wire.cancelDeleteStock()">
            <div class="relative w-full max-w-md bg-[#141414] rounded-[32px] border border-white/15 p-6 sm:p-8 shadow-2xl text-white">
                <div class="w-12 h-12 rounded-full bg-rose-500/20 text-rose-400 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[28px]">warning</span>
                </div>
                <h3 class="font-urbanist text-xl font-bold text-white">Hapus Barang dari Katalog?</h3>
                <p class="text-xs text-white/60 mt-2 leading-relaxed">
                    Tindakan ini bersifat permanen. Data stok <strong>{{ $stock->name }}</strong> beserta seluruh riwayatnya akan dihapus dari sistem.
                </p>
                <div class="flex items-center justify-end gap-3 mt-6">
                    <button type="button" wire:click="cancelDeleteStock" class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-semibold">
                        Batal
                    </button>
                    <button type="button" wire:click="deleteStock" class="btn-interactive px-5 py-2.5 rounded-full bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-lg shadow-rose-600/30">
                        Ya, Hapus Sekarang
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL KONFIRMASI HAPUS COVER PHOTO -->
    @if ($confirmingCoverDeletion)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
            x-data @keydown.escape.window="$wire.cancelDeleteCover()">
            <div class="relative w-full max-w-md bg-[#141414] rounded-[32px] border border-white/15 p-6 sm:p-8 shadow-2xl text-white">
                <div class="w-12 h-12 rounded-full bg-rose-500/20 text-rose-400 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[28px]">delete</span>
                </div>
                <h3 class="font-urbanist text-xl font-bold text-white">Hapus Cover Gambar?</h3>
                <p class="text-xs text-white/60 mt-2 leading-relaxed">
                    Gambar cover produk ini akan dihapus dari penyimpanan server dan diganti dengan placeholder default.
                </p>
                <div class="flex items-center justify-end gap-3 mt-6">
                    <button type="button" wire:click="cancelDeleteCover" class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-semibold">
                        Batal
                    </button>
                    <button type="button" wire:click="deleteCoverPhoto" class="btn-interactive px-5 py-2.5 rounded-full bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-lg shadow-rose-600/30">
                        Ya, Hapus Gambar
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
