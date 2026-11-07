# Data Contract: Model & Payload Stok Barang
*Ditetapkan oleh @data-master | Menjadi acuan @backend & @frontend*

---

## 1. Skema Entitas `Stock`
```json
{
  "id": 1,
  "user_id": 2,
  "name": "Buku Catatan A5",
  "sku": "STK-BKO-001",
  "description": "## Spesifikasi\n- Kertas 80 gsm\n- Isi 100 lembar",
  "quantity": 15,
  "unit": "pcs",
  "price": 25000.00,
  "min_stock": 5,
  "status": "available",
  "cover_image_path": "covers/sample.png",
  "created_at": "2026-11-07T10:00:00Z",
  "updated_at": "2026-11-07T10:00:00Z"
}
```

---

## 2. Kontrak Validasi Form Create / Update
- `name`: `required|string|max:255`
- `sku`: `nullable|string|max:100`
- `description`: `nullable|string` (format Markdown didukung)
- `quantity`: `required|integer|min:0`
- `unit`: `required|string|max:20` (default: `pcs`)
- `price`: `nullable|numeric|min:0`
- `min_stock`: `required|integer|min:0` (default: `5`)
- `cover_image`: `nullable|image|max:2048` (2MB max)

---

## 3. Kontrak Operasi Adjust Quantity
- **Metode:** `adjustQuantity(int $stockId, int $delta)`
  - Parameter `$delta`: `+1` untuk tambah, `-1` untuk kurang.
  - Aturan: `quantity` baru tidak boleh kurang dari `0`.
  - Status otomatis terupdate sesuai formula `StockStatus`.
