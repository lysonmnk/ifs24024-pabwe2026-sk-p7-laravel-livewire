<div>
    <!-- Toast UI Editor CDN Styles & Scripts -->
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
    <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>

    <!-- Top Navigation Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div class="flex items-center space-x-3">
            <a href="{{ route('stocks.index') }}" class="p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-200 transition" title="Kembali ke Daftar Stok">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <div class="flex items-center space-x-2.5">
                    <h1 class="text-2xl font-bold text-slate-900 truncate max-w-md sm:max-w-xl">{{ $stock->name }}</h1>
                    @php
                        $stEnum = $stock->status instanceof \App\Features\Stock\Enums\StockStatus ? $stock->status : \App\Features\Stock\Enums\StockStatus::tryFrom($stock->status);
                    @endphp
                    <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full border {{ $stEnum?->badgeClass() ?? 'bg-slate-100 text-slate-700' }}">
                        {{ $stEnum?->label() ?? ucfirst($stock->status) }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-0.5">SKU: <span class="font-mono font-semibold">{{ $stock->sku ?: 'No SKU' }}</span> &bull; Dibuat pada {{ $stock->created_at ? $stock->created_at->format('d M Y H:i') : '-' }}</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <!-- Edit Button -->
            <button wire:click="openEditModal" wire:loading.attr="disabled" class="inline-flex items-center space-x-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 disabled:opacity-75 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Edit Stok</span>
            </button>

            <!-- Delete Button -->
            <button wire:click="confirmDeleteStock" wire:loading.attr="disabled" class="inline-flex items-center space-x-1 px-3 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-200 text-xs font-semibold rounded-lg transition disabled:opacity-75">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                <span>Hapus</span>
            </button>
        </div>
    </div>

    <!-- Cover Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-8">
        <input type="file" wire:model="coverPhoto" id="coverPhotoInput" accept="image/*" class="hidden">

        @if ($stock->cover_image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($stock->cover_image_path))
            <div class="relative group h-64 sm:h-80 w-full bg-slate-900 overflow-hidden">
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($stock->cover_image_path) }}?v={{ time() }}" alt="Cover Stok" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center space-x-3">
                    <button type="button" onclick="document.getElementById('coverPhotoInput').click()" class="px-4 py-2 bg-white text-slate-800 text-xs font-semibold rounded-xl shadow-lg hover:bg-slate-50 transition flex items-center space-x-1.5">
                        <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Ganti Cover</span>
                    </button>
                    <button type="button" wire:click="confirmDeleteCover" class="px-4 py-2 bg-rose-600 text-white text-xs font-semibold rounded-xl shadow-lg hover:bg-rose-700 transition flex items-center space-x-1.5">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>Hapus Cover</span>
                    </button>
                </div>
            </div>
        @else
            <div class="p-8 text-center bg-gradient-to-b from-slate-50 to-white flex flex-col items-center justify-center border-b border-slate-100">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 mb-3 shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-800">Tambahkan Cover Gambar untuk Stok Ini</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-sm">Unggah gambar produk untuk mempermudah identifikasi barang di gudang.</p>
                <button type="button" onclick="document.getElementById('coverPhotoInput').click()" class="mt-4 px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded-xl shadow-sm hover:bg-blue-700 transition flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Unggah Gambar</span>
                </button>
            </div>
        @endif
    </div>

    <!-- Stock Metrics & Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Quantity Adjuster Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2">Jumlah Stok Saat Ini</span>
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-3xl font-extrabold text-slate-900">{{ $stock->quantity }}</span>
                    <span class="text-sm text-slate-500 ml-1">{{ $stock->unit }}</span>
                </div>
                <div class="inline-flex items-center space-x-2 bg-slate-100 p-1.5 rounded-xl border border-slate-200">
                    <button wire:click="adjustQuantity(-1)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white hover:bg-slate-200 text-slate-800 font-bold shadow-xs transition" title="Kurang 1">−</button>
                    <button wire:click="adjustQuantity(1)" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white hover:bg-slate-200 text-slate-800 font-bold shadow-xs transition" title="Tambah 1">+</button>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Ambang Min. Stok:</span>
                <span class="font-semibold text-slate-700">{{ $stock->min_stock }} {{ $stock->unit }}</span>
            </div>
        </div>

        <!-- Price Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2">Harga Satuan</span>
            <div class="text-2xl font-bold font-mono text-slate-900">
                {{ $stock->price !== null ? 'Rp ' . number_format($stock->price, 0, ',', '.') : '-' }}
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Total Estimasi Aset:</span>
                <span class="font-semibold text-slate-700 font-mono">
                    {{ $stock->price !== null ? 'Rp ' . number_format($stock->price * $stock->quantity, 0, ',', '.') : '-' }}
                </span>
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2">Kondisi Ketersediaan</span>
            <div class="mt-1">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold border {{ $stEnum?->badgeClass() ?? 'bg-slate-100 text-slate-700' }}">
                    {{ $stEnum?->label() ?? ucfirst($stock->status) }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-4 pt-3 border-t border-slate-100">
                @if ($stock->quantity <= 0)
                    Perhatian: Stok habis! Segera lakukan pengadaan barang baru.
                @elseif ($stock->quantity <= $stock->min_stock)
                    Peringatan: Kuantitas berada di bawah ambang batas minimum.
                @else
                    Status stok aman dan siap didistribusikan.
                @endif
            </p>
        </div>
    </div>

    <!-- Markdown Description / Toast UI Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
        <h2 class="text-base font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100">Deskripsi & Spesifikasi Produk</h2>
        @if (!empty($stock->description))
            <div class="prose prose-slate max-w-none text-sm text-slate-700 leading-relaxed" id="markdownViewer">
                {!! \Illuminate\Support\Str::markdown($stock->description) !!}
            </div>
        @else
            <p class="text-sm text-slate-400 italic">Belum ada deskripsi untuk stok barang ini. Klik "Edit Stok" untuk menambahkan spesifikasi dalam format Markdown.</p>
        @endif
    </div>

    <!-- Edit Modal -->
    @if ($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 overflow-y-auto">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-xl p-6 my-8">
                <h3 class="text-lg font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100">Edit Data Stok Barang</h3>
                <form wire:submit.prevent="saveStock" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Barang</label>
                        <input wire:model="name" type="text" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name') <span class="text-xs text-rose-600 block mt-0.5">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">SKU</label>
                            <input wire:model="sku" type="text" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('sku') <span class="text-xs text-rose-600 block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Satuan</label>
                            <input wire:model="unit" type="text" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('unit') <span class="text-xs text-rose-600 block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Kuantitas</label>
                            <input wire:model="quantity" type="number" min="0" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('quantity') <span class="text-xs text-rose-600 block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Min. Stok</label>
                            <input wire:model="min_stock" type="number" min="0" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('min_stock') <span class="text-xs text-rose-600 block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Harga (Rp)</label>
                            <input wire:model="price" type="number" step="0.01" min="0" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('price') <span class="text-xs text-rose-600 block mt-0.5">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Status</label>
                        <select wire:model="status" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="available">Available (Tersedia)</option>
                            <option value="low_stock">Low Stock (Menipis)</option>
                            <option value="out_of_stock">Out of Stock (Habis)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Spesifikasi (Markdown)</label>
                        <textarea wire:model="description" rows="5" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-100">
                        <button type="button" wire:click="closeEditModal" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if ($confirmingStockDeletion)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-2">Hapus Stok Ini?</h3>
                <p class="text-sm text-slate-500 mb-6">Tindakan ini permanen. Semua data stok dan file cover akan dihapus dari server.</p>
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" wire:click="cancelDeleteStock" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                    <button type="button" wire:click="deleteStock" class="px-4 py-2 text-sm font-semibold text-white bg-rose-600 hover:bg-rose-700 rounded-lg shadow-sm">Hapus Permanen</button>
                </div>
            </div>
        </div>
    @endif
</div>
