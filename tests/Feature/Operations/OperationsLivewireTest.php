<?php

namespace Tests\Feature\Operations;

use App\Features\Operations\Livewire\InterBranchTransfer;
use App\Features\Operations\Livewire\PurchaseOrderManager;
use App\Features\Operations\Livewire\StockOpnameSession;
use App\Features\Operations\Livewire\SupplierReturnClaim;
use App\Features\Stock\Livewire\CriticalStockAlert;
use App\Features\Stock\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class OperationsLivewireTest extends TestCase
{
    use RefreshDatabase;

    private User $member;

    protected function setUp(): void
    {
        parent::setUp();
        $this->member = User::factory()->create([
            'role' => 'user',
        ]);
    }

    public function test_guests_are_redirected_to_login_for_operations_routes(): void
    {
        $this->get('/purchase-orders')->assertRedirect(route('login'));
        $this->get('/critical-stock')->assertRedirect(route('login'));
        $this->get('/stock-opname')->assertRedirect(route('login'));
        $this->get('/returns')->assertRedirect(route('login'));
        $this->get('/stock-transfers')->assertRedirect(route('login'));
    }

    public function test_purchase_orders_page_renders_successfully(): void
    {
        Livewire::actingAs($this->member)
            ->test(PurchaseOrderManager::class)
            ->assertStatus(200)
            ->assertSee('Purchase Order')
            ->assertSee('Penerimaan Barang')
            ->assertSee('PO-2026-1092');
    }

    public function test_purchase_order_can_be_filtered_and_searched(): void
    {
        Livewire::actingAs($this->member)
            ->test(PurchaseOrderManager::class)
            ->set('search', 'Bimoli')
            ->assertSee('PO-2026-1092')
            ->assertDontSee('PO-2026-1093')
            ->set('search', '')
            ->call('filterStatus', 'menunggu_truk')
            ->assertSee('PO-2026-1093')
            ->assertDontSee('PO-2026-1094');
    }

    public function test_purchase_order_can_start_unloading_and_verify_receiving(): void
    {
        Livewire::actingAs($this->member)
            ->test(PurchaseOrderManager::class)
            ->call('startUnloading', 'PO-2026-1093')
            ->assertSee('PO-2026-1093')
            ->call('verifyAndReceive', 'PO-2026-1093')
            ->assertSee('Telah Selesai Diverifikasi');
    }

    public function test_critical_stock_page_renders_and_executes_fefo(): void
    {
        $stock = Stock::factory()->create([
            'user_id' => $this->member->id,
            'name' => 'Susu UHT Segar 1L',
            'quantity' => 4,
            'min_stock' => 10,
        ]);

        Livewire::actingAs($this->member)
            ->test(CriticalStockAlert::class)
            ->assertStatus(200)
            ->assertSee('Pusat Peringatan')
            ->assertSee('Susu UHT Segar 1L')
            ->call('executeFefoBatch', $stock->id)
            ->call('applyClearanceDiscount', $stock->id);
    }

    public function test_stock_opname_can_reconcile_physical_count(): void
    {
        $stock = Stock::factory()->create([
            'user_id' => $this->member->id,
            'name' => 'Beras Pandan Wangi 5kg',
            'quantity' => 20,
        ]);

        Livewire::actingAs($this->member)
            ->test(StockOpnameSession::class)
            ->assertStatus(200)
            ->assertSee('Sesi Stock Opname')
            ->call('selectStock', $stock->id)
            ->set('physicalInput', 18)
            ->set('opnameNotes', 'Kemasan sobek 2 bungkus')
            ->call('reconcile', $stock->id);

        $this->assertEquals(18, $stock->fresh()->quantity);
        $this->assertDatabaseHas('stock_mutations', [
            'stock_id' => $stock->id,
            'type' => 'opname',
            'balance_after' => 18,
        ]);
    }

    public function test_supplier_return_claims_workflow(): void
    {
        Livewire::actingAs($this->member)
            ->test(SupplierReturnClaim::class)
            ->assertStatus(200)
            ->assertSee('Retur Barang')
            ->assertSee('BAP-2026-081')
            ->call('approveClaim', 'BAP-2026-081')
            ->assertSee('DISETUJUI')
            ->call('completeClaim', 'BAP-2026-081')
            ->assertSee('Kasus Selesai Ditutup');
    }

    public function test_inter_branch_transfers_workflow(): void
    {
        Livewire::actingAs($this->member)
            ->test(InterBranchTransfer::class)
            ->assertStatus(200)
            ->assertSee('Transfer Stok')
            ->assertSee('TRF-2026-001')
            ->call('confirmArrival', 'TRF-2026-001')
            ->assertSee('Stok Telah Diterima Lengkap di Cabang');
    }
}
