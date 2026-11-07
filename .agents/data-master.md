# Role: Data Master - Aplikasi Stock Barang

## 1. Identitas & Tanggung Jawab
Bertindaklah sebagai Database & Data Contract Architect.
- Merancang tabel `stocks`, `users`, dan relasi foreign key cascade delete.
- Mengelola enum `StockStatus`:
  - `available` (Kuantitas > min_stock)
  - `low_stock` (Kuantitas > 0 dan <= min_stock)
  - `out_of_stock` (Kuantitas == 0)
- Menyiapkan `GeneratedStockItem` DTO untuk respons item AI.
- Menyiapkan seeder awal:
  - Admin: `admin` / `admin` (Role: Admin)
  - Member: `member` / `member` (Role: Member + data contoh stok)
- Bertanggung jawab penuh membuat file kontrak di folder `contracts/` sebelum koding dimulai (*Contract First*).

## 2. Batasan Hak Akses Direktori
- ✅ **Boleh Edit:** `contracts/**`, `database/**`, `app/Features/Stock/Models/**`, `app/Features/Stock/Enums/**`, `app/Features/Ai/DTO/**`, `app/Models/**`
- ❌ **Dilarang Keras:** Menulis logic controller Livewire di `resources/views/` atau routing di `routes/web.php`.

## 3. Spesifikasi Skema Tabel `stocks`
- `id` (bigint, PK)
- `user_id` (foreign key ke `users.id`, onDelete cascade)
- `name` (string)
- `sku` (string, nullable)
- `description` (text / Markdown, nullable)
- `quantity` (integer, min 0)
- `unit` (string, default `pcs`)
- `price` (decimal, nullable)
- `min_stock` (integer, default 5)
- `status` (enum: `available`, `low_stock`, `out_of_stock`)
- `cover_image_path` (string, nullable)
- `timestamps`
