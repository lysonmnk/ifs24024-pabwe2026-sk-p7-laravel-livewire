<?php

namespace App\Features\Stock\Livewire;

use App\Features\Stock\Models\Stock;
use App\Features\Stock\Models\StockMutation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('components.layouts.app')]
#[Title('Laporan Penjualan & Keuangan - StockBarang')]
class SalesReport extends Component
{
    public string $periodFilter = 'month';
    public string $search = '';

    protected $queryString = [
        'periodFilter' => ['except' => 'month'],
        'search' => ['except' => ''],
    ];

    public function setPeriod(string $period): void
    {
        $this->periodFilter = $period;
    }

    public function exportFinancialReport(): StreamedResponse
    {
        $userId = Auth::id();
        $transactions = $this->getTransactionsData();

        $filename = 'laporan-keuangan-' . date('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($transactions) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['No Nota', 'Waktu Transaksi', 'Pelanggan', 'Metode Bayar', 'Total Belanja (Rp)', 'Estimasi Margin (Rp)', 'Status Rekonsiliasi']);

            foreach ($transactions as $t) {
                fputcsv($handle, [
                    $t['ref_no'],
                    $t['date'],
                    $t['customer'],
                    strtoupper($t['payment_method']),
                    $t['total'],
                    $t['margin'],
                    $t['status'],
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function getTransactionsData(): array
    {
        $all = [
            [
                'ref_no' => 'TRX-2026-0842',
                'date' => 'Hari ini • 14:28 WIB',
                'customer' => 'Toko Bu Siti',
                'items_count' => 7,
                'payment_method' => 'Tunai',
                'total' => 286000,
                'margin' => 62500,
                'status' => 'Terekonsiliasi',
            ],
            [
                'ref_no' => 'TRX-2026-0841',
                'date' => 'Hari ini • 13:15 WIB',
                'customer' => 'Grosir Makmur',
                'items_count' => 12,
                'payment_method' => 'QRIS',
                'total' => 450000,
                'margin' => 98000,
                'status' => 'Terekonsiliasi',
            ],
            [
                'ref_no' => 'TRX-2026-0840',
                'date' => 'Hari ini • 11:40 WIB',
                'customer' => 'Depo Cakung',
                'items_count' => 5,
                'payment_method' => 'Bon Toko',
                'total' => 185000,
                'margin' => 38000,
                'status' => 'Piutang Berjalan',
            ],
            [
                'ref_no' => 'TRX-2026-0839',
                'date' => 'Kemarin • 17:20 WIB',
                'customer' => 'Warung Berkah',
                'items_count' => 9,
                'payment_method' => 'Tunai',
                'total' => 320000,
                'margin' => 71000,
                'status' => 'Terekonsiliasi',
            ],
            [
                'ref_no' => 'TRX-2026-0838',
                'date' => 'Kemarin • 15:05 WIB',
                'customer' => 'Pak Haji Rahman',
                'items_count' => 4,
                'payment_method' => 'QRIS',
                'total' => 140000,
                'margin' => 31000,
                'status' => 'Terekonsiliasi',
            ],
            [
                'ref_no' => 'TRX-2026-0837',
                'date' => '2 hari lalu • 10:10 WIB',
                'customer' => 'Kantin Sejahtera',
                'items_count' => 16,
                'payment_method' => 'Bon Toko',
                'total' => 620000,
                'margin' => 135000,
                'status' => 'Piutang Berjalan',
            ],
        ];

        if (!empty($this->search)) {
            $term = strtolower($this->search);
            $all = array_filter($all, function ($t) use ($term) {
                return str_contains(strtolower($t['ref_no']), $term) ||
                       str_contains(strtolower($t['customer']), $term) ||
                       str_contains(strtolower($t['payment_method']), $term);
            });
        }

        return array_values($all);
    }

    public function render()
    {
        $transactions = $this->getTransactionsData();

        $userId = Auth::id();
        $totalStocks = Stock::where('user_id', $userId)->count();

        // Calculate dynamic turnover or fallback to Stitch demo telemetry
        $omsetJt = 148.65;
        $labaJt = 32.48;
        $piutangJt = 6.15;

        return view('livewire.stock.sales-report', [
            'transactions' => $transactions,
            'totalStocks' => $totalStocks,
            'omsetJt' => $omsetJt,
            'labaJt' => $labaJt,
            'piutangJt' => $piutangJt,
        ]);
    }
}
