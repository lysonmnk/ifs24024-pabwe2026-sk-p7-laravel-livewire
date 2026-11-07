<div>
    <!-- Toast UI Editor CDN Styles & Scripts -->
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
    <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>

    <!-- Top Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Stok Barang Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola data inventaris dan kuantitas stok barang secara akurat</p>
        </div>

        <div class="relative" x-data="{ open: false, loading: null }" @click.outside="open = false" @keydown.escape.window="open = false">
            <button type="button" @click="open = !open" :disabled="!!loading"
                class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200 bg-white text-slate-600 hover:bg-slate-50 hover:text-slate-900 shadow-sm transition disabled:opacity-60"
                title="Menu aksi">
                <svg x-show="!loading" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                </svg>
                <svg x-show="loading" x-cloak class="animate-spin w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </button>

            <div x-show="open" x-cloak
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 z-30 mt-2 w-56 origin-top-right rounded-xl border border-slate-200 bg-white py-1.5 shadow-xl shadow-slate-200/70">
                <div class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">Aksi Cepat</div>

                <button type="button" :disabled="!!loading"
                    @click="
                        loading = 'create'; open = false;
                        $wire.openCreateModal().finally(() => loading = null);
                    "
                    class="flex w-full items-center gap-2.5 px-3 py-2.5 text-sm font-semibold text-blue-700 hover:bg-blue-50 transition disabled:opacity-60">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-100 text-blue-600">
                        <svg x-show="loading !== 'create'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        <svg x-show="loading === 'create'" x-cloak class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                    </span>
                    Tambah Stok
                </button>

                <button type="button" :disabled="!!loading"
                    @click="
                        loading = 'ai'; open = false;
                        $wire.openAiModal().finally(() => loading = null);
                    "
                    class="flex w-full items-center gap-2.5 px-3 py-2.5 text-sm font-semibold text-purple-700 hover:bg-purple-50 transition disabled:opacity-60">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                        <svg x-show="loading !== 'ai'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        <svg x-show="loading === 'ai'" x-cloak class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                    </span>
                    Generate dengan AI
                </button>

                <div class="my-1.5 border-t border-slate-100"></div>
                <div class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-600">Spreadsheet</div>

                <button type="button" :disabled="!!loading"
                    @click="
                        loading = 'import'; open = false;
                        $wire.openImportModal().finally(() => loading = null);
                    "
                    class="flex w-full items-center gap-2.5 px-3 py-2.5 text-sm font-semibold text-emerald-700 hover:bg-emerald-50 transition disabled:opacity-60">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                        <svg x-show="loading !== 'import'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                        <svg x-show="loading === 'import'" x-cloak class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                    </span>
                    Import Excel
                </button>

                <button type="button" :disabled="!!loading"
                    @click="
                        loading = 'export'; open = false;
                        $wire.exportExcel().finally(() => loading = null);
                    "
                    class="flex w-full items-center gap-2.5 px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition disabled:opacity-60">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                        <svg x-show="loading !== 'export'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        <svg x-show="loading === 'export'" x-cloak class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                    </span>
                    <span x-text="loading === 'export' ? 'Mengekspor...' : 'Export Excel'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Filter & Search Controls -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
        <div class="w-full sm:w-72 relative">
            <input id="search-input" aria-label="Cari nama, SKU, atau deskripsi stok" wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama, SKU, deskripsi..."
                class="w-full pl-3.5 pr-9 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <div wire:loading wire:target="search,statusFilter" class="absolute right-3 top-2.5">
                <svg class="animate-spin h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
            </div>
        </div>

        <div class="w-full sm:w-auto flex items-center space-x-3">
            <label for="statusFilter" class="text-xs font-semibold text-slate-500 uppercase">Status:</label>
            <select wire:model.live="statusFilter" id="statusFilter" class="text-sm rounded-lg border border-slate-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                @foreach ($statuses as $st)
                    <option value="{{ $st->value }}">{{ $st->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Stocks Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 sm:px-6">Nama Barang / SKU</th>
                        <th class="py-3.5 px-4">Kuantitas</th>
                        <th class="py-3.5 px-4">Harga</th>
                        <th class="py-3.5 px-4">Min. Stok</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right sm:pr-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse ($stocks as $item)
                        @php
                            $statusEnum = $item->status instanceof \App\Features\Stock\Enums\StockStatus ? $item->status : \App\Features\Stock\Enums\StockStatus::tryFrom($item->status);
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-4 px-4 sm:px-6">
                                <a href="{{ route('stocks.show', $item) }}" class="font-semibold text-slate-900 hover:text-blue-600 transition block">
                                    {{ $item->name }}
                                </a>
                                <span class="text-xs text-slate-600 font-mono">{{ $item->sku ?: 'No SKU' }}</span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="inline-flex items-center space-x-1.5 bg-slate-50 border border-slate-200 rounded-lg p-1">
                                    <button wire:click="adjustQuantity({{ $item->id }}, -1)" class="w-6 h-6 flex items-center justify-center rounded bg-white hover:bg-slate-200 text-slate-700 font-bold shadow-xs transition" title="Kurangi 1">−</button>
                                    <span class="px-2 font-bold text-slate-800">{{ $item->quantity }} <span class="text-xs font-normal text-slate-500">{{ $item->unit }}</span></span>
                                    <button wire:click="adjustQuantity({{ $item->id }}, 1)" class="w-6 h-6 flex items-center justify-center rounded bg-white hover:bg-slate-200 text-slate-700 font-bold shadow-xs transition" title="Tambah 1">+</button>
                                </div>
                            </td>
                            <td class="py-4 px-4 font-mono text-slate-700">
                                {{ $item->price !== null ? 'Rp ' . number_format($item->price, 0, ',', '.') : '-' }}
                            </td>
                            <td class="py-4 px-4 text-slate-600">
                                {{ $item->min_stock }} {{ $item->unit }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $statusEnum?->badgeClass() ?? 'bg-slate-100 text-slate-700' }}">
                                    {{ $statusEnum?->label() ?? ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right sm:pr-6 space-x-2">
                                <a href="{{ route('stocks.show', $item) }}" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-slate-100 inline-block" title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <button wire:click="openEditModal({{ $item->id }})" class="p-1.5 text-slate-500 hover:text-amber-600 rounded-lg hover:bg-slate-100 inline-block" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button wire:click="confirmDelete({{ $item->id }})" class="p-1.5 text-slate-500 hover:text-rose-600 rounded-lg hover:bg-slate-100 inline-block" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-600">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                </div>
                                <p class="font-semibold text-slate-700">Belum ada data stok barang</p>
                                <p class="text-xs text-slate-600 mt-0.5">Klik tombol Tambah Stok atau Generate AI untuk memulai.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($stocks->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $stocks->links() }}
            </div>
        @endif
    </div>

    <!-- Create / Edit Stock Modal -->
    @if ($showFormModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 overflow-y-auto">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-xl p-6 my-8" @click.outside="$wire.closeFormModal()">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                    <h2 class="text-lg font-bold text-slate-900">{{ $editingStockId ? 'Edit Stok Barang' : 'Tambah Stok Barang Baru' }}</h2>
                    <button type="button" wire:click="closeFormModal" aria-label="Tutup modal form" class="text-slate-500 hover:text-slate-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveStock" class="space-y-4">
                    <div>
                        <label for="formName" class="block text-xs font-semibold text-slate-700 mb-1">Nama Barang <span class="text-rose-500">*</span></label>
                        <input id="formName" wire:model="formName" type="text" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. Kertas HVS A4 80gsm">
                        @error('formName') <span class="text-xs text-rose-600 mt-0.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="formSku" class="block text-xs font-semibold text-slate-700 mb-1">SKU</label>
                            <input id="formSku" wire:model="formSku" type="text" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. STK-001">
                            @error('formSku') <span class="text-xs text-rose-600 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="formUnit" class="block text-xs font-semibold text-slate-700 mb-1">Satuan <span class="text-rose-500">*</span></label>
                            <input id="formUnit" wire:model="formUnit" type="text" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="e.g. pcs, rim, box">
                            @error('formUnit') <span class="text-xs text-rose-600 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label for="formQuantity" class="block text-xs font-semibold text-slate-700 mb-1">Kuantitas <span class="text-rose-500">*</span></label>
                            <input id="formQuantity" wire:model="formQuantity" type="number" min="0" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('formQuantity') <span class="text-xs text-rose-600 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="formMinStock" class="block text-xs font-semibold text-slate-700 mb-1">Min. Stok <span class="text-rose-500">*</span></label>
                            <input id="formMinStock" wire:model="formMinStock" type="number" min="0" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('formMinStock') <span class="text-xs text-rose-600 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="formPrice" class="block text-xs font-semibold text-slate-700 mb-1">Harga (Rp)</label>
                            <input id="formPrice" wire:model="formPrice" type="number" step="0.01" min="0" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0">
                            @error('formPrice') <span class="text-xs text-rose-600 mt-0.5 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="formStatus" class="block text-xs font-semibold text-slate-700 mb-1">Status Stok <span class="text-rose-500">*</span></label>
                        <select id="formStatus" wire:model="formStatus" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="available">Available (Tersedia)</option>
                            <option value="low_stock">Low Stock (Menipis)</option>
                            <option value="out_of_stock">Out of Stock (Habis)</option>
                        </select>
                        @error('formStatus') <span class="text-xs text-rose-600 mt-0.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="formDescription" class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi / Spesifikasi (Markdown)</label>
                        <textarea id="formDescription" wire:model="formDescription" rows="4" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Deskripsi spesifikasi produk (mendukung format Markdown)..."></textarea>
                        @error('formDescription') <span class="text-xs text-rose-600 mt-0.5 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="closeFormModal" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition">Simpan Stok</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if ($confirmingStockDeletionId)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md p-6">
                <h2 class="text-lg font-bold text-slate-900 mb-2">Hapus Stok Barang?</h2>
                <p class="text-sm text-slate-500 mb-6">Tindakan ini tidak dapat dibatalkan. Data stok dan cover gambarnya akan dihapus permanen.</p>
                <div class="flex items-center justify-end space-x-3">
                    <button type="button" wire:click="cancelDelete" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg transition">Batal</button>
                    <button type="button" wire:click="deleteStock" class="px-4 py-2 text-sm font-semibold text-white bg-rose-700 hover:bg-rose-800 rounded-lg shadow-sm transition">Hapus Permanen</button>
                </div>
            </div>
        </div>
    @endif

    <!-- Import Excel Modal -->
    @if ($showImportModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md p-6" @click.outside="closeImportModal">
                <h2 class="text-lg font-bold text-slate-900 mb-2">Import Stok dari File Excel</h2>
                <p class="text-xs text-slate-500 mb-4">Pilih file spreadsheet (.xlsx, .xls, .csv). Baris pertama akan diabaikan sebagai header kolom.</p>
                <form wire:submit.prevent="importExcel" class="space-y-4">
                    <input type="file" id="importFile" aria-label="Pilih file spreadsheet untuk import" wire:model="importFile" accept=".xlsx,.xls,.csv" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    @error('importFile') <span class="text-xs text-rose-600 block">{{ $message }}</span> @enderror
                    <div class="flex items-center justify-end space-x-3 pt-3">
                        <button type="button" wire:click="closeImportModal" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Batal</button>
                        <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm">Mulai Import</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- AI Generator Modal -->
    @if ($showAiModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 overflow-y-auto">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-2xl p-6 my-8">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <div class="flex items-center space-x-2">
                        <span class="p-1.5 rounded-lg bg-purple-100 text-purple-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </span>
                        <h2 class="text-lg font-bold text-slate-900">AI Stock Generator</h2>
                    </div>
                    <button type="button" wire:click="closeAiModal" aria-label="Tutup modal AI" class="text-slate-500 hover:text-slate-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4 mb-4">
                    <div>
                        <label for="aiPrompt" class="block text-xs font-semibold text-slate-700 mb-1">Deskripsikan Kebutuhan Inventaris Anda</label>
                        <input id="aiPrompt" wire:model="aiPrompt" type="text" placeholder="e.g. 5 perlengkapan kantor untuk percetakan buku" class="w-full px-3 py-2 text-sm rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        @error('aiPrompt') <span class="text-xs text-rose-600 block mt-0.5">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <label for="aiCount" class="text-xs font-semibold text-slate-700">Jumlah Item:</label>
                            <input id="aiCount" wire:model="aiCount" type="number" min="1" max="10" class="w-16 px-2 py-1 text-sm rounded border border-slate-300 text-center">
                        </div>
                        <button type="button" wire:click="generateWithAi" wire:loading.attr="disabled" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold rounded-lg shadow-sm transition disabled:opacity-60 flex items-center space-x-1.5">
                            <span wire:loading.remove wire:target="generateWithAi">Generate Item</span>
                            <span wire:loading wire:target="generateWithAi">Memproses AI...</span>
                        </button>
                    </div>

                    @if ($aiErrorMessage)
                        <div class="p-3 rounded-lg bg-rose-50 border border-rose-200 text-xs text-rose-700">
                            {{ $aiErrorMessage }}
                        </div>
                    @endif

                    @if (!empty($aiGeneratedItems))
                        <div class="mt-4">
                            <div class="text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Pratinjau Hasil AI (Centang untuk simpan):</div>
                            <div class="max-h-60 overflow-y-auto border border-slate-200 rounded-xl divide-y divide-slate-100">
                                @foreach ($aiGeneratedItems as $idx => $gItem)
                                    <label class="p-3 flex items-start space-x-3 hover:bg-slate-50 cursor-pointer">
                                        <input type="checkbox" wire:model="aiSelectedIndices" value="{{ $idx }}" class="mt-1 rounded text-purple-600 border-slate-300">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-semibold text-sm text-slate-800">{{ $gItem['name'] }}</span>
                                                <span class="text-xs font-mono text-slate-500">{{ $gItem['sku'] ?? 'Auto SKU' }}</span>
                                            </div>
                                            <p class="text-xs text-slate-500 mt-0.5">{{ $gItem['quantity'] }} {{ $gItem['unit'] }} &bull; Rp {{ number_format($gItem['price'] ?? 0, 0, ',', '.') }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex items-center justify-end space-x-3 pt-3 border-t border-slate-100">
                    <button type="button" wire:click="closeAiModal" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-lg">Tutup</button>
                    @if (!empty($aiGeneratedItems))
                        <button type="button" wire:click="saveAiGenerated" class="px-4 py-2 text-sm font-semibold text-white bg-purple-600 hover:bg-purple-700 rounded-lg shadow-sm">Simpan Pilihan ke Stok</button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
