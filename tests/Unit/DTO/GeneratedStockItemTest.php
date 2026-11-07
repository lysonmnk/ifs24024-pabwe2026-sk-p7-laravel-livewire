<?php

namespace Tests\Unit\DTO;

use App\Features\Ai\DTO\GeneratedStockItem;
use PHPUnit\Framework\TestCase;

class GeneratedStockItemTest extends TestCase
{
    public function test_dto_properties_and_to_array(): void
    {
        $dto = new GeneratedStockItem(
            name: 'Kabel USB Type-C',
            sku: 'USB-C-001',
            description: 'Kabel fast charging 65W',
            quantity: 25,
            unit: 'pcs',
            price: 45000.0,
            minStock: 5,
            status: 'available'
        );

        $this->assertEquals('Kabel USB Type-C', $dto->name);
        $this->assertEquals('USB-C-001', $dto->sku);
        $this->assertEquals('Kabel fast charging 65W', $dto->description);
        $this->assertEquals(25, $dto->quantity);
        $this->assertEquals('pcs', $dto->unit);
        $this->assertEquals(45000.0, $dto->price);
        $this->assertEquals(5, $dto->minStock);
        $this->assertEquals('available', $dto->status);

        $array = $dto->toArray();
        $this->assertEquals([
            'name' => 'Kabel USB Type-C',
            'sku' => 'USB-C-001',
            'description' => 'Kabel fast charging 65W',
            'quantity' => 25,
            'unit' => 'pcs',
            'price' => 45000.0,
            'min_stock' => 5,
            'status' => 'available',
        ], $array);
    }
}
