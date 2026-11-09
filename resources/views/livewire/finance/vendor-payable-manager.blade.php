<div class="relative z-10 max-w-[1680px] mx-auto flex flex-col gap-6">
    <!-- Top Hero Section: Title, Donut Progress Ring, 3 Giant Metrics -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 px-1 py-2">
        <div class="flex flex-wrap items-center gap-6 sm:gap-8">
            <h1 class="font-urbanist font-medium text-4xl sm:text-5xl lg:text-6xl text-white leading-[1.04] tracking-[-0.02em]">
                Utang Vendor<br/><span class="text-white/90">&amp; Termin Pembayaran</span>
            </h1>
            <!-- Donut Progress Ring (94% Faktur Disiplin TOP) -->
            <div class="flex items-center gap-3.5 pl-6 border-l border-white/20">
                <div class="relative w-16 h-16 flex items-center justify-center shrink-0">
                    <svg class="w-16 h-16 -rotate-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" fill="none" r="19" stroke="rgba(255,255,255,0.18)" stroke-width="3.5"></circle>
                        <circle cx="24" cy="24" fill="none" r="19" stroke="#8FBF5B" stroke-dasharray="119.38" stroke-dashoffset="7.16" stroke-linecap="round" stroke-width="3.5"></circle>
                    </svg>
                    <span class="absolute font-urbanist font-bold text-xs text-white">94%</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-semibold text-white/60 tracking-wider uppercase font-manrope">Disiplin TOP</span>
                    <span class="font-urbanist text-sm font-bold text-[#8FBF5B]">Termin 30 Hari</span>
                </div>
            </div>
        </div>

        <!-- 3 Giant Stats -->
        <div class="flex items-baseline gap-6 sm:gap-10 overflow-x-auto pb-2 lg:pb-0 shrink-0">
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Total Utang Berjalan</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">86,400</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">Jt</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Jatuh Tempo &lt; 7 Hari</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-[#E2725B] leading-none">24,500</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#E2725B] ml-1">Jt</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Skor Kepatuhan Vendor</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-[#8FBF5B] leading-none">98.2</span>
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
                Semua Faktur
            </button>
            <button wire:click="$set('statusFilter', 'critical')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'critical' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Jatuh Tempo &lt;7 Hari <span class="ml-1 text-[#E2725B] font-bold">Kritis</span>
            </button>
            <button wire:click="$set('statusFilter', 'lancar')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'lancar' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                TOP Lancar
            </button>
            <button wire:click="$set('statusFilter', 'lunas')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'lunas' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Lunas
            </button>
        </div>

        <div class="relative flex-1 md:w-80">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-white/50 text-[18px]">search</span>
            <input wire:model.live.debounce.300ms="search" 
                   type="text" 
                   class="w-full h-11 pl-10 pr-4 rounded-full bg-black/40 border border-white/20 text-white placeholder-white/50 text-xs focus:outline-none focus:border-[#8FBF5B] transition-all" 
                   placeholder="Cari faktur, supplier, barang...">
        </div>
    </div>

    <!-- Main Bento Grid (Left ~68% vs Right ~32%) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        <!-- LEFT COLUMN: Selected Invoice Detail (#141414) -->
        <div class="lg:col-span-8 bg-[#141414] rounded-[32px] p-6 sm:p-8 border border-white/10 shadow-2xl flex flex-col justify-between gap-6">
            @if($activeInvoice)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-white/10 border border-white/15 flex items-center justify-center text-[#8FBF5B] shrink-0">
                            <span class="material-symbols-outlined text-[26px]">receipt</span>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-urbanist font-bold text-lg text-white tracking-tight truncate">
                                    {{ $activeInvoice['id'] }} • {{ $activeInvoice['supplier'] }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $activeInvoice['status'] === 'critical' ? 'bg-[#E2725B]/20 text-[#E2725B] border border-[#E2725B]/30' : ($activeInvoice['status'] === 'lunas' ? 'bg-[#8FBF5B]/20 text-[#8FBF5B] border border-[#8FBF5B]/30' : 'bg-white/10 text-white/80 border border-white/20') }}">
                                    {{ $activeInvoice['status'] === 'critical' ? 'Jatuh Tempo Kritis' : ($activeInvoice['status'] === 'lunas' ? 'Lunas Bersih' : 'Termin Berjalan') }}
                                </span>
                            </div>
                            <span class="text-xs text-white/60 mt-0.5">
                                Syarat Pembayaran: {{ $activeInvoice['terms'] }} • Tanggal Faktur: {{ $activeInvoice['invoice_date'] }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <button wire:click="downloadReceipt('{{ $activeInvoice['id'] }}')" 
                                class="px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs text-white/90 hover:text-white hover:bg-white/20 transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">download</span>
                            <span>Instruksi Bayar</span>
                        </button>
                    </div>
                </div>

                <!-- 3 Bento Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-white/90">Nominal Tagihan Utang</span>
                            <div class="my-3">
                                <span class="font-urbanist text-3xl sm:text-4xl font-bold leading-none {{ $activeInvoice['status'] === 'critical' ? 'text-[#E2725B]' : 'text-white' }}">
                                    Rp {{ number_format($activeInvoice['amount'], 0, ',', '.') }}
                                </span>
                                <span class="text-xs text-white/50 block mt-2">Jatuh Tempo: {{ $activeInvoice['due_date'] }}</span>
                            </div>
                        </div>
                        <span class="text-[11px] text-[#8FBF5B] font-bold">Verifikasi PO Gudang ACC</span>
                    </div>

                    <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-white/90">Rekening Tujuan Vendor</span>
                            <p class="text-xs text-white font-mono mt-3 leading-relaxed">
                                {{ $activeInvoice['bank_account'] }}
                            </p>
                        </div>
                        <span class="text-[11px] text-white/50">Transfer Kliring / RTGS</span>
                    </div>

                    <div class="bg-[#8FBF5B] rounded-[22px] p-5 text-[#141414] flex flex-col justify-between shadow-lg">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold tracking-tight text-[#141414]">Ringkasan Barang Diterima</span>
                                <span class="material-symbols-outlined text-[20px]">local_shipping</span>
                            </div>
                            <p class="text-xs font-medium text-[#141414]/90 mt-3 leading-relaxed">
                                {{ $activeInvoice['items_summary'] }}
                            </p>
                        </div>
                        <span class="text-[11px] font-bold pt-2 border-t border-black/15">Sesuai Surat Jalan DO</span>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-3">
                    @if($activeInvoice['status'] !== 'lunas')
                        <button wire:click="payInvoice('{{ $activeInvoice['id'] }}')" 
                                class="h-12 px-8 rounded-full bg-[#8FBF5B] hover:brightness-105 text-[#141414] font-bold text-xs flex items-center gap-2 shadow-xl transition-all active:scale-95">
                            <span class="material-symbols-outlined text-[18px]">payments</span>
                            <span>Bayar Faktur Vendor Sekarang</span>
                        </button>
                    @else
                        <div class="px-5 py-2.5 rounded-full bg-[#8FBF5B]/20 text-[#8FBF5B] text-xs font-bold border border-[#8FBF5B]/40">
                            Faktur Telah Lunas Terbayar
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: Invoices List Stack (#F7F4EA) -->
        <div class="lg:col-span-4 flex flex-col gap-4">
            @foreach($invoices as $inv)
                <div wire:click="selectInvoice('{{ $inv['id'] }}')" 
                     class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-5 shadow-xl border border-black/5 cursor-pointer transition-all hover:brightness-95 {{ $activeInvoice['id'] === $inv['id'] ? 'ring-2 ring-[#8FBF5B]' : '' }}">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-black/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[18px]">account_balance</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-urbanist font-bold text-sm leading-tight">{{ $inv['supplier'] }}</span>
                                <span class="text-[11px] text-[#6F6F66]">{{ $inv['id'] }}</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $inv['status'] === 'critical' ? 'bg-[#E2725B]/20 text-[#E2725B]' : 'bg-[#3E5B34]/15 text-[#2c4323]' }}">
                            {{ $inv['due_date'] }}
                        </span>
                    </div>

                    <div class="flex items-baseline justify-between mt-3 pt-2 border-t border-black/10">
                        <div class="flex items-baseline font-urbanist">
                            <span class="text-xl font-bold leading-none text-[#161616]">
                                Rp {{ number_format($inv['amount'], 0, ',', '.') }}
                            </span>
                        </div>
                        <span class="text-xs font-semibold text-[#8FBF5B]">
                            {{ $inv['terms'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
