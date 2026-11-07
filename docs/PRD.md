# Product Requirements Document (PRD): Aplikasi Stock Barang

---

## 01 Product Overview
- **Nama Produk:** Aplikasi Inventaris Stok Barang (PABWE P7)
- **Tech Stack:** Laravel 13, Livewire, PhpSpreadsheet, MySQL, Toast UI, OpenAI, Jenkins CI.
- **Tujuan Proyek:** Mengembangkan aplikasi manajemen stok barang berbasis Feature-First arsitektur dengan autentikasi, otorisasi berbasis kepemilikan (*ownership*), integrasi AI generator, export/import Excel, dan target pengujian 100% coverage.

---

## 02 Problem
Pengelolaan stok barang manual rentan terhadap ketidaksinkronan jumlah barang, keterlambatan identifikasi barang habis, serta lambatnya input data produk dalam jumlah besar.

---

## 03 Goal
Membangun platform inventaris mandiri bagi Member untuk mengelola stok dengan otomatisasi status kuantitas, import/export cepat via Excel, bantuan AI untuk generate katalog, serta panel audit read-only untuk Admin.

---

## 04 User Personas & Permissions

| Peran | Hak Akses | Keterangan |
|---|---|---|
| **Guest** | Login & Register | Rute `/` otomatis redirect ke `/login`. Form login wajib pakai ID spesifik. |
| **Member** | Manajemen Stok Mandiri | Akses `/stocks`, `/stocks/{id}`, `/profile`. Hanya bisa mengelola stok miliknya sendiri (`owns.stock`). |
| **Admin** | Audit Pengguna & Stok | Akses `/admin/users` dan `/admin/users/{user}/stocks`. Mode **Read-Only** (dilarang ubah/hapus data user lain). |

---

## 05 Core Features
1. **Daftar Stok (`/stocks`):** Pencarian teks, filter status (`available`, `low_stock`, `out_of_stock`), dan pagination.
2. **Modal CRUD Stok:** Field: Nama, SKU, Deskripsi Markdown (Toast UI), Kuantitas, Satuan (`pcs`), Harga, Min Stock (default: 5), Cover Image.
3. **Adjust Kuantitas Otomatis (+ / −):** Penyesuaian kuantitas secara langsung yang otomatis menyinkronkan status:
   - `quantity > min_stock` ➔ `available`
   - `quantity > 0 && quantity <= min_stock` ➔ `low_stock`
   - `quantity == 0` ➔ `out_of_stock`
4. **Detail Stok (`/stocks/{id}`):** Tampilan info detail, cover image, dan deskripsi dengan renderer Toast UI Markdown.
5. **Import & Export Excel:** Menggunakan PhpSpreadsheet untuk memproses data inventaris massal.
6. **AI Item Generator:** Menggunakan OpenAI untuk generate rekomendasi stok barang (preview ➔ select ➔ save).
7. **Profil Member:** Ubah data profil, ganti kata sandi, dan perbarui foto profil.
8. **Admin Audit Dashboard:** Melihat seluruh pengguna dan daftar stok tiap pengguna secara read-only.

---

## 06 Success Metrics & Assessment Criteria
- **Arsitektur:** 100% Feature-First di dalam `app/Features/`.
- **Elemen Login:** ID `login-username`, `login-password`, dan `login-submit` tersedia dan valid.
- **Quality Gate:** **Coverage 100% pada direktori `app/`** tanpa PHPUnit notice.
- **Security:** `composer audit` 100% bersih tanpa celah kerentanan.
- **CI Pipeline:** Tahap Jenkinsfile lolos audit dan lolos gate coverage.
