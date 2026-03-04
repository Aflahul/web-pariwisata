# 🌿 Website Pariwisata

Sistem informasi pariwisata berbasis web dibangun menggunakan **Laravel 12**, **Bootstrap 5**, dan **MySQL**. Mengikuti arsitektur **MVC (Model View Controller)**.

---

## 📋 Daftar Isi

- [Gambaran Umum](#-gambaran-umum)
- [Tujuan Sistem](#-tujuan-sistem)
- [Arsitektur Sistem](#-arsitektur-sistem)
- [Modul Sistem](#-modul-sistem)
- [Struktur Database](#-struktur-database)
- [Alur Sistem](#-alur-sistem)
- [Halaman Website](#-halaman-website)
- [Keamanan Sistem](#-keamanan-sistem)
- [Instalasi](#-instalasi)
- [Teknologi](#-teknologi)
- [Pengembangan Selanjutnya](#-pengembangan-selanjutnya)

---

## 📌 Gambaran Umum

Website Pariwisata adalah sistem informasi berbasis web yang digunakan untuk:

- Menampilkan informasi destinasi wisata
- Menampilkan berita dan event pariwisata
- Menyediakan galeri foto wisata
- Memberikan informasi lokasi dan deskripsi tempat wisata
- Memudahkan admin mengelola data wisata

### Tech Stack

| Komponen | Teknologi |
|---|---|
| Backend | Laravel 12 |
| Frontend | HTML5, Bootstrap 5 |
| Database | MySQL |
| Asset Builder | NPM / Vite |
| Editor | Visual Studio Code |

---

## 🎯 Tujuan Sistem

1. Menyediakan informasi wisata secara terpusat
2. Mempromosikan destinasi wisata daerah
3. Mempermudah pengelolaan data wisata oleh admin
4. Meningkatkan kunjungan wisata melalui media digital

---

## 🏗️ Arsitektur Sistem

```
app
 ├── Models
 ├── Http
 │    ├── Controllers
 │    └── Middleware
 └── Providers

database
 ├── migrations
 └── seeders

resources
 ├── views
 ├── css
 └── js

routes
 └── web.php
```

| Folder | Fungsi |
|---|---|
| `app/Models` | Menyimpan model database |
| `app/Http/Controllers` | Logika aplikasi |
| `resources/views` | Tampilan Blade |
| `database/migrations` | Struktur tabel |
| `routes/web.php` | Routing website |

---

## 📦 Modul Sistem

### 4.1 Modul Destinasi Wisata

**Fungsi:**
- Menampilkan daftar tempat wisata
- Menampilkan detail wisata
- Menampilkan foto wisata
- Menampilkan lokasi

**Struktur data:**

| Field | Tipe |
|---|---|
| id | bigint |
| nama_wisata | varchar |
| deskripsi | text |
| lokasi | varchar |
| latitude | decimal |
| longitude | decimal |
| foto | varchar |

---

### 4.2 Modul Berita Wisata

**Fungsi:**
- Menampilkan berita terbaru
- Promosi event wisata
- Artikel wisata

**Struktur data:**

| Field | Tipe |
|---|---|
| id | bigint |
| judul | varchar |
| slug | varchar |
| isi | text |
| gambar | varchar |
| tanggal | date |

---

### 4.3 Modul Galeri

**Fungsi:**
- Menampilkan foto wisata
- Dokumentasi kegiatan wisata

**Struktur data:**

| Field | Tipe |
|---|---|
| id | bigint |
| judul | varchar |
| foto | varchar |
| deskripsi | text |

---

### 4.4 Modul Event Wisata

**Fungsi:**
- Menampilkan agenda wisata
- Jadwal festival daerah

**Struktur data:**

| Field | Tipe |
|---|---|
| id | bigint |
| nama_event | varchar |
| tanggal | date |
| lokasi | varchar |
| deskripsi | text |

---

### 4.5 Modul Admin Panel

**Admin dapat:**
- Menambah destinasi wisata
- Mengedit destinasi wisata
- Menghapus data wisata
- Mengelola berita
- Mengelola galeri
- Mengelola event

**Fitur keamanan:**
- Login admin
- Middleware auth
- Validasi input
- Proteksi CSRF

---

## 🗄️ Struktur Database

**Tabel `wisata`**

```
id
nama_wisata
deskripsi
lokasi
latitude
longitude
foto
created_at
updated_at
```

**Tabel `berita`**

```
id
judul
slug
isi
gambar
tanggal
created_at
updated_at
```

**Tabel `galeri`**

```
id
judul
foto
deskripsi
created_at
updated_at
```

---

## 🔄 Alur Sistem

**Alur Pengguna**

```
Pengguna buka website
      ↓
Sistem tampilkan halaman utama
      ↓
Pengguna pilih destinasi wisata
      ↓
Sistem tampilkan detail wisata
```

**Alur Admin**

```
Admin login
      ↓
Admin masuk dashboard
      ↓
Admin tambah / edit data wisata
      ↓
Data tersimpan di database
```

---

## 🖥️ Halaman Website

| Halaman | Fungsi |
|---|---|
| Home | Halaman utama |
| Destinasi | Daftar wisata |
| Detail Wisata | Informasi wisata |
| Berita | Artikel wisata |
| Galeri | Foto wisata |
| Event | Agenda wisata |
| Kontak | Informasi kontak |

---

## 🔐 Keamanan Sistem

- Laravel CSRF Protection
- Validasi input
- Authentication Laravel
- Middleware Auth
- File upload validation
- Sanitasi data

---

## ⚙️ Instalasi

**1. Clone repository**

```bash
git clone repository-url
```

**2. Install dependency**

```bash
composer install
npm install
```

**3. Konfigurasi environment**

```bash
cp .env.example .env
```

**4. Generate key**

```bash
php artisan key:generate
```

**5. Migrate database**

```bash
php artisan migrate
```

**6. Jalankan server**

```bash
php artisan serve
```

---

## 🛠️ Teknologi

| Teknologi | Fungsi |
|---|---|
| Laravel | Backend framework |
| Bootstrap 5 | UI framework |
| MySQL | Database |
| Vite | Build asset |
| Blade | Template engine |

---

## 🚀 Pengembangan Selanjutnya

- [ ] Peta wisata menggunakan Google Maps
- [ ] Sistem rating wisata
- [ ] Sistem komentar
- [ ] Booking tiket wisata
- [ ] API pariwisata
- [ ] Dashboard statistik pengunjung
