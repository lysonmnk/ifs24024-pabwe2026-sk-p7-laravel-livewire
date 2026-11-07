<?php

namespace App\Features\Ai\Services;

use App\Features\Ai\Contracts\AiClientInterface;
use App\Features\Ai\DTO\GeneratedStockItem;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class OpenAiStockGeneratorService implements AiClientInterface
{
    protected string $endpoint;
    protected string $apiKey;
    protected string $model;

    public function __construct(
        ?string $endpoint = null,
        ?string $apiKey = null,
        ?string $model = null,
    ) {
        $resolvedEndpoint = (string) ($endpoint ?? config('openai.endpoint', 'https://api.openai.com/v1'));
        $resolvedKey = (string) ($apiKey ?? config('openai.key', ''));

        // Toleransi jika nilai OPENAI_ENDPOINT dan OPENAI_KEY tertukar di .env
        if ((str_starts_with($resolvedKey, 'http://') || str_starts_with($resolvedKey, 'https://')) &&
            (!str_starts_with($resolvedEndpoint, 'http://') && !str_starts_with($resolvedEndpoint, 'https://'))) {
            $temp = $resolvedEndpoint;
            $resolvedEndpoint = $resolvedKey;
            $resolvedKey = $temp;
        }

        // Pastikan scheme http:// atau https:// selalu ada
        if (!empty($resolvedEndpoint) && !str_starts_with($resolvedEndpoint, 'http://') && !str_starts_with($resolvedEndpoint, 'https://')) {
            $resolvedEndpoint = 'https://' . $resolvedEndpoint;
        }

        $this->endpoint = rtrim($resolvedEndpoint, '/');
        $this->apiKey = $resolvedKey;
        $this->model = $model ?? (string) config('openai.model', 'gpt-4o-mini');
    }

    /**
     * Generate multiple structured stock items based on a user prompt.
     *
     * @return array<int, GeneratedStockItem>
     *
     * @throws RuntimeException
     */
    public function generateStocks(string $prompt, int $count = 3): array
    {
        $prompt = trim($prompt);
        if ($prompt === '') {
            throw new RuntimeException('Prompt tidak boleh kosong.');
        }

        $count = max(1, $count);

        $systemPrompt = <<<SYS
You are an expert inventory and warehouse management assistant. Your task is to generate exactly {$count} realistic, practical, and structured stock inventory items based on the user's request.

You MUST respond strictly with a valid JSON object matching this schema:
{
  "stocks": [
    {
      "name": "Item name (max 100 chars)",
      "sku": "Unique SKU code (e.g. STK-001)",
      "description": "Brief helpful Markdown description of specifications",
      "quantity": 10,
      "unit": "pcs",
      "price": 25000,
      "min_stock": 5
    }
  ]
}

Do not include any conversational text, introductory words, or markdown code fences outside the JSON.
SYS;

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->timeout(30)->post("{$this->endpoint}/chat/completions", [
            'model' => $this->model,
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ]);

        if (!$response->successful()) {
            $errorMessage = $response->json('error.message') ?? "Request failed with status code {$response->status()}";
            throw new RuntimeException("OpenAI API Error: {$errorMessage}");
        }

        $rawContent = (string) $response->json('choices.0.message.content');
        return $this->parseContent($rawContent);
    }

    /**
     * Parse raw string content into an array of GeneratedStockItem.
     *
     * @return array<int, GeneratedStockItem>
     *
     * @throws RuntimeException
     */
    public function parseContent(string $rawContent): array
    {
        $cleaned = trim($rawContent);

        // Strip markdown code fences if model returned them
        if (str_starts_with($cleaned, '```json')) {
            $cleaned = substr($cleaned, 7);
        } elseif (str_starts_with($cleaned, '```')) {
            $cleaned = substr($cleaned, 3);
        }
        if (str_ends_with($cleaned, '```')) {
            $cleaned = substr($cleaned, 0, -3);
        }
        $cleaned = trim($cleaned);

        $decoded = json_decode($cleaned, true);

        if (!is_array($decoded) || !isset($decoded['stocks']) || !is_array($decoded['stocks'])) {
            throw new RuntimeException('Format respons AI tidak valid. Diharapkan JSON dengan key "stocks".');
        }

        $items = [];
        foreach ($decoded['stocks'] as $item) {
            if (!is_array($item) || empty($item['name'])) {
                continue;
            }

            $quantity = isset($item['quantity']) && is_numeric($item['quantity']) ? max(0, (int) $item['quantity']) : 10;
            $minStock = isset($item['min_stock']) && is_numeric($item['min_stock']) ? max(0, (int) $item['min_stock']) : 5;
            $price = isset($item['price']) && is_numeric($item['price']) ? (float) $item['price'] : null;

            $status = 'available';
            if ($quantity <= 0) {
                $status = 'out_of_stock';
            } elseif ($quantity <= $minStock) {
                $status = 'low_stock';
            }

            $items[] = new GeneratedStockItem(
                name: substr(trim((string) $item['name']), 0, 255),
                sku: isset($item['sku']) && trim((string) $item['sku']) !== '' ? substr(trim((string) $item['sku']), 0, 100) : null,
                description: isset($item['description']) && trim((string) $item['description']) !== '' ? trim((string) $item['description']) : null,
                quantity: $quantity,
                unit: isset($item['unit']) && trim((string) $item['unit']) !== '' ? substr(trim((string) $item['unit']), 0, 20) : 'pcs',
                price: $price,
                minStock: $minStock,
                status: $status,
            );
        }

        if (empty($items)) {
            throw new RuntimeException('Tidak ada item stok yang valid dalam respons AI.');
        }

        return $items;
    }
}
