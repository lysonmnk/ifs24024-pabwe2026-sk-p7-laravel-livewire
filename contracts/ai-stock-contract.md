# Data Contract: AI Stock Generator (OpenAI)
*Ditetapkan oleh @data-master | Menjadi acuan @backend & @frontend*

---

## 1. DTO Specification: `GeneratedStockItem`
Namespace: `App\Features\Ai\DTO\GeneratedStockItem`

```php
class GeneratedStockItem
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $sku,
        public readonly ?string $description,
        public readonly int $quantity,
        public readonly string $unit = 'pcs',
        public readonly ?float $price = null,
        public readonly int $minStock = 5,
    ) {}

    public static function fromArray(array $data): self;
    public function toArray(): array;
}
```

---

## 2. Kontrak Alur Preview & Simpan di Livewire
1. **Input User:** String prompt (contoh: *"Buatkan 5 perlengkapan alat tulis kantor"*).
2. **Service Call:** `OpenAiStockGeneratorService::generate(string $prompt): array<GeneratedStockItem>`.
3. **Preview State (Livewire):** Ditampilkan dalam bentuk tabel pratinjau dengan kotak centang (*checkbox*).
4. **Penyimpanan:** User mencentang item yang disukai ➔ memanggil `StockService::createMany(array $selectedItems)` untuk disimpan langsung ke database milik user yang sedang login.
