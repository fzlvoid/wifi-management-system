# Ponytail Audit Backlog

Daftar temuan over-engineering dari audit ponytail.  
**Status:** Point 1 (stdlib replacements) sudah dikerjakan. Sisanya menunggu konfirmasi.

---

## Kategori: delete (Kode Mati / Tidak Dipakai)

### `app/Events/PaymentReceived.php`
- **Temuan:** Event class ada tapi tidak ada listener yang mendengarkan.
- **Aksi:** Hapus file. Hapus juga import dan dispatch di `PaymentService.php`.
- **Estimasi baris:** ~20

### `app/Models/Package.php` — relasi `customers()`
- **Baris:** 46-49
- **Temuan:** Relasi `customers()` sama dengan `subscriptions()`, tidak pernah dipanggil di codebase.
- **Aksi:** Hapus method `customers()`.
- **Estimasi baris:** ~4

### `app/Models/User.php` — `remember_token_expired_at`
- **Baris:** 14 (`$fillable`), 33 (`$casts`)
- **Temuan:** Field ada di fillable dan cast, tapi tidak ada kode yang membacanya. Cuma ditulis, tidak dibaca.
- **Aksi:** Hapus dari `$fillable` dan `$casts`.
- **Estimasi baris:** ~2

### `app/Http/Requests/Auth/LoginRequest.php` — update `remember_token_expired_at`
- **Baris:** 59-63
- **Temuan:** Mengupdate kolom `remember_token_expired_at`, tapi kolom tsb tidak pernah dibaca.
- **Aksi:** Hapus baris update tersebut.
- **Estimasi baris:** ~5

### `app/Services/DashboardService.php` — `getTotalActiveCustomers()` & `getCurrentMonthRevenue()`
- **Baris:** 53-61
- **Temuan:** Metode ada tapi tidak pernah dipanggil di luar test (yang juga broken).
- **Aksi:** Hapus kedua metode.
- **Estimasi baris:** ~9

### `app/Services/PaymentService.php` — import & dispatch `PaymentReceived`
- **Baris:** 1 (import), 65-69 (dispatch)
- **Temuan:** Import event dan dispatch event, tapi event tidak punya listener.
- **Aksi:** Hapus `use App\Events\PaymentReceived;` dan `event(new PaymentReceived(...))`.
- **Estimasi baris:** ~6

### `database/factories/PaymentFactory.php`
- **Temuan:** Factory mereferensikan `App\Models\Payment` yang tidak ada. Factory rusak.
- **Aksi:** Hapus file.
- **Estimasi baris:** ~23

### `refactor.php`
- **Temuan:** Script one-off untuk development. Bukan bagian aplikasi.
- **Aksi:** Hapus file.
- **Estimasi baris:** ~59

### `resources/views/welcome.blade.php`
- **Temuan:** View tidak dipakai. Route root redirect ke login.
- **Aksi:** Hapus file.
- **Estimasi baris:** ~172

### `tests/Feature/DashboardTest.php`
- **Temuan:** Test broken. Mereferensikan model `Payment` yang tidak ada dan kolom `package_name` yang tidak ada.
- **Aksi:** Hapus file.
- **Estimasi baris:** ~28

### `tests/Feature/ExampleTest.php`
- **Temuan:** Test scaffold bawaan Laravel. Tidak ada gunanya.
- **Aksi:** Hapus file.
- **Estimasi baris:** ~7

### `tests/Unit/ExampleTest.php`
- **Temuan:** Test scaffold bawaan Laravel. Tidak ada gunanya.
- **Aksi:** Hapus file.
- **Estimasi baris:** ~5

---

## Kategori: shrink (Logika Sama, Bisa Lebih Pendek)

### `app/Http/Controllers/Api/BillingController.php` — Duplikasi API Key Auth
- **Baris:** 19-32
- **Temuan:** Logika autentikasi API key sama persis dengan `CacheController`. Duplikasi kode.
- **Aksi:** Pindahkan ke middleware `ApiKeyAuth` atau extract ke trait/helper.
- **Estimasi baris yang bisa dihemat:** ~14 (per controller, duplikasi di 2 tempat)

### `app/Http/Controllers/Api/CacheController.php` — Helper `authenticate()` & `unauthorizedResponse()`
- **Baris:** 14-31
- **Temuan:** Helper privat dipanggil masing-masing cuma 1x. Tidak perlu jadi method terpisah.
- **Aksi:** Inline logika ke dalam method utama, atau gunakan middleware.
- **Estimasi baris yang bisa dihemat:** ~18

### `app/Http/Controllers/DashboardController.php` — `markAsPaid()` & `reversal()`
- **Baris:** 35-55
- **Temuan:** Kedua method hampir identik, bedanya cuma service call (`processPayment` vs `processReversal`).
- **Aksi:** Extract jadi 1 method private `handlePaymentResult(array $result): RedirectResponse`.
- **Estimasi baris yang bisa dihemat:** ~15

### `app/Http/Controllers/PackageController.php` — `setActive()` raw DB update
- **Baris:** 63-70
- **Temuan:** Pakai raw DB update + manual refresh, padahal bisa lebih simple.
- **Aksi:** `$package->update(['is_active' => !$package->is_active]);`
- **Estimasi baris yang bisa dihemat:** ~7

---

## Ringkasan Estimasi

| Kategori | Estimasi Baris Bisa Dihapus/Disederhanakan |
|----------|-------------------------------------------|
| delete (dead code) | ~340 |
| shrink (duplikasi/inline) | ~54 |
| **Total sisa** | **~394** |

**Sudah dikerjakan (Point 1 — stdlib):** ~10 baris

---

## Catatan Penting Sebelum Eksekusi

Beberapa temuan perlu konfirmasi user sebelum dihapus:

1. **`PaymentReceived` event** — Apakah ada rencana menambahkan listener di masa depan?
2. **`remember_token_expired_at`** — Apakah ini fitur "remember me" yang masih dalam pengembangan?
3. **`refactor.php`** — Apakah script ini masih digunakan sesekali?
4. **`tests/Feature/DashboardTest.php`** — Apakah ada rencana membuat model `Payment` nanti?

---

*File ini dihasilkan oleh Ponytail Audit. Dibuat: 2026-06-23*
