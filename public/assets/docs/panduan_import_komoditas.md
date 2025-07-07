# Panduan Import Data Komoditas dari Excel

## Format File Excel

File Excel yang digunakan untuk import data komoditas harus memiliki format sebagai berikut:

### Header yang Diperlukan
- **nama komoditas** - Nama komoditas sesuai dengan data master
- **Nama pasar** - Setiap kolom setelah "nama komoditas" adalah nama pasar sesuai urutan berikut:
  1. Pasar Baleendah
  2. Pasar Sehat Soreang
  3. Pasar Banjaran
  4. Pasar Ciwidey
  5. Pasar Cileunyi
  6. Pasar Margahayu
  7. Pasar Baru Majalaya
  8. Pasar Stasiun Majalaya
  9. Pasar Sehat Cicalengka

### Contoh Format Excel

| nama komoditas | Pasar Baleendah | Pasar Sehat Soreang | Pasar Banjaran | Pasar Ciwidey | Pasar Cileunyi | Pasar Margahayu | Pasar Baru Majalaya | Pasar Stasiun Majalaya | Pasar Sehat Cicalengka |
|---------------|-----------------|---------------------|----------------|---------------|----------------|------------------|---------------------|------------------------|------------------------|
| Beras Premium | 15000           | 15200               | 15100          | 15050         | 15000          | 15150           | 15200               | 15100                  | 15050                  |
| Jagung        | 8000            | 8100                | 8050           | 8000          | 8000           | 8100            | 8050                | 8000                   | 8000                   |
| Kedelai       | 18000           | 18100               | 18050          | 18000         | 18000          | 18100           | 18050               | 18000                  | 18000                  |

> **Catatan:** Nama pasar pada header harus urut dan sesuai dengan daftar di atas. Jika urutan atau nama tidak sesuai, proses import akan gagal.

## Langkah-langkah Import

### 1. Persiapan File Excel
- Pastikan file berformat `.xlsx` atau `.xls`
- Ukuran file maksimal 5MB
- Header harus berada di baris pertama dan sesuai urutan
- Nama komoditas harus sesuai dengan data master
- Harga diisi angka tanpa format (contoh: 15000, bukan 15.000 atau Rp 15.000)

### 2. Upload dan Preview
1. Buka halaman Import Komoditas
2. Pilih tanggal penginputan
3. Upload file Excel
4. Klik tombol "Preview Data" untuk melihat preview
5. Periksa status validasi data (komoditas ditemukan/tidak, harga valid/tidak)

### 3. Import Data
1. Setelah preview selesai, klik "Import Data"
2. Sistem akan memproses file Excel
3. Data yang valid akan disimpan ke database
4. Pesan sukses/error akan ditampilkan
5. Jika ada error, daftar error detail akan muncul di bawah form import

## Validasi Data

### Validasi yang Dilakukan
1. **Format File**: Harus berformat .xlsx atau .xls
2. **Ukuran File**: Maksimal 5MB
3. **Header**: Harus ada "nama komoditas" dan nama-nama pasar sesuai urutan
4. **Nama Komoditas**: Harus sesuai dengan data master
5. **Harga**: Harus berupa angka positif
6. **Duplikasi**: Tidak boleh ada data duplikat untuk komoditas dan pasar yang sama di tanggal yang sama

### Pesan Error yang Mungkin Muncul
- "File Excel harus diupload"
- "File harus berformat .xlsx atau .xls"
- "Ukuran file maksimal 5MB"
- "Kolom pertama harus 'nama komoditas'"
- "Kolom ke-[n] harus '[nama pasar]'"
- "Komoditas '[nama]' tidak ditemukan"
- "Pasar '[nama pasar]' tidak ditemukan di database"
- "Data untuk komoditas '[nama]' di pasar '[nama pasar]' sudah ada di tanggal [tanggal]"
- "Gagal menyimpan data untuk komoditas '[nama]': [error detail]"

> **Semua error detail akan ditampilkan di bawah form import jika proses gagal. Silakan perbaiki file Excel sesuai pesan error dan ulangi proses import.**

## Tips dan Saran

### Sebelum Import
1. **Periksa Data Master**: Pastikan nama komoditas di Excel sesuai dengan data master
2. **Format Harga**: Gunakan angka tanpa format (contoh: 15000, bukan 15.000 atau Rp 15.000)
3. **Hapus Baris Kosong**: Pastikan tidak ada baris kosong di tengah data
4. **Backup Data**: Selalu backup data sebelum melakukan import besar

### Setelah Import
1. **Periksa Hasil**: Lihat pesan sukses/error yang ditampilkan
2. **Validasi Data**: Periksa data yang berhasil diimport
3. **Perbaiki Error**: Jika ada error, perbaiki file Excel dan import ulang

## Troubleshooting

### Masalah Umum
1. **Komoditas tidak ditemukan**
   - Periksa nama komoditas di Excel
   - Pastikan sesuai dengan data master
   - Periksa huruf besar/kecil

2. **Harga tidak valid**
   - Pastikan harga berupa angka
   - Hapus format mata uang atau separator
   - Pastikan harga lebih dari 0

3. **Data duplikat**
   - Periksa apakah sudah ada data untuk komoditas dan pasar tersebut di tanggal yang sama
   - Hapus baris duplikat di Excel

4. **File tidak terbaca**
   - Pastikan file tidak rusak
   - Coba buka file di Excel untuk memastikan format benar
   - Pastikan file tidak sedang dibuka di aplikasi lain

## Contoh File Excel

File contoh dapat diunduh dari: `contoh_import_komoditas.xlsx`

## Dukungan

Jika mengalami masalah, silakan hubungi administrator sistem. 