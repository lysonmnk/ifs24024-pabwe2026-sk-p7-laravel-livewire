<?php

namespace App\Features\Stock\Repositories;

use App\Features\Stock\Contracts\StockRepositoryInterface;
use App\Features\Stock\Models\Stock;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class StockRepository implements StockRepositoryInterface
{
    /**
     * Get paginated stocks for a given user with optional status, search, and category filters.
     */
    public function forUser(int $userId, ?string $status = null, ?string $search = null, int $perPage = 10, ?string $category = null): LengthAwarePaginator
    {
        $query = Stock::query()->where('user_id', $userId);

        if (!empty($status)) {
            $query->where('status', $status);
        }

        if (!empty($category)) {
            $query->where('category', $category);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('supplier', 'like', "%{$search}%")
                  ->orWhere('rack_location', 'like', "%{$search}%");
            });
        }

        return $query->latest('id')->paginate($perPage);
    }

    /**
     * Get aggregate inventory telemetry for a user (asset value, safe ratio, restock count, categories).
     *
     * @return array{total_items: int, total_asset_value: float, safe_stock_ratio: int, need_restock_count: int, categories: array<int, string>}
     */
    public function getTelemetryForUser(int $userId): array
    {
        $userStocks = Stock::query()
            ->where('user_id', $userId)
            ->get(['id', 'quantity', 'price', 'min_stock', 'category']);

        $totalItems = $userStocks->count();
        $totalAssetValue = (float) $userStocks->sum(fn ($s) => (float) ($s->quantity * ($s->price ?? 0)));
        $safeCount = $userStocks->filter(fn ($s) => $s->quantity > $s->min_stock)->count();
        $needRestockCount = $userStocks->filter(fn ($s) => $s->quantity <= $s->min_stock)->count();
        $safeRatio = $totalItems > 0 ? (int) round(($safeCount / $totalItems) * 100) : 100;

        $categories = $userStocks
            ->pluck('category')
            ->filter(fn ($c) => !empty($c))
            ->unique()
            ->values()
            ->all();

        return [
            'total_items' => $totalItems,
            'total_asset_value' => $totalAssetValue,
            'safe_stock_ratio' => $safeRatio,
            'need_restock_count' => $needRestockCount,
            'categories' => $categories,
        ];
    }

    /**
     * Get all stocks for a given user without pagination.
     *
     * @return Collection<int, Stock>
     */
    public function allForUser(int $userId): Collection
    {
        return Stock::query()
            ->where('user_id', $userId)
            ->latest('id')
            ->get();
    }

    /**
     * Find a stock by id.
     */
    public function find(int $id): ?Stock
    {
        return Stock::find($id);
    }

    /**
     * Find a stock by id or throw an exception.
     */
    public function findOrFail(int $id): Stock
    {
        return Stock::findOrFail($id);
    }

    /**
     * Create a new stock item.
     *
     * @param array<string, mixed> $attributes
     */
    public function create(array $attributes): Stock
    {
        return Stock::create($attributes);
    }

    /**
     * Update an existing stock item.
     *
     * @param array<string, mixed> $attributes
     */
    public function update(Stock $stock, array $attributes): bool
    {
        return $stock->update($attributes);
    }

    /**
     * Delete an existing stock item.
     */
    public function delete(Stock $stock): bool
    {
        return (bool) $stock->delete();
    }

    /**
     * Insert multiple stock items at once.
     *
     * @param array<int, array<string, mixed>> $records
     */
    public function insertMany(array $records): bool
    {
        if (empty($records)) {
            return true;
        }

        return Stock::insert($records);
    }
}
