<?php

namespace Tests\Feature\Stock;

use App\Features\Ai\Contracts\AiClientInterface;
use App\Features\Ai\DTO\GeneratedStockItem;
use App\Features\Stock\Enums\StockStatus;
use App\Features\Stock\Livewire\StockList;
use App\Features\Stock\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class StockListLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_stocks(): void
    {
        $this->get('/stocks')->assertRedirect(route('login'));
    }

    public function test_member_can_view_own_stocks(): void
    {
        $user = User::factory()->member()->create();
        Stock::factory()->create(['user_id' => $user->id, 'name' => 'Stok Khusus Member']);

        $otherUser = User::factory()->member()->create();
        Stock::factory()->create(['user_id' => $otherUser->id, 'name' => 'Stok Rahasia User Lain']);

        $this->actingAs($user);

        Livewire::test(StockList::class)
            ->assertSee('Stok Khusus Member')
            ->assertDontSee('Stok Rahasia User Lain');
    }

    public function test_create_stock_validation_and_success(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        // Validation error
        Livewire::test(StockList::class)
            ->call('openCreateModal')
            ->set('formName', '')
            ->set('formStatus', 'invalid_status')
            ->call('saveStock')
            ->assertHasErrors(['formName', 'formStatus']);

        // Success
        Livewire::test(StockList::class)
            ->call('openCreateModal')
            ->set('formName', 'Kertas HVS Baru')
            ->set('formSku', 'STK-HVS-001')
            ->set('formDescription', 'Deskripsi kertas')
            ->set('formQuantity', 10)
            ->set('formUnit', 'rim')
            ->set('formPrice', 45000.00)
            ->set('formMinStock', 3)
            ->set('formStatus', 'available')
            ->call('saveStock')
            ->assertHasNoErrors()
            ->assertSet('showFormModal', false);

        $this->assertDatabaseHas('stocks', [
            'user_id' => $user->id,
            'name' => 'Kertas HVS Baru',
            'sku' => 'STK-HVS-001',
            'quantity' => 10,
            'unit' => 'rim',
        ]);
    }

    public function test_edit_stock_success(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        $stock = Stock::factory()->create(['user_id' => $user->id, 'name' => 'Nama Lama']);

        Livewire::test(StockList::class)
            ->call('openEditModal', $stock->id)
            ->assertSet('editingStockId', $stock->id)
            ->assertSet('formName', 'Nama Lama')
            ->set('formName', 'Nama Telah Diedit')
            ->call('saveStock')
            ->assertHasNoErrors()
            ->assertSet('showFormModal', false);

        $this->assertDatabaseHas('stocks', [
            'id' => $stock->id,
            'name' => 'Nama Telah Diedit',
        ]);
    }

    public function test_adjust_quantity(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        $stock = Stock::factory()->create([
            'user_id' => $user->id,
            'quantity' => 6,
            'min_stock' => 5,
            'status' => StockStatus::AVAILABLE,
        ]);

        // Decrement by 1 -> quantity = 5 (<= min_stock 5) -> status becomes low_stock
        Livewire::test(StockList::class)
            ->call('adjustQuantity', $stock->id, -1);

        $this->assertEquals(5, $stock->fresh()->quantity);
        $this->assertEquals(StockStatus::LOW_STOCK, $stock->fresh()->status);
    }

    public function test_delete_stock(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        $stock = Stock::factory()->create(['user_id' => $user->id]);

        Livewire::test(StockList::class)
            ->call('deleteStock', $stock->id);

        $this->assertDatabaseMissing('stocks', ['id' => $stock->id]);
    }

    public function test_confirm_and_cancel_delete_stock(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        $stock = Stock::factory()->create(['user_id' => $user->id]);

        Livewire::test(StockList::class)
            ->assertSet('confirmingStockDeletionId', null)
            ->call('confirmDelete', $stock->id)
            ->assertSet('confirmingStockDeletionId', $stock->id)
            ->call('cancelDelete')
            ->assertSet('confirmingStockDeletionId', null)
            ->call('confirmDelete', $stock->id)
            ->call('deleteStock')
            ->assertSet('confirmingStockDeletionId', null);

        $this->assertDatabaseMissing('stocks', ['id' => $stock->id]);
    }

    public function test_search_and_status_filter(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        Stock::factory()->create(['user_id' => $user->id, 'name' => 'Pulpen Pilot', 'status' => StockStatus::AVAILABLE]);
        Stock::factory()->create(['user_id' => $user->id, 'name' => 'Pensil 2B', 'status' => StockStatus::OUT_OF_STOCK]);

        Livewire::test(StockList::class)
            ->set('search', 'Pilot')
            ->assertSee('Pulpen Pilot')
            ->assertDontSee('Pensil 2B')
            ->set('search', '')
            ->set('statusFilter', 'out_of_stock')
            ->assertSee('Pensil 2B')
            ->assertDontSee('Pulpen Pilot');
    }

    public function test_export_excel(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        Stock::factory()->create(['user_id' => $user->id, 'name' => 'Exportable Stock']);

        Livewire::test(StockList::class)
            ->call('exportExcel')
            ->assertFileDownloaded();
    }

    public function test_import_excel(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'SKU');
        $sheet->setCellValue('D1', 'Description');
        $sheet->setCellValue('E1', 'Quantity');
        $sheet->setCellValue('F1', 'Unit');
        $sheet->setCellValue('G1', 'Price');
        $sheet->setCellValue('H1', 'Min Stock');
        $sheet->setCellValue('I1', 'Status');

        $sheet->setCellValue('A2', '1');
        $sheet->setCellValue('B2', 'Imported Stock Item');
        $sheet->setCellValue('C2', 'STK-IMP-001');
        $sheet->setCellValue('D2', 'Desc text');
        $sheet->setCellValue('E2', '15');
        $sheet->setCellValue('F2', 'pcs');
        $sheet->setCellValue('G2', '20000');
        $sheet->setCellValue('H2', '5');
        $sheet->setCellValue('I2', 'available');

        $tempPath = tempnam(sys_get_temp_dir(), 'test_upload_').'.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempPath);

        $fileContent = file_get_contents($tempPath);
        @unlink($tempPath);

        $uploadedFile = UploadedFile::fake()->createWithContent('stocks.xlsx', $fileContent);

        Livewire::test(StockList::class)
            ->call('openImportModal')
            ->assertSet('showImportModal', true)
            ->set('importFile', $uploadedFile)
            ->call('importExcel')
            ->assertSet('showImportModal', false);

        $this->assertDatabaseHas('stocks', [
            'user_id' => $user->id,
            'name' => 'Imported Stock Item',
            'sku' => 'STK-IMP-001',
            'quantity' => 15,
        ]);
    }

    public function test_ai_generation_and_saving(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        // Mock AiClientInterface using createStub
        $mockAiClient = $this->createStub(AiClientInterface::class);
        $mockAiClient->method('generateStocks')->willReturn([
            new GeneratedStockItem('AI Stock Item 1', 'SKU-AI-1', 'Desc 1', 10, 'pcs', 15000.0, 5, 'available'),
            new GeneratedStockItem('AI Stock Item 2', 'SKU-AI-2', 'Desc 2', 20, 'box', 30000.0, 5, 'available'),
        ]);
        $this->app->instance(AiClientInterface::class, $mockAiClient);

        // Test validation for prompt and count
        Livewire::test(StockList::class)
            ->call('openAiModal')
            ->set('aiPrompt', '')
            ->set('aiCount', 0)
            ->call('generateWithAi')
            ->assertHasErrors(['aiPrompt', 'aiCount']);

        $component = Livewire::test(StockList::class)
            ->call('openAiModal')
            ->assertSet('showAiModal', true)
            ->set('aiPrompt', 'Buatkan saya 2 stok alat tulis')
            ->set('aiCount', 2)
            ->call('generateWithAi')
            ->assertCount('aiGeneratedItems', 2)
            ->assertCount('aiSelectedIndices', 2);

        // Try saving with no items selected
        $component->set('aiSelectedIndices', [])
            ->call('saveAiGenerated')
            ->assertSet('aiErrorMessage', 'Pilih minimal satu item stok yang ingin disimpan.');

        // Save selected items
        $component->set('aiSelectedIndices', [0, 1])
            ->call('saveAiGenerated')
            ->assertSet('showAiModal', false);

        $this->assertDatabaseHas('stocks', ['user_id' => $user->id, 'name' => 'AI Stock Item 1']);
        $this->assertDatabaseHas('stocks', ['user_id' => $user->id, 'name' => 'AI Stock Item 2']);
    }

    public function test_ai_generation_handles_exception(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        $mockAiClient = $this->createStub(AiClientInterface::class);
        $mockAiClient->method('generateStocks')->willThrowException(new \RuntimeException('API quota exceeded'));
        $this->app->instance(AiClientInterface::class, $mockAiClient);

        Livewire::test(StockList::class)
            ->call('openAiModal')
            ->set('aiPrompt', 'Error test')
            ->call('generateWithAi')
            ->assertSet('aiErrorMessage', 'API quota exceeded');
    }

    public function test_close_modals(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        Livewire::test(StockList::class)
            ->call('openCreateModal')
            ->call('closeFormModal')
            ->assertSet('showFormModal', false)
            ->call('openImportModal')
            ->call('closeImportModal')
            ->assertSet('showImportModal', false)
            ->call('openAiModal')
            ->call('closeAiModal')
            ->assertSet('showAiModal', false);
    }

    public function test_category_filter_in_livewire(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        Stock::factory()->create(['user_id' => $user->id, 'name' => 'Beras Pandan Wangi', 'category' => 'Sembako']);
        Stock::factory()->create(['user_id' => $user->id, 'name' => 'Kopi Kapal Api', 'category' => 'Minuman']);

        Livewire::test(StockList::class)
            ->call('setCategory', 'Sembako')
            ->assertSee('Beras Pandan Wangi')
            ->assertDontSee('Kopi Kapal Api')
            ->call('setCategory', 'Minuman')
            ->assertSee('Kopi Kapal Api')
            ->assertDontSee('Beras Pandan Wangi')
            ->call('setCategory', 'Minuman')
            ->assertSee('Beras Pandan Wangi')
            ->assertSee('Kopi Kapal Api');
    }

    public function test_view_mode_toggle_in_livewire(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        Livewire::test(StockList::class)
            ->assertSet('viewMode', 'bento')
            ->call('setViewMode', 'table')
            ->assertSet('viewMode', 'table')
            ->call('setViewMode', 'bento')
            ->assertSet('viewMode', 'bento');
    }

    public function test_create_and_update_stock_with_bento_fields(): void
    {
        $user = User::factory()->member()->create();
        $this->actingAs($user);

        Livewire::test(StockList::class)
            ->call('openCreateModal')
            ->set('formName', 'Gula Pasir Gulaku 1kg')
            ->set('formSku', 'STK-GLA-001')
            ->set('formCategory', 'Bumbu')
            ->set('formSupplier', 'PB Sri Makmur')
            ->set('formRackLocation', 'Rak B-04')
            ->set('formOrderStage', 'ready')
            ->set('formQuantity', 85)
            ->set('formUnit', 'pcs')
            ->set('formPrice', 18000)
            ->set('formMinStock', 10)
            ->set('formStatus', 'available')
            ->call('saveStock')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('stocks', [
            'user_id' => $user->id,
            'name' => 'Gula Pasir Gulaku 1kg',
            'category' => 'Bumbu',
            'supplier' => 'PB Sri Makmur',
            'rack_location' => 'Rak B-04',
            'order_stage' => 'ready',
        ]);
    }
}
