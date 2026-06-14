# 📚 Library Management System — `library_kel9`

> **Final Project — Sistem Basis Data (SBD)**
> Kelompok 9 | Departemen Teknologi Informasi, FTEIC — ITS Surabaya

---

## Daftar Isi

- [📚 Library Management System — `library_kel9`](#-library-management-system--library_kel9)
  - [Daftar Isi](#daftar-isi)
  - [Deskripsi Proyek](#deskripsi-proyek)
  - [Anggota Kelompok](#anggota-kelompok)
  - [Teknologi](#teknologi)
  - [Struktur Database](#struktur-database)
    - [Deskripsi Tabel](#deskripsi-tabel)
      - [1. `pengarang`](#1-pengarang)
      - [2. `buku`](#2-buku)
      - [3. `kategori`](#3-kategori)
      - [4. `buku_kategori`](#4-buku_kategori)
      - [5. `anggota`](#5-anggota)
      - [6. `pustakawan`](#6-pustakawan)
      - [7. `peminjaman`](#7-peminjaman)
      - [8. `denda`](#8-denda)
      - [9. `riwayat_aktivitas`](#9-riwayat_aktivitas)
  - [Triggers](#triggers)
  - [Data Dummy](#data-dummy)
  - [Cara Menggunakan](#cara-menggunakan)
    - [Import ke MySQL/phpMyAdmin](#import-ke-mysqlphpmyadmin)
    - [Contoh Query](#contoh-query)

---

## Deskripsi Proyek

`library_kel9` adalah database sistem manajemen perpustakaan yang dirancang untuk mengelola seluruh operasional perpustakaan secara digital. Sistem ini mencakup manajemen koleksi buku, data pengarang, kategori, keanggotaan, transaksi peminjaman, denda keterlambatan, serta audit trail seluruh aktivitas penting.

Database dibangun menggunakan **MySQL (MariaDB 10.4.32)** dan di-_export_ melalui **phpMyAdmin 5.2.1**.

---

## Anggota Kelompok

| No | Nama | NRP |
|----|-----|----|
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

Database `library_kel9` terdiri dari **9 tabel** dengan relasi yang terdefinisi melalui _foreign key constraints_.

<img width="1600" height="925" alt="WhatsApp Image 2026-06-08 at 9 55 36 PM" src="https://github.com/user-attachments/assets/b6db0064-42ea-42e8-a9a6-5d8c82358ace" />

### Deskripsi Tabel

#### 1. `pengarang`
Menyimpan data penulis/pengarang buku.

```sql
CREATE TABLE `pengarang` (
  `id_pengarang` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `biografi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_pengarang` | `INT` | _Primary Key_, _Auto Increment_ |
| `nama` | `VARCHAR(100)` | Nama pengarang |
| `biografi` | `TEXT` | Biografi singkat pengarang |

```sql
INSERT INTO `pengarang` (`id_pengarang`, `nama`, `biografi`) VALUES
(1, 'Tere Liye', 'Penulis produktif Indonesia bernama asli Darwis, lahir 21 Mei 1979 di Lahat, Sumatera Selatan. Lulus dari Fakultas Ekonomi Universitas Indonesia, ia telah menghasilkan puluhan novel lintas genre — mulai dari drama, fantasi, hingga petualangan — dengan karya terkenal antara lain Hafalan Shalat Delisa, Hujan, Rindu, dan seri Bumi.'),
(2, 'Dee Lestari', 'Novelis dan penyanyi-penulis lagu Indonesia bernama lengkap Dewi Lestari Simangunsong, lahir 20 Januari 1976 di Bandung. Alumnus Universitas Parahyangan dan mantan anggota trio vokal Rida Sita Dewi, ia dikenal luas lewat seri Supernova (2001) dan novel Perahu Kertas, serta meraih berbagai penghargaan sastra bergengsi.'),
(3, 'Ahmad Fuadi', 'Penulis dan mantan jurnalis Indonesia kelahiran Bayur, Maninjau, Sumatera Barat, 30 Desember 1972. Karya debutnya, Negeri 5 Menara (2009), menjadi novel inspiratif best seller yang diadaptasi ke layar lebar pada 2012 dan membuka Trilogi Negeri 5 Menara.'),
(4, 'Andrea Hirata', 'Novelis Indonesia kelahiran Gantung, Belitung Timur, 24 Oktober 1967, yang dikenal lewat novel Laskar Pelangi (2005) — terjual lebih dari lima juta eksemplar dan diterjemahkan ke 34 bahasa. Lulusan Ekonomi Universitas Indonesia ini juga mendirikan Museum Kata di Belitung sebagai bentuk apresiasinya terhadap dunia sastra.'),
(5, 'Buya Hamka', 'Ulama, sastrawan, dan tokoh nasional Indonesia bernama asli Haji Abdul Malik Karim Amrullah, lahir 17 Februari 1908 di Agam, Sumatera Barat. Ketua MUI pertama (1975) ini dikenal lewat novel klasik Di Bawah Lindungan Ka\'bah dan Tenggelamnya Kapal Van der Wijck, serta karya monumental Tafsir Al-Azhar.'),
(6, 'Pidi Baiq', 'Penulis, ilustrator, musisi, dan dosen asal Bandung, lahir 8 Agustus 1972, merupakan lulusan FSRD Institut Teknologi Bandung. Ia dikenal luas lewat trilogi novel Dilan (2014–2016) yang diadaptasi ke layar lebar dan mencatatkan jutaan penonton, serta mendirikan grup band The Panas Dalam pada 1995.'),
(7, 'Erisca Febriani', 'Penulis muda Indonesia kelahiran Bandar Lampung, 25 Maret 1998, yang memulai karier menulis di Wattpad semasa SMA. Novel debutnya, Dear Nathan (2016), menjadi trending dan diadaptasi menjadi film laris, membuka trilogi Dear Nathan yang turut difilmkan.'),
(8, 'Ilana Tan', 'Novelis Indonesia yang dikenal sebagai penulis misterius — identitasnya tidak pernah dipublikasikan — dan terkenal lewat Tetralogi Empat Musim: Summer in Seoul, Autumn in Paris, Winter in Tokyo, dan Spring in London. Keempat novel romansanya menampilkan tokoh-tokoh yang saling berkaitan satu sama lain.'),
(9, 'Kang Abik', 'Novelis, dai, penyair, dan sutradara Indonesia bernama lengkap Habiburrahman El Shirazy, lahir 30 September 1976 di Semarang. Lulusan Universitas Al-Azhar Kairo ini dikenal sebagai penulis novel Islami best seller, dengan karya terkenal Ayat-Ayat Cinta (2004) dan Ketika Cinta Bertasbih, serta mendirikan Pesantren Basmala di Semarang.'),
(10, 'Sitta Karina', 'Novelis Indonesia yang aktif menulis sejak awal 2000-an di genre roman dan fantasi remaja, dikenal lewat seri Fairish dan Andai Itu Takdirnya. Ia termasuk pelopor penulis muda Indonesia yang populer di kalangan pembaca remaja pada era tersebut.'),
(11, 'Jostein Gaarder', 'Penulis asal Oslo, Norwegia, lahir 8 Agustus 1952, mantan guru filsafat yang meraih kepopuleran internasional lewat novel Dunia Sophie (1991) — diterjemahkan ke 60 bahasa dengan lebih dari 40 juta eksemplar terjual di seluruh dunia. Karya-karyanya kerap memadukan filsafat dengan narasi fiksi yang mudah dicerna.'),
(12, 'Merry Riana', 'Pengusaha, motivator, dan penulis Indonesia kelahiran Jakarta, 29 Mei 1980, yang meraih penghasilan satu juta dolar Singapura di usia 26 tahun setelah merantau ke Singapura pasca kerusuhan 1998. Kisah hidupnya dituangkan dalam buku biografi Mimpi Sejuta Dolar (2011) yang menjadi national best seller dan diadaptasi menjadi film pada 2014.'),
(13, 'Intan Paramaditha', 'Penulis, akademisi, dan sutradara Indonesia yang berkarya di ranah fiksi eksperimental dan sastra perjalanan. Ia dikenal lewat novel Pilihan Hotel Sinister (Apple and Knife, versi Inggris) dan Kisah Seorang Gembel yang Rajin Menabung, serta aktif sebagai dosen di Macquarie University, Australia.'),
(14, 'Arthur C. Clarke', 'Penulis fiksi ilmiah legendaris asal Inggris (Sri Lanka), lahir 16 Desember 1917, meninggal 19 Maret 2008, dikenal lewat 2001: A Space Odyssey dan konsep orbit geostasioner yang kini dikenal sebagai Orbit Clarke. Ia adalah salah satu dari \"Tiga Besar\" fiksi ilmiah dunia bersama Isaac Asimov dan Robert A. Heinlein.'),
(15, 'Orson Scott Card', 'Penulis fiksi ilmiah Amerika kelahiran 24 Agustus 1951, pemenang Hugo Award dan Nebula Award untuk novel Ender\'s Game (1985) — kisah jenius muda yang dilatih untuk menghadapi invasi alien. Selain fiksi ilmiah, ia juga aktif menulis fantasi dan drama.'),
(16, 'Michael Crichton', 'Penulis dan sutradara Amerika kelahiran 23 Oktober 1942, meninggal 4 November 2008, dikenal lewat novel thriller sains populer seperti Jurassic Park (1990) dan Sphere yang menggabungkan fiksi ilmiah dengan ketegangan plot. Jurassic Park diadaptasi menjadi waralaba film fenomenal oleh Steven Spielberg.'),
(17, 'Frank Herbert', 'Penulis fiksi ilmiah Amerika kelahiran 8 Oktober 1920, meninggal 11 Februari 1986, dikenal lewat epos Dune (1965) yang memenangkan Hugo Award dan Nebula Award serta dianggap sebagai salah satu novel fiksi ilmiah terbesar sepanjang masa. Dune menginspirasi generasi penulis fiksi ilmiah dan diadaptasi berkali-kali ke layar lebar.'),
(18, 'Budi Darma', 'Sastrawan senior Indonesia kelahiran Rembang, 25 April 1937, meninggal 21 Juni 2021, dikenal lewat novel Olenka (1983) yang mengangkat tema eksistensialisme dan dianggap sebagai salah satu karya prosa Indonesia terpenting. Ia juga merupakan guru besar Universitas Indiana, Amerika Serikat.'),
(19, 'Achdiat K. Mihardja', 'Sastrawan Indonesia Angkatan 45 kelahiran Garut, 6 Maret 1911, meninggal 8 Juli 2010, dikenal lewat novel Atheis (1949) yang mengangkat pergolakan batin antara keimanan dan pemikiran ateisme. Novel ini dianggap sebagai salah satu karya prosa Indonesia paling berpengaruh pada masanya.'),
(20, 'Ahmad Tohari', 'Penulis Indonesia kelahiran Banyumas, 13 Juni 1943, dikenal lewat Trilogi Ronggeng Dukuh Paruk yang mengisahkan kehidupan masyarakat pedesaan Jawa dan terpilih sebagai salah satu karya sastra terbaik Indonesia. Novel-novelnya juga telah diterjemahkan ke berbagai bahasa asing.'),
(21, 'Langit Kresna Hariadi', 'Penulis Indonesia spesialis novel sejarah dan budaya Jawa, dikenal lewat seri Gajah Mada yang terdiri dari delapan jilid dan mengisahkan perjalanan hidup Mahapatih Gajah Mada dari Majapahit. Karya-karyanya menjadi referensi populer tentang sejarah Nusantara.'),
(22, 'Motinggo Busye', 'Sastrawan dan dramawan Indonesia kelahiran Palembang, 21 November 1928, meninggal 17 Juli 1999, dikenal sebagai penulis novel dan naskah drama, termasuk naskah yang menginspirasi film komedi Naga Bonar (1987). Ia aktif di dunia sastra Indonesia sejak era 1950-an.'),
(23, 'Danarto', 'Cerpenis dan dramawan Indonesia Angkatan 70-an kelahiran Cirebon, 27 Juni 1940, meninggal 10 Maret 2018, dikenal lewat karya-karyanya yang bernuansa surealis dan mistis. Ia meraih Hadiah Sastra Nasional dan dianggap sebagai salah satu pelopor cerpen surealis Indonesia.'),
(24, 'Fujiko F. Fujio', 'Duo mangaka Jepang terdiri dari Hiroshi Fujimoto (1933–1996) dan Motoo Abiko (1934–2022) yang berkolaborasi di bawah nama Fujiko F. Fujio. Mereka menciptakan Doraemon (1969), manga tentang robot kucing dari masa depan yang menjadi salah satu karya manga paling ikonik dan dicintai di seluruh dunia.'),
(25, 'Masashi Kishimoto', 'Mangaka Jepang kelahiran 8 November 1974 di Okayama, dikenal sebagai pencipta seri Naruto (1999–2014) yang mengisahkan perjalanan ninja muda Naruto Uzumaki. Naruto menjadi salah satu manga terlaris sepanjang masa dengan lebih dari 250 juta kopi terjual di seluruh dunia.'),
(26, 'Eiichiro Oda', 'Mangaka Jepang kelahiran 1 Januari 1975 di Kumamoto, pencipta One Piece (1997–sekarang) yang menjadi seri manga terlaris sepanjang masa dengan lebih dari 530 juta kopi terjual di seluruh dunia. One Piece telah diadaptasi menjadi anime, film, dan serial live-action.'),
(27, 'Akira Toriyama', 'Mangaka Jepang legendaris kelahiran 5 April 1955, meninggal 1 Maret 2024, pencipta Dragon Ball (1984–1995) yang menjadi salah satu manga dan anime paling berpengaruh di dunia. Ia juga dikenal sebagai desainer karakter seri Dragon Quest dan menginspirasi generasi mangaka terkenal seperti Eiichiro Oda dan Masashi Kishimoto.'),
(28, 'Gosho Aoyama', 'Mangaka Jepang kelahiran 21 Juni 1963 di Hokkaido, pencipta seri Detektif Conan (Case Closed, 1994–sekarang) yang mengisahkan detektif remaja Shinichi Kudo yang tubuhnya mengecil akibat racun. Seri ini telah diadaptasi menjadi anime panjang, puluhan film, dan menjadi franchise manga terpopuler di Jepang.'),
(29, 'Yoshito Usui', 'Mangaka Jepang kelahiran 7 April 1958, meninggal 11 Agustus 2009, pencipta Crayon Shin-chan (1990–2009) yang mengisahkan tingkah lucu dan polos bocah lima tahun Shinnosuke Nohara. Manga ini sangat populer di seluruh Asia dan telah diadaptasi menjadi anime panjang serta puluhan film.'),
(30, 'Tite Kubo', 'Mangaka Jepang kelahiran 26 Juni 1977 di Hiroshima, pencipta seri Bleach (2001–2016) yang masuk dalam jajaran \"Big Three\" manga Shonen Jump bersama Naruto dan One Piece. Bleach mengisahkan perjalanan Ichigo Kurosaki sebagai Shinigami dan telah terjual lebih dari 120 juta kopi di seluruh dunia.'),
(31, 'Hajime Isayama', 'Mangaka Jepang kelahiran 29 Agustus 1986 di Ōita, pencipta Attack on Titan (Shingeki no Kyojin, 2009–2021) — manga distopia tentang umat manusia yang berjuang melawan titan raksasa. Seri ini menjadi fenomena global dan diadaptasi menjadi salah satu anime paling populer dan berpengaruh dalam sejarah.'),
(32, 'Koyoharu Gotouge', 'Mangaka Jepang kelahiran 25 Mei 1989, pencipta Demon Slayer (Kimetsu no Yaiba, 2016–2020) yang mengisahkan pembasmi iblis Tanjiro Kamado di era Taisho Jepang. Manga ini memecahkan berbagai rekor penjualan di Jepang dan seluruh dunia, dengan anime adaptasinya menjadi salah satu anime terlaris sepanjang masa.'),
(33, 'Kohei Horikoshi', 'Mangaka Jepang kelahiran 20 November 1986 di Shizuoka, pencipta My Hero Academia (Boku no Hero Academia, 2014–2024) yang mengisahkan dunia superhero di mana Izuku Midoriya berjuang menjadi pahlawan terhebat. Manga ini menjadi salah satu judul Shonen Jump terpopuler dan diadaptasi menjadi anime, film, serta berbagai merchandise global.');
```

---

#### 2. `buku`
Menyimpan data koleksi buku perpustakaan.

```sql
CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `judul` varchar(200) NOT NULL,
  `tahun_terbit` year(4) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `id_pengarang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_buku` | `INT` | _Primary Key_, _Auto Increment_ |
| `isbn` | `VARCHAR(20)` | _Unique_ — kode ISBN buku |
| `judul` | `VARCHAR(200)` | Judul buku |
| `tahun_terbit` | `YEAR(4)` | Tahun terbit |
| `penerbit` | `VARCHAR(100)` | Nama penerbit |
| `stok` | `INT` | Jumlah stok tersedia, default `0` |
| `id_pengarang` | `INT` | FK → `pengarang.id_pengarang` (ON UPDATE CASCADE) |

```sql
INSERT INTO `buku` (`id_buku`, `isbn`, `judul`, `tahun_terbit`, `penerbit`, `stok`, `id_pengarang`) VALUES
(1, '9786020324784', 'Hujan', '2016', 'Gramedia', 15, 1),
(2, '9789799103789', 'Perahu Kertas', '2009', 'Bentang', 8, 2),
(3, '9789793062792', 'Supernova: Petir', '2004', 'Bentang', 12, 2),
(4, '9789792210767', 'Negeri 5 Menara', '2009', 'Gramedia', 20, 3),
(5, '9789791227209', 'Sang Pemimpi', '2006', 'Bentang', 10, 4),
(6, '9789794180556', 'Tenggelamnya Kapal Van Der Wijck', '1938', 'Gema Insani', 6, 5),
(7, '9789792206814', 'Rindu', '2014', 'Republika', 18, 1),
(8, '9786020331607', 'Matahari', '2016', 'Gramedia', 14, 1),
(9, '9786022911029', 'Sirkus Pohon', '2017', 'Bentang', 9, 4),
(10, '9786020822341', 'Pulang', '2015', 'Republika', 11, 1),
(11, '9786020333175', 'Dilan 1990', '2014', 'Pastel Books', 25, 6),
(12, '9786027870413', 'Dilan 1991', '2015', 'Pastel Books', 22, 6),
(13, '9786027870864', 'Milea: Suara dari Dilan', '2016', 'Pastel Books', 20, 6),
(14, '9786020335278', 'Dear Nathan', '2016', 'Best Media', 30, 7),
(15, '9789792247916', 'Autumn in Paris', '2007', 'Gramedia', 17, 8),
(16, '9789792247923', 'Summer in Seoul', '2008', 'Gramedia', 15, 8),
(17, '9789792247930', 'Winter in Tokyo', '2008', 'Gramedia', 14, 8),
(18, '9789792247947', 'Spring in London', '2010', 'Gramedia', 12, 8),
(19, '9786020314129', 'Cinta Dalam Ikhlas', '2018', 'Republika', 19, 9),
(20, '9786020314136', 'Ketika Cinta Bertasbih', '2007', 'Republika', 16, 9),
(21, '9786020325118', 'Bumi', '2014', 'Gramedia', 20, 1),
(22, '9786020325125', 'Bulan', '2015', 'Gramedia', 18, 1),
(23, '9786020325132', 'Matahari', '2016', 'Gramedia', 15, 1),
(24, '9786020325149', 'Komet', '2018', 'Gramedia', 13, 1),
(25, '9786020325156', 'Ceros dan Batozar', '2018', 'Gramedia', 10, 1),
(26, '9786020325163', 'Nebula', '2019', 'Gramedia', 12, 1),
(27, '9786239726207', 'Nixie', '2020', 'Gramedia', 9, 1),
(28, '9786230000011', 'Si Anak Badai', '2020', 'Republika', 11, 1),
(29, '9789793062808', 'Lukisan Hujan', '2004', 'Terant Books', 7, 10),
(30, '9780099578075', 'Dunia Anna', '2013', 'Mizan', 8, 11),
(31, '9789792218008', 'Supernova: Ksatria, Puteri, dan Bintang Jatuh', '2001', 'Bentang', 10, 2),
(32, '9789793062785', 'Supernova: Akar', '2002', 'Bentang', 9, 2),
(33, '9789791227216', 'Supernova: Partikel', '2012', 'Bentang', 11, 2),
(34, '9786022911036', 'Supernova: Inteligensi Embun Pagi', '2014', 'Bentang', 8, 2),
(35, '9789792221114', 'Mimpi Sejuta Dolar', '2011', 'Gramedia', 14, 12),
(36, '9789792247954', 'Alien di Ladang Jagung', '2007', 'Gramedia', 6, 13),
(37, '9780451457998', '2001: A Space Odyssey', '1968', 'Mizan', 5, 14),
(38, '9780812550702', 'Enders Game', '1985', 'Mizan', 7, 15),
(39, '9780345538987', 'Sphere', '1987', 'Gramedia', 4, 16),
(40, '9780441172719', 'Dune', '1965', 'Mizan', 6, 17),
(41, '9789793062778', 'Laskar Pelangi', '2005', 'Bentang', 22, 4),
(42, '9789793062815', 'Edensor', '2007', 'Bentang', 16, 4),
(43, '9789793062822', 'Maryamah Karpov', '2008', 'Bentang', 12, 4),
(44, '9789792210774', 'Olenka', '1983', 'Balai Pustaka', 5, 18),
(45, '9789796663583', 'Atheis', '1949', 'Balai Pustaka', 4, 19),
(46, '9789792206821', 'Trilogi Ronggeng Dukuh Paruk', '1982', 'Gramedia', 8, 20),
(47, '9789797091231', 'Gajah Mada', '2004', 'Tiga Serangkai', 10, 21),
(48, '9789792221121', 'Naga Bonar', '1986', 'Gramedia', 6, 22),
(49, '9789794180563', 'Kalimat Terakhir', '1991', 'Pustaka Bahasa', 3, 23),
(50, '9789794180570', 'Di Bawah Lindungan Kabah', '1938', 'Gema Insani', 7, 5),
(51, '9781569319000', 'Doraemon Vol.1', '1989', 'Elex Media', 40, 24),
(52, '9781569319017', 'Naruto Vol.1', '1999', 'Elex Media', 35, 25),
(53, '9781569319024', 'One Piece Vol.1', '1997', 'Elex Media', 38, 26),
(54, '9781569319031', 'Dragon Ball Vol.1', '1984', 'Elex Media', 30, 27),
(55, '9781569319048', 'Detective Conan Vol.1', '1994', 'Elex Media', 28, 28),
(56, '9781569319055', 'Shinchan Vol.1', '1990', 'Elex Media', 25, 29),
(57, '9781569319062', 'Bleach Vol.1', '2001', 'Elex Media', 20, 30),
(58, '9781569319079', 'Attack on Titan Vol.1', '2009', 'Elex Media', 22, 31),
(59, '9781569319086', 'Demon Slayer Vol.1', '2016', 'Elex Media', 26, 32),
(60, '9781569319093', 'My Hero Academia Vol.1', '2014', 'Elex Media', 24, 33);
```

```sql
DELIMITER $$
CREATE TRIGGER `trg_sebelum_delete_buku` BEFORE DELETE ON `buku` FOR EACH ROW BEGIN
    INSERT INTO `riwayat_aktivitas` (`id_anggota`, `tipe_aksi`, `detail`)
    VALUES (NULL, 'hapus_buku', CONCAT('Buku dihapus: ', OLD.judul, ' (ID Buku: ', OLD.id_buku, ')'));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_setelah_insert_buku` AFTER INSERT ON `buku` FOR EACH ROW BEGIN
    INSERT INTO `riwayat_aktivitas` (`id_anggota`, `tipe_aksi`, `detail`)
    VALUES (NULL, 'tambah_buku', CONCAT('Buku baru ditambahkan: ', NEW.judul, ' (ISBN: ', IFNULL(NEW.isbn, '-'), ')'));
END
$$
DELIMITER ;
```

---

#### 3. `kategori`
Menyimpan kategori/genre buku.

```sql
CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(80) NOT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_kategori` | `INT` | _Primary Key_, _Auto Increment_ |
| `nama_kategori` | `VARCHAR(80)` | Nama kategori |
| `deskripsi` | `TEXT` | Deskripsi kategori |

Kategori yang tersedia: **Drama**, **Romance**, **Fantasy**, **Sci-Fi**, **Adventure**, **Cartoon**.

```sql
INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `deskripsi`) VALUES
(1, 'Drama', 'Karya yang berfokus pada konflik emosional dan hubungan antar karakter, seringkali mengandung unsur kehidupan nyata yang mengharukan.'),
(2, 'Romance', 'Kisah percintaan yang mengeksplorasi hubungan romantis antar tokoh, biasanya berakhir dengan kebahagiaan atau pelajaran tentang cinta.'),
(3, 'Fantasy', 'Karya fiksi yang menampilkan dunia imajinatif dengan elemen magis, makhluk mitologis, dan hukum alam yang berbeda dari dunia nyata.'),
(4, 'Sci-Fi', 'Fiksi ilmiah yang mengeksplorasi dampak teknologi, sains, dan penemuan masa depan terhadap kehidupan manusia dan alam semesta.'),
(5, 'Adventure', 'Kisah penuh aksi dan penjelajahan di mana tokoh menghadapi berbagai tantangan dan bahaya dalam perjalanan menuju tujuannya.'),
(6, 'Cartoon', 'Karya bergambar atau animasi yang menyampaikan cerita secara visual, sering ditujukan untuk hiburan anak-anak maupun remaja.');
```
---

#### 4. `buku_kategori`
Tabel junction (many-to-many) antara `buku` dan `kategori`. Satu buku dapat memiliki lebih dari satu kategori.

```sql
CREATE TABLE `buku_kategori` (
  `id_buku` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_buku` | `INT` | PK + FK → `buku.id_buku` (ON DELETE CASCADE) |
| `id_kategori` | `INT` | PK + FK → `kategori.id_kategori` (ON DELETE CASCADE) |

```sql
INSERT INTO `buku_kategori` (`id_buku`, `id_kategori`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 2),
(12, 2),
(13, 2),
(14, 1),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 1),
(19, 2),
(20, 1),
(20, 2),
(21, 3),
(21, 4),
(22, 3),
(22, 4),
(23, 3),
(23, 4),
(24, 3),
(24, 4),
(25, 3),
(25, 4),
(26, 3),
(26, 4),
(27, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 4),
(32, 4),
(33, 4),
(34, 4),
(35, 4),
(36, 4),
(37, 4),
(37, 5),
(38, 4),
(38, 5),
(39, 4),
(40, 4),
(40, 5),
(41, 1),
(41, 5),
(42, 1),
(42, 5),
(43, 1),
(43, 5),
(44, 5),
(45, 5),
(46, 5),
(47, 5),
(48, 5),
(49, 5),
(50, 5),
(51, 4),
(51, 6),
(52, 6),
(53, 3),
(53, 6),
(54, 3),
(54, 6),
(55, 6),
(56, 6),
(57, 6),
(58, 5),
(58, 6),
(59, 5),
(59, 6),
(60, 5),
(60, 6);
```
---

#### 5. `anggota`
Menyimpan data anggota/member perpustakaan.

```sql
CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tanggal_daftar` date NOT NULL DEFAULT curdate(),
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_anggota` | `INT` | _Primary Key_, _Auto Increment_ |
| `nama` | `VARCHAR(100)` | Nama lengkap anggota |
| `alamat` | `TEXT` | Alamat tempat tinggal |
| `no_telepon` | `VARCHAR(20)` | Nomor telepon |
| `email` | `VARCHAR(100)` | _Unique_ — alamat email |
| `tanggal_daftar` | `DATE` | _Default_ `curdate()` |

```sql
INSERT INTO `anggota` (`id_anggota`, `nama`, `alamat`, `no_telepon`, `email`, `tanggal_daftar`, `status`) VALUES
(1, 'Muhamad Nasrulhaq', 'Mataram', NULL, NULL, '2026-06-08', 'aktif'),
(2, 'Riezco Eka Bayu Witantra', 'Sidoarjo', NULL, NULL, '2026-06-08', 'aktif'),
(3, 'Daffa Ulhaq Fadhlurrahman', 'Banda Aceh', NULL, NULL, '2026-06-09', 'aktif'),
(4, 'Iqbal Rizki Muhammad Fadhli', 'Kota Ponorogo', NULL, NULL, '2026-06-09', 'aktif');
```

```sql
DELIMITER $$
CREATE TRIGGER `trg_sebelum_delete_anggota` BEFORE DELETE ON `anggota` FOR EACH ROW BEGIN
    INSERT INTO `riwayat_aktivitas` (`id_anggota`, `tipe_aksi`, `detail`)
    VALUES (NULL, 'hapus_anggota', CONCAT('Data anggota dihapus: ', OLD.nama, ' (ID Lama: ', OLD.id_anggota, ')'));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_setelah_insert_anggota` AFTER INSERT ON `anggota` FOR EACH ROW BEGIN
    INSERT INTO `riwayat_aktivitas` (`id_anggota`, `tipe_aksi`, `detail`)
    VALUES (NEW.id_anggota, 'daftar', CONCAT('Anggota baru mendaftar: ', NEW.nama, ' (ID: ', NEW.id_anggota, ')'));
END
$$
DELIMITER ;
```

---

#### 6. `pustakawan`
Menyimpan data petugas/staf perpustakaan yang berwenang memproses transaksi.

```sql
CREATE TABLE `pustakawan` (
  `id_petugas` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_petugas` | `INT` | _Primary Key_, _Auto Increment_ |
| `nama` | `VARCHAR(100)` | Nama petugas |
| `username` | `VARCHAR(50)` | _Unique_ — username login |
| `password_hash` | `VARCHAR(255)` | _Password_ dalam bentuk hash |

```sql
INSERT INTO `pustakawan` (`id_petugas`, `nama`, `username`, `password_hash`) VALUES
(1, 'Andre Onana', 'a.onana24', '3b612c75a7b5048a435fb6ec81e52ff92d6d795a8b5a9c17070f6a63c97a53b2'),
(2, 'Bruno Fernandes', 'bruno.assists', '3b0b01e1e1f2fee1bd464ded0ecb23d0b11f4e85c8942a08cec242f182f46bdb'),
(3, 'Casemiro', 'case.casimiro', '6fe472da5a95389092c5cc79cb7b70afbf7eef0e538b7d357ea22c71fc3b711b'),
(4, 'Diogo Dalot', 'dalot.shoots', '61e2c8580e8226ad8e8ef5b12bfc8fd7dd4a4899a81929c49129abe5f19f43fd'),
(5, 'Eric Bailly', 'eric.bailly', '8a84dfa77e084b8640b9e4c99429f99813263036ad8f449f52689ab3960cc3e4');
```

---

#### 7. `peminjaman`
Menyimpan transaksi peminjaman buku oleh anggota.

```sql
CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `tgl_pinjam` date NOT NULL DEFAULT curdate(),
  `tgl_kembali_rencana` date NOT NULL,
  `tgl_kembali_aktual` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan','terlambat') NOT NULL DEFAULT 'dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_peminjaman` | `INT` | _Primary Key_, _Auto Increment_ |
| `id_anggota` | `INT` | FK → `anggota.id_anggota` |
| `id_buku` | `INT` | FK → `buku.id_buku` |
| `id_petugas` | `INT` | FK → `pustakawan.id_petugas` |
| `tgl_pinjam` | `DATE` | Default `curdate()` |
| `tgl_kembali_rencana` | `DATE` | Tanggal jatuh tempo pengembalian |
| `tgl_kembali_aktual` | `DATE` | Tanggal aktual buku dikembalikan (nullable) |
| `status` | `ENUM` | `'dipinjam'` / `'dikembalikan'` / `'terlambat'`, default `'dipinjam'` |

```sql
INSERT INTO `peminjaman` (`id_peminjaman`, `id_anggota`, `id_buku`, `id_petugas`, `tgl_pinjam`, `tgl_kembali_rencana`, `tgl_kembali_aktual`, `status`) VALUES
(1, 1, 1, 1, '2026-05-01', '2026-05-08', '2026-05-07', 'dikembalikan'),
(2, 2, 5, 2, '2026-05-03', '2026-05-10', '2026-05-09', 'dikembalikan'),
(3, 3, 11, 3, '2026-05-05', '2026-05-12', '2026-05-12', 'dikembalikan'),
(4, 4, 41, 4, '2026-05-06', '2026-05-13', '2026-05-13', 'dikembalikan'),
(5, 1, 21, 5, '2026-05-10', '2026-05-17', '2026-05-16', 'dikembalikan'),
(6, 2, 52, 1, '2026-05-12', '2026-05-19', '2026-05-18', 'dikembalikan'),
(7, 3, 2, 2, '2026-05-01', '2026-05-08', '2026-05-12', 'dikembalikan'),
(8, 4, 6, 3, '2026-05-04', '2026-05-11', '2026-05-18', 'dikembalikan'),
(9, 1, 14, 4, '2026-05-07', '2026-05-14', '2026-05-17', 'dikembalikan'),
(10, 2, 37, 5, '2026-05-10', '2026-05-17', '2026-05-25', 'dikembalikan'),
(11, 3, 54, 1, '2026-05-13', '2026-05-20', '2026-05-24', 'dikembalikan'),
(12, 4, 40, 2, '2026-05-15', '2026-05-22', '2026-05-29', 'dikembalikan'),
(13, 1, 4, 3, '2026-06-05', '2026-06-19', NULL, 'dipinjam'),
(14, 2, 22, 4, '2026-06-06', '2026-06-20', NULL, 'dipinjam'),
(15, 3, 58, 5, '2026-06-07', '2026-06-21', NULL, 'dipinjam'),
(16, 4, 15, 1, '2026-06-08', '2026-06-22', NULL, 'dipinjam'),
(17, 1, 50, 2, '2026-05-20', '2026-05-27', NULL, 'terlambat'),
(18, 2, 46, 3, '2026-05-22', '2026-05-29', NULL, 'terlambat'),
(19, 3, 9, 4, '2026-05-25', '2026-06-01', NULL, 'terlambat'),
(20, 4, 30, 5, '2026-05-28', '2026-06-04', NULL, 'terlambat');
```

```sql
DELIMITER $$
CREATE TRIGGER `trg_setelah_insert_peminjaman` AFTER INSERT ON `peminjaman` FOR EACH ROW BEGIN
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
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_setelah_update_peminjaman` AFTER UPDATE ON `peminjaman` FOR EACH ROW BEGIN
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
END
$$
DELIMITER ;
```

---

#### 8. `denda`
Menyimpan data denda akibat keterlambatan pengembalian buku.

```sql
CREATE TABLE `denda` (
  `id_denda` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `jumlah_denda` decimal(10,2) NOT NULL DEFAULT 0.00,
  `tgl_bayar` date DEFAULT NULL,
  `status_bayar` enum('belum_bayar','lunas') NOT NULL DEFAULT 'belum_bayar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_denda` | `INT` | _Primary Key_, _Auto Increment_ |
| `id_peminjaman` | `INT` | _Unique_ + FK → `peminjaman.id_peminjaman` (ON DELETE CASCADE) |
| `jumlah_denda` | `DECIMAL(10,2)` | Nominal denda, default `0.00` |
| `tgl_bayar` | `DATE` | Tanggal pelunasan denda (nullable) |
| `status_bayar` | `ENUM` | `'belum_bayar'` / `'lunas'`, default `'belum_bayar'` |


```sql
INSERT INTO `denda` (`id_denda`, `id_peminjaman`, `jumlah_denda`, `tgl_bayar`, `status_bayar`) VALUES
(1, 7, 8000.00, '2026-05-13', 'lunas'),
(2, 8, 14000.00, NULL, 'belum_bayar'),
(3, 9, 6000.00, '2026-05-18', 'lunas'),
(4, 10, 16000.00, NULL, 'belum_bayar'),
(5, 11, 8000.00, '2026-05-25', 'lunas'),
(6, 12, 14000.00, NULL, 'belum_bayar');
```
---

#### 9. `riwayat_aktivitas`
Tabel audit trail yang merekam seluruh aktivitas penting dalam sistem secara otomatis (via trigger).

```sql
CREATE TABLE `riwayat_aktivitas` (
  `id_aktivitas` bigint(20) NOT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  `tipe_aksi` enum('login','pinjam','kembali','bayar_denda','daftar','hapus_anggota','tambah_buku','hapus_buku') NOT NULL,
  `detail` text DEFAULT NULL,
  `timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id_aktivitas` | `BIGINT` | _Primary Key_, _Auto Increment_ |
| `id_anggota` | `INT` | FK → `anggota.id_anggota` (ON DELETE SET NULL), nullable |
| `tipe_aksi` | `ENUM` | Jenis aktivitas (lihat nilai di bawah) |
| `detail` | `TEXT` | Keterangan detail aktivitas |
| `timestamp` | `DATETIME` | _Default_ `current_timestamp()` |

Nilai `tipe_aksi` yang didukung: `login`, `pinjam`, `kembali`, `bayar_denda`, `daftar`, `hapus_anggota`, `tambah_buku`, `hapus_buku`.

---


## Cara Menggunakan

### Import ke MySQL/phpMyAdmin

  **a. Via phpMyAdmin:**
  1. Buka phpMyAdmin, buat database baru bernama `library_kel9`
  2. Pilih tab _**Import**_, unggah file `library_kel9.sql`
  3. Klik _**Go**_

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
<img width="1128" height="930" alt="image" src="https://github.com/user-attachments/assets/ad951e41-4d53-4f07-9af3-51548accf127" />

```sql
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
```
