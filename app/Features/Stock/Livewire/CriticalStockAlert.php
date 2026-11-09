<?php

namespace App\Features\Stock\Livewire;

use App\Features\Stock\Models\Stock;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class CriticalStockAlert extends Component
{
    public string $search = '';
    public string $filter = 'all'; // all, low_stock, critical, fresh
    public ?int $selectedStockId = null;

    public function filterBy(string $type): void
    {
        $this->filter = $type;
    }

    public function selectStock(int $id): void
    {
        $this->selectedStockId = $id;
    }

    public function executeFefoBatch(int $id): void
    {
        $stock = Stock::find($id);
        if ($stock) {
            session()->flash('success', "Batch FEFO untuk {$stock->name} berhasil dieksekusi ke display rak terdepan.");
        }
    }

    public function applyClearanceDiscount(int $id): void
    {
        $stock = Stock::find($id);
        if ($stock) {
            session()->flash('success', "Program Flash Sale Clearance untuk {$stock->name} berhasil diaktifkan.");
        }
    }

    public function render()
    {
        $user = auth()->user();
        $query = Stock::query();

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%')
                  ->orWhere('rack_location', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter === 'low_stock') {
            $query->where('quantity', '<=', 10);
        } elseif ($this->filter === 'critical') {
            $query->where('quantity', '<=', 5);
        }

        $items = $query->orderBy('quantity', 'asc')->take(20)->get();

        $activeStock = null;
        if ($this->selectedStockId) {
            $activeStock = Stock::find($this->selectedStockId);
        }
        if (!$activeStock && $items->isNotEmpty()) {
            $activeStock = $items->first();
        }

        return view('livewire.stock.critical-stock-alert', [
            'items' => $items,
            'activeStock' => $activeStock,
        ]);
    }
}
