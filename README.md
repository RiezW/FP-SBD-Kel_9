# 📚 Library Management System — `library_kel9`

> **Final Project — Sistem Basis Data (SBD)**
> Kelompok 9 | Departemen Teknologi Informasi, FTEIC — ITS Surabaya

---

## Daftar Isi

- [Deskripsi Proyek](#deskripsi-proyek)
- [Anggota Kelompok](#anggota-kelompok)
- [Teknologi](#teknologi)
- [Struktur Database](#struktur-database)
  - [Diagram Relasi](#diagram-relasi)
  - [Deskripsi Tabel](#deskripsi-tabel)
- [Triggers](#triggers)
- [Data Dummy](#data-dummy)
- [Cara Menggunakan](#cara-menggunakan)

---

## Deskripsi Proyek

`library_kel9` adalah database sistem manajemen perpustakaan yang dirancang untuk mengelola seluruh operasional perpustakaan secara digital. Sistem ini mencakup manajemen koleksi buku, data pengarang, kategori, keanggotaan, transaksi peminjaman, denda keterlambatan, serta audit trail seluruh aktivitas penting.

Database dibangun menggunakan **MySQL (MariaDB 10.4.32)** dan di-export melalui **phpMyAdmin 5.2.1**.

---

## Anggota Kelompok

| No | Nama | NRP |
|----|-----|-----|
| 1  | Iqbal Rizki Muhammad Fadhli | 5027251027 |
| 2  | Daffa Ulhaq Fadhlurrahman | 5027251033 |
| 3  | Riezco Eka Bayu Witantra | 5027251057 |
| 4  | Muhamad Nasrulhaq | 5027251117 |

---

## Teknologi

| Komponen | Detail |
|----------|--------|
| DBMS | MariaDB 10.4.32 |
| Tools | phpMyAdmin 5.2.1 |
| Character Set | `utf8mb4` / `utf8mb4_unicode_ci` |
| Engine | InnoDB (semua tabel) |
| PHP | 8.2.12 |

---

## Struktur Database

Database `library_kel9` terdiri dari **9 tabel** dengan relasi yang terdefinisi melalui foreign key constraints.

<img width="1600" height="925" alt="WhatsApp Image 2026-06-08 at 9 55 36 PM" src="https://github.com/user-attachments/assets/b6db0064-42ea-42e8-a9a6-5d8c82358ace" />

### Deskripsi Tabel

#### 1. `pengarang`
Menyimpan data penulis/pengarang buku.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_pengarang` | `INT` | Primary Key, Auto Increment |
| `nama` | `VARCHAR(100)` | Nama pengarang |
| `biografi` | `TEXT` | Biografi singkat pengarang |

---

#### 2. `buku`
Menyimpan data koleksi buku perpustakaan.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_buku` | `INT` | Primary Key, Auto Increment |
| `isbn` | `VARCHAR(20)` | Unique — kode ISBN buku |
| `judul` | `VARCHAR(200)` | Judul buku |
| `tahun_terbit` | `YEAR(4)` | Tahun terbit |
| `penerbit` | `VARCHAR(100)` | Nama penerbit |
| `stok` | `INT` | Jumlah stok tersedia, default `0` |
| `id_pengarang` | `INT` | FK → `pengarang.id_pengarang` (ON UPDATE CASCADE) |

---

#### 3. `kategori`
Menyimpan kategori/genre buku.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_kategori` | `INT` | Primary Key, Auto Increment |
| `nama_kategori` | `VARCHAR(80)` | Nama kategori |
| `deskripsi` | `TEXT` | Deskripsi kategori |

Kategori yang tersedia: **Drama**, **Romance**, **Fantasy**, **Sci-Fi**, **Adventure**, **Cartoon**.

---

#### 4. `buku_kategori`
Tabel junction (many-to-many) antara `buku` dan `kategori`. Satu buku dapat memiliki lebih dari satu kategori.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_buku` | `INT` | PK + FK → `buku.id_buku` (ON DELETE CASCADE) |
| `id_kategori` | `INT` | PK + FK → `kategori.id_kategori` (ON DELETE CASCADE) |

---

#### 5. `anggota`
Menyimpan data anggota/member perpustakaan.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_anggota` | `INT` | Primary Key, Auto Increment |
| `nama` | `VARCHAR(100)` | Nama lengkap anggota |
| `alamat` | `TEXT` | Alamat tempat tinggal |
| `no_telepon` | `VARCHAR(20)` | Nomor telepon |
| `email` | `VARCHAR(100)` | Unique — alamat email |
| `tanggal_daftar` | `DATE` | Default `curdate()` |

---

#### 6. `pustakawan`
Menyimpan data petugas/staf perpustakaan yang berwenang memproses transaksi.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_petugas` | `INT` | Primary Key, Auto Increment |
| `nama` | `VARCHAR(100)` | Nama petugas |
| `username` | `VARCHAR(50)` | Unique — username login |
| `password_hash` | `VARCHAR(255)` | Password dalam bentuk hash |

---

#### 7. `peminjaman`
Menyimpan transaksi peminjaman buku oleh anggota.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_peminjaman` | `INT` | Primary Key, Auto Increment |
| `id_anggota` | `INT` | FK → `anggota.id_anggota` |
| `id_buku` | `INT` | FK → `buku.id_buku` |
| `id_petugas` | `INT` | FK → `pustakawan.id_petugas` |
| `tgl_pinjam` | `DATE` | Default `curdate()` |
| `tgl_kembali_rencana` | `DATE` | Tanggal jatuh tempo pengembalian |
| `tgl_kembali_aktual` | `DATE` | Tanggal aktual buku dikembalikan (nullable) |
| `status` | `ENUM` | `'dipinjam'` / `'dikembalikan'` / `'terlambat'`, default `'dipinjam'` |

---

#### 8. `denda`
Menyimpan data denda akibat keterlambatan pengembalian buku.

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_denda` | `INT` | Primary Key, Auto Increment |
| `id_peminjaman` | `INT` | Unique + FK → `peminjaman.id_peminjaman` (ON DELETE CASCADE) |
| `jumlah_denda` | `DECIMAL(10,2)` | Nominal denda, default `0.00` |
| `tgl_bayar` | `DATE` | Tanggal pelunasan denda (nullable) |
| `status_bayar` | `ENUM` | `'belum_bayar'` / `'lunas'`, default `'belum_bayar'` |

---

#### 9. `riwayat_aktivitas`
Tabel audit trail yang merekam seluruh aktivitas penting dalam sistem secara otomatis (via trigger).

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_aktivitas` | `BIGINT` | Primary Key, Auto Increment |
| `id_anggota` | `INT` | FK → `anggota.id_anggota` (ON DELETE SET NULL), nullable |
| `tipe_aksi` | `ENUM` | Jenis aktivitas (lihat nilai di bawah) |
| `detail` | `TEXT` | Keterangan detail aktivitas |
| `timestamp` | `DATETIME` | Default `current_timestamp()` |

Nilai `tipe_aksi` yang didukung: `login`, `pinjam`, `kembali`, `bayar_denda`, `daftar`, `hapus_anggota`, `tambah_buku`, `hapus_buku`.

---

## Triggers

Database menggunakan **4 trigger** untuk otomatisasi pencatatan aktivitas ke tabel `riwayat_aktivitas`:

| Nama Trigger | Tabel | Event | Keterangan |
|---|---|---|---|
| `trg_setelah_insert_anggota` | `anggota` | `AFTER INSERT` | Mencatat pendaftaran anggota baru |
| `trg_sebelum_delete_anggota` | `anggota` | `BEFORE DELETE` | Mencatat penghapusan data anggota |
| `trg_setelah_insert_buku` | `buku` | `AFTER INSERT` | Mencatat penambahan buku baru beserta ISBN |
| `trg_sebelum_delete_buku` | `buku` | `BEFORE DELETE` | Mencatat penghapusan buku dari koleksi |

---

## Data Dummy

Database disertai data dummy untuk keperluan pengujian:

| Tabel | Jumlah Data |
|-------|-------------|
| `pengarang` | 33 pengarang (Indonesia & internasional) |
| `buku` | 60 judul buku |
| `kategori` | 6 kategori |
| `buku_kategori` | 83 pasangan relasi buku–kategori |
| `anggota` | 2 anggota |
| `pustakawan` | 5 petugas |
| `peminjaman` | 0 (siap diisi) |
| `denda` | 0 (siap diisi) |
| `riwayat_aktivitas` | 0 (diisi otomatis oleh trigger) |

Koleksi buku mencakup karya dari penulis Indonesia ternama (Tere Liye, Dee Lestari, Andrea Hirata, Pidi Baiq, dll.) hingga manga Jepang populer (Doraemon, Naruto, One Piece, Attack on Titan, dll.) dan fiksi ilmiah internasional (Dune, Ender's Game, 2001: A Space Odyssey).

---

## Cara Menggunakan

### Import ke MySQL/phpMyAdmin

**Via phpMyAdmin:**
1. Buka phpMyAdmin, buat database baru bernama `library_kel9`
2. Pilih tab **Import**, unggah file `library_kel9.sql`
3. Klik **Go**

**Via command line:**
```bash
mysql -u root -p < library_kel9.sql
```

### Contoh Query

```sql
-- Daftar semua buku beserta nama pengarang dan kategorinya
SELECT b.judul, p.nama AS pengarang, GROUP_CONCAT(k.nama_kategori) AS kategori
FROM buku b
JOIN pengarang p ON b.id_pengarang = p.id_pengarang
JOIN buku_kategori bk ON b.id_buku = bk.id_buku
JOIN kategori k ON bk.id_kategori = k.id_kategori
GROUP BY b.id_buku;

-- Cek stok buku yang tersedia (stok > 0)
SELECT judul, penerbit, stok FROM buku WHERE stok > 0 ORDER BY stok DESC;

-- Lihat riwayat aktivitas terbaru
SELECT * FROM riwayat_aktivitas ORDER BY timestamp DESC LIMIT 10;
```

---

> *Database ini dibuat sebagai bagian dari Final Project mata kuliah Sistem Basis Data, Semester Genap 2025/2026.*
