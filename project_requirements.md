# ForIT — Project Requirements Document
> **Forum IT** | Platform Komunitas Diskusi Teknologi Informasi  
> Universitas Trunojoyo Madura · Kelompok 2 · 2026

---

## Daftar Isi

1. [Gambaran Umum](#1-gambaran-umum)
2. [Aktor & Peran](#2-aktor--peran)
3. [Use Case Diagram — Ringkasan](#3-use-case-diagram--ringkasan)
4. [Kebutuhan Fungsional](#4-kebutuhan-fungsional)
   - 4.1 [Guest (Tamu)](#41-guest-tamu)
   - 4.2 [User (Pengguna Terdaftar)](#42-user-pengguna-terdaftar)
   - 4.3 [Moderator](#43-moderator)
   - 4.4 [Super Admin](#44-super-admin)
5. [Skenario Use Case Lengkap](#5-skenario-use-case-lengkap)
6. [Kebutuhan Non-Fungsional](#6-kebutuhan-non-fungsional)
7. [Batasan Teknis & Asumsi](#7-batasan-teknis--asumsi)
8. [Stack Teknologi](#8-stack-teknologi)

---

## 1. Gambaran Umum

**ForIT** adalah aplikasi web berbasis arsitektur *client-server* yang berfungsi sebagai platform komunitas diskusi seputar dunia Teknologi Informasi. Pengguna mengakses sistem melalui *web browser* yang berkomunikasi dengan *web server* dan basis data terpusat secara *real-time*.

| Atribut | Detail |
|---|---|
| Nama Sistem | ForIT (Forum IT) |
| Tipe Aplikasi | Web Application (Client-Server) |
| Target Pengguna | Komunitas IT di Indonesia |
| Institusi | Universitas Trunojoyo Madura |
| Tahun | 2026 |

### Ruang Lingkup Sistem

ForIT menangani lima domain utama:

1. **Sistem Diskusi Komunitas** — Thread dan Post melalui editor teks web
2. **Manajemen Hak Akses** — Empat level aktor dengan fungsionalitas yang dibatasi secara ketat
3. **Fitur Sosial** — Bookmark, Share, dan Report untuk interaksi antar pengguna
4. **Moderasi Konten** — Dasbor validasi laporan dan eksekusi sanksi (Warning / Takedown)
5. **Administrasi Sistem** — Manajemen akun, kategori forum, dan penetapan peran (Role)

---

## 2. Aktor & Peran

| Aktor | Deskripsi | Hak Akses |
|---|---|---|
| **Guest** | Pengunjung tanpa akun; dapat menelusuri dan mencari Thread/Post secara bebas | Fitur publik saja (baca & cari). Tidak dapat berinteraksi aktif |
| **User** | Member komunitas dengan akun aktif | Penuh pada fitur forum setelah login (Thread, Post, Bookmark, Share, Report) |
| **Moderator** | Pengawas konten operasional; memvalidasi laporan dan menerapkan sanksi | Akses dasbor moderasi konten dan manajemen laporan |
| **Super Admin** | Pengelola infrastruktur dan kebijakan sistem | Hak akses penuh (Superuser) ke seluruh modul Dashboard |

### Kemampuan yang Dipersyaratkan per Aktor

| Aktor | Kemampuan Minimum |
|---|---|
| Guest | Dapat mengakses internet menggunakan web browser standar |
| User | Mampu mengoperasikan komputer/smartphone dan memahami dasar web browser |
| Moderator | Mampu menilai kelayakan konten dan berkomunikasi secara digital |
| Super Admin | Menguasai pengoperasian komputer dan manajemen platform digital |

---

## 3. Use Case Diagram — Ringkasan

### Pola Relasi Antar Use Case

| Relasi | Penjelasan |
|---|---|
| `<<include>>` | Use case wajib memicu use case lain (contoh: semua aksi aktif User wajib melalui Login) |
| `<<extend>>` | Use case opsional yang memperluas use case utama (contoh: Melihat Komentar memperluas Melihat Post) |

### Peta Use Case per Aktor

```
Guest
  ├── Melihat Thread          (publik)
  ├── Melihat Post            (publik)
  ├── Melihat Balasan         (publik, <<extend>> Melihat Post)
  ├── Melihat Komentar        (publik, <<extend>> Melihat Post)
  └── Registrasi              (publik)

User
  ├── Login                   (<<include>> oleh semua aksi aktif)
  ├── Thread: Buat            (<<include>> Login)
  ├── Thread: Edit            (<<include>> Login)
  ├── Thread: Hapus           (<<include>> Login)
  ├── Thread: Simpan          (Bookmark, <<include>> Login)
  ├── Thread: Laporkan        (Report, <<include>> Login)
  ├── Post: Buat              (<<include>> Login)
  ├── Post: Edit              (<<include>> Login)
  ├── Post: Hapus             (<<include>> Login)
  ├── Post: Simpan            (Bookmark, <<include>> Login)
  └── Post: Laporkan          (Report, <<include>> Login)

Moderator
  ├── Login                   (<<include>> oleh semua aksi moderasi)
  ├── Validasi Laporan        (<<include>> Login)
  ├── Takedown Post/Thread    (<<include>> Login)
  ├── Member Warning          (<<include>> Login)
  └── Member Punishment       (<<include>> Login)

Super Admin
  ├── Login                   (<<include>> oleh semua aksi admin)
  ├── Promote & Demote Moderator  (<<include>> Login)
  ├── Manajemen Post              (<<include>> Login)
  ├── Manajemen Thread            (<<include>> Login)
  └── Manajemen User/Akun        (<<include>> Login)
```

---

## 4. Kebutuhan Fungsional

### 4.1 Guest (Tamu)

| Kode | Fitur | Deskripsi |
|---|---|---|
| REQ-F-01 | Lihat Daftar Thread, Post, Komentar | Akses publik ke seluruh konten forum tanpa login |
| REQ-F-02 | Pencarian Thread | Pencarian berbasis kata kunci melalui *search bar* web |
| REQ-F-03 | Registrasi Akun | Pendaftaran akun baru melalui form website (Nama, Email, Username, Password) |
| REQ-F-04 | Login | Autentikasi menggunakan Email/Username dan Password |

### 4.2 User (Pengguna Terdaftar)

> Semua fitur berikut memerlukan sesi login yang valid (`<<include>>` Login).

| Kode | Fitur | Deskripsi |
|---|---|---|
| REQ-F-05 | CRUD Thread Milik Sendiri | Buat, baca, edit, dan hapus Thread melalui editor teks web |
| REQ-F-06 | CRUD Post / Komentar | Buat, baca, edit, dan hapus Post/Komentar dalam sebuah Thread |
| REQ-F-07 | Bookmark Konten | Menyimpan Thread/Post favorit ke daftar Bookmark di profil |
| REQ-F-08 | Report Konten | Melaporkan Post/Thread yang melanggar ketentuan komunitas |
| REQ-F-09 | Share Konten | Membagikan tautan Thread/Post ke platform media sosial eksternal |
| REQ-F-10 | Berbagi Profil | Menampilkan halaman profil publik beserta riwayat Thread pengguna |

### 4.3 Moderator

> Semua fitur berikut memerlukan sesi login Moderator yang valid (`<<include>>` Login).

| Kode | Fitur | Deskripsi |
|---|---|---|
| REQ-F-11 | Akses Dasbor Validasi Laporan | Melihat daftar laporan masuk dari User berstatus "Pending" |
| REQ-F-12 | Takedown Konten | Menghapus/menonaktifkan konten yang terbukti melanggar ketentuan |
| REQ-F-13 | Kirim Member Warning | Mengirimkan notifikasi peringatan ke dasbor User yang melanggar |
| REQ-F-14 | Eksekusi Member Punishment | Membatasi hak posting User secara sementara |

### 4.4 Super Admin

> Semua fitur berikut memerlukan sesi login Super Admin yang valid (`<<include>>` Login).

| Kode | Fitur | Deskripsi |
|---|---|---|
| REQ-F-15 | CRUD Seluruh Akun Pengguna | Membuat, melihat, memperbarui, dan menghapus akun pengguna mana pun via panel admin |
| REQ-F-16 | Manajemen Kategori Forum | Tambah, edit, dan hapus kategori forum secara global |
| REQ-F-17 | Promote & Demote Role | Mempromosikan User menjadi Moderator atau menurunkan Moderator menjadi User |
| REQ-F-18 | Banned Akun Permanen | Menonaktifkan akun pengguna secara permanen akibat pelanggaran berat |

---

## 5. Skenario Use Case Lengkap

### REQ-F-01 · Melihat Daftar Thread, Post, dan Komentar

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F01 |
| **Aktor** | Guest, User |
| **Tujuan** | Memberikan akses publik terhadap konten diskusi forum |
| **Prasyarat** | — (tidak memerlukan login) |

| # | Aktor | Sistem |
|---|---|---|
| 1 | Aktor mengakses halaman utama ForIT | |
| 2 | | Menampilkan daftar Thread beserta jumlah post dan komentar |
| 3 | Aktor memilih Thread yang ingin dibaca | |
| 4 | | Menampilkan detail Thread beserta seluruh Post dan Komentar |

---

### REQ-F-02 · Pencarian Thread Berbasis Kata Kunci

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F02 |
| **Aktor** | Guest, User |
| **Tujuan** | Memudahkan pengguna menemukan topik diskusi yang relevan |
| **Prasyarat** | — (tidak memerlukan login) |

| # | Aktor | Sistem |
|---|---|---|
| 1 | Aktor mengetik kata kunci pada *search bar* | |
| 2 | | Melakukan query pencarian ke basis data |
| 3 | | Menampilkan daftar Thread yang relevan |

---

### REQ-F-03 · Registrasi Akun

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F03 |
| **Aktor** | Guest |
| **Tujuan** | Mendaftarkan diri sebagai anggota komunitas ForIT |
| **Prasyarat** | — |

| # | Aktor | Sistem |
|---|---|---|
| 1 | Guest mengakses halaman Registrasi | |
| 2 | | Menampilkan form (Nama, Email, Username, Password) |
| 3 | Guest mengisi form dan klik tombol **Daftar** | |
| 4 | | Memvalidasi kelengkapan dan keunikan data (email/username) |
| 5 | | Menyimpan akun baru ke database dengan status aktif |

---

### REQ-F-04 · Login / Autentikasi

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F04 |
| **Aktor** | User, Moderator, Super Admin |
| **Tujuan** | Memvalidasi identitas untuk masuk ke area privat sistem |
| **Prasyarat** | Aktor memiliki akun terdaftar |

| # | Aktor | Sistem |
|---|---|---|
| 1 | Aktor memasukkan Email/Username dan Password | |
| 2 | | Mencocokkan data dengan basis data |
| 3 | | Jika valid: memberikan hak akses sesuai level (User / Moderator / Super Admin) |
| 4 | | Jika tidak valid: menampilkan notifikasi "Login Gagal" |

---

### REQ-F-05 · CRUD Thread Milik Sendiri

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F05 |
| **Aktor** | User |
| **Tujuan** | Memungkinkan User membuat, membaca, memperbarui, dan menghapus Thread miliknya |
| **Prasyarat** | `<<include>>` Login |

| # | Aktor | Sistem |
|---|---|---|
| 1 | User mengakses fitur **Buat Thread** | |
| 2 | | Memvalidasi sesi Login |
| 3 | | Menampilkan form Thread (Judul, Kategori, Konten) |
| 4 | User mengisi form dan klik **Kirim** | |
| 5 | | Menyimpan Thread ke database dan menampilkannya di forum |
| 6 | User memilih Thread miliknya untuk diedit atau dihapus | |
| 7 | | Memperbarui atau menghapus data Thread sesuai aksi User |

---

### REQ-F-06 · CRUD Post / Komentar

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F06 |
| **Aktor** | User |
| **Tujuan** | Memungkinkan User berkontribusi dan mengelola balasannya dalam sebuah Thread |
| **Prasyarat** | `<<include>>` Login |

| # | Aktor | Sistem |
|---|---|---|
| 1 | User membuka Thread dan mengisi kolom komentar | |
| 2 | | Memvalidasi sesi Login |
| 3 | | Menyimpan Post/Komentar baru ke database |
| 4 | User memilih Post/Komentar miliknya untuk diedit atau dihapus | |
| 5 | | Memperbarui atau menghapus data sesuai aksi User |

---

### REQ-F-07 · Bookmark Konten

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F07 |
| **Aktor** | User |
| **Tujuan** | Menyimpan konten favorit agar mudah diakses kembali dari profil |
| **Prasyarat** | `<<include>>` Login |

| # | Aktor | Sistem |
|---|---|---|
| 1 | User menekan tombol **Simpan** (Bookmark) pada konten | |
| 2 | | Memvalidasi sesi Login |
| 3 | | Menambahkan konten ke daftar Bookmark di profil User |

---

### REQ-F-08 · Pelaporan (Report) Konten

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F08 |
| **Aktor** | User |
| **Tujuan** | Melaporkan konten yang melanggar ketentuan komunitas kepada Moderator |
| **Prasyarat** | `<<include>>` Login |

| # | Aktor | Sistem |
|---|---|---|
| 1 | User menekan tombol **Report** pada Post yang melanggar | |
| 2 | | Memvalidasi sesi Login |
| 3 | | Menampilkan form alasan pelaporan |
| 4 | User mengisi alasan dan mengirimkan laporan | |
| 5 | | Menyimpan laporan ke database dengan status **"Pending"** |

---

### REQ-F-09 · Share Konten

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F09 |
| **Aktor** | User |
| **Tujuan** | Membagikan tautan Thread/Post ke platform media sosial eksternal |
| **Prasyarat** | — |

| # | Aktor | Sistem |
|---|---|---|
| 1 | User menekan tombol **Share** | |
| 2 | | Menampilkan pilihan platform media sosial tujuan |
| 3 | User memilih platform tujuan | |
| 4 | | Menghasilkan tautan dan mengarahkan ke platform yang dipilih |

---

### REQ-F-11 & F-12 · Validasi Laporan & Takedown Konten

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F11, SKPL-F12 |
| **Aktor** | Moderator |
| **Tujuan** | Meninjau laporan User dan mengeksekusi Takedown atas konten yang melanggar |
| **Prasyarat** | `<<include>>` Login sebagai Moderator |

| # | Aktor | Sistem |
|---|---|---|
| 1 | Moderator membuka dasbor validasi laporan | |
| 2 | | Menampilkan daftar laporan berstatus **"Pending"** |
| 3 | Moderator membuka detail laporan dan meninjau konten | |
| 4 | Moderator memilih aksi: **Takedown** atau **Abaikan** | |
| 5 | | Memperbarui status konten dan laporan sesuai aksi |

---

### REQ-F-13 & F-14 · Kirim Warning & Eksekusi Punishment

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F13, SKPL-F14 |
| **Aktor** | Moderator |
| **Tujuan** | Memberikan peringatan dan membatasi hak posting User yang melanggar |
| **Prasyarat** | `<<include>>` Login sebagai Moderator |

| # | Aktor | Sistem |
|---|---|---|
| 1 | Moderator memilih akun User yang akan diberi sanksi | |
| 2 | | Menampilkan pilihan: **Kirim Warning** atau **Batasi Posting** |
| 3 | Moderator memilih jenis sanksi dan mengkonfirmasi | |
| 4 | | Mengirim notifikasi Warning ke dasbor User dan/atau membatasi hak postingnya |

---

### REQ-F-15 · CRUD Seluruh Data Akun Pengguna

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F15 |
| **Aktor** | Super Admin |
| **Tujuan** | Mengelola keseluruhan akun pengguna via panel admin |
| **Prasyarat** | `<<include>>` Login sebagai Super Admin |

| # | Aktor | Sistem |
|---|---|---|
| 1 | Super Admin membuka modul **Manajemen Akun** | |
| 2 | | Memvalidasi sesi Login Super Admin |
| 3 | | Menampilkan daftar seluruh akun pengguna terdaftar |
| 4 | Super Admin memilih akun untuk diedit, membuat akun baru, atau menghapus akun | |
| 5 | | Memperbarui data pengguna di database |

---

### REQ-F-16 · Manajemen Kategori Forum

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F16 |
| **Aktor** | Super Admin |
| **Tujuan** | Mengelola struktur kategori forum secara global |
| **Prasyarat** | `<<include>>` Login sebagai Super Admin |

| # | Aktor | Sistem |
|---|---|---|
| 1 | Super Admin membuka modul **Manajemen Forum** | |
| 2 | | Memvalidasi sesi Login Super Admin |
| 3 | | Menampilkan daftar kategori forum yang ada |
| 4 | Super Admin memilih aksi: tambah, edit, atau hapus kategori | |
| 5 | | Menyimpan perubahan struktur forum ke database |

---

### REQ-F-17 · Promote & Demote Role

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F17 |
| **Aktor** | Super Admin |
| **Tujuan** | Mengubah peran pengguna antara User dan Moderator |
| **Prasyarat** | `<<include>>` Login sebagai Super Admin |

| # | Aktor | Sistem |
|---|---|---|
| 1 | Super Admin memilih akun pada panel admin | |
| 2 | | Memvalidasi sesi Login Super Admin |
| 3 | | Menampilkan detail akun beserta Role saat ini |
| 4 | Super Admin memilih **Promote** (ke Moderator) atau **Demote** (ke User) | |
| 5 | | Memperbarui Role di database dan mengirimkan notifikasi perubahan ke akun terkait |

---

### REQ-F-18 · Banned Akun Permanen

| Atribut | Detail |
|---|---|
| **Kode** | SKPL-F18 |
| **Aktor** | Super Admin |
| **Tujuan** | Menonaktifkan akun secara permanen akibat pelanggaran berat |
| **Prasyarat** | `<<include>>` Login sebagai Super Admin |

| # | Aktor | Sistem |
|---|---|---|
| 1 | Super Admin memilih akun yang akan di-banned | |
| 2 | | Memvalidasi sesi Login Super Admin |
| 3 | | Menampilkan konfirmasi tindakan Banned permanen |
| 4 | Super Admin mengkonfirmasi eksekusi Banned | |
| 5 | | Menonaktifkan akun secara permanen; pengguna tidak dapat login kembali |

---

## 6. Kebutuhan Non-Fungsional

### 6.1 Keamanan (Security)

| Aspek | Deskripsi |
|---|---|
| Enkripsi Transfer | Implementasi SSL/TLS (HTTPS) untuk seluruh komunikasi data |
| Proteksi Injeksi | Perlindungan terhadap serangan SQL Injection |
| Proteksi Skrip | Perlindungan terhadap XSS (Cross-Site Scripting) |

### 6.2 Kompatibilitas

Sistem harus berjalan dengan baik pada browser modern berikut: Google Chrome, Mozilla Firefox, Apple Safari, dan Microsoft Edge (masing-masing versi terbaru).

### 6.3 Usabilitas (Usability)

- Navigasi intuitif sesuai standar User Experience (UX) portal forum
- **Responsive Design** yang kompatibel dengan Desktop, Tablet, dan Mobile Web
- Antarmuka dapat dioperasikan menggunakan keyboard dan mouse/sentuh

### 6.4 Keandalan (Reliability)

- Sistem diharapkan memiliki **uptime tinggi** dengan minimal downtime yang terencana
- Penanganan error yang informatif dan ramah pengguna
- Sistem mampu menangani akses bersamaan dari banyak pengguna tanpa degradasi performa yang signifikan

### 6.5 Performansi

| Metrik | Target |
|---|---|
| First Contentful Paint (FCP) | < 2 detik pada koneksi internet standar |
| Optimasi Aset Gambar | Halaman tetap ringan dan responsif saat dimuat |
| Konkurensi | Mampu melayani banyak pengguna secara bersamaan tanpa degradasi signifikan |

---

## 7. Batasan Teknis & Asumsi

### Batasan

1. Sistem hanya dapat diakses secara optimal jika perangkat pengguna memiliki **koneksi internet yang stabil**
2. Fitur interaktif (Thread, Bookmark, Report) hanya tersedia setelah pengguna **login** sebagai User terdaftar
3. Akses optimal memerlukan **browser modern** dengan dukungan JavaScript yang aktif
4. Keamanan data bergantung pada implementasi protokol enkripsi **HTTPS**

### Asumsi

1. Sistem dijalankan pada perangkat (laptop/PC/smartphone) yang memiliki **koneksi internet aktif**
2. Sistem bergantung pada ketersediaan **Web Server** (Apache/Nginx) dan **DBMS relasional** (MySQL/PostgreSQL) yang beroperasi stabil

---

## 8. Stack Teknologi

| Layer | Teknologi |
|---|---|
| **Frontend** | HTML, CSS Vanilla, JavaScript |
| **Web Server** | Apache / Nginx |
| **Backend** | PHP Vanilla (tanpa framework) |
| **Database** | MySQL |
| **Protokol** | HTTP / HTTPS |

---

*Dokumen ini disusun berdasarkan SKPL ForIT Kelompok 2 — Program Studi Teknik Informatika, Universitas Trunojoyo Madura, 2026.*
