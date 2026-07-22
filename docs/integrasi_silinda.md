# Dokumentasi Integrasi SILINDA - SIBAPOKTING 2024

Dokumentasi ini menjelaskan mekanisme, arsitektur, dan alur integrasi data bahan pokok penting antara aplikasi **SIBAPOKTING (Kabupaten Bandung)** dengan sistem **SILINDA (Sistem Informasi Bahan Pokok dan Barang Penting Jawa Barat)** menggunakan Livewire Component.

---

## 1. Komponen Utama & File Terkait

Integrasi ini diimplementasikan melalui dua komponen Livewire utama:
1. **Monitoring Integrasi / Tampilan Data:** `app/Livewire/Main/Integrasi.php` ([Integrasi.php](file:///c:/Users/Hype/2024-sibapokting/app/Livewire/Main/Integrasi.php))
2. **Proses Eksekusi Sinkronisasi:** `app/Livewire/Main/IntegrasiProses.php` ([IntegrasiProses.php](file:///c:/Users/Hype/2024-sibapokting/app/Livewire/Main/IntegrasiProses.php))

### Model Data Terkait
- **`App\Models\RefSilinda`**: Menyimpan kredensial API, URL token SPLP, Base URL, API path, serta token sesi yang aktif.
- **`App\Models\Referensi\RefPasar`**: Menyimpan data pasar, status integrasi (`status_integrasi = 1`), `kode_integrasi` (ID pasar di SILINDA), dan waktu sinkronisasi terakhir (`last_integrasi`).
- **`App\Models\Transaksi\Komoditas`** (`t_siba_komoditas`): Menyimpan data transaksi harian harga komoditas di tingkat pasar.
- **`ref_siba_komoditas`**: Referensi komoditas yang memetakan komoditas lokal SIBAPOKTING ke SILINDA melalui kolom `id_silinda`.

---

## 2. Alur Otentikasi (SPLP Token)

Otentikasi menggunakan protokol SPLP (Sistem Penghubung Layanan Pemerintah) dengan metode **Client Credentials** untuk mendapatkan Bearer Token.

### Metode `token_splp` & `token_get`
1. Sistem mengambil kredensial yang aktif dari database (`RefSilinda::where('is_active', 1)->first()`).
2. Melakukan request `POST` menggunakan cURL ke `urlTokenSPLP`.
3. **Payload Request:**
   - URL Encoded: `grant_type=client_credentials&scope=silinda_creator`
4. **Header Request:**
   - `Authorization`: `Basic NWEzSzNvTmZGcHdZal9VT0RRR091OFNZZFU0YTpyempwNWpBUGhXSEpOY2JkZkVDSFlZWUg1T1lh` (Basic Auth kredensial SPLP)
   - `Content-Type`: `application/x-www-form-urlencoded`
5. **Penyimpanan Token:**
   - Hasil token (`access_token`) ditambahkan prefix `"Bearer "` dan disimpan kembali ke kolom `token` pada tabel `ref_silinda` via fungsi `token_get()`.

---

## 3. Alur Sinkronisasi & Integrasi

### A. Monitoring Integrasi (`Integrasi.php`)
Digunakan untuk memantau data harga yang ada di SILINDA untuk pasar-pasar yang terintegrasi pada hari ini.

1. Mengambil semua pasar dengan `status_integrasi = 1` dari `RefPasar`.
2. Melakukan pengambilan token SPLP terbaru melalui `token_get()`.
3. Memulai proses query asinkron menggunakan **multi-cURL** (`curl_multi_init`) ke endpoint API SILINDA (`$baseURL . $pathResource`).
4. **Payload per Pasar (JSON):**
   ```json
   {
     "length": 70,
     "market_id": "KODE_INTEGRASI_PASAR",
     "time": "YYYY-MM-DD"
   }
   ```
5. **Header cURL:**
   - `Content-Type: application/json`
   - `Authorization: BEARER_TOKEN_SILINDA`
   - `Cookie: priangan_ses=...` (Cookie sesi Priangan)
6. Hasil response multi-cURL diparse dan ditampilkan di view `livewire.main.integrasi.selesai`.

---

### B. Proses Sinkronisasi Harga (`IntegrasiProses.php`)
Digunakan untuk mengirimkan data harga komoditas harian dari SIBAPOKTING ke SILINDA.

1. **Trigger Sinkronisasi:** Dipicu melalui method `singkronisasi($id)` di mana `$id` adalah ID Pasar di SIBAPOKTING.
2. **Filter & Query Data:**
   - Mengambil data transaksi `t_siba_komoditas` untuk hari ini (`date("Y-m-d")`) pada pasar tersebut.
   - Melakukan join dengan tabel `ref_siba_komoditas` untuk memetakan ke `id_silinda` (di mana `id_silinda` tidak bernilai null).
3. **Pengiriman Data per Komoditas:**
   - Melakukan iterasi (`foreach`) pada daftar komoditas yang valid.
   - Mengirimkan request `POST` via cURL ke endpoint `$baseURL . $pathResourceSend`.
   - **Payload JSON:**
     ```json
     {
       "username_log": "integrasi_kab_bandung",
       "market_id": "KODE_INTEGRASI_PASAR",
       "time": "YYYY-MM-DD",
       "commodity_id": "ID_SILINDA_KOMODITAS",
       "price": "HARGA_PUBLISH"
     }
     ```
   - **Header Request:** Menggunakan token otentikasi SILINDA dan Cookie sesi Priangan yang terdefinisi.
4. **Penanganan Response & Logging:**
   - Jika response JSON mengembalikan status `"ok"`:
     - Update kolom `last_integrasi` pada tabel `RefPasar` untuk pasar bersangkutan.
     - Mencatat log aktivitas sistem menggunakan `setActivity('Integrasi Silinda Berhasil')`.
     - Menampilkan notifikasi alert sukses kepada pengguna.
   - Jika gagal, menampilkan notifikasi alert error.

---

## 4. Temuan Penting & Rekomendasi Dev (Catatan Debugging)

> [!WARNING]
> ### 1. Terdapat Fungsi `dd()` di dalam Loop Sinkronisasi
> Di dalam file `app/Livewire/Main/IntegrasiProses.php` pada baris ke-89 terdapat baris kode `dd($response);` tepat setelah pengiriman cURL pertama di dalam loop `foreach`.
> Hal ini akan menyebabkan proses sinkronisasi **berhenti seketika pada komoditas pertama** dan mencetak respons mentah ke browser, sehingga komoditas-komoditas berikutnya tidak akan terkirim.
> **Rekomendasi:** Baris `dd($response);` harus dihapus atau di-comment dalam mode produksi agar seluruh komoditas terproses sepenuhnya.

> [!NOTE]
> ### 2. Hardcoded Credentials & Cookies
> - **Basic Authorization SPLP** (`Authorization: Basic NWEz...`) didefinisikan secara hardcode di dalam method `token_splp` di kedua file.
> - **Cookie Priangan** (`Cookie: priangan_ses=...`) didefinisikan secara hardcode di dalam fungsi `httpHeader` dan `httpHeaderSend`. Jika sesi cookie kedaluwarsa di sisi SILINDA, request integrasi mungkin akan ditolak.
> **Rekomendasi:** Pindahkan kredensial basic auth dan cookie statis ini ke file konfigurasi `.env` untuk keamanan dan kemudahan pengelolaan sesuai dengan konvensi proyek.
