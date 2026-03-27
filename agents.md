# AGENTS.md — Jules Context

## Project Overview
SIBAPOKTING (Sistem Informasi Bahan Pokok Penting) 2024 Kabupaten Bandung. Aplikasi ini digunakan untuk memantau harga dan ketersediaan bahan pokok di berbagai pasar di wilayah Kabupaten Bandung.

## Tech Stack
- Language: PHP 8.3 / TypeScript / JavaScript
- Framework: Laravel 10 / Livewire 3 / Vite
- Database: PostgreSQL (Koneksi: pgsql)
- Testing: PHPUnit

## Code Conventions
- Komentar dalam Bahasa Indonesia
- Nama file: PascalCase untuk class
- Penamaan method: camelCase (contoh: `apiPasar`, `apiKomoditas`)
- Validasi input wajib di semua endpoint
- Response API selalu dalam format JSON

## File Structure
- `app/Http/Controllers`: Logic controller (Dashboard, API, Chart)
- `app/Models`: Model Eloquent (Referensi, Transaksi, Website, Wilayah)
- `resources/views`: Blade templates
- `resources/views/livewire`: Komponen Livewire
- `routes/web.php` & `routes/api.php`: Definisi rute aplikasi

## Build & Test
- Install: `composer install` & `npm install`
- Build: `npm run build`
- Test: `php artisan test`

## Important Rules
- Jangan hardcode credentials (gunakan `.env`)
- Jangan commit file `.env`
- Selalu buat migration untuk perubahan schema database
- Output file baru ke folder yang sesuai dengan konvensi Laravel
- Pastikan koneksi database menggunakan `pgsql` sesuai konfigurasi model
