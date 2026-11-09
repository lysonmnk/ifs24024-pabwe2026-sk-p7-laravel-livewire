<?php

namespace Tests\Feature\Finance;

use App\Features\Finance\Livewire\CustomerDebtBook;
use App\Features\Finance\Livewire\VendorPayableManager;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FinanceLivewireTest extends TestCase
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

    public function test_guests_are_redirected_to_login_for_finance_routes(): void
    {
        $this->get('/debts')->assertRedirect(route('login'));
        $this->get('/accounts-payable')->assertRedirect(route('login'));
    }

    public function test_customer_debt_book_renders_and_records_payment(): void
    {
        Livewire::actingAs($this->member)
            ->test(CustomerDebtBook::class)
            ->assertStatus(200)
            ->assertSee('Buku Bon')
            ->assertSee('BON-2026-081')
            ->assertSee('Toko Kelontong Berkah Ibu')
            ->set('paymentAmount', 1000000)
            ->call('recordPayment', 'BON-2026-081')
            ->assertSee('7.450.000');
    }

    public function test_vendor_payable_manager_renders_and_pays_invoice(): void
    {
        Livewire::actingAs($this->member)
            ->test(VendorPayableManager::class)
            ->assertStatus(200)
            ->assertSee('Utang Vendor')
            ->assertSee('INV-AP-9901')
            ->assertSee('PT Salim Ivomas Pratama')
            ->call('payInvoice', 'INV-AP-9901')
            ->assertSee('Faktur Telah Lunas Terbayar');
    }
}
