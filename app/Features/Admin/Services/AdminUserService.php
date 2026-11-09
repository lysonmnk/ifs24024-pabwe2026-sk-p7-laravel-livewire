<?php

namespace App\Features\Admin\Services;

use App\Features\Stock\Contracts\StockRepositoryInterface;
use App\Features\Stock\Models\Stock;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AdminUserService
{
    public function __construct(
        protected StockRepositoryInterface $stockRepository
    ) {}

    /**
     * Get paginated list of all users with their stocks count.
     */
    public function getUsersList(?string $search = null, ?string $role = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = User::query()->withCount('stocks');

        if (!empty($role)) {
            $query->where('role', $role);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->latest('id')->paginate($perPage);
    }

    /**
     * Get read-only list of stocks for a specific target user.
     */
    public function getUserStocks(int $userId, ?string $status = null, ?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->stockRepository->forUser($userId, $status, $search, $perPage);
    }

    /**
     * Get aggregate telemetry metrics for admin dashboard.
     */
    public function getAdminTelemetry(): array
    {
        $totalUsers = User::count();
        $totalStores = User::where('role', 'member')->count();
        $adminCount = User::where('role', 'admin')->count();
        $totalSkuCount = Stock::count();
        $totalNetworkAssetValue = (float) (Stock::sum(DB::raw('quantity * COALESCE(price, 0)')) ?? 0);

        return [
            'total_users' => $totalUsers,
            'total_stores' => $totalStores,
            'admin_count' => $adminCount,
            'total_sku_count' => $totalSkuCount,
            'total_network_asset_value' => $totalNetworkAssetValue,
        ];
    }
}
