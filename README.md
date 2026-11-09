#  Courty - Sistem Reservasi Lapangan Olahraga Online

**Courty** adalah aplikasi berbasis web yang dirancang untuk memudahkan pencarian dan reservasi lapangan olahraga secara online. Sistem ini menghubungkan **Pelanggan** yang ingin menyewa lapangan olahraga dengan **Mitra** (pemilik atau pengelola GOR/sarana olahraga). 

Aplikasi ini dibangun menggunakan **PHP CodeIgniter 3** dengan basis data **MySQL/MariaDB** dan dipercantik menggunakan **Tailwind CSS** (via CDN) sehingga responsif dan modern.

---

##  Fitur Utama

Sistem Courty dibagi menjadi 3 hak akses utama (Role):

### 1. Sisi Pelanggan (Role `0`)
* **Registrasi & Login Mudah**: Pembuatan akun cepat dengan enkripsi password menggunakan `password_hash()`.
* **Cari Lapangan Olahraga**: Fitur pencarian cerdas berdasarkan nama venue, alamat, atau jenis olahraga.
* **Filter Olahraga Populer**: Kategori olahraga terpadu (Futsal, Badminton, Renang, Tennis, Padel, Basket, Voli).
* **Trending & Rekomendasi Venue**: Menampilkan venue paling populer berdasarkan jumlah dilihat (view tracking).
* **Detail Venue Lengkap**: Informasi jam operasional, alamat terintegrasi Google Maps, galeri foto lapangan, deskripsi, dan daftar harga sewa per jam.
* **Reservasi Instan**: Formulir pemesanan dengan perhitungan total harga otomatis berdasarkan durasi jam sewa.
* **Riwayat Pesanan (Pesanan Saya)**: Halaman pelacakan status booking dari *Pending*, *Confirmed*, *Paid*, hingga *Completed*.
* **Unggah Bukti Pembayaran**: Sistem unggah bukti transfer pembayaran (gambar/PDF) untuk verifikasi.

### 2. Sisi Mitra / Pemilik Venue (Role `3`)
* **Registrasi Mitra 2 Langkah (Two-Step Register)**:
  * **Langkah 1**: Registrasi data diri & akun personal.
  * **Langkah 2**: Registrasi profil venue (Nama venue, alamat, link Google Maps, deskripsi, jam operasional, dan foto profil venue).
* **Dashboard Mitra**: Panel khusus untuk melihat daftar lapangan olahraga yang dimiliki.
* **Manajemen Lapangan (CRUD)**:
  * Menambahkan lapangan baru beserta foto lapangan, deskripsi, jenis olahraga, dan tarif per jam.
  * Mengubah informasi lapangan.
  * Menghapus lapangan yang tidak aktif.
* **Manajemen Order Masuk**:
  * **Approve Booking**: Menyetujui reservasi dan mengunggah **QR Code** pembayaran agar pelanggan bisa membayar.
  * **Reject Booking**: Menolak pesanan masuk dengan menyertakan alasan penolakan tertentu.
  * **Verify Pembayaran**: Memvalidasi bukti transfer yang diunggah pelanggan untuk menyelesaikan transaksi (*Completed*).

### 3. Sisi Super Admin (Role `1`)
* **Dashboard Admin**: Panel administratif untuk monitoring pengguna sistem, venue, dan data olahraga secara global.

---

## Teknologi yang Digunakan

* **Core Framework**: PHP CodeIgniter 3.x
* **Database**: MySQL / MariaDB
* **Styling & CSS**: Tailwind CSS (via CDN)
* **Icons**: FontAwesome v6
* **Typography**: Inter (Google Fonts)

---

## Struktur Proyek

Struktur folder utama aplikasi ini mengikuti arsitektur MVC (Model-View-Controller) bawaan CodeIgniter:

```text
Courty/
├── application/
│   ├── config/            # Konfigurasi aplikasi (database, routes, autoload, dll.)
│   ├── controllers/       # Logika bisnis & navigasi utama
│   │   ├── Admin.php      # Controller panel Super Admin
│   │   ├── App.php        # Controller untuk Pelanggan (Home, Search, Details)
│   │   ├── Auth.php       # Controller untuk Autentikasi (Login, Register, Logout)
│   │   ├── Booking.php    # Controller transaksi penyewaan & pembayaran
│   │   └── Mitra.php      # Controller panel Mitra & Manajemen Lapangan
│   ├── models/            # Interaksi database
│   │   ├── model.php      # Query utama untuk users, venue, court, dan booking
│   │   └── sportModel.php # Query khusus kategori olahraga & dummy data fallback
│   └── views/             # File antarmuka / UI (.php templates)
├── assets/                # File statis (CSS, JS, Uploads)
│   └── uploads/           # Direktori penyimpanan media (file upload)
│       ├── court_profiles/# Foto-foto lapangan olahraga
│       ├── payments/      # Bukti transfer pembayaran dari pelanggan
│       ├── qrcodes/       # QR Code pembayaran yang diunggah mitra
│       └── venue_profiles/# Foto profil venue olahraga
├── courty.sql             # SQL Database dump
└── index.php              # Entry point utama aplikasi
```

---

## Skema Database (`courty`)

Aplikasi ini menggunakan 6 tabel utama yang saling berelasi:

1. **`users`**: Menyimpan data akun pengguna (Pelanggan, Mitra, Admin).
2. **`venue`**: Menyimpan data profil gedung/tempat olahraga yang didaftarkan oleh Mitra.
3. **`court`**: Menyimpan data detail lapangan di dalam suatu venue.
4. **`sport`**: Menyimpan daftar jenis olahraga yang didukung.
5. **`booking`**: Menyimpan data transaksi reservasi lapangan, bukti bayar, QR Code, dan status pembayaran.
6. **`photo`**: Menyimpan foto galeri tambahan untuk lapangan.

### Relasi Antar Tabel:
* Satu **User** (Mitra) memiliki satu **Venue** (`users.id_user` -> `venue.id_user`).
* Satu **Venue** dapat memiliki banyak **Court** (`venue.id_venue` -> `court.id_venue`).
* Setiap **Court** mengacu pada satu kategori **Sport** (`sport.id_sport` -> `court.id_sport`).
* Transaksi **Booking** mencatat relasi antara **User** (Pelanggan) dan **Court** yang disewa.

---

## Panduan Instalasi di Localhost

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek ini di komputer Anda menggunakan XAMPP:

## 🐳 Panduan Menjalankan dengan Docker & Docker Compose (Rekomendasi)

Aplikasi Courty beserta database MySQL telah ter-dockerisasi penuh menggunakan Docker Compose. Database akan langsung terisi data awal secara otomatis saat pertama kali dijalankan.

### 1. Prasyarat
* [Docker Desktop](https://www.docker.com/products/docker-desktop/) (versi 20.10+ dengan Docker Compose v2) sudah terinstal dan berjalan di komputer Anda.

### 2. Setup Environment Variables
Salin berkas template `.env.example` menjadi `.env`:
* **Windows (PowerShell / CMD)**:
  ```powershell
  copy .env.example .env
  ```
* **Linux / macOS**:
  ```bash
  cp .env.example .env
  ```

Konfigurasi default di dalam `.env`:
```env
APP_PORT=8080
DB_HOST=db
DB_PORT=3306
DB_NAME=courty
DB_USER=courty_user
DB_PASSWORD=courty_password
MYSQL_ROOT_PASSWORD=root_password
```

### 3. Build & Menjalankan Service
Jalankan perintah berikut di terminal root proyek:
```bash
docker compose up --build -d
```
> Perintah di atas akan membangun image backend dari `Dockerfile`, mengunduh image `mysql:8.0` dan `nginx:alpine`, membuat jaringan `courty_network`, membuat volume `courty_db_data`, mengimpor skema awal dari `courty.sql`, serta menjalankan 3 replika backend yang dilindungi oleh reverse proxy Nginx pada port 80.

Setelah proses selesai, buka browser Anda di:
👉 **[http://localhost](http://localhost)**

Untuk mematikan container:
```bash
docker compose down
```

---

## 🛡️ Tugas 2: Arsitektur Reverse Proxy Nginx, Load Balancing & Gateway Keamanan

Pada Tugas 2 ini, arsitektur ditingkatkan menjadi sistem multi-replica produksi dengan Nginx sebagai satu-satunya pintu gerbang (*Single Entry Point*):
1. **Satu Pintu:** Hanya service `nginx` yang membuka port (`80:80`). Port backend (`8080`) dan database (`3307`) ditutup sepenuhnya dari akses host luar.
2. **Reverse Proxy:** Rute `/api/` diteruskan ke backend lengkap dengan header `Host`, `X-Forwarded-For`, dan `X-Real-IP`.
3. **Load Balancing:** Backend berjalan dengan **3 replika** (`deploy: replicas: 3`), upstream menggunakan `zone backend_zone 64k;`, dan respons menyertakan header `X-Upstream: $upstream_addr`.
4. **Rate Limiting:** Rute `/api/` dibatasi dengan `limit_req` dan secara eksplisit menolak request berlebih dengan kode HTTP `429 Too Many Requests`.
5. **Header Keamanan & Gzip:** Menyematkan header `X-Content-Type-Options: nosniff` dan kompresi `gzip on` untuk data JSON.

---

### 1. Bukti Output `curl` Pengujian (Teks Kode Mentah)

#### a. Bukti Port Lama Backend (8080) & Database (3307) Tertutup dari Luar
Pengujian koneksi langsung ke port 8080 dan 3307 pada host gagal (*Connection Refused*), membuktikan akses luar wajib melewati satu pintu Nginx:

```bash
curl.exe -I http://localhost:8080
```
Output:
```text
curl: (7) Failed to connect to localhost port 8080 after 2264 ms: Could not connect to server
```

```bash
curl.exe -I http://localhost:3307
```
Output:
```text
curl: (7) Failed to connect to localhost port 3307 after 2255 ms: Could not connect to server
```

---

#### b. Bukti Load Balancing (Header `X-Upstream` Berganti Antar-Replika)
Pengujian endpoint `/api/status` sebanyak 3 kali berturut-turut membuktikan Nginx mendistribusikan beban secara merata (*Round-Robin*) ke 3 container backend yang berbeda (`172.18.0.5:80`, `172.18.0.4:80`, dan `172.18.0.3:80`):

* **Request 1:**
```bash
curl.exe -i -s http://localhost/api/status
```
Output:
```text
HTTP/1.1 200 OK
Server: nginx/1.31.8
Date: Mon, 09 Nov 2026 04:45:30 GMT
Content-Type: application/json; charset=utf-8
Content-Length: 180
Connection: keep-alive
Vary: Accept-Encoding
X-Powered-By: PHP/8.1.34
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
X-Upstream: 172.18.0.5:80

{
    "status": "success",
    "message": "Courty API Gateway is operational",
    "service": "backend-ci3",
    "timestamp": "2026-11-09 04:45:30",
    "server_ip": "172.18.0.5"
}
```

* **Request 2:**
```bash
curl.exe -i -s http://localhost/api/status
```
Output:
```text
HTTP/1.1 200 OK
Server: nginx/1.31.8
Date: Mon, 09 Nov 2026 04:45:35 GMT
Content-Type: application/json; charset=utf-8
Content-Length: 180
Connection: keep-alive
Vary: Accept-Encoding
X-Powered-By: PHP/8.1.34
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
X-Upstream: 172.18.0.4:80

{
    "status": "success",
    "message": "Courty API Gateway is operational",
    "service": "backend-ci3",
    "timestamp": "2026-11-09 04:45:35",
    "server_ip": "172.18.0.4"
}
```

* **Request 3:**
```bash
curl.exe -i -s http://localhost/api/status
```
Output:
```text
HTTP/1.1 200 OK
Server: nginx/1.31.8
Date: Mon, 09 Nov 2026 04:45:42 GMT
Content-Type: application/json; charset=utf-8
Content-Length: 180
Connection: keep-alive
Vary: Accept-Encoding
X-Powered-By: PHP/8.1.34
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
X-Upstream: 172.18.0.3:80

{
    "status": "success",
    "message": "Courty API Gateway is operational",
    "service": "backend-ci3",
    "timestamp": "2026-11-09 04:45:42",
    "server_ip": "172.18.0.3"
}
```

---

#### c. Bukti Rate Limiting (Muncul Status HTTP 429 Too Many Requests)
Pengujian pengiriman request beruntun secara cepat ke endpoint `/api/venues` membuktikan Nginx menolak request berlebih dengan kode HTTP 429:

```powershell
1..6 | ForEach-Object { curl.exe -s -o /dev/null -w "%{http_code}`n" http://localhost/api/venues }
```
Output:
```text
200
200
200
429
429
429
```

Respons lengkap saat status 429 terjadi:
```text
HTTP/1.1 429 Too Many Requests
Server: nginx/1.31.8
Date: Mon, 09 Nov 2026 04:45:53 GMT
Content-Type: text/html
Content-Length: 169
Connection: keep-alive
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block

<html>
<head><title>429 Too Many Requests</title></head>
<body>
<center><h1>429 Too Many Requests</h1></center>
<hr><center>nginx/1.31.8</center>
</body>
</html>
```

---

#### d. Bukti Header Keamanan & Gzip Compression
Pengujian request dengan header `Accept-Encoding: gzip` membuktikan Nginx berhasil mengompresi payload JSON dan menyematkan header keamanan:

```bash
curl.exe -I -H "Accept-Encoding: gzip" http://localhost/api/venues
```
Output:
```text
HTTP/1.1 200 OK
Server: nginx/1.31.8
Date: Mon, 09 Nov 2026 04:45:59 GMT
Content-Type: application/json; charset=utf-8
Connection: keep-alive
Vary: Accept-Encoding
X-Powered-By: PHP/8.1.34
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
X-Upstream: 172.18.0.5:80
Content-Encoding: gzip
```

---

### 2. Jawaban Pertanyaan Teori

**(a) Kenapa upstream perlu `zone`? Apa yang terjadi kalau dihapus?**  
Direktif `zone` mendefinisikan area memori bersama (*shared memory zone*) yang dapat diakses oleh seluruh *worker process* Nginx untuk menyimpan konfigurasi upstream, counter load balancing, dan status kesehatan server backend secara tersinkronisasi. Jika direktif `zone` dihapus, setiap *worker process* akan mengelola state upstream secara terisolasi di memori lokal masing-masing tanpa koordinasi, sehingga pembagian beban (*load balancing*) menjadi tidak seimbang dan tidak konsisten. Selain itu, fitur dinamis seperti resolusi DNS berkala pada upstream tidak dapat beroperasi optimal antar-worker.

**(b) Kenapa `limit_req_status` diganti ke 429? Apa bedanya dengan bawaan Nginx?**  
Secara bawaan, Nginx merespons pelanggaran batas request (*rate limit*) dengan status HTTP `503 Service Temporarily Unavailable`, yang secara semantik standar HTTP merepresentasikan kegagalan atau kelebihan beban di sisi internal server (*server error*). Status tersebut diganti ke `429 Too Many Requests` (RFC 6585) karena secara tepat mengindikasikan kesalahan ada di pihak klien (*client error*) yang telah melampaui kuota frekuensi pengiriman request dalam kurun waktu tertentu. Perbedaan ini memudahkan klien maupun pengembang API memahami bahwa penolakan terjadi akibat pembatasan laju trafik (*throttling*), bukan karena server aplikasi sedang rusak.

**(c) Kenapa backend dan database tidak punya ports, dan Nginx menjangkau backend lewat apa?**  
Backend dan database sengaja tidak memetakan direktif `ports` ke host untuk menerapkan prinsip keamanan *Least Privilege* dan *Defense in Depth*, sehingga mencegah akses langsung yang tidak terotorisasi dari jaringan luar ke layer aplikasi dan basis data. Nginx menjangkau container backend melalui jaringan privat Docker (*bridge network*) memanfaatkan layanan DNS bawaan Docker yang secara otomatis mengarahkan nama service `web` ke alamat IP internal ketiga replika backend. Dengan demikian, Nginx bertindak sebagai satu-satunya gerbang masuk (*single entry point*) yang mengamankan seluruh lalu lintas data.

---

---

## 🧪 Panduan Pengujian Sistem & Persistensi Data

### 1. Pengujian Endpoint / Fitur Aplikasi (Baca & Tulis Data)
1. **Buka Aplikasi**: Akses `http://localhost:8080` di browser.
2. **Uji Tulis Data (Registrasi Akun Baru)**:
   * Klik tombol **Login / Register** di pojok kanan atas, lalu pilih **Daftar Sekarang**.
   * Isi nama, email, nomor telepon, dan password baru.
   * Klik **Daftar**. Sistem akan menyimpan user baru ke tabel `users` di MySQL.
3. **Uji Baca Data (Login)**:
   * Masukkan email dan password akun yang baru didaftarkan.
   * Jika berhasil masuk dan nama Anda muncul di navbar, integrasi backend dan database terbukti sukses.

### 2. Pengujian Persistensi Data (Volume Persistence Test)
Pengujian ini membuktikan bahwa data di database tetap aman dan tidak hilang saat container dihapus/dibuat ulang:
1. Pastikan Anda sudah membuat akun baru pada langkah sebelumnya.
2. Hentikan dan hapus container di terminal (tanpa menghapus volume):
   ```bash
   docker compose down
   ```
3. Nyalakan kembali container:
   ```bash
   docker compose up -d
   ```
4. Buka kembali `http://localhost:8080`, lakukan login dengan akun yang Anda buat tadi.
5. **Hasil**: Akun tetap dapat login dengan normal, membuktikan data tersimpan permanen di dalam Docker named volume `courty_db_data`.

---

## 💻 Panduan Menjalankan Manual (Alternatif Non-Docker / XAMPP)

## Akun Demo (Bawaan Database)

Anda dapat menggunakan akun-akun demo berikut yang sudah ada dalam database untuk menguji fitur aplikasi:

| Peran (Role) | Email | Password | Keterangan |
|---|---|---|---|
| **Super Admin** | `admin@gmail.com` | `admin123` / Silakan Daftar Baru | Hak akses mengelola sistem keseluruhan |
| **Mitra (Partner)** | `alif@gmail.com` | Silakan Daftar Baru | Mengelola "GOR Bulan Sabit" |
| **Mitra (Partner)** | `mahdi@gmail.com` | Silakan Daftar Baru | Mengelola "GOR YU AI" |
| **Pelanggan (User)** | `furinaaaaaa@gmail.com` | Silakan Daftar Baru | Melakukan booking lapangan |

> **Catatan Keamanan**: 
> Untuk keamanan data dan pengujian fitur pendaftaran secara real, disarankan untuk melakukan registrasi akun baru (baik Pelanggan maupun Mitra) secara langsung melalui antarmuka web.

---

## Alur Kerja Reservasi Lapangan

```mermaid
sequenceDiagram
    autonumber
    actor Pelanggan
    actor Mitra
    
    Pelanggan->>Pelanggan: Registrasi & Login
    Pelanggan->>Pelanggan: Cari & Pilih Lapangan
    Pelanggan->>Mitra: Buat Reservasi (Status: Pending)
    Mitra->>Mitra: Tinjau Jadwal Lapangan
    Mitra->>Pelanggan: Setujui Booking & Upload QR Code Pembayaran (Status: Confirmed)
    Pelanggan->>Pelanggan: Lakukan Transfer & Upload Bukti Bayar (Status: Paid)
    Mitra->>Mitra: Verifikasi Bukti Transfer
    Mitra->>Pelanggan: Selesaikan Pemesanan (Status: Completed)
    Pelanggan->>Pelanggan: Datang ke Lapangan sesuai Jadwal
```

---

## 📚 Referensi & Penggunaan AI (Attribution)
* **Framework**: CodeIgniter 3.1.13 Documentation ([codeigniter.com](https://codeigniter.com))
* **Containerization**: Official Docker & Docker Compose Documentation ([docs.docker.com](https://docs.docker.com))
* **Bantuan AI**: Menggunakan asistensi AI (Antigravity AI Assistant) untuk perancangan `Dockerfile`, konfigurasi `docker-compose.yml`, optimasi penanganan environment variable pada CodeIgniter 3, serta penyusunan dokumentasi teknis ini sesuai ketentuan Tugas 1 Backend Intermediate.

---

*Made with ❤️ by Courty Development Team*
