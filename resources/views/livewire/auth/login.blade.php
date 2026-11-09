<div class="relative w-full flex items-center justify-center min-h-[calc(100vh-6rem)] py-6">
    <!-- Top-Right Theme Toggle Button (Day & Night Mode) -->
    <div class="fixed top-5 right-5 z-50" x-data="{
        theme: localStorage.getItem('app-theme') || (document.documentElement.classList.contains('dark') ? 'dark' : 'light'),
        init() {
            if (this.theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            window.dispatchEvent(new CustomEvent('app-theme-changed', { detail: { theme: this.theme } }));
        },
        toggleTheme() {
            this.theme = this.theme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('app-theme', this.theme);
            if (this.theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            window.dispatchEvent(new CustomEvent('app-theme-changed', { detail: { theme: this.theme } }));
        }
    }">
        <button
            type="button"
            @click="toggleTheme()"
            class="btn-interactive active:scale-95 p-3 rounded-2xl bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border border-slate-200 dark:border-slate-700 shadow-xl text-slate-700 dark:text-amber-400 hover:scale-110 transition-all cursor-pointer flex items-center justify-center group"
            :title="theme === 'dark' ? 'Beralih ke Mode Terang (Day Mode)' : 'Beralih ke Mode Gelap (Night Mode)'"
            :aria-label="theme === 'dark' ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap'">
            <!-- Sun icon (shown in Dark mode) -->
            <svg x-show="theme === 'dark'" x-cloak class="w-5 h-5 text-amber-400 group-hover:rotate-45 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <!-- Moon icon (shown in Light mode) -->
            <svg x-show="theme === 'light'" class="w-5 h-5 text-slate-700 group-hover:-rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>
    </div>

    <!-- React Island: GridMotion 3D Ambient Background -->
    <div id="grid-motion-root" wire:ignore class="absolute inset-0 -top-24 -bottom-24 w-full h-[calc(100%+12rem)] z-0 pointer-events-auto opacity-85" aria-hidden="true"></div>

    <!-- 3D Interactive Flip Card Container -->
    <div class="relative z-10 w-full max-w-lg mx-auto my-auto px-4 perspective-1100"
         x-data="{
             isFlipped: false,
             tiltX: 0,
             tiltY: 0,
             glareX: 50,
             glareY: 50,
             sheen: 0,
             handleMouseMove(e) {
                 const rect = this.$el.getBoundingClientRect();
                 const px = Math.min(1, Math.max(0, (e.clientX - rect.left) / rect.width));
                 const py = Math.min(1, Math.max(0, (e.clientY - rect.top) / rect.height));
                 this.tiltX = (0.5 - py) * 12;
                 this.tiltY = (px - 0.5) * 12;
                 this.glareX = px * 100;
                 this.glareY = py * 100;
                 this.sheen = 1;
             },
             handleMouseLeave() {
                 this.tiltX = 0;
                 this.tiltY = 0;
                 this.sheen = 0;
             },
             flipToRegister() {
                 this.isFlipped = true;
                 window.history.pushState(null, '', '{{ route('register') }}');
             },
             flipToLogin() {
                 this.isFlipped = false;
                 window.history.pushState(null, '', '{{ route('login') }}');
             }
         }"
         @mousemove="handleMouseMove($event)"
         @mouseleave="handleMouseLeave()">

        <!-- Soft 3D Elevation Dynamic Shadow -->
        <div class="absolute inset-x-8 -bottom-4 h-16 rounded-3xl bg-black/40 dark:bg-black/75 blur-2xl pointer-events-none transition-all duration-700"
             :style="'transform: scaleX(' + (isFlipped ? 0.92 : 1) + '); opacity: ' + (isFlipped ? 0.35 : 0.45) + ';'"></div>

        <!-- 3D Rotor -->
        <div class="relative w-full preserve-3d transition-transform duration-700 ease-[cubic-bezier(0.34,1.56,0.64,1)]"
             :style="'transform: rotateX(' + tiltX + 'deg) rotateY(' + (tiltY + (isFlipped ? 180 : 0)) + 'deg);'">

            <!-- ================= FRONT FACE: LOGIN FORM ================= -->
            <div class="w-full glass-auth-card p-7 sm:p-9 rounded-3xl backface-hidden relative overflow-hidden transition-all duration-300 min-h-[490px] flex flex-col justify-between"
                 :class="isFlipped ? 'pointer-events-none' : ''">
                <!-- Glare / Sheen Reflection Overlay -->
                <div class="absolute inset-0 pointer-events-none rounded-3xl transition-opacity duration-300"
                     :style="'background: radial-gradient(circle farthest-side at ' + glareX + '% ' + glareY + '%, rgba(255, 255, 255, 0.28) 0%, rgba(255, 255, 255, 0) 75%); opacity: ' + sheen + ';'"
                     aria-hidden="true"></div>

                <div class="relative z-10 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="text-center mb-6">
                            <div class="inline-flex items-center justify-center p-3 mb-2.5 bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 text-white rounded-2xl shadow-lg shadow-blue-500/25">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Masuk ke Akun Anda</h1>
                            <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 mt-1 font-medium">Kelola inventaris stok barang Anda secara teratur dan efisien</p>
                        </div>

                        <form wire:submit.prevent="authenticate" action="{{ route('login') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="login-username" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1">Username atau Email</label>
                                <input wire:model="login" type="text" name="username" id="login-username" autocomplete="username" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm transition bg-white/70 dark:bg-slate-800/70 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 shadow-sm" placeholder="username atau nama@email.com" required>
                                @error('login') <span class="text-xs text-rose-600 dark:text-rose-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="login-password" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1">Password</label>
                                <input wire:model="password" type="password" name="password" id="login-password" autocomplete="current-password" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm transition bg-white/70 dark:bg-slate-800/70 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 shadow-sm" placeholder="••••••••" required>
                                @error('password') <span class="text-xs text-rose-600 dark:text-rose-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <label class="flex items-center space-x-2 text-xs sm:text-sm text-slate-800 dark:text-slate-200 cursor-pointer">
                                    <input wire:model="remember" type="checkbox" name="remember" class="rounded border-slate-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 bg-white dark:bg-slate-800">
                                    <span>Ingat Saya</span>
                                </label>
                            </div>

                            <button type="submit" id="login-submit" wire:loading.attr="disabled" class="btn-interactive active:scale-95 w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 disabled:opacity-75 disabled:cursor-not-allowed text-white font-semibold rounded-xl shadow-md shadow-blue-500/25 transition flex items-center justify-center space-x-2 cursor-pointer">
                                <svg wire:loading wire:target="authenticate" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="authenticate">Masuk</span>
                                <span wire:loading wire:target="authenticate">Memverifikasi...</span>
                            </button>
                        </form>
                    </div>

                    <div class="mt-6 text-center text-xs sm:text-sm text-slate-700 dark:text-slate-300 font-medium">
                        Belum memiliki akun?
                        <button type="button" @click="flipToRegister()" class="font-bold text-blue-700 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline ml-1 cursor-pointer">
                            Daftar sekarang ↻
                        </button>
                    </div>
                </div>
            </div>

            <!-- ================= BACK FACE: REGISTER FORM ================= -->
            <div class="w-full glass-auth-card p-7 sm:p-9 rounded-3xl backface-hidden rotate-y-180 absolute inset-0 overflow-hidden transition-all duration-300 min-h-[490px] flex flex-col justify-between"
                 :class="!isFlipped ? 'pointer-events-none' : ''">
                <!-- Glare / Sheen Reflection Overlay -->
                <div class="absolute inset-0 pointer-events-none rounded-3xl transition-opacity duration-300"
                     :style="'background: radial-gradient(circle farthest-side at ' + glareX + '% ' + glareY + '%, rgba(255, 255, 255, 0.28) 0%, rgba(255, 255, 255, 0) 75%); opacity: ' + sheen + ';'"
                     aria-hidden="true"></div>

                <div class="relative z-10 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="text-center mb-4">
                            <div class="inline-flex items-center justify-center p-2.5 mb-2 bg-gradient-to-tr from-emerald-600 via-teal-600 to-cyan-600 text-white rounded-2xl shadow-lg shadow-emerald-500/25">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Buat Akun Member</h2>
                            <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 mt-0.5 font-medium">Daftar sekarang untuk mulai mengelola stok barang</p>
                        </div>

                        <form wire:submit.prevent="registerUser" class="space-y-3">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="reg-name" class="block text-xs font-semibold text-slate-800 dark:text-slate-200 mb-1">Nama Lengkap</label>
                                    <input wire:model="reg_name" type="text" id="reg-name" class="w-full px-3 py-2 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm transition bg-white/70 dark:bg-slate-800/70 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 shadow-sm" placeholder="Nama Anda" required>
                                    @error('reg_name') <span class="text-xs text-rose-600 dark:text-rose-400 mt-0.5 block font-medium">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="reg-username" class="block text-xs font-semibold text-slate-800 dark:text-slate-200 mb-1">Username</label>
                                    <input wire:model="reg_username" type="text" id="reg-username" class="w-full px-3 py-2 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm transition bg-white/70 dark:bg-slate-800/70 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 shadow-sm" placeholder="username_kamu" required>
                                    @error('reg_username') <span class="text-xs text-rose-600 dark:text-rose-400 mt-0.5 block font-medium">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="reg-email" class="block text-xs font-semibold text-slate-800 dark:text-slate-200 mb-1">Email</label>
                                <input wire:model="reg_email" type="email" id="reg-email" class="w-full px-3 py-2 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm transition bg-white/70 dark:bg-slate-800/70 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 shadow-sm" placeholder="nama@email.com" required>
                                @error('reg_email') <span class="text-xs text-rose-600 dark:text-rose-400 mt-0.5 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label for="reg-password" class="block text-xs font-semibold text-slate-800 dark:text-slate-200 mb-1">Password</label>
                                    <input wire:model="reg_password" type="password" id="reg-password" class="w-full px-3 py-2 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm transition bg-white/70 dark:bg-slate-800/70 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 shadow-sm" placeholder="Min. 8 karakter" required>
                                    @error('reg_password') <span class="text-xs text-rose-600 dark:text-rose-400 mt-0.5 block font-medium">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="reg-password-confirmation" class="block text-xs font-semibold text-slate-800 dark:text-slate-200 mb-1">Konfirmasi</label>
                                    <input wire:model="reg_password_confirmation" type="password" id="reg-password-confirmation" class="w-full px-3 py-2 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm transition bg-white/70 dark:bg-slate-800/70 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 shadow-sm" placeholder="Ulangi password" required>
                                </div>
                            </div>

                            <button type="submit" wire:loading.attr="disabled" class="btn-interactive active:scale-95 w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-75 disabled:cursor-not-allowed text-white font-semibold rounded-xl shadow-md shadow-emerald-500/25 transition flex items-center justify-center space-x-2 cursor-pointer">
                                <svg wire:loading wire:target="registerUser" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="registerUser">Daftar Akun</span>
                                <span wire:loading wire:target="registerUser">Mendaftarkan...</span>
                            </button>
                        </form>
                    </div>

                    <div class="mt-4 text-center text-xs sm:text-sm text-slate-700 dark:text-slate-300 font-medium">
                        Sudah memiliki akun?
                        <button type="button" @click="flipToLogin()" class="font-bold text-emerald-700 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 underline ml-1 cursor-pointer">
                            Masuk di sini ↺
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
