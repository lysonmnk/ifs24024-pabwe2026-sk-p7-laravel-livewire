<div class="bento-dashboard-bg bento-grain-overlay min-h-screen -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 text-white relative font-manrope selection:bg-[#8FBF5B] selection:text-[#141414]">
    <div class="relative z-10 max-w-[1560px] mx-auto flex flex-col gap-6 md:gap-7 pb-12">

        <!-- Top System Stamp & Header Bar -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E2725B]"></span>
                <span class="text-xs font-semibold tracking-wider text-white/80 uppercase font-mono">D 09/90</span>
            </div>
            <div class="flex items-center gap-2 text-xs text-white/70 bg-black/30 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/10">
                <span class="w-2 h-2 rounded-full bg-[#8FBF5B] animate-pulse"></span>
                <span>Kasir Terminal #01 Aktif • Shift Pagi ({{ auth()->user()->name }})</span>
            </div>
        </div>

        <!-- B. Hero Section: Huge White Title + Stats Row -->
        <div class="flex flex-col xl:flex-row items-start xl:items-end justify-between gap-6 pt-2">
            <!-- Giant Title + Progress Donut -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                <div>
                    <h1 class="font-urbanist font-medium text-4xl sm:text-5xl lg:text-[56px] text-white leading-tight tracking-tight">
                        Kasir POS<br/>
                        <span class="opacity-95 font-semibold text-[#8FBF5B]">Transaksi Toko</span>
                    </h1>
                </div>
                <!-- Donut Progress Badge -->
                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-full border border-white/10 self-start sm:self-center">
                    <div class="relative w-11 h-11 flex items-center justify-center shrink-0">
                        <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                            <path class="text-white/20" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="4"></path>
                            <path class="text-[#8FBF5B]" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-dasharray="74, 100" stroke-linecap="round" stroke-width="4"></path>
                        </svg>
                        <span class="absolute font-urbanist text-[11px] font-bold text-white">74%</span>
                    </div>
                    <div class="flex flex-col pr-1">
                        <span class="text-[10px] uppercase tracking-wider text-white/70 font-semibold">Target Shift</span>
                        <span class="text-xs font-semibold text-white">Tercapai</span>
                    </div>
                </div>
            </div>

            <!-- 3 Giant Stat Readouts -->
            <div class="flex flex-wrap items-end gap-7 sm:gap-10 xl:gap-12">
                <!-- Stat 1: Total Omset -->
                <div class="flex flex-col">
                    <span class="text-xs text-white/75 font-medium mb-0.5">Total Omset Hari Ini</span>
                    <div class="flex items-start">
                        <span class="font-urbanist text-4xl sm:text-5xl lg:text-[52px] font-medium text-white leading-none tracking-tight">
                            {{ number_format(4850000 + (isset($completedTransaction) ? $completedTransaction['total'] : 0), 0, ',', '.') }}
                        </span>
                        <span class="text-xs sm:text-sm font-semibold text-[#8FBF5B] ml-1.5 -mt-1 font-urbanist">Rp</span>
                    </div>
                </div>
                <!-- Stat 2: Transaksi Selesai -->
                <div class="flex flex-col">
                    <span class="text-xs text-white/75 font-medium mb-0.5">Transaksi Selesai</span>
                    <div class="flex items-start">
                        <span class="font-urbanist text-4xl sm:text-5xl lg:text-[52px] font-medium text-white leading-none tracking-tight">
                            {{ 42 + (isset($completedTransaction) ? 1 : 0) }}
                        </span>
                        <span class="text-xs sm:text-sm font-semibold text-white/80 ml-1.5 -mt-1 font-urbanist">Nota</span>
                    </div>
                </div>
                <!-- Stat 3: Item Terjual -->
                <div class="flex flex-col">
                    <span class="text-xs text-white/75 font-medium mb-0.5">Item Terjual</span>
                    <div class="flex items-start">
                        <span class="font-urbanist text-4xl sm:text-5xl lg:text-[52px] font-medium text-white leading-none tracking-tight">186</span>
                        <span class="text-xs sm:text-sm font-semibold text-white/80 ml-1.5 -mt-1 font-urbanist">Pcs</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- C. Category Filters & Scanner Bar -->
        <div class="flex flex-wrap items-center justify-between gap-3.5 pt-1">
            <!-- Category Pills -->
            <div class="flex items-center gap-2 overflow-x-auto py-1 scrollbar-none max-w-full">
                <button type="button"
                    wire:click="setCategory('')"
                    class="px-5 py-2 rounded-full text-xs font-semibold shadow-sm shrink-0 transition-all {{ $categoryFilter === '' ? 'bg-[#141414] text-white border border-white/20' : 'border border-white/20 bg-white/5 hover:bg-white/10 text-white/80' }}">
                    Semua
                </button>
                @foreach($categories as $cat)
                    <button type="button"
                        wire:click="setCategory('{{ $cat }}')"
                        class="px-5 py-2 rounded-full text-xs font-medium transition-all shrink-0 {{ $categoryFilter === $cat ? 'bg-[#141414] text-white border border-[#8FBF5B]' : 'border border-white/20 bg-white/5 hover:bg-white/10 text-white/80' }}">
                        {{ $cat }}
                    </button>
                @endforeach
            </div>

            <!-- Search Bar + Scanner Input -->
            <div class="flex items-center gap-2.5 flex-1 max-w-lg ml-auto">
                <div class="flex items-center gap-2.5 flex-1 bg-white/10 backdrop-blur-md px-4 py-2 rounded-full border border-white/15 focus-within:border-[#8FBF5B] focus-within:bg-[#141414] transition-all">
                    <span class="material-symbols-outlined text-[19px] text-[#8FBF5B]">barcode_scanner</span>
                    <input 
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        id="barcode-input"
                        placeholder="Scan barcode [EAN-13] atau cari nama produk..."
                        class="w-full bg-transparent border-none text-xs text-white placeholder-white/50 focus:outline-none focus:ring-0 p-0" />
                    <div class="hidden sm:flex items-center gap-1 text-[10px] text-white/60 font-medium">
                        <span class="px-1.5 py-0.5 rounded border border-white/20 font-mono">F2</span>
                    </div>
                </div>
                <a href="{{ route('stocks.index') }}" class="px-4 py-2 rounded-full bg-[#8FBF5B] hover:brightness-105 active:scale-95 text-[#141414] text-xs font-bold transition flex items-center gap-1.5 shrink-0 shadow-sm">
                    <span class="material-symbols-outlined text-[17px]">add_circle</span>
                    <span>+ Item Gudang</span>
                </a>
            </div>
        </div>

        <!-- D. Main Bento Grid (Left ~68% Dark Bento, Right ~32% Cream Floating Bento Cards) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- LEFT COLUMN (~68%): Single Matte Dark Bento Card (#141414) -->
            <div class="lg:col-span-8 bg-[#141414] rounded-[32px] p-6 sm:p-7 md:p-8 flex flex-col gap-6 shadow-xl border border-white/10">
                <!-- Header in Card: Active Customer with Stacked Avatars & Action Icons -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-[#232323] text-white flex items-center justify-center border border-white/10">
                            <span class="material-symbols-outlined text-[22px] text-[#8FBF5B]">storefront</span>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="font-urbanist font-semibold text-lg text-white">{{ $customerName }}</h2>
                                <span class="px-2 py-0.5 rounded-full bg-[#8FBF5B]/20 text-[10px] text-[#8FBF5B] font-bold uppercase tracking-wider border border-[#8FBF5B]/30">
                                    {{ $customerType }}
                                </span>
                            </div>
                            <p class="text-xs text-[#9A9A92]">ID: {{ $customerId }} • Plafon Kredit Tersedia: Rp 2.500.000</p>
                        </div>
                    </div>

                    <!-- Stacked Avatars + Circular Action Icons -->
                    <div class="flex items-center gap-3">
                        <div class="flex items-center -space-x-2">
                            <span class="w-7 h-7 rounded-full bg-[#8FBF5B] text-[#141414] font-bold text-[10px] flex items-center justify-center border-2 border-[#141414]">ST</span>
                            <span class="w-7 h-7 rounded-full bg-[#c3d2af] text-[#141414] font-bold text-[10px] flex items-center justify-center border-2 border-[#141414]">MR</span>
                            <span class="w-7 h-7 rounded-full bg-[#232323] text-white/70 font-semibold text-[10px] flex items-center justify-center border-2 border-[#141414]">+2</span>
                        </div>
                        <button aria-label="Pin atau Edit" class="w-8 h-8 rounded-full bg-[#232323] hover:bg-white/15 text-white/80 flex items-center justify-center transition" type="button" title="Pelanggan Terpilih">
                            <span class="material-symbols-outlined text-[16px]">push_pin</span>
                        </button>
                        <button aria-label="Expand Pelanggan" class="w-8 h-8 rounded-full bg-[#232323] hover:bg-white/15 text-white/80 flex items-center justify-center transition" type="button" title="Audit ID">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                        </button>
                    </div>
                </div>

                <!-- Thin Connector Line with 3 Lime Checked Dots -->
                <div class="relative py-1">
                    <div class="absolute top-1/2 left-0 right-0 h-[1px] bg-white/10 -translate-y-1/2"></div>
                    <div class="relative flex justify-between px-10">
                        <span class="w-4 h-4 rounded-full bg-[#8FBF5B] text-[#141414] flex items-center justify-center text-[10px] font-bold ring-4 ring-[#141414]">✓</span>
                        <span class="w-4 h-4 rounded-full bg-[#8FBF5B] text-[#141414] flex items-center justify-center text-[10px] font-bold ring-4 ring-[#141414]">✓</span>
                        <span class="w-4 h-4 rounded-full bg-[#8FBF5B] text-[#141414] flex items-center justify-center text-[10px] font-bold ring-4 ring-[#141414]">✓</span>
                    </div>
                </div>

                <!-- 3 Inner Side-by-Side Panels inside the Dark Bento -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Panel 1: Mini Payment Method Selector -->
                    <div class="bg-[#232323] p-4 rounded-2xl flex flex-col justify-between border border-white/5">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs text-[#9A9A92] font-semibold uppercase tracking-wider">Metode Bayar</span>
                            <span class="material-symbols-outlined text-[16px] text-[#8FBF5B]">payments</span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <button type="button" wire:click="setPaymentMethod('cash')"
                                class="flex items-center justify-between p-2 rounded-xl transition-all {{ $paymentMethod === 'cash' ? 'bg-white/10 border border-[#8FBF5B] text-white' : 'bg-transparent text-[#9A9A92] hover:text-white' }}">
                                <span class="text-xs font-semibold">Tunai (Cash)</span>
                                @if($paymentMethod === 'cash')
                                    <span class="w-4 h-4 rounded-full bg-[#8FBF5B] text-[#141414] flex items-center justify-center text-[10px] font-bold">✓</span>
                                @endif
                            </button>
                            <button type="button" wire:click="setPaymentMethod('qris')"
                                class="flex items-center justify-between p-2 rounded-xl transition-all {{ $paymentMethod === 'qris' ? 'bg-white/10 border border-[#8FBF5B] text-white' : 'bg-transparent text-[#9A9A92] hover:text-white' }}">
                                <span class="text-xs font-semibold">QRIS Dinamis</span>
                                @if($paymentMethod === 'qris')
                                    <span class="w-4 h-4 rounded-full bg-[#8FBF5B] text-[#141414] flex items-center justify-center text-[10px] font-bold">✓</span>
                                @else
                                    <span class="text-[10px] border border-white/20 px-1.5 py-0.5 rounded text-white/60">Scan</span>
                                @endif
                            </button>
                            <button type="button" wire:click="setPaymentMethod('bon')"
                                class="flex items-center justify-between p-2 rounded-xl transition-all {{ $paymentMethod === 'bon' ? 'bg-white/10 border border-[#8FBF5B] text-white' : 'bg-transparent text-[#9A9A92] hover:text-white' }}">
                                <span class="text-xs font-semibold">Catat Bon Toko</span>
                                @if($paymentMethod === 'bon')
                                    <span class="w-4 h-4 rounded-full bg-[#8FBF5B] text-[#141414] flex items-center justify-center text-[10px] font-bold">✓</span>
                                @else
                                    <span class="text-[10px] text-[#8FBF5B]">Plafon OK</span>
                                @endif
                            </button>
                        </div>
                    </div>

                    <!-- Panel 2: Nominal / Diskon Member -->
                    <div class="bg-[#232323] p-4 rounded-2xl flex flex-col justify-between border border-white/5">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs text-[#9A9A92] font-semibold uppercase tracking-wider">Voucher & Diskon</span>
                            <span class="material-symbols-outlined text-[16px] text-[#8FBF5B]">loyalty</span>
                        </div>
                        <div>
                            <span class="text-[11px] text-[#9A9A92]">Potongan Aktif:</span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="font-urbanist font-medium text-2xl text-white">{{ number_format($discount, 0, ',', '.') }}</span>
                                <span class="text-xs text-white/70 font-semibold font-urbanist">Rp</span>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center gap-1.5 bg-[#141414] px-3 py-1.5 rounded-full border border-white/10">
                            <input 
                                type="text"
                                wire:model.defer="voucherCode"
                                placeholder="Kode voucher..."
                                class="w-full bg-transparent text-[11px] text-[#8FBF5B] font-semibold uppercase focus:outline-none p-0 border-none" />
                            <button 
                                type="button" 
                                wire:click="applyVoucher"
                                class="text-[10px] bg-[#8FBF5B] hover:brightness-110 text-[#141414] px-2.5 py-1 rounded-full font-bold transition">
                                Pakai
                            </button>
                        </div>
                    </div>

                    <!-- Panel 3: Lime Panel (#8FBF5B) with Shift Sales Bar Chart -->
                    <div class="bg-[#8FBF5B] text-[#141414] p-4 rounded-2xl flex flex-col justify-between shadow-md">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider">Shift Performance</span>
                            <span class="text-[11px] font-semibold">78,890 <span class="font-bold">k</span></span>
                        </div>
                        <!-- Minimalist Bar Chart -->
                        <div class="flex items-end justify-between gap-2.5 h-16 pt-3 px-1">
                            <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                <span class="text-[9px] font-semibold">39k</span>
                                <div class="w-full bg-[#141414]/30 rounded-t-lg h-9"></div>
                                <span class="text-[9px] font-medium">09:00</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                <span class="text-[9px] font-semibold">45k</span>
                                <div class="w-full bg-[#141414] rounded-t-lg h-14"></div>
                                <span class="text-[9px] font-bold">12:00</span>
                            </div>
                            <div class="flex-1 flex flex-col items-center gap-1 h-full justify-end">
                                <span class="text-[9px] font-semibold">78k</span>
                                <div class="w-full bg-[#141414] rounded-t-lg h-16"></div>
                                <span class="text-[9px] font-bold">Kini</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-[#141414]/15 mt-2">
                            <span class="text-[10px] font-semibold">Laju Penjualan Kasir</span>
                            <span class="text-[10px] font-bold">Tinggi ↑</span>
                        </div>
                    </div>
                </div>

                <!-- Bottom Stat Row inside the Dark Card (4 Big Summary Numbers + Giant Lime Checkmark Button) -->
                <div class="flex flex-wrap items-center justify-between gap-6 pt-2 border-t border-white/5">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 flex-1">
                        <!-- 1. Subtotal -->
                        <div>
                            <span class="text-xs text-[#9A9A92]">Subtotal Nota</span>
                            <div class="flex items-start mt-0.5">
                                <span class="font-urbanist font-medium text-2xl lg:text-3xl text-white">
                                    {{ number_format($subtotal, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] font-semibold text-white/70 ml-1 font-urbanist">Rp</span>
                            </div>
                        </div>
                        <!-- 2. Diskon -->
                        <div>
                            <span class="text-xs text-[#9A9A92]">Diskon Toko</span>
                            <div class="flex items-start mt-0.5">
                                <span class="font-urbanist font-medium text-2xl lg:text-3xl text-[#8FBF5B]">
                                    -{{ number_format($discount, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] font-semibold text-[#8FBF5B] ml-1 font-urbanist">Rp</span>
                            </div>
                        </div>
                        <!-- 3. Pajak/Admin -->
                        <div>
                            <span class="text-xs text-[#9A9A92]">Pajak / PPN</span>
                            <div class="flex items-start mt-0.5">
                                <span class="font-urbanist font-medium text-2xl lg:text-3xl text-white">0</span>
                                <span class="text-[10px] font-semibold text-white/70 ml-1 font-urbanist">Rp (0%)</span>
                            </div>
                        </div>
                        <!-- 4. Total Qty -->
                        <div>
                            <span class="text-xs text-[#9A9A92]">Jumlah Barang</span>
                            <div class="flex items-start mt-0.5">
                                <span class="font-urbanist font-medium text-2xl lg:text-3xl text-white">
                                    {{ str_pad((string)$totalQty, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <span class="text-[10px] font-semibold text-white/70 ml-1 font-urbanist">Item</span>
                            </div>
                        </div>
                    </div>

                    <!-- Giant Lime Circular Checkmark Button -->
                    <button 
                        type="button"
                        wire:click="checkout"
                        aria-label="Validasi Transaksi" 
                        title="Proses Transaksi Kasir"
                        class="w-14 h-14 rounded-full bg-[#8FBF5B] hover:brightness-105 active:scale-95 text-[#141414] flex items-center justify-center shadow-lg transition shrink-0 cursor-pointer disabled:opacity-50"
                        @if(empty($cart)) disabled @endif>
                        <span class="material-symbols-outlined text-[28px] font-bold">check</span>
                    </button>
                </div>
            </div>

            <!-- RIGHT COLUMN (~32%): Floating Cream Cards (#F7F4EA) -->
            <div class="lg:col-span-4 flex flex-col gap-4">
                
                <!-- CARD 1: Receipt / Nota Penjualan Aktif -->
                <div class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-6 shadow-xl flex flex-col justify-between border border-[#161616]/10">
                    <div class="flex items-start justify-between pb-3 border-b border-[#161616]/10">
                        <div>
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[19px] text-[#161616]">receipt_long</span>
                                <h3 class="font-urbanist font-bold text-lg text-[#161616]">Struk Nota Kasir</h3>
                            </div>
                            <span class="text-[11px] text-[#6F6F66]">#TRX-AKTIF • {{ now()->format('H:i') }} WIB</span>
                        </div>
                        <!-- Clear Cart Button -->
                        @if(!empty($cart))
                            <button 
                                type="button"
                                wire:click="clearCart"
                                aria-label="Kosongkan Keranjang" 
                                class="w-8 h-8 rounded-full border border-[#161616]/20 bg-white/50 flex items-center justify-center hover:bg-rose-100 text-rose-700 transition"
                                title="Kosongkan Keranjang">
                                <span class="material-symbols-outlined text-[15px]">delete_sweep</span>
                            </button>
                        @endif
                    </div>

                    <!-- Receipt Item List -->
                    <div class="flex flex-col gap-3 py-4 divide-y divide-[#161616]/5 max-h-72 overflow-y-auto">
                        @forelse($cart as $item)
                            <div class="flex items-center justify-between pt-2">
                                <div class="flex flex-col max-w-[170px]">
                                    <span class="text-xs font-bold text-[#161616] leading-tight truncate">{{ $item['name'] }}</span>
                                    <div class="flex items-center gap-1.5 mt-0.5">
                                        <button type="button" wire:click="decrementQty({{ $item['id'] }})" class="w-4 h-4 rounded bg-[#161616]/10 text-xs font-bold flex items-center justify-center hover:bg-[#161616]/20">-</button>
                                        <span class="text-[11px] font-semibold text-[#161616]">{{ $item['quantity'] }} {{ $item['unit'] }}</span>
                                        <button type="button" wire:click="incrementQty({{ $item['id'] }})" class="w-4 h-4 rounded bg-[#161616]/10 text-xs font-bold flex items-center justify-center hover:bg-[#161616]/20">+</button>
                                        <span class="text-[10px] text-[#6F6F66]">× {{ number_format($item['price'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="font-urbanist font-semibold text-sm text-[#161616]">
                                        {{ number_format($item['subtotal'], 0, ',', '.') }}
                                    </span>
                                    <button type="button" wire:click="removeFromCart({{ $item['id'] }})" class="text-[#E2725B] hover:opacity-80 text-xs ml-1 font-bold" title="Hapus Item">
                                        ✕
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-[#6F6F66]">
                                <span class="material-symbols-outlined text-3xl mb-1 text-[#161616]/30">shopping_cart</span>
                                <p class="text-xs font-semibold text-[#161616]/70">Keranjang masih kosong</p>
                                <p class="text-[11px] text-[#6F6F66] mt-0.5">Klik "+ Keranjang" pada item katalog di bawah</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Giant Total Tagihan Display -->
                    <div class="pt-3 border-t border-[#161616]/10 flex flex-col">
                        <span class="text-[11px] uppercase tracking-wider text-[#6F6F66] font-semibold">Total Tagihan Bersih</span>
                        <div class="flex items-start justify-between mt-1">
                            <div class="flex items-start">
                                <span class="font-urbanist font-medium text-4xl sm:text-[44px] text-[#161616] leading-none tracking-tight">
                                    {{ number_format($total, 0, ',', '.') }}
                                </span>
                                <span class="text-xs font-semibold text-[#6F6F66] ml-1 font-urbanist">Rp</span>
                            </div>
                            <!-- Checkmark Pill Indicator -->
                            <div class="flex items-center gap-1 bg-[#161616]/5 px-2.5 py-1 rounded-full">
                                <span class="w-4 h-4 rounded-full bg-[#8FBF5B] text-[#141414] flex items-center justify-center text-[10px] font-bold">✓</span>
                                <span class="text-[10px] font-bold text-[#161616] font-mono">READY</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Quick Cash & Payment Action Card -->
                <div class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-6 shadow-xl flex flex-col gap-4 border border-[#161616]/10">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#6F6F66]">Tender Pembayaran</span>
                        <span class="text-xs font-semibold {{ $change > 0 ? 'text-[#8FBF5B] font-bold' : 'text-[#6F6F66]' }}">
                            Kembalian: Rp {{ number_format($change, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Quick Cash Suggestion Chips -->
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button"
                            wire:click="quickCash({{ $total > 0 ? (int)(ceil($total / 50000) * 50000) : 50000 }})"
                            class="py-2 px-1 rounded-full border border-[#161616]/20 bg-white/60 hover:bg-white text-xs font-semibold text-[#161616] transition text-center truncate">
                            Rp {{ number_format($total > 0 ? (int)(ceil($total / 50000) * 50000) : 50000, 0, ',', '.') }}
                        </button>
                        <button type="button"
                            wire:click="quickCash({{ $total > 0 ? (int)(ceil($total / 100000) * 100000) : 100000 }})"
                            class="py-2 px-1 rounded-full border border-[#161616]/20 bg-white/60 hover:bg-white text-xs font-semibold text-[#161616] transition text-center truncate">
                            Rp {{ number_format($total > 0 ? (int)(ceil($total / 100000) * 100000) : 100000, 0, ',', '.') }}
                        </button>
                        <button type="button"
                            wire:click="payExact"
                            class="py-2 px-1 rounded-full bg-[#161616] text-white text-xs font-bold transition text-center shadow-sm">
                            Uang Pas
                        </button>
                    </div>

                    <!-- Input Nominal Tunai -->
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 font-urbanist font-bold text-xs text-[#6F6F66]">Rp</span>
                        <input 
                            type="number"
                            wire:model.live="cashTendered"
                            placeholder="Nominal uang tunai..."
                            class="w-full pl-9 pr-4 py-2.5 rounded-full border border-[#161616]/20 bg-white/80 font-urbanist font-bold text-sm text-[#161616] focus:outline-none focus:ring-2 focus:ring-[#8FBF5B]" />
                    </div>

                    <!-- Big Lime Pay Button -->
                    <button 
                        type="button"
                        wire:click="checkout"
                        class="w-full py-3.5 px-5 rounded-full bg-[#8FBF5B] hover:brightness-105 active:scale-[0.98] text-[#141414] font-urbanist font-bold text-base flex items-center justify-center gap-2 transition shadow-md cursor-pointer disabled:opacity-50"
                        @if(empty($cart)) disabled @endif>
                        <span class="material-symbols-outlined text-[20px]">print</span>
                        <span>Proses Bayar & Cetak Struk (Enter)</span>
                    </button>

                    <!-- Secondary Actions (Tahan & Kosongkan) -->
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button"
                            wire:click="$dispatch('notify-hold')"
                            class="py-2 px-3 rounded-full border border-[#161616]/20 bg-white/40 hover:bg-white/70 text-xs font-semibold text-[#161616] flex items-center justify-center gap-1.5 transition">
                            <span class="material-symbols-outlined text-[15px]">pause_circle</span>
                            <span>Tahan Nota</span>
                        </button>
                        <button type="button"
                            wire:click="clearCart"
                            class="py-2 px-3 rounded-full border border-[#E2725B]/30 hover:bg-[#E2725B]/15 text-xs font-semibold text-[#E2725B] flex items-center justify-center gap-1.5 transition">
                            <span class="material-symbols-outlined text-[15px]">delete_sweep</span>
                            <span>Kosongkan</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- E. Bottom Section: Quick Product Catalog as Horizontal Bento Grid Cards -->
        <div class="flex flex-col gap-4 pt-4 border-t border-white/10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#8FBF5B]"></span>
                    <h2 class="font-urbanist font-bold text-xl text-white">Katalog Cepat Item Toko</h2>
                    <span class="text-xs text-white/60 hidden sm:inline">• Klik "+ Keranjang" untuk input instan ke struk</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-white/70 font-semibold">{{ $catalogStocks->count() }} Barang Siap Jual</span>
                </div>
            </div>

            <!-- Horizontal Bento Product Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-3.5">
                @forelse($catalogStocks as $stock)
                    <div class="bg-[#141414] hover:bg-[#1f1f1f] border border-white/5 p-4 rounded-[24px] flex flex-col justify-between transition group shadow-md hover:border-[#8FBF5B]/40">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-[#9A9A92] uppercase font-semibold font-mono">
                                {{ $stock->sku ?? ('SKU-' . str_pad((string)$stock->id, 3, '0', STR_PAD_LEFT)) }}
                            </span>
                            <span class="px-2 py-0.5 rounded-full {{ $stock->quantity > 5 ? 'bg-[#8FBF5B]/20 text-[#8FBF5B]' : 'bg-[#E2725B]/20 text-[#E2725B]' }} text-[10px] font-bold">
                                Stok: {{ $stock->quantity }}
                            </span>
                        </div>
                        <div class="my-3">
                            <div class="w-10 h-10 rounded-xl bg-[#232323] flex items-center justify-center mb-2 text-[#8FBF5B]">
                                <span class="material-symbols-outlined text-[20px]">inventory_2</span>
                            </div>
                            <h3 class="font-urbanist font-bold text-sm text-white line-clamp-1 group-hover:text-[#8FBF5B] transition-colors" title="{{ $stock->name }}">
                                {{ $stock->name }}
                            </h3>
                            <span class="text-[11px] text-[#9A9A92]">{{ $stock->category ?? 'Umum' }}</span>
                            <div class="mt-1.5 flex items-baseline gap-1">
                                <span class="font-urbanist font-bold text-base text-white">
                                    {{ number_format($stock->price, 0, ',', '.') }}
                                </span>
                                <span class="text-[10px] text-[#9A9A92]">Rp</span>
                            </div>
                        </div>
                        <button 
                            type="button"
                            wire:click="addToCart({{ $stock->id }})"
                            class="w-full py-2 rounded-full bg-[#8FBF5B] hover:brightness-105 active:scale-95 text-[#141414] text-xs font-bold transition flex items-center justify-center gap-1 shadow-sm cursor-pointer disabled:opacity-40"
                            @if($stock->quantity <= 0) disabled @endif>
                            <span class="material-symbols-outlined text-[15px]">add_shopping_cart</span>
                            <span>{{ $stock->quantity > 0 ? '+ Keranjang' : 'Habis' }}</span>
                        </button>
                    </div>
                @empty
                    <div class="col-span-full bg-[#141414] p-8 rounded-3xl text-center text-white/60 border border-white/5">
                        <span class="material-symbols-outlined text-4xl text-white/30 mb-2">search_off</span>
                        <p class="text-sm font-semibold">Tidak ada produk yang cocok dengan pencarian atau filter.</p>
                        <a href="{{ route('stocks.index') }}" class="inline-flex items-center gap-1.5 mt-3 text-xs text-[#8FBF5B] font-bold hover:underline">
                            + Tambah Stok di Halaman Inventaris
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- MODAL CETAK STRUK THERMAL NOTA KASIR -->
    @if($showReceiptModal && $completedTransaction)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md" x-data>
            <div class="bg-[#F7F4EA] text-[#161616] w-full max-w-sm rounded-[28px] p-6 shadow-2xl flex flex-col gap-4 border border-[#161616]/10 animate-in fade-in zoom-in-95 duration-200">
                <!-- Receipt Top Header -->
                <div class="text-center pb-3 border-b-2 border-dashed border-[#161616]/20">
                    <div class="w-10 h-10 rounded-full bg-[#141414] text-[#8FBF5B] font-urbanist font-extrabold text-base flex items-center justify-center mx-auto mb-2 shadow-sm">
                        sb
                    </div>
                    <h3 class="font-urbanist font-extrabold text-xl text-[#161616]">StockBarang POS</h3>
                    <p class="text-[11px] text-[#6F6F66]">Jl. Percetakan Toko No. 42 • Jakarta</p>
                    <p class="text-[10px] text-[#6F6F66] mt-1 font-mono">
                        {{ $completedTransaction['trx_id'] }} • {{ $completedTransaction['date'] }} {{ $completedTransaction['time'] }}
                    </p>
                </div>

                <!-- Customer & Cashier Info -->
                <div class="text-[11px] text-[#6F6F66] flex justify-between py-1 border-b border-[#161616]/10 font-mono">
                    <span>Kasir: {{ $completedTransaction['cashier'] }}</span>
                    <span>Pelanggan: {{ $completedTransaction['customer'] }}</span>
                </div>

                <!-- Receipt Items -->
                <div class="flex flex-col gap-2 py-2 max-h-48 overflow-y-auto font-mono text-xs divide-y divide-[#161616]/5">
                    @foreach($completedTransaction['items'] as $item)
                        <div class="pt-1.5 flex justify-between items-start">
                            <div class="flex flex-col max-w-[190px]">
                                <span class="font-bold text-[#161616]">{{ $item['name'] }}</span>
                                <span class="text-[10px] text-[#6F6F66]">{{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                            </div>
                            <span class="font-bold text-[#161616]">
                                Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <!-- Receipt Totals -->
                <div class="pt-2 border-t-2 border-dashed border-[#161616]/20 flex flex-col gap-1 font-mono text-xs">
                    <div class="flex justify-between text-[#6F6F66]">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($completedTransaction['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    @if($completedTransaction['discount'] > 0)
                        <div class="flex justify-between text-[#8FBF5B] font-bold">
                            <span>Diskon:</span>
                            <span>-Rp {{ number_format($completedTransaction['discount'], 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-sm font-urbanist font-extrabold text-[#161616] pt-1 border-t border-[#161616]/10">
                        <span>TOTAL:</span>
                        <span>Rp {{ number_format($completedTransaction['total'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] text-[#6F6F66] pt-1">
                        <span>Bayar ({{ strtoupper($completedTransaction['payment_method']) }}):</span>
                        <span>Rp {{ number_format($completedTransaction['cash_tendered'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] font-bold text-[#161616]">
                        <span>Kembalian:</span>
                        <span>Rp {{ number_format($completedTransaction['change'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2 pt-3 border-t border-[#161616]/10">
                    <button 
                        type="button" 
                        onclick="window.print()"
                        class="flex-1 py-2.5 rounded-full bg-[#8FBF5B] hover:brightness-105 active:scale-95 text-[#141414] font-urbanist font-bold text-xs flex items-center justify-center gap-1.5 shadow transition">
                        <span class="material-symbols-outlined text-[16px]">print</span>
                        <span>Cetak Struk</span>
                    </button>
                    <button 
                        type="button" 
                        wire:click="closeReceipt"
                        class="px-5 py-2.5 rounded-full bg-[#141414] hover:bg-black text-white font-urbanist font-bold text-xs transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
