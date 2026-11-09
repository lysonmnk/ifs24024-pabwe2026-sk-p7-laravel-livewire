<?php

namespace App\Features\Stock\Livewire;

use App\Features\Stock\Enums\StockStatus;
use App\Features\Stock\Models\Stock;
use App\Features\Stock\Services\StockService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Stock Detail - StockApp')]
class StockDetail extends Component
{
    use WithFileUploads;

    public Stock $stock;
    public string $name = '';
    public ?string $sku = null;
    public ?string $description = '';
    public ?string $category = null;
    public ?string $supplier = null;
    public ?string $rack_location = null;
    public string $order_stage = 'ready';
    public int $quantity = 0;
    public string $unit = 'pcs';
    public ?float $price = null;
    public int $min_stock = 5;
    public string $status = 'available';

    public mixed $coverPhoto = null;
    public bool $showEditModal = false;
    public bool $showBarcodeModal = false;
    public bool $confirmingStockDeletion = false;
    public bool $confirmingCoverDeletion = false;

    public function mount(Stock $stock): void
    {
        Gate::authorize('view', $stock);

        $this->stock = $stock;
        $this->fillStockData();
    }

    protected function fillStockData(): void
    {
        $this->name = $this->stock->name;
        $this->sku = $this->stock->sku;
        $this->description = $this->stock->description ?? '';
        $this->category = $this->stock->category ?? 'Sembako';
        $this->supplier = $this->stock->supplier;
        $this->rack_location = $this->stock->rack_location;
        $this->order_stage = $this->stock->order_stage ?? 'ready';
        $this->quantity = $this->stock->quantity;
        $this->unit = $this->stock->unit ?? 'pcs';
        $this->price = $this->stock->price !== null ? (float) $this->stock->price : null;
        $this->min_stock = $this->stock->min_stock;
        $this->status = $this->stock->status instanceof StockStatus ? $this->stock->status->value : (string) $this->stock->status;
    }

    public function openEditModal(): void
    {
        Gate::authorize('update', $this->stock);

        $this->fillStockData();
        $this->resetErrorBag();
        $this->showEditModal = true;
    }

    public function closeEditModal(): void
    {
        $this->showEditModal = false;
    }

    public function updatedCoverPhoto(StockService $stockService): void
    {
        Gate::authorize('update', $this->stock);

        $this->validate([
            'coverPhoto' => ['required', 'image', 'max:5120'], // max 5MB
        ]);

        $stockService->updateCoverPhoto($this->stock, $this->coverPhoto);
        $this->stock->refresh();
        $this->reset('coverPhoto');

        session()->flash('success', 'Cover gambar stok berhasil diperbarui.');
    }

    public function confirmDeleteCover(): void
    {
        $this->confirmingCoverDeletion = true;
    }

    public function cancelDeleteCover(): void
    {
        $this->confirmingCoverDeletion = false;
    }

    public function deleteCoverPhoto(StockService $stockService): void
    {
        Gate::authorize('update', $this->stock);

        $stockService->deleteCoverPhoto($this->stock);
        $this->stock->refresh();
        $this->confirmingCoverDeletion = false;

        session()->flash('success', 'Cover gambar stok berhasil dihapus.');
    }

    public function adjustQuantity(int $delta, StockService $stockService): void
    {
        Gate::authorize('update', $this->stock);

        $stockService->adjustQuantity($this->stock, $delta);
        $this->stock->refresh();
        $this->fillStockData();
    }

    public function saveStock(StockService $stockService): void
    {
        Gate::authorize('update', $this->stock);

        $this->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'sku' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'supplier' => ['nullable', 'string', 'max:150'],
            'rack_location' => ['nullable', 'string', 'max:50'],
            'order_stage' => ['nullable', 'string', 'in:ordered,verified,stored,ready'],
            'quantity' => ['required', 'integer', 'min:0'],
            'unit' => ['required', 'string', 'max:20'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'min_stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'string', Rule::in(['available', 'low_stock', 'out_of_stock'])],
        ]);

        $stockService->updateStock($this->stock, [
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description,
            'category' => $this->category,
            'supplier' => $this->supplier,
            'rack_location' => $this->rack_location,
            'order_stage' => $this->order_stage ?: 'ready',
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'price' => $this->price,
            'min_stock' => $this->min_stock,
            'status' => $this->status,
        ]);

        $this->stock->refresh();
        $this->fillStockData();
        $this->showEditModal = false;

        session()->flash('success', 'Data stok berhasil diperbarui.');
    }

    public function confirmDeleteStock(): void
    {
        $this->confirmingStockDeletion = true;
    }

    public function cancelDeleteStock(): void
    {
        $this->confirmingStockDeletion = false;
    }

    public function deleteStock(StockService $stockService): mixed
    {
        Gate::authorize('delete', $this->stock);

        $stockService->deleteStock($this->stock);
        session()->flash('success', 'Stok barang berhasil dihapus.');

        return redirect()->route('stocks.index');
    }

    public function toggleBarcodeModal(): void
    {
        $this->showBarcodeModal = !$this->showBarcodeModal;
    }

    public function saveDescription(StockService $stockService): void
    {
        Gate::authorize('update', $this->stock);

        $this->validate([
            'description' => ['nullable', 'string'],
        ]);

        $stockService->updateStock($this->stock, [
            'description' => $this->description,
        ]);

        $this->stock->refresh();
        $this->fillStockData();

        session()->flash('success', 'Deskripsi stok berhasil disimpan.');
    }

    public function render(): View
    {
        $min = $this->stock->min_stock > 0 ? $this->stock->min_stock : 1;
        $bufferRatio = (int) round(($this->stock->quantity / $min) * 100);
        $estimatedDays = max(1, (int) round($this->stock->quantity * 1.5));
        $totalAssetValue = ($this->stock->price ?? 0) * $this->stock->quantity;

        return view('livewire.stock.stock-detail', [
            'bufferRatio' => $bufferRatio,
            'estimatedDays' => $estimatedDays,
            'totalAssetValue' => $totalAssetValue,
        ]);
    }
}
