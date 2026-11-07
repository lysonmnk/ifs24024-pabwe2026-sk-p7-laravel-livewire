# DESIGN_SYSTEM.md: Standar Visual & UI Aplikasi Stock Barang

---

## 01 Brand Identity & Layout
- **Aplikasi:** Inventaris Stok Barang (Stock Management)
- **Master Layout:** `resources/views/components/layouts/app.blade.php`
- **Prinsip Tampilan:** Bersih, fungsional, responsif, dan mudah dibaca pada daftar data tabel yang padat.

---

## 02 Badge Status Kuantitas Stok (Wajib Sesuai Modul)

| Status Stok | Warna Badge | Tailwind Class | Keterangan |
|---|---|---|---|
| `available` | **Hijau** | `bg-emerald-100 text-emerald-800 border border-emerald-200` | Stok aman di atas `min_stock` |
| `low_stock` | **Kuning** | `bg-amber-100 text-amber-800 border border-amber-200` | Stok menipis (<= `min_stock` dan > 0) |
| `out_of_stock` | **Merah** | `bg-rose-100 text-rose-800 border border-rose-200` | Stok kosong (`quantity == 0`) |

---

## 03 Form Login IDs (Wajib Sesuai Kriteria Penilaian)
Untuk memastikan pengujian otomatis dan penilaian lolos, form login pada `resources/views/livewire/auth/login.blade.php` WAJIB menggunakan ID berikut:
- Input Username: `id="login-username"`
- Input Password: `id="login-password"`
- Tombol Submit: `id="login-submit"`

---

## 04 Editor & Renderer Deskripsi (Toast UI)
- Untuk field `description` pada form create/edit stok: gunakan **Toast UI Editor** mode Markdown.
- Untuk tampilan detail stok di `stock-detail.blade.php`: gunakan **Toast UI Viewer** agar format Markdown (heading, list, bold, code block) ter-render dengan sempurna.

---

## 05 Komponen Tabel & Modal
- **Tabel Stok:** Kolom: Checkbox, Nama Barang, SKU, Status (Badge), Kuantitas (dengan tombol inline `+` dan `−`), Satuan, Harga, Aksi.
- **Modal CRUD:** Modal pop-up Livewire dengan transisi halus (`wire:model` real-time validation feedback).
