<div class="bento-dashboard-bg bento-grain-overlay min-h-screen -m-4 sm:-m-6 lg:-m-8 p-4 sm:p-6 lg:p-8 text-white relative font-manrope selection:bg-[#8FBF5B] selection:text-black">
    <!-- Cropper.js CDN Styles & Scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

    <!-- Logout Hidden Form -->
    <form id="profile-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

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

        <!-- TOP EDITORIAL HEADER SECTION (STITCH SCREEN 8) -->
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-2 border-b border-white/10">
            <div class="flex flex-col max-w-3xl">
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex items-center justify-center w-2 h-2 rounded-full bg-[#8FBF5B] animate-pulse"></span>
                    <span class="text-xs uppercase tracking-wider text-[#C8D7B4] font-semibold">Workspace Settings • Keamanan Akun</span>
                </div>
                <h1 class="font-urbanist font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-tight">
                    Pengaturan Profil &amp; Akun Pengguna
                </h1>
                <p class="text-xs sm:text-sm text-white/60 mt-1 max-w-2xl leading-relaxed">
                    Kelola preferensi akun personal, hak akses administrasi gudang, otentikasi kata sandi terenkripsi, serta log aktivitas sesi aktif toko Anda.
                </p>
            </div>

            <!-- Quick Action Badges / Capsule Status Header -->
            <div class="flex items-center gap-2.5 flex-wrap">
                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-black/40 border border-white/15 backdrop-blur-md text-xs font-semibold text-white shadow-md">
                    <span class="material-symbols-outlined text-[#8FBF5B] text-[18px]">verified_user</span>
                    <span>Otentikasi Aktif</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 rounded-full bg-[#8FBF5B]/20 border border-[#8FBF5B]/40 text-xs font-bold text-[#8FBF5B] shadow-md uppercase">
                    <span class="material-symbols-outlined text-[18px]">shield</span>
                    <span>{{ ucfirst($user->role) }}</span>
                </div>
            </div>
        </header>

        <!-- ASYMMETRIC BENTO GRID (KIRI 7 KOLOM / KANAN 5 KOLOM) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            <!-- ================= LEFT COLUMN (Span 7) ================= -->
            <div class="lg:col-span-7 flex flex-col gap-6">

                <!-- 1. KARTU KIRI ATAS: FOTO PROFIL & AVATAR (PORCELAIN CREAM #F7F4EA) -->
                <section class="relative overflow-hidden rounded-[28px] bg-[#F7F4EA] text-[#161616] p-6 sm:p-8 shadow-xl border border-black/5">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-[#636159] font-bold">Modul Identitas Visual</span>
                            <h2 class="font-urbanist text-2xl font-bold tracking-tight text-[#161616] mt-0.5">
                                Foto Profil &amp; Avatar
                            </h2>
                        </div>
                        <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#8FBF5B] text-[#141414] text-xs font-bold shadow-sm">
                            <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span>{{ $user->isAdmin() ? 'Super Admin Aktif' : 'Member Retail Aktif' }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-6 pt-2">
                        <!-- Avatar Display 1:1 with Verified Ring -->
                        <div class="relative group shrink-0">
                            <div class="w-32 h-32 sm:w-36 sm:h-36 rounded-full overflow-hidden shadow-lg bg-[#E8E2D2] border-2 border-white flex items-center justify-center">
                                @if ($user->profile_photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_photo_path))
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($user->profile_photo_path) }}?v={{ time() }}"
                                        alt="{{ $user->name }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-tr from-[#2C4328] to-[#8FBF5B] text-white font-urbanist font-extrabold text-3xl">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="absolute bottom-1 right-1 w-8 h-8 rounded-full bg-[#141414] text-[#8FBF5B] flex items-center justify-center shadow-md border border-white/20">
                                <span class="material-symbols-outlined text-[18px]">verified</span>
                            </div>
                        </div>

                        <!-- Avatar Info & Capsule Buttons -->
                        <div class="flex flex-col gap-3 text-center sm:text-left flex-1">
                            <div>
                                <h3 class="font-urbanist text-xl font-bold text-[#161616]">{{ $user->name }}</h3>
                                <p class="text-xs text-[#636159] mt-0.5 font-mono">&#64;{{ $user->username }} &bull; {{ $user->email }}</p>
                            </div>

                            <!-- Hidden file input for Photo Upload -->
                            <input type="file" wire:model="photo" id="profilePhotoInput" accept="image/*" class="hidden">

                            <!-- Capsule Buttons -->
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5 mt-1">
                                <button type="button" onclick="document.getElementById('profilePhotoInput').click()"
                                    class="btn-interactive inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#141414] hover:bg-[#282828] active:scale-95 text-[#F7F4EA] text-xs font-bold transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
                                    <span>Unggah Foto Baru</span>
                                </button>

                                @if ($user->profile_photo_path)
                                    <button type="button" wire:click="confirmDeletePhoto"
                                        class="btn-interactive inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full bg-rose-500/10 hover:bg-rose-500/20 active:scale-95 text-[#93000A] text-xs font-semibold transition-all">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                        <span>Hapus Foto</span>
                                    </button>
                                @endif
                            </div>

                            <div wire:loading wire:target="photo" class="text-xs text-emerald-800 font-semibold animate-pulse">
                                Membaca file gambar untuk pemotongan 1:1...
                            </div>

                            <div class="flex items-center justify-center sm:justify-start gap-1.5 text-[11px] text-[#636159]">
                                <span class="material-symbols-outlined text-[16px]">info</span>
                                <span>Format JPG, JPEG, atau PNG (Maks 5MB). Dipotong presisi 1:1.</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- 2. KARTU KIRI BAWAH: UBAH DATA DIRI (HITAM MATTE #141414) -->
                <section class="relative overflow-hidden rounded-[32px] bg-[#141414] text-white p-6 sm:p-8 shadow-2xl border border-white/10">
                    <div class="flex items-start justify-between gap-4 mb-6 pb-2 border-b border-white/10">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-[#8FBF5B] font-bold">Profil Operasional</span>
                            <h2 class="font-urbanist text-2xl font-bold text-white tracking-tight mt-0.5">
                                Ubah Identitas Diri
                            </h2>
                        </div>
                        <div class="p-2.5 rounded-full bg-[#232323] text-[#8FBF5B]">
                            <span class="material-symbols-outlined text-[20px]">badge</span>
                        </div>
                    </div>

                    <form wire:submit.prevent="updateProfileInformation" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nama Lengkap -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-semibold text-white/80 uppercase tracking-wider" for="fullname">Nama Lengkap</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-white/40 text-[18px]">person</span>
                                    <input id="fullname" wire:model="name" type="text"
                                        class="w-full h-11 pl-11 pr-4 rounded-full bg-[#232323] border border-white/15 text-white text-xs sm:text-sm focus:outline-none focus:border-[#8FBF5B] transition-all"
                                        placeholder="Masukkan nama lengkap" required />
                                </div>
                                @error('name') <span class="text-xs text-rose-400 mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Username -->
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-semibold text-white/80 uppercase tracking-wider" for="username">Username Akun</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-white/40 text-[18px]">alternate_email</span>
                                    <input id="profile-username" wire:model="username" type="text"
                                        class="w-full h-11 pl-11 pr-4 rounded-full bg-[#232323] border border-white/15 text-white text-xs sm:text-sm font-mono focus:outline-none focus:border-[#8FBF5B] transition-all"
                                        placeholder="username_anda" required />
                                </div>
                                @error('username') <span class="text-xs text-rose-400 mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Email Bisnis -->
                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-semibold text-white/80 uppercase tracking-wider" for="profile-email">Email Bisnis</label>
                                <span class="text-[11px] text-[#8FBF5B] font-semibold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">check</span> Terverifikasi
                                </span>
                            </div>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-white/40 text-[18px]">mail</span>
                                <input id="profile-email" wire:model="email" type="email"
                                    class="w-full h-11 pl-11 pr-4 rounded-full bg-[#232323] border border-white/15 text-white text-xs sm:text-sm focus:outline-none focus:border-[#8FBF5B] transition-all"
                                    placeholder="nama@bisnis.id" required />
                            </div>
                            @error('email') <span class="text-xs text-rose-400 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Simpan Perubahan Button -->
                        <div class="pt-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-t border-white/10 mt-4">
                            <span class="text-xs text-white/50 flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-[#8FBF5B]">lock_clock</span>
                                <span>Sinkronisasi otomatis ke semua perangkat kasir &amp; gudang</span>
                            </span>
                            <button type="submit" wire:loading.attr="disabled"
                                class="btn-interactive inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] active:scale-95 text-[#141414] text-xs sm:text-sm font-bold transition-all shadow-lg shadow-[#8FBF5B]/20">
                                <span wire:loading.remove wire:target="updateProfileInformation" class="material-symbols-outlined text-[18px]">save</span>
                                <svg wire:loading wire:target="updateProfileInformation" class="animate-spin h-4 w-4 text-black" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="updateProfileInformation">Simpan Perubahan Identitas</span>
                                <span wire:loading wire:target="updateProfileInformation">Menyimpan...</span>
                            </button>
                        </div>
                    </form>
                </section>

            </div>

            <!-- ================= RIGHT COLUMN (Span 5) ================= -->
            <div class="lg:col-span-5 flex flex-col gap-6">

                <!-- 3. KARTU KANAN ATAS: KEAMANAN & KATA SANDI (HITAM MATTE #141414) -->
                <section class="relative overflow-hidden rounded-[32px] bg-[#141414] text-white p-6 sm:p-8 shadow-2xl border border-white/10">
                    <div class="flex items-start justify-between gap-4 mb-5 pb-2 border-b border-white/10">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider text-[#8FBF5B] font-bold">Enkripsi Akses</span>
                            <h2 class="font-urbanist text-2xl font-bold text-white tracking-tight mt-0.5">
                                Keamanan &amp; Kata Sandi
                            </h2>
                        </div>
                        <div class="p-2.5 rounded-full bg-[#232323] text-[#8FBF5B]">
                            <span class="material-symbols-outlined text-[20px]">key</span>
                        </div>
                    </div>

                    <form wire:submit.prevent="updatePassword" class="space-y-4">
                        <!-- Password Saat Ini -->
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-white/80 uppercase tracking-wider" for="current-password">Password Lama</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-white/40 text-[18px]">lock</span>
                                <input id="current-password" wire:model="current_password" type="password"
                                    class="w-full h-11 pl-11 pr-4 rounded-full bg-[#232323] border border-white/15 text-white text-xs sm:text-sm focus:outline-none focus:border-[#8FBF5B] transition-all"
                                    placeholder="Masukkan kata sandi lama" required />
                            </div>
                            @error('current_password') <span class="text-xs text-rose-400 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password Baru -->
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-white/80 uppercase tracking-wider" for="new-password">Password Baru</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-white/40 text-[18px]">lock_reset</span>
                                <input id="new-password" wire:model="password" type="password"
                                    class="w-full h-11 pl-11 pr-4 rounded-full bg-[#232323] border border-white/15 text-white text-xs sm:text-sm focus:outline-none focus:border-[#8FBF5B] transition-all"
                                    placeholder="Minimal 8 karakter unik" required />
                            </div>
                            @error('password') <span class="text-xs text-rose-400 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Konfirmasi Password Baru -->
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-semibold text-white/80 uppercase tracking-wider" for="confirm-password">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-white/40 text-[18px]">check_box</span>
                                <input id="confirm-password" wire:model="password_confirmation" type="password"
                                    class="w-full h-11 pl-11 pr-4 rounded-full bg-[#232323] border border-white/15 text-white text-xs sm:text-sm focus:outline-none focus:border-[#8FBF5B] transition-all"
                                    placeholder="Ulangi kata sandi baru" required />
                            </div>
                        </div>

                        <!-- Meteran Kekuatan Kata Sandi Visual (Kuat - 100%) -->
                        <div class="p-3.5 rounded-2xl bg-[#1C1C1C] border border-white/5 flex flex-col gap-2 mt-2">
                            <div class="flex items-center justify-between text-xs font-semibold">
                                <span class="text-white/70 flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-[#8FBF5B]">security</span>
                                    <span>Standar Keamanan</span>
                                </span>
                                <span class="text-[#8FBF5B] font-bold">Terenkripsi Bcrypt</span>
                            </div>
                            <div class="w-full grid grid-cols-4 gap-1.5 h-1.5">
                                <div class="h-full rounded-full bg-[#8FBF5B]"></div>
                                <div class="h-full rounded-full bg-[#8FBF5B]"></div>
                                <div class="h-full rounded-full bg-[#8FBF5B]"></div>
                                <div class="h-full rounded-full bg-[#8FBF5B]"></div>
                            </div>
                            <p class="text-[11px] text-white/50">
                                Gunakan kombinasi huruf besar, angka, dan simbol untuk proteksi optimal.
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" wire:loading.attr="disabled"
                                class="btn-interactive w-full inline-flex items-center justify-center gap-2 py-3 rounded-full bg-[#232323] hover:bg-[#2d2d2d] active:scale-95 text-white text-xs sm:text-sm font-bold transition-all shadow-md border border-white/10">
                                <span wire:loading.remove wire:target="updatePassword" class="material-symbols-outlined text-[18px] text-[#8FBF5B]">sync_lock</span>
                                <svg wire:loading wire:target="updatePassword" class="animate-spin h-4 w-4 text-[#8FBF5B]" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="updatePassword">Perbarui Password</span>
                                <span wire:loading wire:target="updatePassword">Memproses...</span>
                            </button>
                        </div>
                    </form>
                </section>

                <!-- 4. KARTU KANAN BAWAH: AKTIVITAS & KEANGGOTAAN (PORCELAIN CREAM #F7F4EA) -->
                <section class="relative overflow-hidden rounded-[28px] bg-[#F7F4EA] text-[#161616] p-6 sm:p-8 shadow-xl flex flex-col justify-between gap-5 border border-black/5">
                    <div>
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-[#636159] font-bold">Ringkasan Sesi &amp; Rekam Jejak</span>
                                <h2 class="font-urbanist text-2xl font-bold text-[#161616] tracking-tight mt-0.5">
                                    Aktivitas &amp; Keanggotaan
                                </h2>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-[#E5DFC9] flex items-center justify-center text-[#141414]">
                                <span class="material-symbols-outlined text-[22px]">history</span>
                            </div>
                        </div>

                        <!-- Metrik Grid Mini Bento -->
                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="p-3.5 rounded-2xl bg-[#ECE6D5] flex flex-col">
                                <span class="text-[11px] text-[#636159] font-semibold">Total Item Terkelola</span>
                                <span class="font-urbanist text-xl font-extrabold text-[#161616] mt-1">{{ $user->stocks()->count() }} SKU</span>
                                <span class="text-[10px] text-emerald-800 font-bold flex items-center gap-0.5 mt-0.5">
                                    <span class="material-symbols-outlined text-[13px]">inventory</span> Terdata di Sistem
                                </span>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-[#ECE6D5] flex flex-col">
                                <span class="text-[11px] text-[#636159] font-semibold">Bergabung Sejak</span>
                                <span class="font-urbanist text-xl font-extrabold text-[#161616] mt-1">
                                    {{ $user->created_at ? $user->created_at->format('M Y') : '-' }}
                                </span>
                                <span class="text-[10px] text-[#636159] mt-0.5">
                                    {{ $user->created_at ? $user->created_at->diffForHumans() : '-' }}
                                </span>
                            </div>
                        </div>

                        <!-- Login Terakhir Box -->
                        <div class="p-4 rounded-2xl bg-[#ECE6D5] flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-full bg-[#141414] text-[#8FBF5B] flex items-center justify-center shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[18px]">devices</span>
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="text-xs font-bold text-[#161616]">Sesi Login Terakhir</span>
                                <span class="text-xs text-[#4B4942]">{{ now()->format('l, d M Y, H:i') }} WIB</span>
                                <div class="flex items-center gap-1.5 text-[#636159] text-[11px] mt-1">
                                    <span class="material-symbols-outlined text-[14px]">desktop_windows</span>
                                    <span>Web Browser Session &bull; Status Aman</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Logout Action Button -->
                    <div class="pt-2 border-t border-black/10">
                        <button type="button"
                            onclick="if(confirm('Apakah Anda yakin ingin keluar dari akun ini?')) document.getElementById('profile-logout-form').submit();"
                            class="btn-interactive w-full inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-[#E05345] hover:bg-[#C94336] active:scale-95 text-white text-xs sm:text-sm font-bold shadow-md transition-all group">
                            <span class="material-symbols-outlined text-[18px] transition-transform group-hover:-translate-x-1">logout</span>
                            <span>Keluar dari Akun</span>
                        </button>
                    </div>
                </section>

            </div>

        </div>

    </div>

    <!-- MODAL CROPPER FOTO PROFIL (RASIO 1:1) -->
    @if ($showCropModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
            x-data="{
                cropper: null,
                init() {
                    this.$nextTick(() => {
                        const image = document.getElementById('cropImageTarget');
                        if (image) {
                            this.cropper = new Cropper(image, {
                                aspectRatio: 1,
                                viewMode: 1,
                                autoCropArea: 0.9,
                                responsive: true,
                            });
                        }
                    });
                },
                save() {
                    if (this.cropper) {
                        const canvas = this.cropper.getCroppedCanvas({
                            width: 400,
                            height: 400,
                            imageSmoothingQuality: 'high',
                        });
                        @this.set('croppedPhoto', canvas.toDataURL('image/jpeg'));
                        @this.call('saveCroppedPhoto');
                    }
                }
            }">
            <div class="relative w-full max-w-lg bg-[#141414] rounded-[32px] border border-white/15 p-6 sm:p-8 shadow-2xl text-white">
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <div class="flex items-center gap-2.5">
                        <span class="material-symbols-outlined text-[#8FBF5B] text-[24px]">crop</span>
                        <h3 class="font-urbanist text-xl font-bold text-white">Potong Foto Profil (Rasio 1:1)</h3>
                    </div>
                    <button type="button" wire:click="closeCropModal" class="w-8 h-8 rounded-full bg-white/5 hover:bg-white/15 text-white/60 hover:text-white flex items-center justify-center">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>

                <div class="mt-4 max-h-80 overflow-hidden rounded-2xl bg-black flex items-center justify-center">
                    @if ($photo)
                        <img id="cropImageTarget" src="{{ $photo->temporaryUrl() }}" alt="Preview" class="max-h-80 w-auto">
                    @endif
                </div>

                <div class="flex items-center justify-end gap-3 mt-6">
                    <button type="button" wire:click="closeCropModal" class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-semibold">
                        Batal
                    </button>
                    <button type="button" @click="save()" class="btn-interactive px-5 py-2.5 rounded-full bg-[#8FBF5B] hover:bg-[#9ecc67] text-[#0A0A0A] text-xs font-bold flex items-center gap-2 shadow-lg shadow-[#8FBF5B]/20">
                        <span class="material-symbols-outlined text-[18px]">check</span>
                        <span>Potong &amp; Simpan</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL KONFIRMASI HAPUS FOTO PROFIL -->
    @if ($confirmingPhotoDeletion)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
            x-data @keydown.escape.window="$wire.cancelDeletePhoto()">
            <div class="relative w-full max-w-md bg-[#141414] rounded-[32px] border border-white/15 p-6 sm:p-8 shadow-2xl text-white">
                <div class="w-12 h-12 rounded-full bg-rose-500/20 text-rose-400 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[28px]">delete</span>
                </div>
                <h3 class="font-urbanist text-xl font-bold text-white">Hapus Foto Profil?</h3>
                <p class="text-xs text-white/60 mt-2 leading-relaxed">
                    Foto profil Anda akan dihapus secara permanen dan digantikan dengan monogram inisial nama.
                </p>
                <div class="flex items-center justify-end gap-3 mt-6">
                    <button type="button" wire:click="cancelDeletePhoto" class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs font-semibold">
                        Batal
                    </button>
                    <button type="button" wire:click="deletePhoto" class="btn-interactive px-5 py-2.5 rounded-full bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-lg shadow-rose-600/30">
                        Ya, Hapus Foto
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
