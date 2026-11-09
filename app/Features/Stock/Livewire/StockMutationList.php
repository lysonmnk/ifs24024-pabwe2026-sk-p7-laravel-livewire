<?php

namespace App\Features\Stock\Livewire;

use App\Features\Stock\Models\Stock;
use App\Features\Stock\Models\StockMutation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('components.layouts.app')]
#[Title('Riwayat Mutasi Stok & Audit Log - StockBarang')]
class StockMutationList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $typeFilter = 'all';

    protected $queryString = [
        'search' => ['except' => ''],
        'typeFilter' => ['except' => 'all'],
    ];

    public function setFilter(string $type): void
    {
        $this->typeFilter = $type;
        $this->resetPage();
    }

    public function exportAuditLog(): StreamedResponse
    {
        $userId = Auth::id();
        $query = StockMutation::with('stock')
            ->where('user_id', $userId)
            ->latest();

        if ($this->typeFilter !== 'all') {
            $query->where('type', $this->typeFilter);
        }

        if (!empty($this->search)) {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('batch_no', 'like', $term)
                    ->orWhere('notes', 'like', $term)
                    ->orWhereHas('stock', function ($sq) use ($term) {
                        $sq->where('name', 'like', $term)
                           ->orWhere('sku', 'like', $term);
                    });
            });
        }

        $mutations = $query->get();

        $filename = 'audit-log-mutasi-' . date('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($mutations) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Waktu Audit', 'No Batch', 'Nama Barang', 'SKU', 'Tipe Alur', 'Perubahan Qty', 'Saldo Akhir', 'Catatan']);

            foreach ($mutations as $m) {
                fputcsv($handle, [
                    $m->id,
                    $m->created_at ? $m->created_at->format('Y-m-d H:i:s') : '-',
                    $m->batch_no,
                    $m->stock?->name ?? 'Penyesuaian Sistem',
                    $m->stock?->sku ?? '-',
                    strtoupper($m->type),
                    $m->quantity > 0 ? '+' . $m->quantity : $m->quantity,
                    $m->balance_after,
                    $m->notes ?? '-',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function ensureDemoMutationsExist(int $userId): void
    {
        if (StockMutation::where('user_id', $userId)->count() === 0) {
            $stocks = Stock::where('user_id', $userId)->take(4)->get();
            if ($stocks->isNotEmpty()) {
                $batchId = 'MUT-2026-884';
                foreach ($stocks as $idx => $s) {
                    StockMutation::create([
                        'user_id' => $userId,
                        'stock_id' => $s->id,
                        'batch_no' => '#' . $batchId,
                        'type' => $idx % 2 === 0 ? 'in' : 'out',
                        'quantity' => $idx % 2 === 0 ? 50 : -5,
                        'balance_after' => $s->quantity,
                        'notes' => $idx % 2 === 0 ? 'Penerimaan PO Supplier Wilayah Jakarta' : 'Penjualan Kasir POS Shift Pagi',
                        'created_at' => now()->subMinutes(($idx + 1) * 12),
                    ]);
                }
            }
        }
    }

    public function render()
    {
        $userId = Auth::id();
        $this->ensureDemoMutationsExist($userId);

        $query = StockMutation::with('stock')
            ->where('user_id', $userId)
            ->latest();

        if ($this->typeFilter !== 'all') {
            $query->where('type', $this->typeFilter);
        }

        if (!empty($this->search)) {
            $term = '%' . $this->search . '%';
            $query->where(function ($q) use ($term) {
                $q->where('batch_no', 'like', $term)
                    ->orWhere('notes', 'like', $term)
                    ->orWhereHas('stock', function ($sq) use ($term) {
                        $sq->where('name', 'like', $term)
                           ->orWhere('sku', 'like', $term);
                    });
            });
        }

        $mutations = $query->paginate(8);

        $totalCount = StockMutation::where('user_id', $userId)->count();
        $netAdd = StockMutation::where('user_id', $userId)->where('quantity', '>', 0)->sum('quantity');

        return view('livewire.stock.stock-mutation-list', [
            'mutations' => $mutations,
            'totalCount' => $totalCount,
            'netAdd' => $netAdd,
        ]);
    }
}
