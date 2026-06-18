# 🗄️ Panduan Query Demo Database (MySQL & MongoDB)

## MySQL

### Lihat semua anggota
```sql
SELECT * FROM anggota;
```

### Lihat semua buku
```sql
SELECT * FROM buku;
```

### Lihat semua peminjaman
```sql
SELECT * FROM peminjaman;
```

### Lihat semua denda
```sql
SELECT * FROM denda;
```

---

## 🔗 Query JOIN Terlengkap (Paling Disukai Dosen/Aslab)

### 1. Peminjaman + Anggota + Buku (Wajib)
*Menunjukkan relasi Peminjaman $\leftrightarrow$ Anggota $\leftrightarrow$ Buku:*
```sql
SELECT
    p.id_peminjaman,
    a.nama AS anggota,
    b.judul AS buku,
    p.tgl_pinjam,
    p.tgl_kembali_rencana,
    p.status
FROM peminjaman p
JOIN anggota a
    ON p.id_anggota = a.id_anggota
JOIN buku b
    ON p.id_buku = b.id_buku;
```

### 2. Peminjaman + Denda
*Menunjukkan relasi Peminjaman $\leftrightarrow$ Denda menggunakan FK `denda.id_peminjaman`:*
```sql
SELECT
    p.id_peminjaman,
    p.status,
    d.jumlah_denda,
    d.status_bayar
FROM peminjaman p
LEFT JOIN denda d
    ON p.id_peminjaman = d.id_peminjaman;
```

### 3. Anggota yang Memiliki Denda
*Menampilkan Nama Anggota, Buku, Jumlah Denda, dan Status Pembayaran:*
```sql
SELECT
    a.nama AS nama_anggota,
    b.judul AS buku,
    d.jumlah_denda,
    d.status_bayar
FROM denda d
JOIN peminjaman p
    ON d.id_peminjaman = p.id_peminjaman
JOIN anggota a
    ON p.id_anggota = a.id_anggota
JOIN buku b
    ON p.id_buku = b.id_buku;
```

### 4. Buku + Pengarang
*Menunjukkan relasi Buku $\leftrightarrow$ Pengarang menggunakan FK `id_pengarang`:*
```sql
SELECT
    b.judul,
    p.nama AS nama_pengarang
FROM buku b
JOIN pengarang p
    ON b.id_pengarang = p.id_pengarang;
```

### 5. Buku + Kategori (Relasi Many-to-Many)
*Menunjukkan relasi Many-to-Many melalui tabel pivot/penghubung `buku_kategori`. Ini sangat bagus untuk membuktikan normalisasi database:*
```sql
SELECT
    b.judul,
    k.nama_kategori
FROM buku b
JOIN buku_kategori bk
    ON b.id_buku = bk.id_buku
JOIN kategori k
    ON bk.id_kategori = k.id_kategori;
```

### 6. Semua Relasi Sekaligus (Flexing Query 😆)
*Menggabungkan seluruh tabel relasional utama dalam satu query tunggal:*
```sql
SELECT
    a.nama AS nama_anggota,
    b.judul AS judul_buku,
    pg.nama AS nama_pengarang,
    k.nama_kategori,
    p.tgl_pinjam,
    p.status
FROM peminjaman p
JOIN anggota a
    ON p.id_anggota = a.id_anggota
JOIN buku b
    ON p.id_buku = b.id_buku
JOIN pengarang pg
    ON b.id_pengarang = pg.id_pengarang
JOIN buku_kategori bk
    ON b.id_buku = bk.id_buku
JOIN kategori k
    ON bk.id_kategori = k.id_kategori;
```

---

## 🍃 MongoDB

### Masuk ke database:
```javascript
use library_kel9
```

### Lihat semua ulasan
```javascript
db.ulasan.find()
```

### Lebih rapi
```javascript
db.ulasan.find().pretty()
```

### Tampilkan hanya rating dan judul
```javascript
db.ulasan.find(
    {},
    {
        judul_buku: 1,
        rating: 1
    }
)
```

### Cari ulasan buku tertentu
*Misalnya buku Hujan:*
```javascript
db.ulasan.find({
    judul_buku: "Hujan"
})
```

### Cari rating 5
```javascript
db.ulasan.find({
    rating: 5
})
```

### Hitung jumlah ulasan
```javascript
db.ulasan.countDocuments()
```

---

## Kalau Dosen/Aslab Tanya "Mana bukti data dari backend masuk ke database?"

*Urutan demo yang bagus:*

### 1. MySQL (Relational DB)
1. Buka API client (seperti **Thunder Client** / Postman).
2. Kirim request **POST `/anggota`** untuk membuat anggota baru.
3. Buka **phpMyAdmin** atau CLI MySQL, jalankan:
   ```sql
   SELECT * FROM anggota;
   ```
4. Tunjukkan anggota baru yang di-input dari API client tadi sudah berhasil masuk ke tabel MySQL.

### 2. MongoDB (NoSQL DB)
1. Buka API client (seperti **Thunder Client** / Postman).
2. Kirim request **POST `/ulasan`** untuk membuat ulasan baru.
3. Buka **MongoDB Compass** atau **Mongo Shell (`mongosh`)**, jalankan:
   ```javascript
   db.ulasan.find().pretty()
   ```
4. Tunjukkan dokumen ulasan baru beserta tag/rating yang di-input dari API client tadi sudah berhasil tersimpan di koleksi MongoDB.
