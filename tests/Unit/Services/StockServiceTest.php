<?php

namespace Tests\Unit\Services;

use App\Features\Stock\Contracts\StockRepositoryInterface;
use App\Features\Stock\Enums\StockStatus;
use App\Features\Stock\Models\Stock;
use App\Features\Stock\Repositories\StockRepository;
use App\Features\Stock\Services\StockService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StockServiceTest extends TestCase
{
    use RefreshDatabase;

    protected StockService $service;
    protected StockRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new StockRepository();
        $this->service = new StockService($this->repository);
    }

    public function test_calculate_status(): void
    {
        $this->assertEquals(StockStatus::OUT_OF_STOCK, $this->service->calculateStatus(0, 5));
        $this->assertEquals(StockStatus::OUT_OF_STOCK, $this->service->calculateStatus(-2, 5));
        $this->assertEquals(StockStatus::LOW_STOCK, $this->service->calculateStatus(3, 5));
        $this->assertEquals(StockStatus::LOW_STOCK, $this->service->calculateStatus(5, 5));
        $this->assertEquals(StockStatus::AVAILABLE, $this->service->calculateStatus(6, 5));
    }

    public function test_get_stocks_for_user(): void
    {
        $user = User::factory()->create();
        Stock::factory()->count(2)->create(['user_id' => $user->id]);

        $paginator = $this->service->getStocksForUser($user->id);
        $this->assertCount(2, $paginator);
    }

    public function test_create_stock(): void
    {
        $user = User::factory()->create();
        $stock = $this->service->createStock($user->id, [
            'name' => 'Service Stock',
            'sku' => 'SVC-001',
            'description' => 'Service Description',
            'quantity' => 15,
            'unit' => 'pcs',
            'price' => 20000,
            'min_stock' => 5,
        ]);

        $this->assertInstanceOf(Stock::class, $stock);
        $this->assertEquals('Service Stock', $stock->name);
        $this->assertEquals('available', $stock->status->value ?? $stock->status);
    }

    public function test_create_stock_with_explicit_status(): void
    {
        $user = User::factory()->create();
        $stock = $this->service->createStock($user->id, [
            'name' => 'Explicit Status Stock',
            'quantity' => 10,
            'status' => StockStatus::LOW_STOCK,
        ]);

        $this->assertEquals(StockStatus::LOW_STOCK, $stock->status);
    }

    public function test_update_stock(): void
    {
        $user = User::factory()->create();
        $stock = Stock::factory()->create(['user_id' => $user->id, 'name' => 'Old Name', 'quantity' => 20, 'min_stock' => 5]);

        $updated = $this->service->updateStock($stock, [
            'name' => 'New Name',
            'quantity' => 2,
        ]);

        $this->assertTrue($updated);
        $stock->refresh();
        $this->assertEquals('New Name', $stock->name);
        $this->assertEquals(2, $stock->quantity);
        $this->assertEquals(StockStatus::LOW_STOCK, $stock->status);

        // Update with explicit StockStatus Enum
        $this->service->updateStock($stock, [
            'status' => StockStatus::AVAILABLE,
        ]);
        $stock->refresh();
        $this->assertEquals(StockStatus::AVAILABLE, $stock->status);
    }

    public function test_adjust_quantity(): void
    {
        $user = User::factory()->create();
        $stock = Stock::factory()->create(['user_id' => $user->id, 'quantity' => 10, 'min_stock' => 5, 'status' => StockStatus::AVAILABLE]);

        // Adjust -6 => quantity 4 (low_stock)
        $this->service->adjustQuantity($stock, -6);
        $stock->refresh();
        $this->assertEquals(4, $stock->quantity);
        $this->assertEquals(StockStatus::LOW_STOCK, $stock->status);

        // Adjust -10 => quantity 0 (out_of_stock, not negative)
        $this->service->adjustQuantity($stock, -10);
        $stock->refresh();
        $this->assertEquals(0, $stock->quantity);
        $this->assertEquals(StockStatus::OUT_OF_STOCK, $stock->status);

        // Adjust +8 => quantity 8 (available)
        $this->service->adjustQuantity($stock, 8);
        $stock->refresh();
        $this->assertEquals(8, $stock->quantity);
        $this->assertEquals(StockStatus::AVAILABLE, $stock->status);
    }

    public function test_cover_photo_management(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $stock = Stock::factory()->create(['user_id' => $user->id]);

        $fakeFile = UploadedFile::fake()->image('cover.jpg');

        // Update cover
        $path = $this->service->updateCoverPhoto($stock, $fakeFile);
        $stock->refresh();
        $this->assertEquals($path, $stock->cover_image_path);
        Storage::disk('public')->assertExists($path);

        // Update cover again (replaces old)
        $newFakeFile = UploadedFile::fake()->image('new-cover.jpg');
        $newPath = $this->service->updateCoverPhoto($stock, $newFakeFile);
        $stock->refresh();
        $this->assertEquals($newPath, $stock->cover_image_path);
        Storage::disk('public')->assertMissing($path);
        Storage::disk('public')->assertExists($newPath);

        // Delete cover
        $deleted = $this->service->deleteCoverPhoto($stock);
        $this->assertTrue($deleted);
        $stock->refresh();
        $this->assertNull($stock->cover_image_path);
        Storage::disk('public')->assertMissing($newPath);

        // Delete stock cleans up cover photo if present
        $anotherFile = UploadedFile::fake()->image('another.jpg');
        $anotherPath = $this->service->updateCoverPhoto($stock, $anotherFile);
        Storage::disk('public')->assertExists($anotherPath);

        $this->service->deleteStock($stock);
        Storage::disk('public')->assertMissing($anotherPath);
        $this->assertDatabaseMissing('stocks', ['id' => $stock->id]);
    }
}
