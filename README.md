# ISP Billing & WiFi Management System

Sistem manajemen penagihan internet berbasis web yang dirancang untuk operator RT-RW Net maupun ISP skala kecil hingga menengah. Dibangun dengan **Laravel 13**, **PostgreSQL**, dan **Tailwind CSS v4**.

---

## ✨ Fitur Utama

### 🏠 Dashboard
- **4 Widget Ringkasan**: Total pelanggan aktif, pendapatan bulan ini, total piutang, dan jumlah tagihan belum bayar.
- **Grafik Pertumbuhan Pendapatan**: Visualisasi 12 bulan terakhir (line chart berbasis Chart.js).
- **Tabel Daftar Pelanggan Aktif** dengan:
  - 🔍 Pencarian by nama (case-insensitive)
  - 🏷️ Filter status: **Semua / Aktif / H-7 Jatuh Tempo / Menunggak**
  - 📄 Pagination 10 data per halaman
  - Aksi per baris: **Tandai Lunas**, **Batal Lunas**, **Chat WA**, **Histori**
- **Widget 5 Tagihan Menunggak Teratas**: Menampilkan pelanggan dengan `end_date` langganan yang sudah terlewati dan masih punya tagihan belum bayar.
- **Widget 5 Pembayaran Terbaru** (pada tampilan tertentu).

### 👥 Manajemen Pelanggan
- **Tambah Pelanggan**: Form penambahan pelanggan beserta data langganan (paket, tanggal mulai).
- **Hapus Pelanggan**: Halaman dedicated dengan konfirmasi permanen delete.
- **Histori Tagihan per Pelanggan**: Rekam jejak seluruh tagihan (lunas maupun belum) per pelanggan, lengkap dengan tanggal jatuh tempo dan tanggal pembayaran.

### 📦 Manajemen Paket WiFi
- Daftar, tambah, edit, dan hapus paket internet.
- Setiap paket memiliki nama dan harga (amount).
- Bisa diaktifkan / dinonaktifkan.

### 💳 Sistem Penagihan (Billing)
- **Generate Billing Bulanan via API**: Endpoint `GET/POST /api/billing/generate` menghasilkan tagihan untuk semua pelanggan aktif yang belum ditagih pada bulan tersebut.
- **Status Tagihan**: `unpaid` (belum bayar) dan `paid` (lunas).
- **Tandai Lunas**: Mengupdate status billing ke `paid`, mencatat `payment_date`, dan memperbarui `CustomerSubscription.end_date` ke bulan berikutnya.
- **Batal Lunas (Reversal)**: Membatalkan pembayaran, mengembalikan status ke `unpaid`, dan merestorasi `end_date`.

### 📊 Status Langganan Dinamis
Status dihitung secara _real-time_ (tanpa cron job) menggunakan Eloquent Accessor berdasarkan `end_date`:
| Status | Kondisi |
|---|---|
| `active` | `end_date` lebih dari 7 hari dari sekarang |
| `due_soon` | `end_date` dalam rentang 0–7 hari ke depan (H-7) |
| `overdue` | `end_date` sudah terlewati (melewati jatuh tempo) |
| `inactive` | `is_active = false` |

### 📱 WhatsApp Messaging Template
Tombol **Chat WA** otomatis muncul untuk pelanggan `due_soon` atau `overdue` yang belum bayar. Pesan template dibedakan secara otomatis:
- **H-7**: Pemberitahuan tagihan akan jatuh tempo.
- **Overdue**: Peringatan tunggakan dengan informasi denda dan penarikan perangkat.

### 👑 Super Admin
- Manajemen user (tambah, edit, hapus operator).
- Regenerasi API key per user.

---

## 🗄️ Struktur Database

```
users               — Operator / Super Admin
packages            — Paket internet (nama, harga)
customers           — Data pelanggan (nama, telepon, alamat)
customer_subscriptions — Langganan aktif per pelanggan (paket, start_date, end_date)
billings            — Rekam tagihan per bulan per pelanggan
sessions / cache / jobs — Infrastruktur Laravel
```

---

## 🔗 Daftar Route

| Method | URI | Keterangan |
|---|---|---|
| `GET` | `/login` | Halaman login |
| `GET` | `/dashboard` | Dashboard utama |
| `POST` | `/dashboard/pay/{id}` | Tandai tagihan lunas |
| `POST` | `/dashboard/reversal/{id}` | Batal lunas |
| `GET` | `/customers/create` | Form tambah pelanggan |
| `POST` | `/customers` | Simpan pelanggan baru |
| `GET` | `/customers/{customer}/history` | Histori tagihan pelanggan |
| `DELETE` | `/customers/{id}` | Hapus pelanggan permanen |
| `PATCH` | `/customers/{id}/activate` | Aktifkan pelanggan |
| `PATCH` | `/customers/{id}/deactivate` | Nonaktifkan pelanggan |
| `GET` | `/customers/delete` | Halaman daftar hapus pelanggan |
| `GET` | `/packages` | Daftar paket |
| `POST` | `/packages` | Tambah paket |
| `GET/PUT` | `/packages/{package}/edit` | Edit paket |
| `DELETE` | `/packages/{package}` | Hapus paket |
| `GET/POST` | `/api/billing/generate` | **[API]** Generate tagihan bulanan |
| `GET` | `/admin/users` | Kelola user (Super Admin) |

---

## ⚙️ Konfigurasi Awal

### Persyaratan
- PHP 8.4+
- PostgreSQL
- Node.js & NPM
- Laravel Herd (opsional, untuk development lokal)

### Instalasi

```bash
# 1. Clone & install dependensi
composer install
npm install

# 2. Salin konfigurasi environment
cp .env.example .env
php artisan key:generate

# 3. Atur database di .env
DB_CONNECTION=pgsql
DB_HOST=...
DB_PORT=5432
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

# 4. Pastikan timezone diset ke Asia/Jakarta di config/app.php
'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta'),

# 5. Jalankan migrasi
php artisan migrate

# 6. Build aset frontend
npm run build

# 7. Buat admin pertama via tinker
php artisan tinker
> User::create(['name' => 'Admin', 'username' => 'admin', 'password' => bcrypt('password'), 'role' => 'admin']);
```

---

## 📡 API Billing

Endpoint untuk generate tagihan bulanan — bisa dipanggil manual atau dijadwalkan via cron job eksternal.

```
GET/POST /api/billing/generate
```

**Autentikasi**: Header `Authorization: Bearer {api_key}` (API key didapat dari halaman Kelola User).

**Cara kerja**:
1. Mengambil seluruh pelanggan aktif yang memiliki langganan aktif.
2. Mengecek apakah tagihan untuk bulan & tahun saat ini sudah ada (mencegah duplikat).
3. Membuat record billing baru dengan status `unpaid`.

**Contoh pemanggilan via cron (server)**:
```bash
0 1 1 * * curl -X POST https://yourdomain.test/api/billing/generate \
  -H "Authorization: Bearer YOUR_API_KEY"
```

---

## 🏗️ Arsitektur Aplikasi

```
app/
├── Http/Controllers/
│   ├── DashboardController.php   — Dashboard & pembayaran
│   ├── CustomerController.php    — CRUD + histori pelanggan
│   ├── PackageController.php     — CRUD paket
│   ├── Admin/UserController.php  — Manajemen user (Super Admin)
│   └── Api/BillingController.php — API generate billing
├── Models/
│   ├── Customer.php              — Relasi ke subscriptions & billings
│   ├── CustomerSubscription.php  — Model langganan + accessor status dinamis
│   ├── Billing.php               — Model tagihan
│   ├── Package.php               — Model paket internet
│   └── User.php                  — Model operator/admin
└── Services/
    ├── DashboardService.php      — Logika query dashboard & filter
    └── PaymentService.php        — Logika konfirmasi & pembatalan bayar

resources/views/
├── dashboard/index.blade.php     — Halaman dashboard utama
├── customers/
│   ├── create.blade.php          — Form tambah pelanggan
│   ├── history.blade.php         — Histori tagihan pelanggan
│   └── delete.blade.php          — Hapus pelanggan
└── components/sidebar.blade.php  — Komponen sidebar global
```

---

## 📝 Catatan Pengembangan

- **Timezone**: Aplikasi dikonfigurasi ke `Asia/Jakarta`. Seluruh logika `now()` dan perbandingan tanggal sudah akurat sesuai WIB.
- **Status `overdue` lama**: Database lama yang masih menyimpan status `overdue` pada kolom `billings.status` tetap terbaca karena query menggunakan `whereIn('status', ['unpaid', 'overdue'])`. Ke depan, semua billing baru hanya menggunakan status `unpaid`.
- **Multi-tenant / Multi-user**: Setiap user operator hanya melihat data pelanggan yang mereka kelola sendiri (via `UserScope` di model). Super Admin bisa melihat semua data.
- **Mobile-First**: Semua halaman menggunakan tampilan _card_ di ponsel dan _tabel_ di layar yang lebih lebar.
