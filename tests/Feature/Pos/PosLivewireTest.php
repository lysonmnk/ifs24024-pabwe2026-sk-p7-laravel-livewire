<?php

namespace Tests\Feature\Pos;

use App\Features\Pos\Livewire\PosTerminal;
use App\Features\Stock\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PosLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_pos(): void
    {
        $this->get('/pos')
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_render_pos_page(): void
    {
        $user = User::factory()->member()->create();

        Stock::factory()->count(3)->create([
            'user_id' => $user->id,
            'category' => 'Sembako',
        ]);

        $this->actingAs($user)
            ->get('/pos')
            ->assertStatus(200)
            ->assertSee('Kasir POS')
            ->assertSee('Transaksi Toko');
    }

    public function test_can_search_and_filter_stocks(): void
    {
        $user = User::factory()->member()->create();

        Stock::factory()->create([
            'user_id' => $user->id,
            'name' => 'Beras Pandan Wangi',
            'category' => 'Sembako',
            'price' => 75000,
            'quantity' => 20,
        ]);

        Stock::factory()->create([
            'user_id' => $user->id,
            'name' => 'Minyak Goreng Bimoli',
            'category' => 'Minuman',
            'price' => 37000,
            'quantity' => 15,
        ]);

        Livewire::actingAs($user)
            ->test(PosTerminal::class)
            ->set('search', 'Beras')
            ->assertSee('Beras Pandan Wangi')
            ->assertDontSee('Minyak Goreng Bimoli')
            ->set('search', '')
            ->call('setCategory', 'Minuman')
            ->assertSee('Minyak Goreng Bimoli')
            ->assertDontSee('Beras Pandan Wangi');
    }

    public function test_can_add_item_to_cart_and_modify_quantity(): void
    {
        $user = User::factory()->member()->create();

        $stock = Stock::factory()->create([
            'user_id' => $user->id,
            'name' => 'Gula Pasir Gulaku',
            'price' => 17500,
            'quantity' => 10,
        ]);

        Livewire::actingAs($user)
            ->test(PosTerminal::class)
            ->call('addToCart', $stock->id)
            ->assertSet('cart.' . $stock->id . '.quantity', 1)
            ->assertSet('cart.' . $stock->id . '.subtotal', 17500)
            ->call('incrementQty', $stock->id)
            ->assertSet('cart.' . $stock->id . '.quantity', 2)
            ->assertSet('cart.' . $stock->id . '.subtotal', 35000)
            ->call('decrementQty', $stock->id)
            ->assertSet('cart.' . $stock->id . '.quantity', 1)
            ->assertSet('cart.' . $stock->id . '.subtotal', 17500)
            ->call('decrementQty', $stock->id)
            ->assertSet('cart', []);
    }

    public function test_cannot_exceed_available_stock_in_cart(): void
    {
        $user = User::factory()->member()->create();

        $stock = Stock::factory()->create([
            'user_id' => $user->id,
            'name' => 'Barang Terbatas',
            'price' => 10000,
            'quantity' => 2,
        ]);

        Livewire::actingAs($user)
            ->test(PosTerminal::class)
            ->call('addToCart', $stock->id)
            ->call('incrementQty', $stock->id)
            ->assertSet('cart.' . $stock->id . '.quantity', 2)
            ->call('incrementQty', $stock->id)
            ->assertSet('cart.' . $stock->id . '.quantity', 2);
    }

    public function test_can_apply_voucher_and_calculate_discount(): void
    {
        $user = User::factory()->member()->create();

        Livewire::actingAs($user)
            ->test(PosTerminal::class)
            ->set('voucherCode', 'MEMBER-SITI')
            ->call('applyVoucher')
            ->assertSet('discount', 10000)
            ->set('voucherCode', 'HEMAT20')
            ->call('applyVoucher')
            ->assertSet('discount', 20000)
            ->set('voucherCode', 'INVALID')
            ->call('applyVoucher');
    }

    public function test_can_checkout_and_decrement_stock_in_database(): void
    {
        $user = User::factory()->member()->create();

        $stock = Stock::factory()->create([
            'user_id' => $user->id,
            'name' => 'Kopi Kapal Api',
            'price' => 15000,
            'quantity' => 20,
        ]);

        Livewire::actingAs($user)
            ->test(PosTerminal::class)
            ->call('addToCart', $stock->id)
            ->call('incrementQty', $stock->id) // quantity = 2, total = 30000 - discount
            ->set('discount', 5000)
            ->set('cashTendered', 50000)
            ->call('checkout')
            ->assertSet('showReceiptModal', true)
            ->assertSet('cart', [])
            ->assertHasNoErrors();

        $this->assertDatabaseHas('stocks', [
            'id' => $stock->id,
            'quantity' => 18, // 20 - 2 = 18
        ]);
    }

    public function test_cannot_checkout_with_empty_cart(): void
    {
        $user = User::factory()->member()->create();

        Livewire::actingAs($user)
            ->test(PosTerminal::class)
            ->set('cart', [])
            ->call('checkout')
            ->assertSet('showReceiptModal', false);
    }
}
