<?php

namespace Tests\Feature\Stock;

use App\Features\Stock\Livewire\SalesReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SalesReportLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_redirected_to_login_when_accessing_reports(): void
    {
        $this->get('/reports')
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_render_sales_report_page(): void
    {
        $user = User::factory()->member()->create();

        $this->actingAs($user)
            ->get('/reports')
            ->assertStatus(200)
            ->assertSee('Laporan')
            ->assertSee('Penjualan & Laba');
    }

    public function test_can_switch_period_filter(): void
    {
        $user = User::factory()->member()->create();

        Livewire::actingAs($user)
            ->test(SalesReport::class)
            ->assertSet('periodFilter', 'month')
            ->call('setPeriod', 'today')
            ->assertSet('periodFilter', 'today')
            ->call('setPeriod', 'week')
            ->assertSet('periodFilter', 'week');
    }

    public function test_can_search_transactions(): void
    {
        $user = User::factory()->member()->create();

        Livewire::actingAs($user)
            ->test(SalesReport::class)
            ->set('search', 'Bu Siti')
            ->assertSee('TRX-2026-0842')
            ->assertDontSee('TRX-2026-0840')
            ->set('search', 'Cakung')
            ->assertSee('TRX-2026-0840')
            ->assertDontSee('TRX-2026-0842');
    }

    public function test_can_export_financial_report(): void
    {
        $user = User::factory()->member()->create();

        $component = Livewire::actingAs($user)
            ->test(SalesReport::class)
            ->call('exportFinancialReport');

        $component->assertFileDownloaded();
    }
}
