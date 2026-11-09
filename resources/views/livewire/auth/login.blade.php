<div class="relative w-full flex items-center justify-center">
    <!-- React Island: GridMotion 3D Ambient Background -->
    <div id="grid-motion-root" wire:ignore class="absolute inset-0 -top-24 -bottom-24 w-full h-[calc(100%+12rem)] z-0 pointer-events-auto opacity-80" aria-hidden="true"></div>

    <!-- Foreground Login Form Card -->
    <div class="relative z-10 w-full max-w-md mx-auto my-4 p-8 rounded-3xl bg-white/95 backdrop-blur-xl shadow-2xl border border-white/80 ring-1 ring-slate-900/5">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center p-3 mb-3 bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 text-white rounded-2xl shadow-lg shadow-blue-500/25">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Masuk ke Akun Anda</h1>
            <p class="text-sm text-slate-600 mt-1">Kelola inventaris stok barang Anda secara teratur dan efisien</p>
        </div>

        <form wire:submit.prevent="authenticate" action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="login-username" class="block text-sm font-semibold text-slate-700 mb-1">Username atau Email</label>
                <input wire:model="login" type="text" name="username" id="login-username" autocomplete="username" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition bg-white/90" placeholder="username atau nama@email.com" required>
                @error('login') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="login-password" class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                <input wire:model="password" type="password" name="password" id="login-password" autocomplete="current-password" class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition bg-white/90" placeholder="••••••••" required>
                @error('password') <span class="text-xs text-rose-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center space-x-2 text-sm text-slate-700 cursor-pointer">
                    <input wire:model="remember" type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
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

        <div class="mt-6 text-center text-sm text-slate-600">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="font-semibold text-blue-700 hover:text-blue-800 underline">Daftar sekarang</a>
        </div>
    </div>
</div>
