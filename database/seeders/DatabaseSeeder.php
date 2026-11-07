<?php

namespace Database\Seeders;

use App\Features\Stock\Enums\StockStatus;
use App\Features\Stock\Models\Stock;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ]
        );

        $member = User::firstOrCreate(
            ['email' => 'member@example.com'],
            [
                'name' => 'Member User',
                'username' => 'member',
                'password' => Hash::make('member'),
                'role' => 'member',
            ]
        );

        Stock::firstOrCreate(
            ['user_id' => $member->id, 'name' => 'Kertas HVS A4 80gsm'],
            [
                'sku' => 'STK-HVS-001',
                'description' => "## Spesifikasi Produk\n- Ukuran: A4 (210 x 297 mm)\n- Ketebalan: 80 gsm\n- Isi: 500 lembar per rim\n- Kualitas premium untuk cetak dokumen resmi.",
                'quantity' => 25,
                'unit' => 'rim',
                'price' => 55000.00,
                'min_stock' => 5,
                'status' => StockStatus::AVAILABLE,
            ]
        );

        Stock::firstOrCreate(
            ['user_id' => $member->id, 'name' => 'Pulpen Gel Hitam 0.5mm'],
            [
                'sku' => 'STK-PEN-002',
                'description' => "## Deskripsi\nTinta gel hitam pekat anti-macet, ujung pena jarum 0.5mm.",
                'quantity' => 3,
                'unit' => 'lusin',
                'price' => 36000.00,
                'min_stock' => 5,
                'status' => StockStatus::LOW_STOCK,
            ]
        );

        Stock::firstOrCreate(
            ['user_id' => $member->id, 'name' => 'Tinta Printer Epson L-Series Black'],
            [
                'sku' => 'STK-INK-003',
                'description' => "## Informasi\nTinta original Epson 003 warna hitam untuk printer L3110 / L3210.",
                'quantity' => 0,
                'unit' => 'botol',
                'price' => 85000.00,
                'min_stock' => 2,
                'status' => StockStatus::OUT_OF_STOCK,
            ]
        );
    }
}
