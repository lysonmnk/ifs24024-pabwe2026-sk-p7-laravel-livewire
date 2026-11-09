<?php

namespace Tests\Feature\Stock;

use App\Features\Stock\Livewire\StockMutationList;
use App\Features\Stock\Models\Stock;
use App\Features\Stock\Models\StockMutation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StockMutationLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_redirected_to_login_when_accessing_mutations(): void
    {
        $this->get('/mutations')
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_render_mutations_page(): void
    {
        $user = User::factory()->member()->create();

        $this->actingAs($user)
            ->get('/mutations')
            ->assertStatus(200)
            ->assertSee('Riwayat Mutasi')
            ->assertSee('Audit Ledger');
    }

    public function test_can_filter_mutations_by_type(): void
    {
        $user = User::factory()->member()->create();

        $stock = Stock::factory()->create(['user_id' => $user->id, 'name' => 'Kecap Manis Bango']);

        StockMutation::create([
            'user_id' => $user->id,
            'stock_id' => $stock->id,
            'batch_no' => '#MUT-KULAKAN-01',
            'type' => 'in',
            'quantity' => 100,
            'balance_after' => 100,
            'notes' => 'Kulakan Supplier Bango',
        ]);

        StockMutation::create([
            'user_id' => $user->id,
            'stock_id' => $stock->id,
            'batch_no' => '#MUT-KASIR-99',
            'type' => 'out',
            'quantity' => -10,
            'balance_after' => 90,
            'notes' => 'Kasir POS Pembeli Retail',
        ]);

        Livewire::actingAs($user)
            ->test(StockMutationList::class)
            ->call('setFilter', 'in')
            ->assertSee('#MUT-KULAKAN-01')
            ->assertDontSee('#MUT-KASIR-99')
            ->call('setFilter', 'out')
            ->assertSee('#MUT-KASIR-99')
            ->assertDontSee('#MUT-KULAKAN-01');
    }

    public function test_can_search_mutations(): void
    {
        $user = User::factory()->member()->create();

        $stock = Stock::factory()->create(['user_id' => $user->id, 'name' => 'Susu Kental Manis']);

        StockMutation::create([
            'user_id' => $user->id,
            'stock_id' => $stock->id,
            'batch_no' => '#BATCH-UNIK-999',
            'type' => 'in',
            'quantity' => 20,
            'balance_after' => 20,
            'notes' => 'Pengiriman Khusus Toko',
        ]);

        Livewire::actingAs($user)
            ->test(StockMutationList::class)
            ->set('search', 'UNIK-999')
            ->assertSee('#BATCH-UNIK-999');
    }

    public function test_can_export_audit_log(): void
    {
        $user = User::factory()->member()->create();

        $stock = Stock::factory()->create(['user_id' => $user->id, 'name' => 'Teh Celup Sariwangi']);

        StockMutation::create([
            'user_id' => $user->id,
            'stock_id' => $stock->id,
            'batch_no' => '#MUT-EXP-01',
            'type' => 'in',
            'quantity' => 50,
            'balance_after' => 50,
            'notes' => 'Barang Masuk',
        ]);

        $component = Livewire::actingAs($user)
            ->test(StockMutationList::class)
            ->call('exportAuditLog');

        $component->assertFileDownloaded();
    }
}
