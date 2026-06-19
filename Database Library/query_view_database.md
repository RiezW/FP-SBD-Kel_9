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

---

## 📥 Cara Input Data (INSERT / CREATE)

### 1. MySQL (Input ke Semua Tabel)

Berikut adalah contoh syntax SQL `INSERT` untuk memasukkan data baru ke dalam setiap tabel di MySQL:

#### a. Tabel `pengarang`
```sql
INSERT INTO pengarang (nama, biografi) 
VALUES ('Pramoedya Ananta Toer', 'Salah satu sastrawan besar Indonesia yang menulis Bumi Manusia.');
```

#### b. Tabel `kategori`
```sql
INSERT INTO kategori (nama_kategori, deskripsi) 
VALUES ('Mystery', 'Kisah fiksi yang berfokus pada penyelidikan suatu kejahatan atau teka-teki.');
```

#### c. Tabel `buku`
```sql
INSERT INTO buku (isbn, judul, tahun_terbit, penerbit, stok, id_pengarang) 
VALUES ('9789799731234', 'Bumi Manusia', 1980, 'Lentera Dipantara', 10, 1);
```
*(Catatan: pastikan `id_pengarang` bernilai sesuai dengan ID pengarang yang ada di tabel `pengarang`)*

#### d. Tabel `buku_kategori` (Relasi Many-to-Many)
```sql
INSERT INTO buku_kategori (id_buku, id_kategori) 
VALUES (1, 1);
```
*(Catatan: pastikan `id_buku` dan `id_kategori` yang di-input sudah terdaftar di tabel masing-masing)*

#### e. Tabel `anggota`
```sql
INSERT INTO anggota (nama, alamat, no_telepon, email, tanggal_daftar, status) 
VALUES ('Budi Santoso', 'Surabaya', '081234567890', 'budi.santoso@email.com', CURDATE(), 'aktif');
```

#### f. Tabel `pustakawan`
```sql
INSERT INTO pustakawan (nama, username, password_hash) 
VALUES ('Marcus Rashford', 'm.rashford10', 'hashedpassword123456');
```

#### g. Tabel `peminjaman`
```sql
INSERT INTO peminjaman (id_anggota, id_buku, id_petugas, tgl_pinjam, tgl_kembali_rencana, status) 
VALUES (1, 1, 1, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'dipinjam');
```

#### h. Tabel `denda`
```sql
INSERT INTO denda (id_peminjaman, jumlah_denda, tgl_bayar, status_bayar) 
VALUES (1, 2000.00, NULL, 'belum_bayar');
```
*(Catatan: pastikan `id_peminjaman` sesuai dengan id transaksi peminjaman yang aktif)*

#### i. Tabel `riwayat_aktivitas` (Opsional/Manual)
*Sebenarnya diisi otomatis oleh trigger, namun jika ingin di-input manual:*
```sql
INSERT INTO riwayat_aktivitas (id_anggota, tipe_aksi, detail, timestamp) 
VALUES (1, 'login', 'Anggota melakukan login ke sistem', NOW());
```

---

### 2. MongoDB (Input ke Koleksi Ulasan)

MongoDB menggunakan konsep dokumen (JSON/BSON). Berikut adalah perintah untuk memasukkan ulasan baru ke koleksi `ulasan`:

```javascript
db.ulasan.insertOne({
  id_anggota: "1",
  nama_anggota: "Muhamad Nasrulhaq",
  id_buku: "1",
  judul_buku: "Hujan",
  rating: 5,
  teks_ulasan: "Sangat direkomendasikan untuk dibaca berulang kali!",
  tgl_ulasan: new Date().toISOString(),
  tag: ["rekomendasi", "fiksi", "terbaik"]
})
```

Atau untuk memasukkan beberapa data sekaligus (`insertMany`):

```javascript
db.ulasan.insertMany([
  {
    id_anggota: "2",
    nama_anggota: "Riezco Eka Bayu Witantra",
    id_buku: "21",
    judul_buku: "Bumi",
    rating: 4,
    teks_ulasan: "Petualangan fantastis di dunia paralel.",
    tgl_ulasan: new Date().toISOString(),
    tag: ["fantasy", "adventure"]
  },
  {
    id_anggota: "3",
    nama_anggota: "Daffa Ulhaq Fadhlurrahman",
    id_buku: "11",
    judul_buku: "Dilan 1990",
    rating: 5,
    teks_ulasan: "Suka sekali dengan gombalan Dilan.",
    tgl_ulasan: new Date().toISOString(),
    tag: ["romance", "populer"]
  }
])
```
