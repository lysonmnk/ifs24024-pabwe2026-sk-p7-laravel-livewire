<?php

namespace App\Features\Operations\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class SupplierReturnClaim extends Component
{
    public string $search = '';
    public string $statusFilter = 'all';
    public ?string $selectedClaimId = 'BAP-2026-081';
    public array $claims = [];

    public function mount(): void
    {
        $this->claims = [
            [
                'id' => 'BAP-2026-081',
                'supplier' => 'PT Salim Ivomas Pratama',
                'item_name' => 'Minyak Bimoli 2L',
                'quantity' => 24,
                'unit' => 'Pouch',
                'reason' => 'Karton Basah & Bocor',
                'claim_amount' => 'Rp 888.000',
                'status' => 'diproses',
                'contact' => 'Pak Dimas (0812-3344-55xx)',
                'evidence' => '3 Foto QC & Berita Acara Sopir',
                'compensation_type' => 'Potong Faktur PO Berikutnya',
                'date' => '07 Nov 2026',
            ],
            [
                'id' => 'BAP-2026-082',
                'supplier' => 'PT Indofood CBP Sukses Makmur',
                'item_name' => 'Indomie Kuah Kari Ayam',
                'quantity' => 15,
                'unit' => 'Dus',
                'reason' => 'Kemasan Sobek Benturan Truk',
                'claim_amount' => 'Rp 450.000',
                'status' => 'disetujui',
                'contact' => 'Bu Maya (0811-9988-77xx)',
                'evidence' => 'Nota Tanda Terima Ekspedisi',
                'compensation_type' => 'Retur Fisik Pengganti 1:1',
                'date' => '05 Nov 2026',
            ],
            [
                'id' => 'BAP-2026-083',
                'supplier' => 'CV Sumber Unggas Lestari',
                'item_name' => 'Telur Ayam Ras Fresh Blitar',
                'quantity' => 10,
                'unit' => 'Tray',
                'reason' => 'Pecah Cangkang Saat Pengiriman',
                'claim_amount' => 'Rp 280.000',
                'status' => 'selesai',
                'contact' => 'Pak H. Munir (0852-6677-88xx)',
                'evidence' => 'Foto QC Saat Bongkar Dok C',
                'compensation_type' => 'Pengembalian Dana Cash/Transfer',
                'date' => '01 Nov 2026',
            ],
        ];
    }

    public function selectClaim(string $id): void
    {
        $this->selectedClaimId = $id;
    }

    public function approveClaim(string $id): void
    {
        foreach ($this->claims as &$c) {
            if ($c['id'] === $id) {
                $c['status'] = 'disetujui';
                session()->flash('success', "Klaim {$id} ({$c['item_name']}) telah disetujui oleh principal vendor.");
                return;
            }
        }
    }

    public function completeClaim(string $id): void
    {
        foreach ($this->claims as &$c) {
            if ($c['id'] === $id) {
                $c['status'] = 'selesai';
                session()->flash('success', "Penyelesaian klaim {$id} berhasil! Kompensasi telah dicatat.");
                return;
            }
        }
    }

    public function generateBAP(string $id): void
    {
        session()->flash('success', "Dokumen Berita Acara Pemeriksaan (BAP) untuk {$id} berhasil diunduh.");
    }

    public function render()
    {
        $filtered = array_filter($this->claims, function ($c) {
            $matchesSearch = empty($this->search) ||
                stripos($c['id'], $this->search) !== false ||
                stripos($c['supplier'], $this->search) !== false ||
                stripos($c['item_name'], $this->search) !== false;

            $matchesFilter = $this->statusFilter === 'all' || $c['status'] === $this->statusFilter;

            return $matchesSearch && $matchesFilter;
        });

        $activeClaim = null;
        foreach ($this->claims as $c) {
            if ($c['id'] === $this->selectedClaimId) {
                $activeClaim = $c;
                break;
            }
        }
        if (!$activeClaim && !empty($this->claims)) {
            $activeClaim = $this->claims[0];
        }

        return view('livewire.operations.supplier-return-claim', [
            'claims' => $filtered,
            'activeClaim' => $activeClaim,
        ]);
    }
}
