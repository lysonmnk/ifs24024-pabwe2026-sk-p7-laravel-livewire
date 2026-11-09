<?php

namespace App\Features\Finance\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class VendorPayableManager extends Component
{
    public string $search = '';
    public string $statusFilter = 'all';
    public ?string $selectedInvoiceId = 'INV-AP-9901';
    public array $invoices = [];

    public function mount(): void
    {
        $this->invoices = [
            [
                'id' => 'INV-AP-9901',
                'supplier' => 'PT Salim Ivomas Pratama',
                'amount' => 63700000,
                'due_date' => '3 Hari Lagi',
                'status' => 'critical',
                'bank_account' => 'BCA 129-0091-2291 a.n PT Salim Ivomas Pratama',
                'terms' => 'TOP 30 hari',
                'items_summary' => '850 Karton Minyak Goreng Bimoli 2L',
                'invoice_date' => '10 Okt 2026',
            ],
            [
                'id' => 'INV-AP-9902',
                'supplier' => 'PT Pangan Nusantara Makmur',
                'amount' => 48000000,
                'due_date' => '12 Hari Lagi',
                'status' => 'lancar',
                'bank_account' => 'Bank Mandiri 133-00-112233-1',
                'terms' => 'TOP 14 hari',
                'items_summary' => '400 Sak Beras Ramos Super 25kg',
                'invoice_date' => '28 Okt 2026',
            ],
            [
                'id' => 'INV-AP-9903',
                'supplier' => 'CV Sumber Pangan Utama',
                'amount' => 24500000,
                'due_date' => 'Besok',
                'status' => 'critical',
                'bank_account' => 'BNI 098-1122-334 a.n Sumber Pangan',
                'terms' => 'TOP 7 hari',
                'items_summary' => '200 Karung Gula Kristal GMP 50kg',
                'invoice_date' => '02 Nov 2026',
            ],
            [
                'id' => 'INV-AP-9904',
                'supplier' => 'PT Indofood Sukses Makmur',
                'amount' => 0,
                'due_date' => 'Lunas',
                'status' => 'lunas',
                'bank_account' => 'BCA 889-1100-221 a.n Indofood',
                'terms' => 'Lunas COD',
                'items_summary' => '50 Sak Tepung Terigu Segitiga Biru',
                'invoice_date' => '05 Nov 2026',
            ],
        ];
    }

    public function selectInvoice(string $id): void
    {
        $this->selectedInvoiceId = $id;
    }

    public function payInvoice(string $id): void
    {
        foreach ($this->invoices as &$inv) {
            if ($inv['id'] === $id) {
                $inv['status'] = 'lunas';
                $inv['due_date'] = 'Lunas';
                session()->flash('success', "Pelunasan faktur vendor {$id} ({$inv['supplier']}) berhasil disahkan!");
                return;
            }
        }
    }

    public function downloadReceipt(string $id): void
    {
        session()->flash('success', "Bukti Bayar & Surat Instruksi Transfer untuk {$id} berhasil dibuat.");
    }

    public function render()
    {
        $filtered = array_filter($this->invoices, function ($inv) {
            $matchesSearch = empty($this->search) ||
                stripos($inv['id'], $this->search) !== false ||
                stripos($inv['supplier'], $this->search) !== false ||
                stripos($inv['items_summary'], $this->search) !== false;

            $matchesFilter = true;
            if ($this->statusFilter === 'critical') {
                $matchesFilter = $inv['status'] === 'critical';
            } elseif ($this->statusFilter === 'lancar') {
                $matchesFilter = $inv['status'] === 'lancar';
            } elseif ($this->statusFilter === 'lunas') {
                $matchesFilter = $inv['status'] === 'lunas';
            }

            return $matchesSearch && $matchesFilter;
        });

        $activeInvoice = null;
        foreach ($this->invoices as $inv) {
            if ($inv['id'] === $this->selectedInvoiceId) {
                $activeInvoice = $inv;
                break;
            }
        }
        if (!$activeInvoice && !empty($this->invoices)) {
            $activeInvoice = $this->invoices[0];
        }

        return view('livewire.finance.vendor-payable-manager', [
            'invoices' => $filtered,
            'activeInvoice' => $activeInvoice,
        ]);
    }
}
