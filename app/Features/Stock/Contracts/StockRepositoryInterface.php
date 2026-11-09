<?php

namespace App\Features\Stock\Contracts;

use App\Features\Stock\Models\Stock;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface StockRepositoryInterface
{
    /**
     * Get paginated stocks for a given user with optional status, search, and category filters.
     */
    public function forUser(int $userId, ?string $status = null, ?string $search = null, int $perPage = 10, ?string $category = null): LengthAwarePaginator;

    /**
     * Get aggregate inventory telemetry for a user (asset value, safe ratio, restock count, categories).
     *
     * @return array{total_items: int, total_asset_value: float, safe_stock_ratio: int, need_restock_count: int, categories: array<int, string>}
     */
    public function getTelemetryForUser(int $userId): array;

    /**
     * Get all stocks for a given user without pagination.
     *
     * @return Collection<int, Stock>
     */
    public function allForUser(int $userId): Collection;

    /**
     * Find a stock by id.
     */
    public function find(int $id): ?Stock;

    /**
     * Find a stock by id or throw an exception.
     */
    public function findOrFail(int $id): Stock;

    /**
     * Create a new stock item.
     *
     * @param array<string, mixed> $attributes
     */
    public function create(array $attributes): Stock;

    /**
     * Update an existing stock item.
     *
     * @param array<string, mixed> $attributes
     */
    public function update(Stock $stock, array $attributes): bool;

    /**
     * Delete an existing stock item.
     */
    public function delete(Stock $stock): bool;

    /**
     * Insert multiple stock items at once.
     *
     * @param array<int, array<string, mixed>> $records
     */
    public function insertMany(array $records): bool;
}
