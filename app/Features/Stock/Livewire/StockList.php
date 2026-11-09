<?php

namespace App\Features\Stock\Livewire;

use App\Features\Ai\Contracts\AiClientInterface;
use App\Features\Stock\Enums\StockStatus;
use App\Features\Stock\Models\Stock;
use App\Features\Stock\Services\StockExcelService;
use App\Features\Stock\Services\StockService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Layout('components.layouts.app')]
#[Title('My Stocks - StockApp')]
class StockList extends Component
{
    use WithPagination, WithFileUploads;

    // Filters & View Mode
    public string $search = '';
    public string $statusFilter = '';
    public string $categoryFilter = '';
    public string $viewMode = 'bento';

    // Create / Edit Modal State
    public bool $showFormModal = false;
    public ?int $editingStockId = null;
    public string $formName = '';
    public ?string $formSku = null;
    public ?string $formDescription = null;
    public ?string $formCategory = 'Sembako';
    public ?string $formSupplier = null;
    public ?string $formRackLocation = null;
    public string $formOrderStage = 'ready';
    public int $formQuantity = 0;
    public string $formUnit = 'pcs';
    public ?float $formPrice = null;
    public int $formMinStock = 5;
    public string $formStatus = 'available';

    // Delete Confirmation Modal State
    public ?int $confirmingStockDeletionId = null;

    // Excel Import State
    public bool $showImportModal = false;
    public mixed $importFile = null;

    // AI Generator State
    public bool $showAiModal = false;
    public string $aiPrompt = '';
    public int $aiCount = 3;
    public array $aiGeneratedItems = [];
    public array $aiSelectedIndices = [];
    public bool $aiIsGenerating = false;
    public ?string $aiErrorMessage = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'viewMode' => ['except' => 'bento'],
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function setCategory(string $category): void
    {
        $this->categoryFilter = ($this->categoryFilter === $category) ? '' : $category;
        $this->resetPage();
    }

    public function setViewMode(string $mode): void
    {
        $this->viewMode = in_array($mode, ['bento', 'table'], true) ? $mode : 'bento';
    }

    // --- CRUD Operations ---

    public function openCreateModal(): void
    {
        $this->resetForm();
        $this->showFormModal = true;
    }

    public function openEditModal(int $id): void
    {
        $stock = Stock::findOrFail($id);
        Gate::authorize('update', $stock);

        $this->resetErrorBag();
        $this->editingStockId = $stock->id;
        $this->formName = $stock->name;
        $this->formSku = $stock->sku;
        $this->formDescription = $stock->description;
        $this->formCategory = $stock->category ?? 'Sembako';
        $this->formSupplier = $stock->supplier;
        $this->formRackLocation = $stock->rack_location;
        $this->formOrderStage = $stock->order_stage ?? 'ready';
        $this->formQuantity = $stock->quantity;
        $this->formUnit = $stock->unit ?? 'pcs';
        $this->formPrice = $stock->price !== null ? (float) $stock->price : null;
        $this->formMinStock = $stock->min_stock;
        $this->formStatus = $stock->status instanceof StockStatus ? $stock->status->value : (string) $stock->status;
        $this->showFormModal = true;
    }

    public function closeFormModal(): void
    {
        $this->showFormModal = false;
    }

    public function resetForm(): void
    {
        $this->reset([
            'editingStockId',
            'formName',
            'formSku',
            'formDescription',
            'formSupplier',
            'formRackLocation',
            'formPrice',
        ]);
        $this->formCategory = 'Sembako';
        $this->formOrderStage = 'ready';
        $this->formQuantity = 0;
        $this->formUnit = 'pcs';
        $this->formMinStock = 5;
        $this->formStatus = StockStatus::AVAILABLE->value;
        $this->resetErrorBag();
    }

    public function saveStock(StockService $stockService): void
    {
        $this->validate([
            'formName' => ['required', 'string', 'max:255'],
            'formSku' => ['nullable', 'string', 'max:100'],
            'formDescription' => ['nullable', 'string'],
            'formCategory' => ['nullable', 'string', 'max:100'],
            'formSupplier' => ['nullable', 'string', 'max:150'],
            'formRackLocation' => ['nullable', 'string', 'max:50'],
            'formOrderStage' => ['nullable', 'string', 'in:ordered,verified,stored,ready'],
            'formQuantity' => ['required', 'integer', 'min:0'],
            'formUnit' => ['required', 'string', 'max:20'],
            'formPrice' => ['nullable', 'numeric', 'min:0'],
            'formMinStock' => ['required', 'integer', 'min:0'],
            'formStatus' => ['required', 'in:available,low_stock,out_of_stock'],
        ]);

        $data = [
            'name' => $this->formName,
            'sku' => $this->formSku,
            'description' => $this->formDescription,
            'category' => $this->formCategory,
            'supplier' => $this->formSupplier,
            'rack_location' => $this->formRackLocation,
            'order_stage' => $this->formOrderStage ?: 'ready',
            'quantity' => $this->formQuantity,
            'unit' => $this->formUnit,
            'price' => $this->formPrice,
            'min_stock' => $this->formMinStock,
            'status' => $this->formStatus,
        ];

        if ($this->editingStockId) {
            $stock = Stock::findOrFail($this->editingStockId);
            Gate::authorize('update', $stock);
            $stockService->updateStock($stock, $data);
            session()->flash('success', 'Stok barang berhasil diperbarui.');
        } else {
            $stockService->createStock(Auth::id(), $data);
            session()->flash('success', 'Stok barang baru berhasil ditambahkan.');
        }

        $this->closeFormModal();
    }

    public function adjustQuantity(int $id, int $delta, StockService $stockService): void
    {
        $stock = Stock::findOrFail($id);
        Gate::authorize('update', $stock);

        $stockService->adjustQuantity($stock, $delta);
    }

    public function confirmDelete(int $id): void
    {
        $this->confirmingStockDeletionId = $id;
    }

    public function cancelDelete(): void
    {
        $this->confirmingStockDeletionId = null;
    }

    public function deleteStock(?int $id = null, ?StockService $stockService = null): void
    {
        $stockService = $stockService ?? app(StockService::class);
        $targetId = $id ?? $this->confirmingStockDeletionId;

        if ($targetId) {
            $stock = Stock::findOrFail($targetId);
            Gate::authorize('delete', $stock);

            $stockService->deleteStock($stock);
            $this->confirmingStockDeletionId = null;
            session()->flash('success', 'Stok barang berhasil dihapus.');
        }
    }

    // --- Excel Export & Import ---

    public function exportExcel(StockExcelService $excelService): StreamedResponse
    {
        $user = Auth::user();
        $stocks = $user ? $user->stocks()->latest('id')->get() : collect();

        return $excelService->exportToResponse($stocks, 'stocks-'.now()->format('Ymd-His').'.xlsx');
    }

    public function openImportModal(): void
    {
        $this->reset(['importFile']);
        $this->showImportModal = true;
    }

    public function closeImportModal(): void
    {
        $this->showImportModal = false;
    }

    public function importExcel(StockExcelService $excelService): void
    {
        $this->validate([
            'importFile' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:10240'],
        ]);

        $path = $this->importFile->getRealPath();
        $result = $excelService->import($path, Auth::id());

        $this->closeImportModal();
        session()->flash('success', "Berhasil mengimpor {$result['imported']} item stok.");
    }

    // --- AI Stock Generator ---

    public function openAiModal(): void
    {
        $this->reset(['aiPrompt', 'aiGeneratedItems', 'aiSelectedIndices', 'aiErrorMessage', 'aiIsGenerating']);
        $this->aiCount = 3;
        $this->showAiModal = true;
    }

    public function closeAiModal(): void
    {
        $this->showAiModal = false;
    }

    public function generateWithAi(AiClientInterface $aiClient): void
    {
        $this->validate([
            'aiPrompt' => ['required', 'string', 'min:3', 'max:500'],
            'aiCount' => ['required', 'integer', 'min:1'],
        ]);

        $this->aiIsGenerating = true;
        $this->aiErrorMessage = null;

        try {
            $items = $aiClient->generateStocks($this->aiPrompt, $this->aiCount);
            $this->aiGeneratedItems = array_map(fn ($item) => $item->toArray(), $items);
            $this->aiSelectedIndices = array_keys($this->aiGeneratedItems);
        } catch (\Throwable $e) {
            $this->aiErrorMessage = $e->getMessage();
        } finally {
            $this->aiIsGenerating = false;
        }
    }

    public function saveAiGenerated(StockService $stockService): void
    {
        if (empty($this->aiSelectedIndices) || empty($this->aiGeneratedItems)) {
            $this->aiErrorMessage = 'Pilih minimal satu item stok yang ingin disimpan.';
            return;
        }

        $savedCount = 0;
        foreach ($this->aiSelectedIndices as $index) {
            if (isset($this->aiGeneratedItems[$index])) {
                $item = $this->aiGeneratedItems[$index];
                $stockService->createStock(Auth::id(), [
                    'name' => $item['name'],
                    'sku' => $item['sku'] ?? null,
                    'description' => $item['description'] ?? null,
                    'quantity' => $item['quantity'] ?? 10,
                    'unit' => $item['unit'] ?? 'pcs',
                    'price' => $item['price'] ?? null,
                    'min_stock' => $item['min_stock'] ?? 5,
                    'status' => $item['status'] ?? 'available',
                ]);
                $savedCount++;
            }
        }

        $this->closeAiModal();
        session()->flash('success', "Berhasil menambahkan {$savedCount} item stok yang digenerate oleh AI.");
    }

    public function render(StockService $stockService): View
    {
        $userId = Auth::id() ?? 0;
        $stocks = $stockService->getStocksForUser(
            $userId,
            $this->statusFilter ?: null,
            $this->search ?: null,
            8,
            $this->categoryFilter ?: null
        );

        $telemetry = $stockService->getTelemetryForUser($userId);

        $featuredStock = $stocks->first();

        $alertQuery = Stock::where('user_id', $userId)
            ->where(function ($q) {
                $q->where('quantity', '<=', 5)
                  ->orWhere('status', 'out_of_stock')
                  ->orWhere('status', 'low_stock');
            });

        if (!empty($this->search)) {
            $alertQuery->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('sku', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%")
                  ->orWhere('supplier', 'like', "%{$this->search}%")
                  ->orWhere('rack_location', 'like', "%{$this->search}%");
            });
        }

        if (!empty($this->categoryFilter)) {
            $alertQuery->where('category', $this->categoryFilter);
        }

        if (!empty($this->statusFilter)) {
            $alertQuery->where('status', $this->statusFilter);
        }

        $alertStocks = $alertQuery->latest('updated_at')->take(3)->get();

        return view('livewire.stock.stock-list', [
            'stocks' => $stocks,
            'statuses' => StockStatus::cases(),
            'telemetry' => $telemetry,
            'featuredStock' => $featuredStock,
            'alertStocks' => $alertStocks,
        ]);
    }
}
