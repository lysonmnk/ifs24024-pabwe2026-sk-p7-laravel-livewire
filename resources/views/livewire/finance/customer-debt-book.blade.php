<div class="relative z-10 max-w-[1680px] mx-auto flex flex-col gap-6">
    <!-- Top Hero Section: Title, Donut Progress Ring, 3 Giant Metrics -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 px-1 py-2">
        <div class="flex flex-wrap items-center gap-6 sm:gap-8">
            <h1 class="font-urbanist font-medium text-4xl sm:text-5xl lg:text-6xl text-white leading-[1.04] tracking-[-0.02em]">
                Buku Bon<br/><span class="text-white/90">&amp; Piutang Warung</span>
            </h1>
            <!-- Donut Progress Ring (82% Kolektibilitas Lancar) -->
            <div class="flex items-center gap-3.5 pl-6 border-l border-white/20">
                <div class="relative w-16 h-16 flex items-center justify-center shrink-0">
                    <svg class="w-16 h-16 -rotate-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" fill="none" r="19" stroke="rgba(255,255,255,0.18)" stroke-width="3.5"></circle>
                        <circle cx="24" cy="24" fill="none" r="19" stroke="#8FBF5B" stroke-dasharray="119.38" stroke-dashoffset="21.48" stroke-linecap="round" stroke-width="3.5"></circle>
                    </svg>
                    <span class="absolute font-urbanist font-bold text-xs text-white">82%</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-semibold text-white/60 tracking-wider uppercase font-manrope">Kolektibilitas</span>
                    <span class="font-urbanist text-sm font-bold text-[#8FBF5B]">Lancar Bulanan</span>
                </div>
            </div>
        </div>

        <!-- 3 Giant Stats -->
        <div class="flex items-baseline gap-6 sm:gap-10 overflow-x-auto pb-2 lg:pb-0 shrink-0">
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Total Piutang Aktif</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">42,850</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">Jt</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Tertagih Bulan Ini</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-[#8FBF5B] leading-none">67,200</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">Jt</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Pelanggan Lewat Tempo</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-[#E2725B] leading-none">08</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#E2725B] ml-1">Warung</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Action Bar -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 px-1">
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
            <button wire:click="$set('statusFilter', 'all')" 
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ $statusFilter === 'all' ? 'bg-[#141414] text-white shadow-md border border-white/20' : 'text-white/80 border border-white/20 hover:bg-white/10' }}">
                Semua Pelanggan
            </button>
            <button wire:click="$set('statusFilter', 'overdue')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'overdue' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Lewat Tempo <span class="ml-1 text-[#E2725B] font-bold">(8)</span>
            </button>
            <button wire:click="$set('statusFilter', 'critical_limit')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'critical_limit' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Limit Kritis &gt;80%
            </button>
            <button wire:click="$set('statusFilter', 'paid')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'paid' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Lunas Terbaru
            </button>
        </div>

        <div class="relative flex-1 md:w-80">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-white/50 text-[18px]">search</span>
            <input wire:model.live.debounce.300ms="search" 
                   type="text" 
                   class="w-full h-11 pl-10 pr-4 rounded-full bg-black/40 border border-white/20 text-white placeholder-white/50 text-xs focus:outline-none focus:border-[#8FBF5B] transition-all" 
                   placeholder="Cari warung, pemilik, no HP...">
        </div>
    </div>

    <!-- Main Bento Grid (Left ~68% vs Right ~32%) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        <!-- LEFT COLUMN: Selected Warung Debt Detail Card (#141414) -->
        <div class="lg:col-span-8 bg-[#141414] rounded-[32px] p-6 sm:p-8 border border-white/10 shadow-2xl flex flex-col justify-between gap-6">
            @if($activeCustomer)
                @php
                    $limitPercent = min(100, round(($activeCustomer['current_debt'] / max(1, $activeCustomer['credit_limit'])) * 100));
                @endphp
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-white/10 border border-white/15 flex items-center justify-center text-[#8FBF5B] shrink-0">
                            <span class="material-symbols-outlined text-[26px]">storefront</span>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-urbanist font-bold text-lg text-white tracking-tight truncate">
                                    {{ $activeCustomer['name'] }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $activeCustomer['status'] === 'overdue' ? 'bg-[#E2725B]/20 text-[#E2725B] border border-[#E2725B]/30' : 'bg-[#8FBF5B]/20 text-[#8FBF5B] border border-[#8FBF5B]/30' }}">
                                    {{ $activeCustomer['status'] === 'overdue' ? 'Tunggakan Lewat Tempo' : ($activeCustomer['status'] === 'paid' ? 'Lunas Bersih' : 'Lancar TOP') }}
                                </span>
                            </div>
                            <span class="text-xs text-white/60 mt-0.5">
                                Pemilik: {{ $activeCustomer['owner'] }} • {{ $activeCustomer['phone'] }} • {{ $activeCustomer['address'] }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <button wire:click="exportDebtCard('{{ $activeCustomer['id'] }}')" 
                                class="px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs text-white/90 hover:text-white hover:bg-white/20 transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">receipt_long</span>
                            <span>Cetak Kartu Bon</span>
                        </button>
                    </div>
                </div>

                <!-- Credit Limit Meter -->
                <div class="p-5 rounded-2xl bg-[#232323] border border-white/5">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-white/80">Penggunaan Plafon Kredit (Batas Bon)</span>
                        <span class="font-urbanist text-sm font-bold {{ $limitPercent > 80 ? 'text-[#E2725B]' : 'text-[#8FBF5B]' }}">
                            {{ $limitPercent }}% Terpakai
                        </span>
                    </div>
                    <div class="w-full h-3 rounded-full bg-black/40 overflow-hidden">
                        <div class="h-full rounded-full {{ $limitPercent > 80 ? 'bg-[#E2725B]' : 'bg-[#8FBF5B]' }}" style="width: {{ $limitPercent }}%;"></div>
                    </div>
                    <div class="flex items-center justify-between mt-2 text-xs text-white/50">
                        <span>Terutang: Rp {{ number_format($activeCustomer['current_debt'], 0, ',', '.') }}</span>
                        <span>Maksimal Plafon: Rp {{ number_format($activeCustomer['credit_limit'], 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- 3 Bento Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-white/90">Sisa Saldo Kasbon</span>
                            <div class="my-3">
                                <div class="flex items-baseline gap-1">
                                    <span class="font-urbanist text-3xl sm:text-4xl font-bold leading-none {{ $activeCustomer['current_debt'] > 0 ? 'text-[#E2725B]' : 'text-[#8FBF5B]' }}">
                                        Rp {{ number_format($activeCustomer['current_debt'], 0, ',', '.') }}
                                    </span>
                                </div>
                                <span class="text-xs text-white/50 block mt-2">Jatuh Tempo: {{ $activeCustomer['due_date'] }}</span>
                            </div>
                        </div>
                        <span class="text-[11px] text-white/60">Terakhir bayar: {{ $activeCustomer['last_payment_date'] }}</span>
                    </div>

                    <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-white/90">Catatan Order Bon Terakhir</span>
                            <p class="text-xs text-white/80 mt-2 font-medium leading-relaxed">
                                {{ $activeCustomer['last_transaction'] }}
                            </p>
                        </div>
                        <span class="text-[11px] text-[#8FBF5B] font-bold">Sinkron POS Kasir</span>
                    </div>

                    <div class="bg-[#8FBF5B] rounded-[22px] p-5 text-[#141414] flex flex-col justify-between shadow-lg">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold tracking-tight text-[#141414]">Skor Disiplin Mitra</span>
                                <span class="material-symbols-outlined text-[20px]">verified</span>
                            </div>
                            <div class="my-2">
                                <span class="font-urbanist text-4xl font-extrabold leading-none">
                                    {{ $activeCustomer['status'] === 'overdue' ? 'Grade C' : 'Grade A+' }}
                                </span>
                            </div>
                            <p class="text-[11px] font-medium leading-tight">
                                {{ $activeCustomer['status'] === 'overdue' ? 'Disarankan stop sementara bon baru.' : 'Mitra loyal, plafon bon dapat dinaikkan.' }}
                            </p>
                        </div>
                        <span class="text-[11px] font-bold pt-2 border-t border-black/15">Kebijakan Kasbon Toko</span>
                    </div>
                </div>

                <!-- Payment Logger Bar -->
                <div class="pt-4 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="w-full sm:w-1/2 flex items-center gap-2">
                        <span class="text-xs font-bold text-white/70">Bayar (Rp):</span>
                        <input wire:model="paymentAmount" 
                               type="number" 
                               min="0" 
                               placeholder="Nominal pembayaran..." 
                               class="flex-1 h-11 px-4 rounded-full bg-black/40 border border-white/20 text-white placeholder-white/40 text-xs focus:outline-none focus:border-[#8FBF5B]">
                    </div>
                    <button wire:click="recordPayment('{{ $activeCustomer['id'] }}')" 
                            type="button" 
                            class="h-11 px-7 rounded-full bg-[#8FBF5B] hover:brightness-105 text-[#141414] font-bold text-xs flex items-center justify-center gap-2 shadow-xl transition-all active:scale-95 shrink-0 cursor-pointer">
                        <span class="material-symbols-outlined text-[18px]">payments</span>
                        <span>Catat Pelunasan Bon</span>
                    </button>
                </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: Customer Directory Stack (#F7F4EA) -->
        <div class="lg:col-span-4 flex flex-col gap-4">
            @foreach($customers as $c)
                <div wire:click="selectCustomer('{{ $c['id'] }}')" 
                     class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-5 shadow-xl border border-black/5 cursor-pointer transition-all hover:brightness-95 {{ $activeCustomer['id'] === $c['id'] ? 'ring-2 ring-[#8FBF5B]' : '' }}">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-black/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[18px]">store</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-urbanist font-bold text-sm leading-tight">{{ $c['name'] }}</span>
                                <span class="text-[11px] text-[#6F6F66]">{{ $c['owner'] }}</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $c['status'] === 'overdue' ? 'bg-[#E2725B]/20 text-[#E2725B]' : 'bg-[#3E5B34]/15 text-[#2c4323]' }}">
                            {{ $c['id'] }}
                        </span>
                    </div>

                    <div class="flex items-baseline justify-between mt-3 pt-2 border-t border-black/10">
                        <div class="flex items-baseline font-urbanist">
                            <span class="text-xl font-bold leading-none {{ $c['current_debt'] > 0 ? 'text-[#161616]' : 'text-[#8FBF5B]' }}">
                                Rp {{ number_format($c['current_debt'], 0, ',', '.') }}
                            </span>
                        </div>
                        <span class="text-xs font-semibold {{ $c['status'] === 'overdue' ? 'text-[#E2725B]' : 'text-[#6F6F66]' }}">
                            {{ $c['due_date'] }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
