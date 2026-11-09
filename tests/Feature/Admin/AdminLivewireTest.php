<?php

namespace Tests\Feature\Admin;

use App\Features\Admin\Livewire\AdminUserStockList;
use App\Features\Admin\Livewire\UserList;
use App\Features\Stock\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminLivewireTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_forbidden_from_admin_pages(): void
    {
        $member = User::factory()->member()->create();
        $targetUser = User::factory()->member()->create();

        $this->actingAs($member)
            ->get('/admin/users')
            ->assertStatus(403);

        $this->actingAs($member)
            ->get("/admin/users/{$targetUser->id}/stocks")
            ->assertStatus(403);
    }

    public function test_admin_can_view_user_list(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->create(['name' => 'Budi Santoso', 'email' => 'budi@test.com']);
        User::factory()->create(['name' => 'Citra Lestari', 'email' => 'citra@test.com']);

        $this->actingAs($admin);

        Livewire::test(UserList::class)
            ->assertSee('Budi Santoso')
            ->assertSee('Citra Lestari')
            ->set('search', 'Budi')
            ->assertSee('Budi Santoso')
            ->assertDontSee('Citra Lestari');
    }

    public function test_admin_can_view_user_stocks_read_only(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->member()->create(['name' => 'Dewi Sartika']);

        Stock::factory()->create(['user_id' => $member->id, 'name' => 'Kertas A4', 'status' => 'available']);
        Stock::factory()->create(['user_id' => $member->id, 'name' => 'Pulpen Gel', 'status' => 'out_of_stock']);

        $this->actingAs($admin);

        Livewire::test(AdminUserStockList::class, ['user' => $member])
            ->assertSee('Dewi Sartika')
            ->assertSee('Kertas A4')
            ->assertSee('Pulpen Gel')
            ->set('search', 'Kertas')
            ->assertSee('Kertas A4')
            ->assertDontSee('Pulpen Gel')
            ->set('search', '')
            ->set('statusFilter', 'out_of_stock')
            ->assertSee('Pulpen Gel')
            ->assertDontSee('Kertas A4');
    }

    public function test_admin_can_export_user_stocks(): void
    {
        $admin = User::factory()->admin()->create();
        $member = User::factory()->member()->create(['name' => 'Eko Prasetyo']);
        Stock::factory()->create(['user_id' => $member->id, 'name' => 'Barang Export Admin']);

        $this->actingAs($admin);

        Livewire::test(AdminUserStockList::class, ['user' => $member])
            ->call('exportExcel')
            ->assertFileDownloaded();
    }

    public function test_admin_can_filter_users_by_role_and_toggle_view_mode(): void
    {
        $admin = User::factory()->admin()->create(['name' => 'Admin Boss']);
        User::factory()->member()->create(['name' => 'Member Store One']);
        User::factory()->admin()->create(['name' => 'Co-Admin Two']);

        $this->actingAs($admin);

        Livewire::test(UserList::class)
            ->assertSee('Member Store One')
            ->assertSee('Co-Admin Two')
            ->call('setRole', 'member')
            ->assertSee('Member Store One')
            ->assertDontSee('Co-Admin Two')
            ->call('setRole', 'admin')
            ->assertSee('Co-Admin Two')
            ->assertDontSee('Member Store One')
            ->call('setViewMode', 'table')
            ->assertSet('viewMode', 'table')
            ->assertSee('Co-Admin Two');
    }
}
