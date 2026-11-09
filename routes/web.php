<?php

use App\Features\Admin\Livewire\AdminUserStockList;
use App\Features\Admin\Livewire\UserList;
use App\Features\Auth\Actions\LoginUserAction;
use App\Features\Auth\Livewire\Login;
use App\Features\Auth\Livewire\Register;
use App\Features\Stock\Livewire\StockDetail;
use App\Features\Stock\Livewire\StockList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:1000-per-second'])->group(function () {
    // Root Redirection
    Route::get('/', function () {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.users')
                : redirect()->route('stocks.index');
        }
        return redirect()->route('login');
    });

    // Guest Authentication Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', Login::class)->name('login');
        Route::post('/login', function (Request $request, LoginUserAction $action) {
            $validated = $request->validate([
                'login' => ['nullable', 'string'],
                'username' => ['nullable', 'string'],
                'email' => ['nullable', 'string'],
                'password' => ['required', 'string'],
            ]);

            $identifier = $validated['username'] ?? $validated['login'] ?? $validated['email'] ?? '';

            if ($action->execute($identifier, $validated['password'], $request->boolean('remember'))) {
                $request->session()->regenerate();
                $user = Auth::user();
                if ($user && $user->isAdmin()) {
                    return redirect()->route('admin.users');
                }
                return redirect()->route('stocks.index');
            }

            return back()->withInput()->withErrors([
                'login' => 'Username/email atau password yang Anda masukkan tidak sesuai.',
            ]);
        })->name('login.post');

        Route::get('/register', Register::class)->name('register');
    });

    // Authenticated Routes
    Route::middleware('auth')->group(function () {
        Route::post('/logout', function (Request $request) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        })->name('logout');

        // Member Stock Routes protected by ownership middleware
        Route::get('/stocks', StockList::class)
            ->middleware('owns.stock')
            ->name('stocks.index');
        Route::get('/stocks/{stock}', StockDetail::class)
            ->middleware('owns.stock')
            ->name('stocks.show');

        // Kasir POS Route
        Route::get('/pos', \App\Features\Pos\Livewire\PosTerminal::class)->name('pos.index');

        // Riwayat Mutasi Stok & Audit Log Route
        Route::get('/mutations', \App\Features\Stock\Livewire\StockMutationList::class)->name('mutations.index');

        // Laporan Penjualan & Keuangan Route
        Route::get('/reports', \App\Features\Stock\Livewire\SalesReport::class)->name('reports.index');

        // Stitch Precision Bento Operations & Finance Modules
        Route::get('/purchase-orders', \App\Features\Operations\Livewire\PurchaseOrderManager::class)->name('purchase-orders.index');
        Route::get('/critical-stock', \App\Features\Stock\Livewire\CriticalStockAlert::class)->name('critical-stock.index');
        Route::get('/stock-opname', \App\Features\Operations\Livewire\StockOpnameSession::class)->name('stock-opname.index');
        Route::get('/debts', \App\Features\Finance\Livewire\CustomerDebtBook::class)->name('debts.index');
        Route::get('/returns', \App\Features\Operations\Livewire\SupplierReturnClaim::class)->name('returns.index');
        Route::get('/accounts-payable', \App\Features\Finance\Livewire\VendorPayableManager::class)->name('accounts-payable.index');
        Route::get('/stock-transfers', \App\Features\Operations\Livewire\InterBranchTransfer::class)->name('stock-transfers.index');

        // User Profile Route
        Route::get('/profile', \App\Features\Profile\Livewire\Profile::class)->name('profile');

        // Admin Routes protected by Role middleware
        Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
            Route::get('/users', UserList::class)->name('users');
            Route::get('/users/{user}/stocks', AdminUserStockList::class)->name('users.stocks');
        });
    });
});
