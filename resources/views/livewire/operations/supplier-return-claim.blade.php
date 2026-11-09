<div class="relative z-10 max-w-[1680px] mx-auto flex flex-col gap-6">
    <!-- Top Hero Section: Title, Donut Progress Ring, 3 Giant Metrics -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 px-1 py-2">
        <div class="flex flex-wrap items-center gap-6 sm:gap-8">
            <h1 class="font-urbanist font-medium text-4xl sm:text-5xl lg:text-6xl text-white leading-[1.04] tracking-[-0.02em]">
                Retur Barang<br/><span class="text-white/90">&amp; Klaim Supplier</span>
            </h1>
            <!-- Donut Progress Ring (96% Tingkat Klaim Disetujui) -->
            <div class="flex items-center gap-3.5 pl-6 border-l border-white/20">
                <div class="relative w-16 h-16 flex items-center justify-center shrink-0">
                    <svg class="w-16 h-16 -rotate-90" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" fill="none" r="19" stroke="rgba(255,255,255,0.18)" stroke-width="3.5"></circle>
                        <circle cx="24" cy="24" fill="none" r="19" stroke="#8FBF5B" stroke-dasharray="119.38" stroke-dashoffset="4.77" stroke-linecap="round" stroke-width="3.5"></circle>
                    </svg>
                    <span class="absolute font-urbanist font-bold text-xs text-white">96%</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-semibold text-white/60 tracking-wider uppercase font-manrope">Disetujui</span>
                    <span class="font-urbanist text-sm font-bold text-[#8FBF5B]">Tier-A Vendor</span>
                </div>
            </div>
        </div>

        <!-- 3 Giant Stats -->
        <div class="flex items-baseline gap-6 sm:gap-10 overflow-x-auto pb-2 lg:pb-0 shrink-0">
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Total Nilai Klaim Retur</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">24,800</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">Jt</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Berkas Dalam Proses</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-white leading-none">07</span>
                    <span class="text-xl sm:text-2xl font-bold text-white/60 ml-1">Kasus</span>
                </div>
            </div>
            <div class="flex flex-col">
                <span class="text-xs font-medium text-white/70 mb-1">Tingkat Restitusi Tuntas</span>
                <div class="flex items-baseline font-urbanist">
                    <span class="text-4xl sm:text-5xl font-medium tracking-tight text-[#8FBF5B] leading-none">94.2</span>
                    <span class="text-xl sm:text-2xl font-bold text-[#8FBF5B] ml-1">%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 px-1">
        <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
            <button wire:click="$set('statusFilter', 'all')" 
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition-all {{ $statusFilter === 'all' ? 'bg-[#141414] text-white shadow-md border border-white/20' : 'text-white/80 border border-white/20 hover:bg-white/10' }}">
                Semua Kasus
            </button>
            <button wire:click="$set('statusFilter', 'diproses')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'diproses' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Dalam Proses
            </button>
            <button wire:click="$set('statusFilter', 'disetujui')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'disetujui' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Disetujui Principal
            </button>
            <button wire:click="$set('statusFilter', 'selesai')" 
                    class="px-4 py-2.5 rounded-full text-xs font-semibold whitespace-nowrap transition-all {{ $statusFilter === 'selesai' ? 'bg-[#141414] text-white border border-white/20' : 'text-white/90 border border-white/20 hover:bg-white/10' }}">
                Selesai Ganti
            </button>
        </div>

        <div class="relative flex-1 md:w-80">
            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-white/50 text-[18px]">search</span>
            <input wire:model.live.debounce.300ms="search" 
                   type="text" 
                   class="w-full h-11 pl-10 pr-4 rounded-full bg-black/40 border border-white/20 text-white placeholder-white/50 text-xs focus:outline-none focus:border-[#8FBF5B] transition-all" 
                   placeholder="Cari BAP / Vendor / Produk...">
        </div>
    </div>

    <!-- Main Bento Grid (Left ~68% vs Right ~32%) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        <!-- LEFT COLUMN: Selected Claim Detail (#141414) -->
        <div class="lg:col-span-8 bg-[#141414] rounded-[32px] p-6 sm:p-8 border border-white/10 shadow-2xl flex flex-col justify-between gap-6">
            @if($activeClaim)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-white/10 border border-white/15 flex items-center justify-center text-[#E2725B] shrink-0">
                            <span class="material-symbols-outlined text-[26px]">assignment_return</span>
                        </div>
                        <div class="flex flex-col min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-urbanist font-bold text-lg text-white tracking-tight truncate">
                                    {{ $activeClaim['id'] }} • {{ $activeClaim['supplier'] }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $activeClaim['status'] === 'selesai' ? 'bg-[#8FBF5B]/20 text-[#8FBF5B] border border-[#8FBF5B]/30' : ($activeClaim['status'] === 'disetujui' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-[#E2725B]/20 text-[#E2725B] border border-[#E2725B]/30') }}">
                                    {{ strtoupper($activeClaim['status']) }}
                                </span>
                            </div>
                            <span class="text-xs text-white/60 mt-0.5">
                                Kontak Distributor: {{ $activeClaim['contact'] }} • Dibuat: {{ $activeClaim['date'] }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <button wire:click="generateBAP('{{ $activeClaim['id'] }}')" 
                                class="px-3.5 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs text-white/90 hover:text-white hover:bg-white/20 transition-all flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]">print</span>
                            <span>Unduh BAP</span>
                        </button>
                    </div>
                </div>

                <!-- 3 Bento Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-white/90">Barang &amp; Kerusakan</span>
                            <div class="my-2">
                                <span class="font-urbanist text-xl font-bold text-white block">
                                    {{ $activeClaim['item_name'] }}
                                </span>
                                <span class="text-xs text-[#E2725B] font-semibold block mt-1">
                                    Alasan: {{ $activeClaim['reason'] }}
                                </span>
                            </div>
                        </div>
                        <span class="text-[11px] text-white/50">Lampiran: {{ $activeClaim['evidence'] }}</span>
                    </div>

                    <div class="bg-[#232323] rounded-[22px] p-5 border border-white/5 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-white/90">Volume &amp; Nilai Klaim</span>
                            <div class="my-2">
                                <div class="flex items-baseline gap-1">
                                    <span class="font-urbanist text-3xl font-bold leading-none text-white">
                                        {{ $activeClaim['quantity'] }}
                                    </span>
                                    <span class="text-xs text-white/60 font-medium">{{ $activeClaim['unit'] }}</span>
                                </div>
                                <span class="font-urbanist text-base font-bold text-[#8FBF5B] block mt-1">
                                    {{ $activeClaim['claim_amount'] }}
                                </span>
                            </div>
                        </div>
                        <span class="text-[11px] text-white/50">Bentuk: {{ $activeClaim['compensation_type'] }}</span>
                    </div>

                    <div class="bg-[#8FBF5B] rounded-[22px] p-5 text-[#141414] flex flex-col justify-between shadow-lg">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold tracking-tight text-[#141414]">SOP Restitusi Supplier</span>
                                <span class="material-symbols-outlined text-[20px]">verified_user</span>
                            </div>
                            <p class="text-xs font-medium text-[#141414]/90 mt-2 leading-relaxed">
                                Klaim dijamin tuntas dalam 7 hari kerja sesuai perjanjian SLA distributor level A.
                            </p>
                        </div>
                        <span class="text-[11px] font-bold pt-2 border-t border-black/15">SLA Garansi Resmi</span>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-3">
                    @if($activeClaim['status'] === 'diproses')
                        <button wire:click="approveClaim('{{ $activeClaim['id'] }}')" 
                                class="h-11 px-6 rounded-full bg-amber-500 hover:brightness-105 text-[#141414] font-bold text-xs flex items-center gap-1.5 transition-all">
                            <span class="material-symbols-outlined text-[16px]">check_circle</span>
                            <span>Setujui Klaim Vendor</span>
                        </button>
                    @endif

                    @if($activeClaim['status'] !== 'selesai')
                        <button wire:click="completeClaim('{{ $activeClaim['id'] }}')" 
                                class="h-11 px-6 rounded-full bg-[#8FBF5B] hover:brightness-105 text-[#141414] font-bold text-xs flex items-center gap-1.5 transition-all">
                            <span class="material-symbols-outlined text-[16px]">task_alt</span>
                            <span>Selesaikan Kompensasi</span>
                        </button>
                    @else
                        <div class="px-5 py-2.5 rounded-full bg-[#8FBF5B]/20 text-[#8FBF5B] text-xs font-bold border border-[#8FBF5B]/40">
                            Kasus Selesai Ditutup
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: Claims List Stack (#F7F4EA) -->
        <div class="lg:col-span-4 flex flex-col gap-4">
            @foreach($claims as $c)
                <div wire:click="selectClaim('{{ $c['id'] }}')" 
                     class="bg-[#F7F4EA] text-[#161616] rounded-[24px] p-5 shadow-xl border border-black/5 cursor-pointer transition-all hover:brightness-95 {{ $activeClaim['id'] === $c['id'] ? 'ring-2 ring-[#8FBF5B]' : '' }}">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-black/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[18px]">assignment</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-urbanist font-bold text-sm leading-tight">{{ $c['item_name'] }}</span>
                                <span class="text-[11px] text-[#6F6F66]">{{ $c['supplier'] }}</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#E2725B]/20 text-[#E2725B]">
                            {{ $c['id'] }}
                        </span>
                    </div>

                    <div class="flex items-baseline justify-between mt-3 pt-2 border-t border-black/10">
                        <div class="flex items-baseline font-urbanist">
                            <span class="text-xl font-bold leading-none text-[#161616]">{{ $c['claim_amount'] }}</span>
                            <span class="text-xs font-semibold text-[#6F6F66] ml-1">({{ $c['quantity'] }} {{ $c['unit'] }})</span>
                        </div>
                        <span class="text-xs font-semibold text-[#8FBF5B]">
                            {{ ucfirst($c['status']) }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
