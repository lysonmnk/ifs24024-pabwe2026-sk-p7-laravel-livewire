<?php

namespace App\Features\Operations\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class InterBranchTransfer extends Component
{
    public string $search = '';
    public string $statusFilter = 'all';
    public ?string $selectedTransferId = 'TRF-2026-001';
    public array $transfers = [];

    public function mount(): void
    {
        $this->transfers = [
            [
                'id' => 'TRF-2026-001',
                'from_branch' => 'Gudang Pusat Cakung (DC-1)',
                'to_branch' => 'Cabang Bekasi Timur (ST-04)',
                'item_summary' => 'Minyak Bimoli 2L (200 Ctn) + Beras Ramos (100 Sak)',
                'fleet' => 'Armada Truk Box B 9182 KXA',
                'driver' => 'Pak Rudi Hartono (0812-4411-99xx)',
                'departure_time' => '13:00 WIB',
                'eta' => '16:30 WIB (Hari Ini)',
                'status' => 'in_transit',
                'seal_number' => 'SEGEL-DC1-9921',
                'progress' => '70%',
            ],
            [
                'id' => 'TRF-2026-002',
                'from_branch' => 'Gudang Pusat Cakung (DC-1)',
                'to_branch' => 'Cabang Tambun Selatan (ST-02)',
                'item_summary' => 'Gula Kristal Putih GMP (80 Karung 50kg)',
                'fleet' => 'Pickup Daihatsu GranMax B 9021 UT',
                'driver' => 'Pak Dedi (0856-7788-11xx)',
                'departure_time' => '15:15 WIB',
                'eta' => '17:45 WIB',
                'status' => 'persiapan',
                'seal_number' => 'SEGEL-DC1-9922',
                'progress' => '25%',
            ],
            [
                'id' => 'TRF-2026-003',
                'from_branch' => 'Cabang Cikarang Barat (ST-05)',
                'to_branch' => 'Cabang Bekasi Timur (ST-04)',
                'item_summary' => 'Telur Ayam Ras Fresh Blitar (60 Tray)',
                'fleet' => 'Blindvan Isuzu Traga B 8821 PO',
                'driver' => 'Pak Agus (0813-2233-44xx)',
                'departure_time' => '09:00 WIB',
                'eta' => '11:15 WIB (Tiba)',
                'status' => 'diterima',
                'seal_number' => 'SEGEL-ST5-0144',
                'progress' => '100%',
            ],
        ];
    }

    public function selectTransfer(string $id): void
    {
        $this->selectedTransferId = $id;
    }

    public function confirmArrival(string $id): void
    {
        foreach ($this->transfers as &$t) {
            if ($t['id'] === $id) {
                $t['status'] = 'diterima';
                $t['progress'] = '100%';
                session()->flash('success', "Penerimaan mutasi stok {$id} telah dikonfirmasi oleh kepala gudang cabang tujuan!");
                return;
            }
        }
    }

    public function downloadSuratJalan(string $id): void
    {
        session()->flash('success', "Surat Jalan Mutasi Cabang {$id} berhasil diunduh.");
    }

    public function render()
    {
        $filtered = array_filter($this->transfers, function ($t) {
            $matchesSearch = empty($this->search) ||
                stripos($t['id'], $this->search) !== false ||
                stripos($t['from_branch'], $this->search) !== false ||
                stripos($t['to_branch'], $this->search) !== false ||
                stripos($t['item_summary'], $this->search) !== false;

            $matchesFilter = $this->statusFilter === 'all' || $t['status'] === $this->statusFilter;

            return $matchesSearch && $matchesFilter;
        });

        $activeTransfer = null;
        foreach ($this->transfers as $t) {
            if ($t['id'] === $this->selectedTransferId) {
                $activeTransfer = $t;
                break;
            }
        }
        if (!$activeTransfer && !empty($this->transfers)) {
            $activeTransfer = $this->transfers[0];
        }

        return view('livewire.operations.inter-branch-transfer', [
            'transfers' => $filtered,
            'activeTransfer' => $activeTransfer,
        ]);
    }
}
