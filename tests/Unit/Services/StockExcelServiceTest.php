<?php

namespace Tests\Unit\Services;

use App\Features\Stock\Models\Stock;
use App\Features\Stock\Repositories\StockRepository;
use App\Features\Stock\Services\StockExcelService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Tests\TestCase;

class StockExcelServiceTest extends TestCase
{
    use RefreshDatabase;

    protected StockExcelService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new StockExcelService(new StockRepository());
    }

    public function test_build_spreadsheet_and_export_response(): void
    {
        $user = User::factory()->create();
        $stocks = Stock::factory()->count(2)->create(['user_id' => $user->id]);

        $spreadsheet = $this->service->buildSpreadsheet($stocks, 'Custom Stocks');
        $this->assertInstanceOf(Spreadsheet::class, $spreadsheet);
        $this->assertEquals('Custom Stocks', $spreadsheet->getActiveSheet()->getTitle());

        $response = $this->service->exportToResponse($stocks, 'test-stocks.xlsx');
        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        ob_start();
        $response->sendContent();
        $outputContent = ob_get_clean();
        $this->assertNotEmpty($outputContent);
    }

    public function test_import_spreadsheet(): void
    {
        $user = User::factory()->create();

        // Create an in-memory spreadsheet and save to a temporary file
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'SKU');
        $sheet->setCellValue('D1', 'Description');
        $sheet->setCellValue('E1', 'Quantity');
        $sheet->setCellValue('F1', 'Unit');
        $sheet->setCellValue('G1', 'Price');
        $sheet->setCellValue('H1', 'Min Stock');
        $sheet->setCellValue('I1', 'Status');

        // Row 2: Standard stock
        $sheet->setCellValue('A2', '1');
        $sheet->setCellValue('B2', 'Kabel LAN Cat6');
        $sheet->setCellValue('C2', 'LAN-CAT6');
        $sheet->setCellValue('D2', 'Kabel 1 meter');
        $sheet->setCellValue('E2', '15');
        $sheet->setCellValue('F2', 'pcs');
        $sheet->setCellValue('G2', '15000');
        $sheet->setCellValue('H2', '5');
        $sheet->setCellValue('I2', 'available');

        // Row 3: Status invalid fallback to low_stock (qty 3, min 5)
        $sheet->setCellValue('A3', '2');
        $sheet->setCellValue('B3', 'Konektor RJ45');
        $sheet->setCellValue('C3', '-');
        $sheet->setCellValue('D3', '-');
        $sheet->setCellValue('E3', '3');
        $sheet->setCellValue('F3', '-');
        $sheet->setCellValue('G3', '-');
        $sheet->setCellValue('H3', '5');
        $sheet->setCellValue('I3', 'unknown_status');

        // Row 4: Column B empty, fallback to Column A; qty 0 -> out_of_stock
        $sheet->setCellValue('A4', 'Crimping Tool');
        $sheet->setCellValue('B4', '');
        $sheet->setCellValue('C4', 'CRIMP-1');
        $sheet->setCellValue('D4', 'Tang crimping');
        $sheet->setCellValue('E4', '0');
        $sheet->setCellValue('F4', 'unit');
        $sheet->setCellValue('G4', '75000');
        $sheet->setCellValue('H4', '2');
        $sheet->setCellValue('I4', '');

        // Row 5: Invalid status with high quantity (fallback to available)
        $sheet->setCellValue('A5', '5');
        $sheet->setCellValue('B5', 'Switch Hub 8 Port');
        $sheet->setCellValue('C5', 'SW-8P');
        $sheet->setCellValue('D5', 'Gigabit switch');
        $sheet->setCellValue('E5', '20');
        $sheet->setCellValue('F5', 'unit');
        $sheet->setCellValue('G5', '250000');
        $sheet->setCellValue('H5', '5');
        $sheet->setCellValue('I5', 'invalid_status_fallback');

        // Row 6: Header repeat / empty row (should be skipped)
        $sheet->setCellValue('A6', 'No');
        $sheet->setCellValue('B6', 'Name');
        $sheet->setCellValue('C6', 'Skip this');

        $tempPath = tempnam(sys_get_temp_dir(), 'test_stock_excel_') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempPath);

        $result = $this->service->import($tempPath, $user->id);
        @unlink($tempPath);

        $this->assertEquals(4, $result['imported']);
        $this->assertDatabaseHas('stocks', [
            'user_id' => $user->id,
            'name' => 'Kabel LAN Cat6',
            'sku' => 'LAN-CAT6',
            'status' => 'available',
            'quantity' => 15,
        ]);
        $this->assertDatabaseHas('stocks', [
            'user_id' => $user->id,
            'name' => 'Konektor RJ45',
            'sku' => null,
            'description' => null,
            'status' => 'low_stock',
            'quantity' => 3,
        ]);
        $this->assertDatabaseHas('stocks', [
            'user_id' => $user->id,
            'name' => 'Crimping Tool',
            'status' => 'out_of_stock',
            'quantity' => 0,
        ]);
        $this->assertDatabaseHas('stocks', [
            'user_id' => $user->id,
            'name' => 'Switch Hub 8 Port',
            'status' => 'available',
            'quantity' => 20,
        ]);
    }
}
