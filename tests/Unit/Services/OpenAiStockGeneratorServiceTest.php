<?php

namespace Tests\Unit\Services;

use App\Features\Ai\Services\OpenAiStockGeneratorService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use RuntimeException;

class OpenAiStockGeneratorServiceTest extends TestCase
{
    public function test_empty_prompt_throws_exception(): void
    {
        $service = new OpenAiStockGeneratorService('https://api.openai.com/v1', 'mock-key', 'gpt-4o-mini');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Prompt tidak boleh kosong.');
        $service->generateStocks('   ');
    }

    public function test_successful_generation(): void
    {
        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response([
                'choices' => [
                    [
                        'message' => [
                            'content' => json_encode([
                                'stocks' => [
                                    [
                                        'name' => 'Buku Catatan A5',
                                        'sku' => 'NOTE-A5',
                                        'description' => 'Buku tulis garis 80 lembar',
                                        'quantity' => 20,
                                        'unit' => 'pcs',
                                        'price' => 12000,
                                        'min_stock' => 5,
                                    ],
                                    [
                                        'name' => 'Pulpen Gel Hitam',
                                        'sku' => null,
                                        'description' => null,
                                        'quantity' => 2,
                                        'unit' => 'pack',
                                        'price' => null,
                                        'min_stock' => 5,
                                    ],
                                    [
                                        'name' => 'Spidol Papan Tulis Habis',
                                        'sku' => 'SPIDOL-0',
                                        'description' => 'Spidol tinta habis',
                                        'quantity' => 0,
                                        'unit' => 'pcs',
                                        'price' => 8000,
                                        'min_stock' => 2,
                                    ],
                                ],
                            ]),
                        ],
                    ],
                ],
            ], 200),
        ]);

        $service = new OpenAiStockGeneratorService('https://api.openai.com/v1', 'mock-key', 'gpt-4o-mini');
        $results = $service->generateStocks('Buatkan 3 item stok', 3);

        $this->assertCount(3, $results);

        $this->assertEquals('Buku Catatan A5', $results[0]->name);
        $this->assertEquals('NOTE-A5', $results[0]->sku);
        $this->assertEquals('Buku tulis garis 80 lembar', $results[0]->description);
        $this->assertEquals(20, $results[0]->quantity);
        $this->assertEquals('pcs', $results[0]->unit);
        $this->assertEquals(12000.0, $results[0]->price);
        $this->assertEquals(5, $results[0]->minStock);
        $this->assertEquals('available', $results[0]->status);

        $this->assertEquals('Pulpen Gel Hitam', $results[1]->name);
        $this->assertNull($results[1]->sku);
        $this->assertNull($results[1]->description);
        $this->assertEquals(2, $results[1]->quantity);
        $this->assertEquals('pack', $results[1]->unit);
        $this->assertEquals('low_stock', $results[1]->status);

        $this->assertEquals('Spidol Papan Tulis Habis', $results[2]->name);
        $this->assertEquals(0, $results[2]->quantity);
        $this->assertEquals('out_of_stock', $results[2]->status);
    }

    public function test_api_failure_throws_exception(): void
    {
        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response([
                'error' => [
                    'message' => 'Invalid API Key provided',
                ],
            ], 401),
        ]);

        $service = new OpenAiStockGeneratorService('https://api.openai.com/v1', 'mock-key', 'gpt-4o-mini');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('OpenAI API Error: Invalid API Key provided');
        $service->generateStocks('Stok alat tulis');
    }

    public function test_parse_content_with_markdown_fences(): void
    {
        $service = new OpenAiStockGeneratorService('https://api.openai.com/v1', 'mock-key', 'gpt-4o-mini');
        
        // Test with ```json fence
        $rawJson = "```json\n{\"stocks\": [{\"name\": \"Code Fence Stock\", \"quantity\": 15, \"min_stock\": 5}]}\n```";
        $resultsJson = $service->parseContent($rawJson);
        $this->assertCount(1, $resultsJson);
        $this->assertEquals('Code Fence Stock', $resultsJson[0]->name);
        $this->assertEquals(15, $resultsJson[0]->quantity);

        // Test with plain ``` fence (without json)
        $rawPlain = "```\n{\"stocks\": [{\"name\": \"Plain Fence Stock\", \"quantity\": 8, \"min_stock\": 5}]}\n```";
        $resultsPlain = $service->parseContent($rawPlain);
        $this->assertCount(1, $resultsPlain);
        $this->assertEquals('Plain Fence Stock', $resultsPlain[0]->name);
        $this->assertEquals(8, $resultsPlain[0]->quantity);
    }

    public function test_parse_content_invalid_json(): void
    {
        $service = new OpenAiStockGeneratorService('https://api.openai.com/v1', 'mock-key', 'gpt-4o-mini');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Format respons AI tidak valid');
        $service->parseContent('Not valid JSON');
    }

    public function test_parse_content_empty_stocks(): void
    {
        $service = new OpenAiStockGeneratorService('https://api.openai.com/v1', 'mock-key', 'gpt-4o-mini');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Tidak ada item stok yang valid dalam respons AI.');
        $service->parseContent('{"stocks": []}');
    }

    public function test_parse_content_no_valid_items(): void
    {
        $service = new OpenAiStockGeneratorService('https://api.openai.com/v1', 'mock-key', 'gpt-4o-mini');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Tidak ada item stok yang valid dalam respons AI.');
        $service->parseContent('{"stocks": [{"bad_key": "val"}]}');
    }

    public function test_constructor_handles_swapped_endpoint_and_key(): void
    {
        Http::fake([
            'https://ai.example.com/v1/chat/completions' => Http::response([
                'choices' => [['message' => ['content' => '{"stocks":[{"name":"Barang"}]}']]],
            ]),
        ]);

        // Key given as URL, endpoint given as secret
        $service = new OpenAiStockGeneratorService('sk-secret-key', 'https://ai.example.com/v1');
        $stocks = $service->generateStocks('Barang');
        $this->assertCount(1, $stocks);
    }

    public function test_constructor_auto_prefixes_https(): void
    {
        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response([
                'choices' => [['message' => ['content' => '{"stocks":[{"name":"Barang"}]}']]],
            ]),
        ]);

        $service = new OpenAiStockGeneratorService('api.openai.com/v1', 'mock-key');
        $stocks = $service->generateStocks('Barang');
        $this->assertCount(1, $stocks);
    }
}
