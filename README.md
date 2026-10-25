# Project Salman

Aplikasi manajemen produk sederhana yang terdiri dari:

- **backend/** — REST API dengan Laravel (PHP 8.4)
- **frontend/** — SPA dengan Vue 3, Vue Router, Tailwind CSS 4, dan Axios (Vite)

## Prasyarat

- PHP 8.4 dan Composer 2
- Node.js 20+ dan npm
- Database: SQLite (default) atau MySQL/MariaDB

## Setup Backend

```bash
cd backend

# Install dependensi
composer install
npm install

# Siapkan file environment
cp .env.example .env
php artisan key:generate
```

### Konfigurasi database

Secara default `.env.example` memakai SQLite. Buat file database-nya:

```bash
touch database/database.sqlite
```

Jika ingin memakai MySQL/MariaDB, ubah bagian berikut di `.env`:

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_salman
DB_USERNAME=root
DB_PASSWORD=
```

### Migrasi dan seeder

```bash
php artisan migrate --seed
```

Perintah ini membuat tabel dan mengisi 1 user uji (`test@example.com`) serta 10 contoh produk. Untuk mengisi produk saja:

```bash
php artisan db:seed --class=ProductSeeder
```

### Menjalankan server

```bash
php artisan serve
```

API berjalan di `http://localhost:8000`.

## Setup Frontend

```bash
cd frontend
npm install
npm run dev
```

Buka `http://localhost:5173`. Halaman utama akan diarahkan ke `/products` yang menampilkan daftar produk dari API.

Secara default frontend memanggil API di `http://localhost:8000`. Untuk mengganti alamatnya, buat file `frontend/.env.local`:

```env
VITE_API_URL=http://localhost:8000
```

Build untuk production:

```bash
npm run build
```

## Endpoint API

| Method    | Endpoint             | Keterangan                       |
| --------- | -------------------- | -------------------------------- |
| GET       | `/api/products`      | Daftar produk (paginasi 15/hal.) |
| POST      | `/api/products`      | Tambah produk                    |
| GET       | `/api/products/{id}` | Detail produk                    |
| PUT/PATCH | `/api/products/{id}` | Ubah produk                      |
| DELETE    | `/api/products/{id}` | Hapus produk                     |

Field produk: `code` (unik), `name`, `price`, `expired_date` (opsional, format `Y-m-d`), `supplier_name`.

Contoh request:

```bash
curl -X POST http://localhost:8000/api/products \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"code":"PRD-0100","name":"Produk Baru","price":25000,"expired_date":"2027-12-31","supplier_name":"PT Supplier"}'
```

## Pengujian dengan Postman

Import file `backend/Product-API.postman_collection.json` ke Postman, lalu jalankan dengan **Run collection**. Koleksi ini menguji seluruh endpoint CRUD secara berurutan beserta validasi dan kasus 404.

## Menjalankan Test Backend

```bash
cd backend
php artisan test --compact
```
