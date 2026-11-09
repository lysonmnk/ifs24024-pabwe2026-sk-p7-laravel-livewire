<?php

namespace App\Features\Operations\Livewire;

use App\Features\Stock\Models\Stock;
use App\Features\Stock\Models\StockMutation;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('components.layouts.app')]
class StockOpnameSession extends Component
{
    public string $search = '';
    public string $rackFilter = 'all';
    public ?int $selectedStockId = null;
    public int $physicalInput = 0;
    public string $opnameNotes = '';

    public function selectStock(int $id): void
    {
        $this->selectedStockId = $id;
        $stock = Stock::find($id);
        if ($stock) {
            $this->physicalInput = $stock->quantity;
        }
    }

    public function reconcile(int $id): void
    {
        $stock = Stock::find($id);
        if (!$stock) {
            return;
        }

        $systemAmount = $stock->quantity;
        $physical = max(0, $this->physicalInput);
        $diff = $physical - $systemAmount;

        DB::transaction(function () use ($stock, $systemAmount, $physical, $diff) {
            $stock->quantity = $physical;
            $stock->save();

            StockMutation::create([
                'stock_id' => $stock->id,
                'user_id' => auth()->id(),
                'batch_no' => 'OPN-' . date('Ymd') . '-' . sprintf('%03d', $stock->id),
                'type' => 'opname',
                'quantity' => abs($diff),
                'balance_after' => $physical,
                'notes' => 'Stock opname rekonsiliasi fisik. Selisih: ' . ($diff >= 0 ? '+' : '') . $diff . ($this->opnameNotes ? ' (' . $this->opnameNotes . ')' : ''),
            ]);
        });

        session()->flash('success', "Rekonsiliasi fisik untuk {$stock->name} berhasil disimpan. Stok buku disinkronkan ke {$physical} unit (Selisih: {$diff}).");
        $this->opnameNotes = '';
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

        if ($this->rackFilter === 'chiller') {
            $query->where('rack_location', 'like', '%Chiller%');
        } elseif ($this->rackFilter === 'rak_a') {
            $query->where('rack_location', 'like', '%Rak A%');
        }

        $items = $query->take(20)->get();

        $activeStock = null;
        if ($this->selectedStockId) {
            $activeStock = Stock::find($this->selectedStockId);
        }
        if (!$activeStock && $items->isNotEmpty()) {
            $activeStock = $items->first();
            $this->selectedStockId = $activeStock->id;
            $this->physicalInput = $activeStock->quantity;
        }

        return view('livewire.operations.stock-opname-session', [
            'items' => $items,
            'activeStock' => $activeStock,
        ]);
    }
}
