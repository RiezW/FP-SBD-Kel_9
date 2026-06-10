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

Database berikut disertai data dummy untuk keperluan pengujian:

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

  **a. Via phpMyAdmin:**
  1. Buka phpMyAdmin, buat database baru bernama `library_kel9`
  2. Pilih tab **Import**, unggah file `library_kel9.sql`
  3. Klik **Go**

  **b. Via command line:**
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

Yang baru di file tambahan_library_kel9.sql:
[1] sp_pinjam_buku — 4 parameter: id_anggota, id_buku, id_petugas, durasi_hari. Validasi bertingkat: stok tersedia → anggota aktif → tidak ada denda belum bayar → baru INSERT + kurangi stok.
[2] trg_setelah_insert_peminjaman — auto-log ke riwayat_aktivitas dengan tipe_aksi = 'pinjam' setiap ada peminjaman baru.
[3] trg_setelah_update_peminjaman — auto-log tipe_aksi = 'kembali' ketika status berubah jadi 'dikembalikan' (cek OLD.status != NEW.status supaya tidak double log).
[4] Dummy data peminjaman — 20 baris, 4 skenario:
SkenarioIDKeteranganA — tepat waktu1–6Dikembalikan sebelum/tepat jatuh tempoB — terlambat7–12Dikembalikan terlambat, ada dendaC — aktif normal13–16Masih dipinjam, belum jatuh tempoD — terlambat aktif17–20Masih dipinjam, sudah lewat jatuh tempo
[5] Dummy data denda — 6 baris dari skenario B, tarif Rp 2.000/hari. 3 sudah lunas, 3 masih belum_bayar — bagus untuk demo view dan rekap.

---

> *Database ini dibuat sebagai bagian dari Final Project mata kuliah Sistem Basis Data, Semester Genap 2025/2026.*

-- ================================================================
-- FILE TAMBAHAN: library_kel9
-- Berisi: sp_pinjam_buku, trigger peminjaman/pengembalian,
--          dummy data peminjaman & denda
-- ================================================================

-- ----------------------------------------------------------------
-- [1] STORED PROCEDURE: sp_pinjam_buku
-- ----------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pinjam_buku` (
    IN `p_id_anggota`  INT,
    IN `p_id_buku`     INT,
    IN `p_id_petugas`  INT,
    IN `p_durasi_hari` INT   -- misal: 7 atau 14
)
BEGIN
    DECLARE v_stok         INT DEFAULT 0;
    DECLARE v_status       VARCHAR(20);
    DECLARE v_aktif        VARCHAR(20);
    DECLARE v_tgl_kembali  DATE;

    -- Cek stok buku
    SELECT `stok` INTO v_stok
    FROM `buku`
    WHERE `id_buku` = p_id_buku;

    IF v_stok IS NULL THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Buku tidak ditemukan!';
    ELSEIF v_stok = 0 THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Stok buku habis, tidak bisa dipinjam!';
    ELSE
        -- Cek status anggota
        SELECT `status` INTO v_aktif
        FROM `anggota`
        WHERE `id_anggota` = p_id_anggota;

        IF v_aktif IS NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Anggota tidak ditemukan!';
        ELSEIF v_aktif != 'aktif' THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Anggota non-aktif tidak dapat meminjam buku!';
        ELSE
            -- Cek apakah anggota masih punya denda belum bayar
            IF EXISTS (
                SELECT 1
                FROM `denda` d
                JOIN `peminjaman` p ON d.`id_peminjaman` = p.`id_peminjaman`
                WHERE p.`id_anggota` = p_id_anggota
                  AND d.`status_bayar` = 'belum_bayar'
            ) THEN
                SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Anggota masih memiliki denda yang belum dibayar!';
            ELSE
                SET v_tgl_kembali = DATE_ADD(CURDATE(), INTERVAL p_durasi_hari DAY);

                -- Insert record peminjaman
                INSERT INTO `peminjaman`
                    (`id_anggota`, `id_buku`, `id_petugas`, `tgl_pinjam`,
                     `tgl_kembali_rencana`, `status`)
                VALUES
                    (p_id_anggota, p_id_buku, p_id_petugas, CURDATE(),
                     v_tgl_kembali, 'dipinjam');

                -- Kurangi stok
                UPDATE `buku`
                SET `stok` = `stok` - 1
                WHERE `id_buku` = p_id_buku;
            END IF;
        END IF;
    END IF;
END$$

DELIMITER ;


-- ----------------------------------------------------------------
-- [2] TRIGGER: log peminjaman ke riwayat_aktivitas
-- ----------------------------------------------------------------
DELIMITER $$

CREATE TRIGGER `trg_setelah_insert_peminjaman`
AFTER INSERT ON `peminjaman`
FOR EACH ROW
BEGIN
    INSERT INTO `riwayat_aktivitas` (`id_anggota`, `tipe_aksi`, `detail`)
    VALUES (
        NEW.id_anggota,
        'pinjam',
        CONCAT(
            'Buku ID ', NEW.id_buku,
            ' dipinjam oleh anggota ID ', NEW.id_anggota,
            ' (peminjaman ID: ', NEW.id_peminjaman,
            ', tgl kembali rencana: ', NEW.tgl_kembali_rencana, ')'
        )
    );
END$$

DELIMITER ;


-- ----------------------------------------------------------------
-- [3] TRIGGER: log pengembalian ke riwayat_aktivitas
-- ----------------------------------------------------------------
DELIMITER $$

CREATE TRIGGER `trg_setelah_update_peminjaman`
AFTER UPDATE ON `peminjaman`
FOR EACH ROW
BEGIN
    -- Hanya log ketika status berubah ke 'dikembalikan'
    IF NEW.status = 'dikembalikan' AND OLD.status != 'dikembalikan' THEN
        INSERT INTO `riwayat_aktivitas` (`id_anggota`, `tipe_aksi`, `detail`)
        VALUES (
            NEW.id_anggota,
            'kembali',
            CONCAT(
                'Buku ID ', NEW.id_buku,
                ' dikembalikan oleh anggota ID ', NEW.id_anggota,
                ' (peminjaman ID: ', NEW.id_peminjaman,
                ', tgl kembali aktual: ', NEW.tgl_kembali_aktual, ')'
            )
        );
    END IF;
END$$

DELIMITER ;


-- ================================================================
-- [4] DUMMY DATA: tabel peminjaman
--
-- Skenario peminjaman:
--   A  = tepat waktu (sudah dikembalikan)
--   B  = terlambat   (sudah dikembalikan, ada denda)
--   C  = masih dipinjam, belum jatuh tempo
--   D  = masih dipinjam, sudah melewati jatuh tempo (terlambat)
--
-- id_anggota 1-4, id_buku 1-60, id_petugas 1-5
-- ================================================================

-- Nonaktifkan trigger sementara agar log riwayat tidak menumpuk
-- saat insert dummy; hapus 2 baris SET berikut jika ingin log ikut masuk
SET @OLD_SQL_SAFE_UPDATES = @@SQL_SAFE_UPDATES;
SET SQL_SAFE_UPDATES = 0;

INSERT INTO `peminjaman`
    (`id_peminjaman`, `id_anggota`, `id_buku`, `id_petugas`,
     `tgl_pinjam`, `tgl_kembali_rencana`, `tgl_kembali_aktual`, `status`)
VALUES

-- ── Skenario A: dikembalikan tepat waktu ──────────────────────────
(1,  1, 1,  1, '2026-05-01', '2026-05-08', '2026-05-07', 'dikembalikan'),
(2,  2, 5,  2, '2026-05-03', '2026-05-10', '2026-05-09', 'dikembalikan'),
(3,  3, 11, 3, '2026-05-05', '2026-05-12', '2026-05-12', 'dikembalikan'),
(4,  4, 41, 4, '2026-05-06', '2026-05-13', '2026-05-13', 'dikembalikan'),
(5,  1, 21, 5, '2026-05-10', '2026-05-17', '2026-05-16', 'dikembalikan'),
(6,  2, 52, 1, '2026-05-12', '2026-05-19', '2026-05-18', 'dikembalikan'),

-- ── Skenario B: dikembalikan terlambat (ada denda) ────────────────
(7,  3, 2,  2, '2026-05-01', '2026-05-08', '2026-05-12', 'dikembalikan'),  -- 4 hari telat
(8,  4, 6,  3, '2026-05-04', '2026-05-11', '2026-05-18', 'dikembalikan'),  -- 7 hari telat
(9,  1, 14, 4, '2026-05-07', '2026-05-14', '2026-05-17', 'dikembalikan'),  -- 3 hari telat
(10, 2, 37, 5, '2026-05-10', '2026-05-17', '2026-05-25', 'dikembalikan'),  -- 8 hari telat
(11, 3, 54, 1, '2026-05-13', '2026-05-20', '2026-05-24', 'dikembalikan'),  -- 4 hari telat
(12, 4, 40, 2, '2026-05-15', '2026-05-22', '2026-05-29', 'dikembalikan'),  -- 7 hari telat

-- ── Skenario C: masih dipinjam, belum jatuh tempo ────────────────
(13, 1, 4,  3, '2026-06-05', '2026-06-19', NULL, 'dipinjam'),
(14, 2, 22, 4, '2026-06-06', '2026-06-20', NULL, 'dipinjam'),
(15, 3, 58, 5, '2026-06-07', '2026-06-21', NULL, 'dipinjam'),
(16, 4, 15, 1, '2026-06-08', '2026-06-22', NULL, 'dipinjam'),

-- ── Skenario D: masih dipinjam, sudah melewati jatuh tempo ───────
(17, 1, 50, 2, '2026-05-20', '2026-05-27', NULL, 'terlambat'),  -- ~15 hari telat per 11 Jun
(18, 2, 46, 3, '2026-05-22', '2026-05-29', NULL, 'terlambat'),  -- ~13 hari telat
(19, 3, 9,  4, '2026-05-25', '2026-06-01', NULL, 'terlambat'),  -- ~10 hari telat
(20, 4, 30, 5, '2026-05-28', '2026-06-04', NULL, 'terlambat');  --  ~7 hari telat


-- ================================================================
-- [5] DUMMY DATA: tabel denda
--
-- Tarif: Rp 2.000 / hari keterlambatan (sesuai sp_kembali_buku)
-- Hanya untuk peminjaman yang dikembalikan terlambat (Skenario B)
-- Sebagian sudah lunas, sebagian belum
-- ================================================================

INSERT INTO `denda`
    (`id_denda`, `id_peminjaman`, `jumlah_denda`, `tgl_bayar`, `status_bayar`)
VALUES
--  pmj_id=7  : 4 hari × 2000 = 8.000
(1,  7,  8000.00, '2026-05-13', 'lunas'),

--  pmj_id=8  : 7 hari × 2000 = 14.000
(2,  8,  14000.00, NULL, 'belum_bayar'),

--  pmj_id=9  : 3 hari × 2000 = 6.000
(3,  9,  6000.00, '2026-05-18', 'lunas'),

--  pmj_id=10 : 8 hari × 2000 = 16.000
(4,  10, 16000.00, NULL, 'belum_bayar'),

--  pmj_id=11 : 4 hari × 2000 = 8.000
(5,  11, 8000.00, '2026-05-25', 'lunas'),

--  pmj_id=12 : 7 hari × 2000 = 14.000
(6,  12, 14000.00, NULL, 'belum_bayar');


-- Kembalikan safe updates
SET SQL_SAFE_UPDATES = @OLD_SQL_SAFE_UPDATES;

-- ================================================================
-- Catatan:
--  - AUTO_INCREMENT peminjaman dilanjutkan dari 21
--  - AUTO_INCREMENT denda dilanjutkan dari 7
-- ================================================================

ALTER TABLE `peminjaman` MODIFY `id_peminjaman` INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
ALTER TABLE `denda`      MODIFY `id_denda`      INT NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
