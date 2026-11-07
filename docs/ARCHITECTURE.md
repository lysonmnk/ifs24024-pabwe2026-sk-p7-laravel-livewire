# ARCHITECTURE.md: Arsitektur Sistem Aplikasi Stock Barang

---

## 01 System Overview
Aplikasi ini dibangun menggunakan arsitektur **Feature-First / Domain-Driven** pada Laravel 13 dengan komponen interaktif Livewire:

```
[ Browser / Client ]
         │ (HTTP / Livewire AJAX wire:click & wire:model)
         ▼
[ Laravel 13 Routing & Middleware ]
         │ ├── EnsureRole ('role:admin', 'role:member')
         │ └── EnsureStockOwnership ('owns.stock')
         ▼
[ app/Features/* / Livewire Components ]
         │
         ├──► [ Services & Actions ] (StockService, StockExcelService, etc.)
         │          │
         │          ├──► [ Repositories & Eloquent Models ] ──► [ MySQL: pabwe_p7_stock ]
         │          ├──► [ PhpSpreadsheet ] ──► [ Excel Import/Export ]
         │          └──► [ OpenAiStockGeneratorService ] ──► [ OpenAI API ]
         ▼
[ Resources / Views / Livewire Blade ]
```

---

## 02 Tech Stack
- **Framework Utama:** Laravel 13
- **Frontend Interaktif:** Laravel Livewire & Blade Components
- **CSS Framework:** Tailwind CSS
- **Markdown Editor & Viewer:** Toast UI Editor
- **Database:** MySQL (Database: `pabwe_p7_stock`)
- **Excel Processor:** PhpSpreadsheet
- **AI Engine:** OpenAI API (Klien Interface: `AiClientInterface.php`)
- **CI / CD Pipeline:** Jenkins (Jenkinsfile)
- **Testing Suite:** PHPUnit / Pest dengan PHP Code Coverage (Xdebug/PCOV)

---

## 03 Project Structure
Struktur wajib sesuai instruksi modul:
```text
app/
├── Features/
│   ├── Admin/      # Livewire: AdminUserStockList, UserList | Service: AdminUserService
│   ├── Ai/         # Contract: AiClientInterface | DTO: GeneratedStockItem | Service: OpenAiStockGeneratorService
│   ├── Auth/       # Actions: LoginUserAction, RegisterUserAction | Livewire: Login, Register
│   ├── Profile/    # Livewire: Profile | Service: ProfileService
│   └── Stock/      # Contract: StockRepositoryInterface | Enum: StockStatus | Model: Stock
│                   # Policy: StockPolicy | Repo: StockRepository | Services: StockService, StockExcelService
│                   # Livewire: StockList, StockDetail
├── Http/Middleware/
│   ├── EnsureRole.php
│   └── EnsureStockOwnership.php
├── Models/User.php
└── Providers/AppServiceProvider.php
```

---

## 04 Data Flow & Ownership Rule
1. **Ownership Enforcement:** Setiap query stok di `StockRepository` atau aksi di `StockService` wajib menyaring berdasarkan `user_id = Auth::id()` kecuali diakses oleh Admin dalam rute audit read-only.
2. **Stock Status Transition Formula:**
   ```php
   if ($quantity <= 0) {
       $status = StockStatus::OUT_OF_STOCK;
   } elseif ($quantity <= $minStock) {
       $status = StockStatus::LOW_STOCK;
   } else {
       $status = StockStatus::AVAILABLE;
   }
   ```
3. **AI Generation Pipeline:** 
   Prompt dimasukkan user ➔ `OpenAiStockGeneratorService` memanggil `AiClientInterface` ➔ Response di-parse menjadi `GeneratedStockItem` DTO ➔ Preview di Livewire ➔ User memilih item ➔ Disimpan ke database via `StockService`.
