<?php

namespace App\Features\Finance\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class CustomerDebtBook extends Component
{
    public string $search = '';
    public string $statusFilter = 'all';
    public ?string $selectedBonId = 'BON-2026-081';
    public int $paymentAmount = 0;
    public array $customers = [];

    public function mount(): void
    {
        $this->customers = [
            [
                'id' => 'BON-2026-081',
                'name' => 'Toko Kelontong Berkah Ibu',
                'owner' => 'Ibu Siti Rahmah',
                'phone' => '0812-8822-1922',
                'address' => 'Jl. Merak No. 14, Tambun Selatan',
                'credit_limit' => 15000000,
                'current_debt' => 8450000,
                'due_date' => '3 Hari Lagi',
                'status' => 'lancar',
                'last_transaction' => '12 Karton Minyak Bimoli + 5 Sak Beras',
                'last_payment_date' => '02 Nov 2026',
            ],
            [
                'id' => 'BON-2026-082',
                'name' => 'Warung Madura Barokah 24 Jam',
                'owner' => 'Cak Slamet',
                'phone' => '0877-9911-3344',
                'address' => 'Jl. KH Noer Ali No. 8, Kalimalang',
                'credit_limit' => 10000000,
                'current_debt' => 9420000,
                'due_date' => 'Lewat 5 Hari',
                'status' => 'overdue',
                'last_transaction' => '20 Dus Indomie Goreng + 10 Dus Telur',
                'last_payment_date' => '24 Okt 2026',
            ],
            [
                'id' => 'BON-2026-083',
                'name' => 'Toko Sembako Jaya Abadi',
                'owner' => 'Pak Joko Santoso',
                'phone' => '0813-1122-8899',
                'address' => 'Pasar Induk Cibitung Blok C-12',
                'credit_limit' => 20000000,
                'current_debt' => 4200000,
                'due_date' => '14 Hari Lagi',
                'status' => 'lancar',
                'last_transaction' => '8 Sak Gula GMP 50kg',
                'last_payment_date' => '05 Nov 2026',
            ],
            [
                'id' => 'BON-2026-084',
                'name' => 'Depot Jamu & Kelontong Segar Waras',
                'owner' => 'Ibu Endang Lestari',
                'phone' => '0856-7788-9900',
                'address' => 'Jl. Cut Meutia No. 44, Bekasi Timur',
                'credit_limit' => 5000000,
                'current_debt' => 0,
                'due_date' => 'Lunas',
                'status' => 'paid',
                'last_transaction' => 'Pelunasan Bon Kasir #TX-901',
                'last_payment_date' => '08 Nov 2026',
            ],
        ];
    }

    public function selectCustomer(string $id): void
    {
        $this->selectedBonId = $id;
    }

    public function recordPayment(string $id): void
    {
        $amount = max(0, $this->paymentAmount);
        if ($amount <= 0) {
            session()->flash('error', 'Masukkan nominal pembayaran kasbon yang valid.');
            return;
        }

        foreach ($this->customers as &$c) {
            if ($c['id'] === $id) {
                $c['current_debt'] = max(0, $c['current_debt'] - $amount);
                if ($c['current_debt'] === 0) {
                    $c['status'] = 'paid';
                    $c['due_date'] = 'Lunas';
                }
                session()->flash('success', "Pembayaran sebesar Rp " . number_format($amount, 0, ',', '.') . " untuk {$c['name']} berhasil dicatat!");
                $this->paymentAmount = 0;
                return;
            }
        }
    }

    public function exportDebtCard(string $id): void
    {
        session()->flash('success', "Kartu Piutang & Surat Tagihan untuk {$id} berhasil dibuat dan siap dicetak.");
    }

    public function render()
    {
        $filtered = array_filter($this->customers, function ($c) {
            $matchesSearch = empty($this->search) ||
                stripos($c['name'], $this->search) !== false ||
                stripos($c['owner'], $this->search) !== false ||
                stripos($c['phone'], $this->search) !== false ||
                stripos($c['id'], $this->search) !== false;

            $matchesFilter = true;
            if ($this->statusFilter === 'overdue') {
                $matchesFilter = $c['status'] === 'overdue';
            } elseif ($this->statusFilter === 'paid') {
                $matchesFilter = $c['status'] === 'paid';
            } elseif ($this->statusFilter === 'critical_limit') {
                $matchesFilter = ($c['current_debt'] / max(1, $c['credit_limit'])) >= 0.8;
            }

            return $matchesSearch && $matchesFilter;
        });

        $activeCustomer = null;
        foreach ($this->customers as $c) {
            if ($c['id'] === $this->selectedBonId) {
                $activeCustomer = $c;
                break;
            }
        }
        if (!$activeCustomer && !empty($this->customers)) {
            $activeCustomer = $this->customers[0];
        }

        return view('livewire.finance.customer-debt-book', [
            'customers' => $filtered,
            'activeCustomer' => $activeCustomer,
        ]);
    }
}
