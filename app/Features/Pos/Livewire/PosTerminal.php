<?php

namespace App\Features\Pos\Livewire;

use App\Features\Stock\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Kasir POS - StockBarang')]
class PosTerminal extends Component
{
    public string $search = '';
    public string $categoryFilter = '';
    public array $cart = [];
    public string $paymentMethod = 'cash';
    public string $voucherCode = 'MEMBER-SITI';
    public int $discount = 10000;
    public string $discountMessage = 'Voucher aktif: Potongan Rp 10.000';
    public int $cashTendered = 300000;
    public string $customerName = 'Toko Bu Siti';
    public string $customerType = 'Member Retail';
    public string $customerId = 'CUST-8492';
    public bool $showReceiptModal = false;
    public ?array $completedTransaction = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
    ];

    public function setCategory(string $category): void
    {
        $this->categoryFilter = $category;
    }

    public function addToCart(int $stockId): void
    {
        $stock = Stock::where('user_id', Auth::id())->find($stockId);

        if (!$stock) {
            session()->flash('error', 'Produk tidak ditemukan.');
            return;
        }

        if ($stock->quantity <= 0) {
            session()->flash('error', 'Stok produk ini sedang habis.');
            return;
        }

        if (isset($this->cart[$stockId])) {
            if ($this->cart[$stockId]['quantity'] < $stock->quantity) {
                $this->cart[$stockId]['quantity']++;
                $this->cart[$stockId]['subtotal'] = $this->cart[$stockId]['quantity'] * $this->cart[$stockId]['price'];
            } else {
                session()->flash('error', "Maksimum stok fisik tercapai ({$stock->quantity} {$stock->unit}).");
            }
        } else {
            $this->cart[$stockId] = [
                'id' => $stock->id,
                'name' => $stock->name,
                'sku' => $stock->sku ?? ('SKU-' . strtoupper(substr($stock->category ?? 'GEN', 0, 3)) . '-' . str_pad((string)$stock->id, 2, '0', STR_PAD_LEFT)),
                'category' => $stock->category ?? 'Umum',
                'price' => (int) $stock->price,
                'unit' => $stock->unit ?? 'pcs',
                'quantity' => 1,
                'stock' => (int) $stock->quantity,
                'subtotal' => (int) $stock->price,
            ];
        }

        $this->recalculateTender();
    }

    public function incrementQty(int $stockId): void
    {
        if (isset($this->cart[$stockId])) {
            if ($this->cart[$stockId]['quantity'] < $this->cart[$stockId]['stock']) {
                $this->cart[$stockId]['quantity']++;
                $this->cart[$stockId]['subtotal'] = $this->cart[$stockId]['quantity'] * $this->cart[$stockId]['price'];
                $this->recalculateTender();
            } else {
                session()->flash('error', 'Jumlah melebihi stok yang tersedia.');
            }
        }
    }

    public function decrementQty(int $stockId): void
    {
        if (isset($this->cart[$stockId])) {
            if ($this->cart[$stockId]['quantity'] > 1) {
                $this->cart[$stockId]['quantity']--;
                $this->cart[$stockId]['subtotal'] = $this->cart[$stockId]['quantity'] * $this->cart[$stockId]['price'];
                $this->recalculateTender();
            } else {
                $this->removeFromCart($stockId);
            }
        }
    }

    public function updateQty(int $stockId, int $qty): void
    {
        if (isset($this->cart[$stockId])) {
            $clampedQty = max(1, min($qty, $this->cart[$stockId]['stock']));
            $this->cart[$stockId]['quantity'] = $clampedQty;
            $this->cart[$stockId]['subtotal'] = $clampedQty * $this->cart[$stockId]['price'];
            $this->recalculateTender();
        }
    }

    public function removeFromCart(int $stockId): void
    {
        unset($this->cart[$stockId]);
        $this->recalculateTender();
    }

    public function clearCart(): void
    {
        $this->cart = [];
        $this->discount = 0;
        $this->discountMessage = '';
        $this->voucherCode = '';
        $this->cashTendered = 0;
        session()->flash('success', 'Keranjang kasir berhasil dikosongkan.');
    }

    public function applyVoucher(): void
    {
        $code = strtoupper(trim($this->voucherCode));

        if ($code === 'MEMBER-SITI' || $code === 'DISKON10') {
            $this->discount = 10000;
            $this->discountMessage = 'Voucher aktif: Potongan Rp 10.000';
            session()->flash('success', $this->discountMessage);
        } elseif ($code === 'HEMAT20') {
            $this->discount = 20000;
            $this->discountMessage = 'Voucher aktif: Potongan Rp 20.000';
            session()->flash('success', $this->discountMessage);
        } elseif ($code === '') {
            $this->discount = 0;
            $this->discountMessage = '';
        } else {
            session()->flash('error', 'Kode voucher tidak valid.');
        }

        $this->recalculateTender();
    }

    public function setPaymentMethod(string $method): void
    {
        $this->paymentMethod = in_array($method, ['cash', 'qris', 'bon']) ? $method : 'cash';
    }

    public function quickCash(int $amount): void
    {
        $this->cashTendered = $amount;
    }

    public function payExact(): void
    {
        $subtotal = array_sum(array_column($this->cart, 'subtotal'));
        $total = max(0, $subtotal - $this->discount);
        $this->cashTendered = $total;
    }

    private function recalculateTender(): void
    {
        $subtotal = array_sum(array_column($this->cart, 'subtotal'));
        $total = max(0, $subtotal - $this->discount);
        if ($this->cashTendered < $total && $total > 0) {
            // suggest rounded up to nearest 10.000
            $this->cashTendered = (int) (ceil($total / 10000) * 10000);
        }
    }

    public function checkout(): void
    {
        if (empty($this->cart)) {
            session()->flash('error', 'Keranjang kasir masih kosong. Silakan tambahkan barang terlebih dahulu.');
            return;
        }

        $subtotal = array_sum(array_column($this->cart, 'subtotal'));
        $total = max(0, $subtotal - $this->discount);

        if ($this->paymentMethod === 'cash' && $this->cashTendered < $total && $total > 0) {
            session()->flash('error', 'Nominal tunai yang diserahkan kurang dari total tagihan.');
            return;
        }

        try {
            DB::transaction(function () {
                foreach ($this->cart as $item) {
                    $stock = Stock::where('user_id', Auth::id())
                        ->lockForUpdate()
                        ->find($item['id']);

                    if (!$stock || $stock->quantity < $item['quantity']) {
                        throw new \RuntimeException("Stok '{$item['name']}' tidak mencukupi untuk checkout.");
                    }

                    $stock->decrement('quantity', $item['quantity']);
                }
            });
        } catch (\Throwable $e) {
            session()->flash('error', 'Gagal memproses transaksi: ' . $e->getMessage());
            return;
        }

        $cashTendered = $this->cashTendered > 0 ? $this->cashTendered : $total;
        $change = max(0, $cashTendered - $total);

        $this->completedTransaction = [
            'trx_id' => 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(4)),
            'time' => now()->translatedFormat('H:i') . ' WIB',
            'date' => now()->translatedFormat('d M Y'),
            'customer' => $this->customerName,
            'customer_type' => $this->customerType,
            'customer_id' => $this->customerId,
            'cashier' => Auth::user()->name,
            'items' => array_values($this->cart),
            'subtotal' => $subtotal,
            'discount' => $this->discount,
            'tax' => 0,
            'total' => $total,
            'payment_method' => $this->paymentMethod,
            'cash_tendered' => $cashTendered,
            'change' => $change,
        ];

        $this->showReceiptModal = true;
        $this->cart = [];
        $this->discount = 0;
        $this->discountMessage = '';
        $this->voucherCode = '';
        $this->cashTendered = 0;

        session()->flash('success', 'Transaksi Kasir POS berhasil diselesaikan!');
    }

    public function closeReceipt(): void
    {
        $this->showReceiptModal = false;
        $this->completedTransaction = null;
    }

    public function render()
    {
        $query = Stock::where('user_id', Auth::id());

        if (!empty($this->search)) {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', $term)
                    ->orWhere('category', 'like', $term)
                    ->orWhere('supplier', 'like', $term)
                    ->orWhere('rack_location', 'like', $term);
            });
        }

        if (!empty($this->categoryFilter)) {
            $query->where('category', $this->categoryFilter);
        }

        $catalogStocks = $query->latest()->take(12)->get();

        $subtotal = array_sum(array_column($this->cart, 'subtotal'));
        $totalQty = array_sum(array_column($this->cart, 'quantity'));
        $total = max(0, $subtotal - $this->discount);
        $change = max(0, $this->cashTendered - $total);

        // Predefined popular categories
        $categories = ['Sembako', 'Minuman', 'Bumbu Dapur', 'Snack', 'Alat Tulis', 'Kebutuhan Rumah'];

        return view('livewire.pos.pos-terminal', [
            'catalogStocks' => $catalogStocks,
            'subtotal' => $subtotal,
            'totalQty' => $totalQty,
            'total' => $total,
            'change' => $change,
            'categories' => $categories,
        ]);
    }
}
