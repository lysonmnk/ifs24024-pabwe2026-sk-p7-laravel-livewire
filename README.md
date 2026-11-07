# Aplikasi Stock Barang

Aplikasi inventaris stok barang berbasis Laravel dan Livewire. Proyek ini mengikuti pola yang sama dengan latihan Todolist (Feature-First, Livewire, Auth, Profil, Admin, Excel, AI, coverage 100%, Jenkins), dengan perbedaan pada domain: Todo diganti menjadi Stock.

## Daftar Isi

1. [Informasi Proyek](#1-informasi-proyek)
2. [Teknologi](#2-teknologi)
3. [Peran dan Hak Akses](#3-peran-dan-hak-akses)
4. [Fitur](#4-fitur)
5. [Model Data](#5-model-data)
6. [Struktur Folder](#6-struktur-folder)
7. [Rute](#7-rute)
8. [Keamanan dan Kualitas](#8-keamanan-dan-kualitas)
9. [Instalasi](#9-instalasi)
10. [Pengujian dan Audit](#10-pengujian-dan-audit)
11. [Pemetaan Todo ke Stock](#11-pemetaan-todo-ke-stock)
12. [Langkah Pengerjaan](#12-langkah-pengerjaan)
13. [Kriteria Penilaian](#13-kriteria-penilaian)

---

## 1. Informasi Proyek

| Item | Keterangan |
|---|---|
| Format nama repositori | `{username}-pabwe2026-sk-p7-laravel-livewire` |
| Contoh nama repositori | `abdullah_ubaid-pabwe2026-sk-p7-laravel-livewire` |
| Nama database contoh | `pabwe_p7_stock` |
| Domain | Stock (inventaris barang) |
| Acuan pola dan kode | Latihan Todolist |

Inisialisasi proyek mengikuti bagian 2.2 pada modul latihan (Laravel 13, Livewire, PhpSpreadsheet, MySQL, `.env`, layout, `storage:link`, `.gitignore`).

Cara paling mudah: salin hasil latihan yang sudah berjalan, ganti nama folder, lalu ganti seluruh domain Todo menjadi Stock.

## 2. Teknologi

- Laravel 13
- Livewire
- PhpSpreadsheet (import dan export Excel)
- MySQL
- Toast UI (editor dan tampilan Markdown)
- OpenAI (generate item stok dengan AI)
- Jenkins (CI)

## 3. Peran dan Hak Akses

| Peran | Hak Akses |
|---|---|
| Guest | Login dan register. Rute `/` diarahkan ke halaman login. |
| Member | Mengelola stok miliknya sendiri saja. |
| Admin | Melihat daftar user beserta stok tiap user secara read-only. Admin tidak dapat mengubah atau menghapus stok user lain. |

## 4. Fitur

### 4.1 Fitur Member

- **Daftar stok** (`/stocks`): pencarian, filter status, dan pagination.
- **CRUD stok** melalui modal create/edit dengan field: nama, SKU, deskripsi Markdown, quantity, unit, price, min_stock, dan status.
- **Adjust quantity (+ / −)** dari halaman daftar maupun halaman detail. Status menyesuaikan otomatis (`available`, `low_stock`, `out_of_stock`) berdasarkan perbandingan quantity dengan min_stock.
- **Detail stok** (`/stocks/{stock}`): melihat dan mengedit data, cover image, serta deskripsi Markdown (Toast UI).
- **Import dan export Excel** menggunakan PhpSpreadsheet.
- **Generate item stok dengan AI**: hasil ditampilkan sebagai preview, dipilih, lalu disimpan.
- **Profil**: ubah data, ubah password, dan ubah foto.

### 4.2 Fitur Admin

- `/admin/users`: daftar user beserta ringkasan jumlah stok.
- `/admin/users/{user}/stocks`: daftar stok milik user terkait, hanya baca.

## 5. Model Data

### 5.1 Tabel `stocks`

| Kolom | Keterangan |
|---|---|
| `user_id` | Foreign key ke `users`, cascade delete |
| `name` | Nama barang |
| `sku` | Kode SKU (nullable) |
| `description` | Teks atau Markdown (nullable) |
| `quantity` | Jumlah stok (integer, minimal 0) |
| `unit` | Satuan, default `pcs` |
| `price` | Harga (decimal, nullable) |
| `min_stock` | Ambang stok menipis, default `5` |
| `status` | `available`, `low_stock`, atau `out_of_stock` |
| `cover_image_path` | Path cover (nullable) |
| `created_at`, `updated_at` | Timestamps |

### 5.2 Enum `StockStatus`

Berisi label serta kelas badge UI untuk setiap status:

| Status | Warna Badge |
|---|---|
| `available` | Hijau |
| `low_stock` | Kuning |
| `out_of_stock` | Merah |

### 5.3 Tabel `users`

Tetap seperti latihan: `username`, `role` (`admin` atau `member`), dan `profile_photo_path`.

### 5.4 Seeder

Seeder minimal yang disediakan:

| Username | Password | Peran |
|---|---|---|
| `admin` | `admin` | Admin |
| `member` | `member` | Member |

Seeder juga membuat beberapa contoh stok untuk akun `member`.

## 6. Struktur Folder

Struktur berikut wajib diikuti.

```text
app/
├── Features/
│   ├── Admin/
│   │   ├── Livewire/
│   │   │   ├── AdminUserStockList.php
│   │   │   └── UserList.php
│   │   └── Services/
│   │       └── AdminUserService.php
│   ├── Ai/
│   │   ├── Contracts/
│   │   │   └── AiClientInterface.php
│   │   ├── DTO/
│   │   │   └── GeneratedStockItem.php
│   │   └── Services/
│   │       └── OpenAiStockGeneratorService.php
│   ├── Auth/
│   │   ├── Actions/
│   │   │   ├── LoginUserAction.php
│   │   │   └── RegisterUserAction.php
│   │   └── Livewire/
│   │       ├── Login.php
│   │       └── Register.php
│   ├── Profile/
│   │   ├── Livewire/
│   │   │   └── Profile.php
│   │   └── Services/
│   │       └── ProfileService.php
│   └── Stock/
│       ├── Contracts/
│       │   └── StockRepositoryInterface.php
│       ├── Enums/
│       │   └── StockStatus.php
│       ├── Livewire/
│       │   ├── StockDetail.php
│       │   └── StockList.php
│       ├── Models/
│       │   └── Stock.php
│       ├── Policies/
│       │   └── StockPolicy.php
│       ├── Repositories/
│       │   └── StockRepository.php
│       └── Services/
│           ├── StockExcelService.php
│           └── StockService.php
├── Http/Middleware/
│   ├── EnsureRole.php
│   └── EnsureStockOwnership.php
├── Models/User.php
└── Providers/AppServiceProvider.php

resources/views/
├── components/layouts/app.blade.php
└── livewire/
    ├── admin/admin-user-stock-list.blade.php
    ├── admin/user-list.blade.php
    ├── auth/login.blade.php
    ├── auth/register.blade.php
    ├── profile/profile.blade.php
    ├── stock/stock-detail.blade.php
    └── stock/stock-list.blade.php

database/
├── migrations/…_create_stocks_table.php
├── migrations/…_add_cover_image_path_to_stocks_table.php
├── factories/StockFactory.php
└── seeders/DatabaseSeeder.php

bootstrap/app.php          # alias: role, owns.stock
routes/web.php
config/openai.php
Jenkinsfile
tests/                     # mirror latihan, namespace Stock
```

## 7. Rute

| Method | URI | Keterangan |
|---|---|---|
| GET | `/` | Guest diarahkan ke login; admin ke users; member ke stocks |
| GET | `/login`, `/register` | Khusus guest |
| POST | `/logout` | Khusus user terautentikasi |
| GET | `/stocks` | Daftar stok (member, `owns.stock`) |
| GET | `/stocks/{stock}` | Detail stok |
| GET | `/profile` | Profil |
| GET | `/admin/users` | Admin |
| GET | `/admin/users/{user}/stocks` | Admin, read-only |

## 8. Keamanan dan Kualitas

- Middleware role (`role`) dan ownership (`owns.stock`).
- Policy `StockPolicy`.
- Rate limit 1000 per detik.
- `FORCE_HTTPS` diaktifkan.
- Form login menggunakan ID berikut:
  - `login-username`
  - `login-password`
  - `login-submit`
- Coverage direktori `app/` sebesar 100%.
- `composer audit` bersih tanpa kerentanan.
- `Jenkinsfile`:
  - Tahap audit gagal jika ditemukan kerentanan.
  - Tahap coverage gagal jika coverage kurang dari 100%.
- File `.env` dan artefak uji tidak boleh di-commit.

## 9. Instalasi

Prasyarat: PHP, Composer, Node.js, dan MySQL sesuai kebutuhan Laravel 13.

```bash
# 1. Clone repositori
git clone <url-repositori> {username}-pabwe2026-sk-p7-laravel-livewire
cd {username}-pabwe2026-sk-p7-laravel-livewire

# 2. Pasang dependensi
composer install
npm install

# 3. Siapkan environment
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi database pada `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pabwe_p7_stock
DB_USERNAME=root
DB_PASSWORD=
```

Atur juga kredensial layanan AI pada `.env` sesuai kebutuhan `config/openai.php`.

```bash
# 4. Migrasi dan seeder
php artisan migrate --seed

# 5. Tautan storage
php artisan storage:link

# 6. Jalankan aplikasi
npm run build
php artisan serve
```

Akun awal setelah seeding: `admin` / `admin` dan `member` / `member`.

## 10. Pengujian dan Audit

```bash
# Menjalankan seluruh test (coverage app/ harus 100%, tanpa PHPUnit notice)
composer test

# Audit kerentanan dependensi (harus bersih)
composer audit
```

Catatan: gunakan `createStub` untuk klien AI pada test agar tidak muncul PHPUnit notice.

## 11. Pemetaan Todo ke Stock

| Latihan (Todo) | Studi Kasus (Stock) |
|---|---|
| `Todo` / `todos` | `Stock` / `stocks` |
| `TodoList` / `TodoDetail` | `StockList` / `StockDetail` |
| `TodoStatus` | `StockStatus` |
| `TodoService` / `TodoExcelService` | `StockService` / `StockExcelService` |
| `TodoRepository` | `StockRepository` |
| `TodoPolicy` | `StockPolicy` |
| `EnsureTodoOwnership` (`owns.todo`) | `EnsureStockOwnership` (`owns.stock`) |
| `GeneratedTodoItem` | `GeneratedStockItem` |
| `OpenAiTodoGeneratorService` | `OpenAiStockGeneratorService` |
| `AdminUserTodoList` | `AdminUserStockList` |
| Toggle complete | Adjust quantity (+/−) dan sinkronisasi status |
| Prompt AI: rencana tugas | Prompt AI: item inventaris / stok barang |
| Header Excel todo | Header Excel stok (`name`, `sku`, `qty`, `unit`, `price`, `min_stock`, `status`, dan seterusnya) |

Pola Auth, Profile, Admin user list, layout, dan CI tetap seperti latihan.

## 12. Langkah Pengerjaan

1. Selesaikan latihan Todolist sampai hijau (`composer test` 100%, tanpa notice).
2. Salin proyek, ganti nama sesuai format SK, buat database `pabwe_p7_stock`, dan sesuaikan `.env`.
3. Ganti migration, model, enum, dan factory dari Todo menjadi Stock (field pada bagian 5).
4. Ganti feature folder Todo menjadi Stock (repository, service, policy, Livewire, Excel, DTO dan service AI).
5. Ganti middleware ownership dan alias `owns.stock`; perbarui `routes/web.php` dan arahkan member ke `/stocks`.
6. Sesuaikan views (`livewire/stock/...`, daftar stok admin) dan teks UI menjadi konteks inventaris.
7. Sesuaikan header Excel dan prompt AI ke konteks stok.
8. Ganti nama dan adaptasi seluruh test; pastikan `composer test` 100% dan tanpa PHPUnit notice (`createStub` untuk AI).
9. Jalankan `composer audit`; pastikan `.gitignore` mengabaikan artefak uji; samakan `Jenkinsfile` dengan pola latihan.

## 13. Kriteria Penilaian

- Feature-First dan struktur folder sesuai bagian 6.
- Auth, Stock (CRUD, adjust quantity, cover, Markdown), Excel, AI, Profile, dan Admin read-only berjalan.
- Ownership dan role benar.
- ID login sesuai: `login-username`, `login-password`, `login-submit`.
- Coverage `app/` 100% dan audit bersih.
- Tidak ada kredensial atau artefak uji di Git.
- CI Jenkins (audit dan gate coverage) siap dijalankan.
