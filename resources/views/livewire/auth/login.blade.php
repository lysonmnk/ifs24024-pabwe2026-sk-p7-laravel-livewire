<div class="relative w-full flex items-center justify-center">
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

    <!-- Foreground Login Form Card (Adapts to Light & Dark Theme) -->
    <div class="relative z-10 w-full max-w-md mx-auto my-4 p-8 rounded-3xl bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl shadow-2xl border border-white/80 dark:border-slate-800 ring-1 ring-slate-900/5 dark:ring-white/10 transition-colors duration-300">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center p-3 mb-3 bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 text-white rounded-2xl shadow-lg shadow-blue-500/25">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Masuk ke Akun Anda</h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Kelola inventaris stok barang Anda secara teratur dan efisien</p>
        </div>

        <form wire:submit.prevent="authenticate" action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="login-username" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Username atau Email</label>
                <input wire:model="login" type="text" name="username" id="login-username" autocomplete="username" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent text-sm transition bg-white/90 dark:bg-slate-800/90 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500" placeholder="username atau nama@email.com" required>
                @error('login') <span class="text-xs text-rose-600 dark:text-rose-400 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="login-password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Password</label>
                <input wire:model="password" type="password" name="password" id="login-password" autocomplete="current-password" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 dark:border-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent text-sm transition bg-white/90 dark:bg-slate-800/90 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500" placeholder="••••••••" required>
                @error('password') <span class="text-xs text-rose-600 dark:text-rose-400 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer">
                    <input wire:model="remember" type="checkbox" name="remember" class="rounded border-slate-300 dark:border-slate-700 text-blue-600 focus:ring-blue-500 bg-white dark:bg-slate-800">
                    <span>Ingat Saya</span>
                </label>
            </div>

            <button type="submit" id="login-submit" wire:loading.attr="disabled" class="btn-interactive active:scale-95 w-full py-2.5 px-4 bg-blue-600 hover:bg-blue-700 disabled:opacity-75 disabled:cursor-not-allowed text-white font-semibold rounded-xl shadow-md shadow-blue-500/20 transition flex items-center justify-center space-x-2">
                <svg wire:loading wire:target="authenticate" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span wire:loading.remove wire:target="authenticate">Masuk</span>
                <span wire:loading wire:target="authenticate">Memverifikasi...</span>
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="font-semibold text-blue-700 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline">Daftar sekarang</a>
        </div>
    </div>
</div>
