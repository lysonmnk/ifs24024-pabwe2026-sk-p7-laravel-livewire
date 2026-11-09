<?php

namespace Tests\Feature\Stock;

use App\Features\Stock\Enums\StockStatus;
use App\Features\Stock\Livewire\StockDetail;
use App\Features\Stock\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class StockDetailLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_stock_detail(): void
    {
        $stock = Stock::factory()->create();

        $this->get(route('stocks.show', $stock->id))
            ->assertRedirect(route('login'));
    }

    public function test_member_cannot_access_other_member_stock(): void
    {
        $owner = User::factory()->member()->create();
        $otherMember = User::factory()->member()->create();

        $stock = Stock::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($otherMember);

        $this->get(route('stocks.show', $stock->id))
            ->assertStatus(403);
    }

    public function test_member_can_view_own_stock_detail(): void
    {
        $user = User::factory()->member()->create();
        $stock = Stock::factory()->create([
            'user_id' => $user->id,
            'name' => 'Kertas A4 Pro',
            'sku' => 'STK-001',
            'description' => '# Deskripsi Markdown',
            'quantity' => 15,
            'unit' => 'rim',
            'price' => 50000.00,
            'min_stock' => 5,
            'status' => StockStatus::AVAILABLE,
        ]);

        $this->actingAs($user);

        Livewire::test(StockDetail::class, ['stock' => $stock])
            ->assertOk()
            ->assertSet('name', 'Kertas A4 Pro')
            ->assertSet('sku', 'STK-001')
            ->assertSet('description', '# Deskripsi Markdown')
            ->assertSet('quantity', 15)
            ->assertSet('unit', 'rim')
            ->assertSet('price', 50000.00)
            ->assertSet('min_stock', 5)
            ->assertSet('status', 'available')
            ->assertSee('Kertas A4 Pro');
    }

    public function test_open_and_close_edit_modal(): void
    {
        $user = User::factory()->member()->create();
        $stock = Stock::factory()->create([
            'user_id' => $user->id,
            'name' => 'Nama Stok Detail',
            'description' => 'Deskripsi lama',
        ]);

        $this->actingAs($user);

        Livewire::test(StockDetail::class, ['stock' => $stock])
            ->assertSet('showEditModal', false)
            ->call('openEditModal')
            ->assertSet('showEditModal', true)
            ->assertSet('name', 'Nama Stok Detail')
            ->assertSet('description', 'Deskripsi lama')
            ->call('closeEditModal')
            ->assertSet('showEditModal', false);
    }

    public function test_update_stock_validation_and_success(): void
    {
        $user = User::factory()->member()->create();
        $stock = Stock::factory()->create(['user_id' => $user->id, 'name' => 'Nama Awal']);

        $this->actingAs($user);

        // Validation errors
        Livewire::test(StockDetail::class, ['stock' => $stock])
            ->call('openEditModal')
            ->set('name', 'ab') // min:3
            ->set('status', 'invalid_status')
            ->call('saveStock')
            ->assertHasErrors(['name', 'status']);

        // Success
        Livewire::test(StockDetail::class, ['stock' => $stock])
            ->call('openEditModal')
            ->set('name', 'Nama Telah Diperbarui')
            ->set('sku', 'STK-UPD-001')
            ->set('description', '## Rincian Baru')
            ->set('quantity', 20)
            ->set('unit', 'box')
            ->set('price', 75000.00)
            ->set('min_stock', 5)
            ->set('status', 'available')
            ->call('saveStock')
            ->assertHasNoErrors()
            ->assertSet('showEditModal', false);

        $this->assertDatabaseHas('stocks', [
            'id' => $stock->id,
            'name' => 'Nama Telah Diperbarui',
            'sku' => 'STK-UPD-001',
            'quantity' => 20,
            'unit' => 'box',
        ]);
    }

    public function test_adjust_quantity(): void
    {
        $user = User::factory()->member()->create();
        $stock = Stock::factory()->create([
            'user_id' => $user->id,
            'quantity' => 6,
            'min_stock' => 5,
            'status' => StockStatus::AVAILABLE,
        ]);

        $this->actingAs($user);

        // Decrement by 1 -> quantity = 5 (<= min_stock 5) -> status becomes low_stock
        Livewire::test(StockDetail::class, ['stock' => $stock])
            ->call('adjustQuantity', -1)
            ->assertSet('quantity', 5)
            ->assertSet('status', 'low_stock');

        $this->assertDatabaseHas('stocks', [
            'id' => $stock->id,
            'quantity' => 5,
            'status' => 'low_stock',
        ]);

        // Increment by 2 -> quantity = 7 (> min_stock 5) -> status becomes available
        Livewire::test(StockDetail::class, ['stock' => $stock])
            ->call('adjustQuantity', 2)
            ->assertSet('quantity', 7)
            ->assertSet('status', 'available');
    }

    public function test_cover_photo_upload_and_delete(): void
    {
        Storage::fake('public');

        $user = User::factory()->member()->create();
        $stock = Stock::factory()->create(['user_id' => $user->id, 'cover_image_path' => null]);

        $this->actingAs($user);

        // Invalid file
        $invalidFile = UploadedFile::fake()->create('document.pdf', 100);
        Livewire::test(StockDetail::class, ['stock' => $stock])
            ->set('coverPhoto', $invalidFile)
            ->assertHasErrors(['coverPhoto']);

        // Valid image upload
        $imageFile = UploadedFile::fake()->image('cover.jpg', 800, 400);
        $component = Livewire::test(StockDetail::class, ['stock' => $stock])
            ->set('coverPhoto', $imageFile)
            ->assertHasNoErrors();

        $stock->refresh();
        $this->assertNotNull($stock->cover_image_path);
        Storage::disk('public')->assertExists($stock->cover_image_path);

        // Delete cover photo
        $component->call('deleteCoverPhoto');

        $stock->refresh();
        $this->assertNull($stock->cover_image_path);
    }

    public function test_delete_stock_redirects(): void
    {
        $user = User::factory()->member()->create();
        $stock = Stock::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test(StockDetail::class, ['stock' => $stock])
            ->call('deleteStock')
            ->assertRedirect(route('stocks.index'));

        $this->assertDatabaseMissing('stocks', ['id' => $stock->id]);
    }

    public function test_confirm_and_cancel_delete_modal_actions(): void
    {
        $user = User::factory()->member()->create();
        $stock = Stock::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test(StockDetail::class, ['stock' => $stock])
            ->assertSet('confirmingStockDeletion', false)
            ->call('confirmDeleteStock')
            ->assertSet('confirmingStockDeletion', true)
            ->call('cancelDeleteStock')
            ->assertSet('confirmingStockDeletion', false)
            ->assertSet('confirmingCoverDeletion', false)
            ->call('confirmDeleteCover')
            ->assertSet('confirmingCoverDeletion', true)
            ->call('cancelDeleteCover')
            ->assertSet('confirmingCoverDeletion', false);
    }

    public function test_update_stock_with_bento_fields(): void
    {
        $user = User::factory()->member()->create();
        $stock = Stock::factory()->create([
            'user_id' => $user->id,
            'name' => 'Original Item',
            'category' => 'Sembako',
        ]);

        $this->actingAs($user);

        Livewire::test(StockDetail::class, ['stock' => $stock])
            ->call('openEditModal')
            ->set('name', 'Updated Rice Item')
            ->set('category', 'Sembako Premium')
            ->set('supplier', 'PB Sri Makmur')
            ->set('rack_location', 'Rak A-02')
            ->set('order_stage', 'ready')
            ->call('saveStock')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('stocks', [
            'id' => $stock->id,
            'name' => 'Updated Rice Item',
            'category' => 'Sembako Premium',
            'supplier' => 'PB Sri Makmur',
            'rack_location' => 'Rak A-02',
            'order_stage' => 'ready',
        ]);
    }

    public function test_save_description_inline(): void
    {
        $user = User::factory()->member()->create();
        $stock = Stock::factory()->create([
            'user_id' => $user->id,
            'description' => 'Initial description',
        ]);

        $this->actingAs($user);

        Livewire::test(StockDetail::class, ['stock' => $stock])
            ->set('description', '### New Markdown Spec')
            ->call('saveDescription')
            ->assertHasNoErrors()
            ->assertSet('description', '### New Markdown Spec');

        $this->assertDatabaseHas('stocks', [
            'id' => $stock->id,
            'description' => '### New Markdown Spec',
        ]);
    }

    public function test_toggle_barcode_modal(): void
    {
        $user = User::factory()->member()->create();
        $stock = Stock::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        Livewire::test(StockDetail::class, ['stock' => $stock])
            ->assertSet('showBarcodeModal', false)
            ->call('toggleBarcodeModal')
            ->assertSet('showBarcodeModal', true)
            ->call('toggleBarcodeModal')
            ->assertSet('showBarcodeModal', false);
    }
}

