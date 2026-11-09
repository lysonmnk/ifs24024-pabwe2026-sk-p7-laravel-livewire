<?php

namespace App\Features\Operations\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class PurchaseOrderManager extends Component
{
    public string $search = '';
    public string $statusFilter = 'all';
    public ?string $selectedPoId = 'PO-2026-1092';
    public array $purchaseOrders = [];

    public function mount(): void
    {
        $this->purchaseOrders = [
            [
                'id' => 'PO-2026-1092',
                'supplier' => 'PT Salim Ivomas Pratama',
                'item_name' => 'Minyak Bimoli 2L',
                'packaging' => 'Karton Segel Utuh',
                'ordered_qty' => 850,
                'received_qty' => 848,
                'damaged_qty' => 2,
                'unit' => 'ctn',
                'status' => 'pengecekan_fisik',
                'truck' => 'Armada Truk Hino B 9421 KXT',
                'driver' => 'Pak Slamet (0812-9921-88xx)',
                'dock' => 'Dok #B-04',
                'arrival_time' => '14:15 WIB',
                'invoice_amount' => 'Rp 63.7 Jt',
                'payment_terms' => 'TOP 30 hari',
                'priority' => 'Prioritas 1',
            ],
            [
                'id' => 'PO-2026-1093',
                'supplier' => 'PT Pangan Nusantara Makmur',
                'item_name' => 'Beras Ramos Super',
                'packaging' => 'Sak 25kg Segel',
                'ordered_qty' => 400,
                'received_qty' => 0,
                'damaged_qty' => 0,
                'unit' => 'sak',
                'status' => 'menunggu_truk',
                'truck' => 'Isuzu Giga D 8821 PO',
                'driver' => 'Pak Ujang (0856-1122-33xx)',
                'dock' => 'Dok #A-02',
                'arrival_time' => '15:30 WIB',
                'invoice_amount' => 'Rp 48.0 Jt',
                'payment_terms' => 'TOP 14 hari',
                'priority' => 'Reguler',
            ],
            [
                'id' => 'PO-2026-1094',
                'supplier' => 'PT Indofood Sukses Makmur',
                'item_name' => 'Tepung Terigu Segitiga',
                'packaging' => 'Sak 25kg',
                'ordered_qty' => 50,
                'received_qty' => 50,
                'damaged_qty' => 0,
                'unit' => 'sak',
                'status' => 'diterima_lengkap',
                'truck' => 'Mitsubishi Fuso B 9112 JKL',
                'driver' => 'Pak Hendra (0813-4455-66xx)',
                'dock' => 'Dok #B-02',
                'arrival_time' => '11:20 WIB',
                'invoice_amount' => 'Rp 12.5 Jt',
                'payment_terms' => 'Lunas COD',
                'priority' => 'Reguler',
            ],
            [
                'id' => 'PO-2026-1088',
                'supplier' => 'CV Sumber Pangan Utama',
                'item_name' => 'Gula Kristal Putih GMP',
                'packaging' => 'Karung 50kg',
                'ordered_qty' => 200,
                'received_qty' => 185,
                'damaged_qty' => 15,
                'unit' => 'kg',
                'status' => 'selisih_klaim',
                'truck' => 'Daihatsu GranMax B 9022 QW',
                'driver' => 'Pak Yayan (0877-3344-55xx)',
                'dock' => 'Dok #C-01',
                'arrival_time' => '09:40 WIB',
                'invoice_amount' => 'Rp 24.5 Jt',
                'payment_terms' => 'TOP 7 hari',
                'priority' => 'Klaim Retur',
            ],
        ];
    }

    public function selectPo(string $id): void
    {
        $this->selectedPoId = $id;
    }

    public function filterStatus(string $status): void
    {
        $this->statusFilter = $status;
    }

    public function startUnloading(string $id): void
    {
        foreach ($this->purchaseOrders as &$po) {
            if ($po['id'] === $id) {
                $po['status'] = 'pengecekan_fisik';
                $po['received_qty'] = $po['ordered_qty'];
                session()->flash('success', "Proses bongkar muat untuk {$id} ({$po['item_name']}) telah dimulai.");
                $this->selectedPoId = $id;
                return;
            }
        }
    }

    public function verifyAndReceive(string $id): void
    {
        foreach ($this->purchaseOrders as &$po) {
            if ($po['id'] === $id) {
                $po['status'] = 'diterima_lengkap';
                session()->flash('success', "Purchase Order {$id} berhasil diverifikasi dan stok gudang telah diperbarui.");
                $this->selectedPoId = $id;
                return;
            }
        }
    }

    public function downloadEDO(string $id): void
    {
        session()->flash('success', "Surat Jalan Elektronik (e-DO) untuk {$id} berhasil diunduh.");
    }

    public function render()
    {
        $filtered = array_filter($this->purchaseOrders, function ($po) {
            $matchesSearch = empty($this->search) ||
                stripos($po['id'], $this->search) !== false ||
                stripos($po['supplier'], $this->search) !== false ||
                stripos($po['item_name'], $this->search) !== false;

            $matchesStatus = $this->statusFilter === 'all' || $po['status'] === $this->statusFilter;

            return $matchesSearch && $matchesStatus;
        });

        $activePo = null;
        foreach ($this->purchaseOrders as $po) {
            if ($po['id'] === $this->selectedPoId) {
                $activePo = $po;
                break;
            }
        }

        if (!$activePo && !empty($this->purchaseOrders)) {
            $activePo = $this->purchaseOrders[0];
        }

        return view('livewire.operations.purchase-order-manager', [
            'orders' => $filtered,
            'activePo' => $activePo,
        ]);
    }
}
