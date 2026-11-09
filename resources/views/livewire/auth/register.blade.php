<div class="relative w-full flex items-center justify-center min-h-[calc(100vh-2rem)] sm:min-h-[calc(100vh-4rem)] py-4 sm:py-6">
    <!-- Top-Right Theme Toggle Button (Day & Night Mode) -->
    <div class="fixed top-4 right-4 sm:top-5 sm:right-5 z-50" x-data="{
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
            class="btn-interactive active:scale-95 p-2.5 sm:p-3 rounded-2xl bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border border-slate-200 dark:border-slate-700 shadow-xl text-slate-700 dark:text-amber-400 hover:scale-110 transition-all cursor-pointer flex items-center justify-center group"
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

    <!-- 3D Interactive Flip Card Container (Starts flipped to register face) -->
    <div class="relative z-10 w-full max-w-md mx-auto my-auto px-2 sm:px-4 perspective-1100"
         x-data="{
             isFlipped: true,
             tiltX: 0,
             tiltY: 0,
             glareX: 50,
             glareY: 50,
             sheen: 0,
             handleMouseMove(e) {
                 if (window.matchMedia('(hover: none)').matches) return;
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
        <div class="absolute inset-x-6 -bottom-3 h-12 sm:h-16 rounded-3xl bg-black/40 dark:bg-black/75 blur-2xl pointer-events-none transition-all duration-700"
             :style="'transform: scaleX(' + (isFlipped ? 0.94 : 1) + '); opacity: ' + (isFlipped ? 0.35 : 0.45) + ';'"></div>

        <!-- 3D Rotor Container using CSS Grid stacking -->
        <div class="relative w-full preserve-3d flip-card-grid transition-transform duration-700 ease-[cubic-bezier(0.34,1.56,0.64,1)]"
             :style="'transform: rotateX(' + tiltX + 'deg) rotateY(' + (tiltY + (isFlipped ? 180 : 0)) + 'deg);'">

            <!-- ================= FRONT FACE: LOGIN FORM ================= -->
            <div class="flip-card-cell w-full glass-auth-card p-5 sm:p-8 rounded-3xl backface-hidden relative transition-all duration-300 flex flex-col justify-between"
                 :class="isFlipped ? 'pointer-events-none opacity-0 sm:opacity-100' : 'pointer-events-auto opacity-100'">
                <!-- Dynamic Glare Sheen -->
                <div class="absolute inset-0 pointer-events-none rounded-3xl overflow-hidden transition-opacity duration-300"
                     :style="'background: radial-gradient(circle farthest-side at ' + glareX + '% ' + glareY + '%, rgba(255, 255, 255, 0.28) 0%, rgba(255, 255, 255, 0) 75%); opacity: ' + sheen + ';'"
                     aria-hidden="true"></div>

                <div class="relative z-10 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="text-center mb-5 sm:mb-6">
                            <div class="inline-flex items-center justify-center p-2.5 sm:p-3 mb-2 bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 text-white rounded-2xl shadow-lg shadow-blue-500/25">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Masuk ke Akun Anda</h2>
                            <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 mt-1 font-medium">Kelola inventaris stok barang Anda secara teratur dan efisien</p>
                        </div>

                        <form wire:submit.prevent="authenticateUser" class="space-y-3.5 sm:space-y-4">
                            <div>
                                <label for="login-username-reg" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1">Username atau Email</label>
                                <input wire:model="login" type="text" id="login-username-reg" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-blue-500 text-base sm:text-sm transition bg-white/70 dark:bg-slate-800/80 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 shadow-sm" placeholder="username atau nama@email.com" required>
                                @error('login') <span class="text-xs text-rose-600 dark:text-rose-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="login-password-reg" class="block text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 mb-1">Password</label>
                                <input wire:model="login_password" type="password" id="login-password-reg" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-blue-500 text-base sm:text-sm transition bg-white/70 dark:bg-slate-800/80 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 shadow-sm" placeholder="••••••••" required>
                                @error('login_password') <span class="text-xs text-rose-600 dark:text-rose-400 mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <label class="flex items-center space-x-2 text-xs sm:text-sm text-slate-800 dark:text-slate-200 cursor-pointer">
                                    <input wire:model="remember" type="checkbox" class="rounded border-slate-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 bg-white dark:bg-slate-800">
                                    <span>Ingat Saya</span>
                                </label>
                            </div>

                            <button type="submit" wire:loading.attr="disabled" class="btn-interactive active:scale-95 w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 disabled:opacity-75 disabled:cursor-not-allowed text-white font-semibold rounded-xl shadow-md shadow-blue-500/25 transition flex items-center justify-center space-x-2 cursor-pointer">
                                <svg wire:loading wire:target="authenticateUser" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="authenticateUser">Masuk</span>
                                <span wire:loading wire:target="authenticateUser">Memverifikasi...</span>
                            </button>
                        </form>
                    </div>

                    <div class="mt-5 sm:mt-6 text-center text-xs sm:text-sm text-slate-700 dark:text-slate-300 font-medium">
                        Belum memiliki akun?
                        <button type="button" @click="flipToRegister()" class="font-bold text-blue-700 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline ml-1 cursor-pointer">
                            Daftar sekarang ↻
                        </button>
                    </div>
                </div>
            </div>

            <!-- ================= BACK FACE: REGISTER FORM ================= -->
            <div class="flip-card-cell w-full glass-auth-card p-5 sm:p-8 rounded-3xl backface-hidden rotate-y-180 transition-all duration-300 flex flex-col justify-between"
                 :class="!isFlipped ? 'pointer-events-none opacity-0 sm:opacity-100' : 'pointer-events-auto opacity-100'">
                <!-- Dynamic Glare Sheen -->
                <div class="absolute inset-0 pointer-events-none rounded-3xl overflow-hidden transition-opacity duration-300"
                     :style="'background: radial-gradient(circle farthest-side at ' + glareX + '% ' + glareY + '%, rgba(255, 255, 255, 0.28) 0%, rgba(255, 255, 255, 0) 75%); opacity: ' + sheen + ';'"
                     aria-hidden="true"></div>

                <div class="relative z-10 flex-1 flex flex-col justify-between">
                    <div>
                        <div class="text-center mb-3.5 sm:mb-4">
                            <div class="inline-flex items-center justify-center p-2 sm:p-2.5 mb-1.5 bg-gradient-to-tr from-emerald-600 via-teal-600 to-cyan-600 text-white rounded-2xl shadow-lg shadow-emerald-500/25">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Buat Akun Member</h1>
                            <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 mt-0.5 font-medium">Daftar sekarang untuk mulai mengelola stok barang</p>
                        </div>

                        <form wire:submit.prevent="register" class="space-y-2.5 sm:space-y-3">
                            <div class="grid grid-cols-2 gap-2 sm:gap-3">
                                <div>
                                    <label for="name" class="block text-xs font-semibold text-slate-800 dark:text-slate-200 mb-0.5 sm:mb-1">Nama Lengkap</label>
                                    <input wire:model="name" type="text" id="name" class="w-full px-2.5 sm:px-3 py-2 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm transition bg-white/70 dark:bg-slate-800/80 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 shadow-sm" placeholder="Nama Anda" required>
                                    @error('name') <span class="text-xs text-rose-600 dark:text-rose-400 mt-0.5 block font-medium">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="username" class="block text-xs font-semibold text-slate-800 dark:text-slate-200 mb-0.5 sm:mb-1">Username</label>
                                    <input wire:model="username" type="text" id="username" class="w-full px-2.5 sm:px-3 py-2 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm transition bg-white/70 dark:bg-slate-800/80 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 shadow-sm" placeholder="username" required>
                                    @error('username') <span class="text-xs text-rose-600 dark:text-rose-400 mt-0.5 block font-medium">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-semibold text-slate-800 dark:text-slate-200 mb-0.5 sm:mb-1">Email</label>
                                <input wire:model="email" type="email" id="email" class="w-full px-3 py-2 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm transition bg-white/70 dark:bg-slate-800/80 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 shadow-sm" placeholder="nama@email.com" required>
                                @error('email') <span class="text-xs text-rose-600 dark:text-rose-400 mt-0.5 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-2 sm:gap-3">
                                <div>
                                    <label for="password" class="block text-xs font-semibold text-slate-800 dark:text-slate-200 mb-0.5 sm:mb-1">Password</label>
                                    <input wire:model="password" type="password" id="password" class="w-full px-2.5 sm:px-3 py-2 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm transition bg-white/70 dark:bg-slate-800/80 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 shadow-sm" placeholder="Min. 8" required>
                                    @error('password') <span class="text-xs text-rose-600 dark:text-rose-400 mt-0.5 block font-medium">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-800 dark:text-slate-200 mb-0.5 sm:mb-1">Konfirmasi</label>
                                    <input wire:model="password_confirmation" type="password" id="password_confirmation" class="w-full px-2.5 sm:px-3 py-2 rounded-xl border border-slate-300/80 dark:border-slate-700/80 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm transition bg-white/70 dark:bg-slate-800/80 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 shadow-sm" placeholder="Ulangi" required>
                                </div>
                            </div>

                            <button type="submit" wire:loading.attr="disabled" class="btn-interactive active:scale-95 w-full py-2.5 px-4 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-75 disabled:cursor-not-allowed text-white font-semibold rounded-xl shadow-md shadow-emerald-500/25 transition flex items-center justify-center space-x-2 cursor-pointer mt-1">
                                <svg wire:loading wire:target="register" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="register">Daftar Akun</span>
                                <span wire:loading wire:target="register">Mendaftarkan...</span>
                            </button>
                        </form>
                    </div>

                    <div class="mt-3.5 sm:mt-4 text-center text-xs sm:text-sm text-slate-700 dark:text-slate-300 font-medium">
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
