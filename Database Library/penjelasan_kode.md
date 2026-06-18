# 📚 Penjelasan Detail Blok Kode Backend (Model, Controller, & Routes)

Dokumen ini menjelaskan baris demi baris dan logika dari blok kode utama pada setiap **Model** dan **Controller** yang terhubung melalui rute di **Laravel**.

---

## 1. Modul Anggota

### Model: [Anggota.php](../backend/app/Models/Anggota.php)

```php
class Anggota extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'alamat',
        'no_telepon',
        'email',
        'tanggal_daftar',
        'status'
    ];

    public function peminjaman()
    {
        return $this->hasMany(
            Peminjaman::class,
            'id_anggota',
            'id_anggota'
        );
    }
}
```
* **`$table = 'anggota'` & `$primaryKey = 'id_anggota'`**: Menghubungkan model ini secara spesifik ke tabel `anggota` dengan primary key `id_anggota` (bukan default `'id'`).
* **`$timestamps = false`**: Menghindari error SQL karena tabel ini tidak memiliki kolom default Laravel `created_at` dan `updated_at`.
* **`$fillable = [...]`**: Daftar kolom yang diizinkan untuk diisi secara massal saat memanggil method `create()` atau `update()`.
* **`peminjaman()`**: Mendefinisikan relasi **One-to-Many**. Method ini mencari baris di tabel `peminjaman` yang kolom `id_anggota`-nya cocok dengan `id_anggota` milik instansi model ini.

---

### Controller: [AnggotaController.php](../backend/app/Http/Controllers/AnggotaController.php)

#### Method `store()`
```php
public function store(Request $request)
{
    $anggota = Anggota::create([
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'no_telepon' => $request->no_telepon,
        'email' => $request->email,
        'tanggal_daftar' => $request->tanggal_daftar ?: now()->toDateString(),
        'status' => $request->status
    ]);

    return response()->json($anggota, 201, [], JSON_PRETTY_PRINT);
}
```
* **`Anggota::create([...])`**: Menyimpan anggota baru ke database.
* **`$request->tanggal_daftar ?: now()->toDateString()`**: Menggunakan operator Elvis (`?:`). Jika request `tanggal_daftar` bernilai kosong (`null`, `""`, atau tidak dikirim), maka otomatis digantikan oleh string tanggal hari ini (`now()->toDateString()`).
* **`response()->json(..., 201)`**: Mengembalikan data anggota yang baru dibuat dengan kode status HTTP `201 Created`.

#### Method `update()`
```php
public function update(Request $request, $id)
{
    $anggota = Anggota::findOrFail($id);

    $anggota->update([
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'no_telepon' => $request->no_telepon,
        'email' => $request->email,
        'tanggal_daftar' => $request->tanggal_daftar,
        'status' => $request->status
    ]);

    return response()->json($anggota, 200, [], JSON_PRETTY_PRINT);
}
```
* **`findOrFail($id)`**: Mengambil data anggota berdasarkan ID. Jika data tidak ditemukan, Laravel langsung menghentikan eksekusi dan mengembalikan response error `404 Not Found`.
* **`$anggota->update([...])`**: Memperbarui kolom anggota di database berdasarkan data request baru.

#### Method `search()`
```php
public function search(Request $request)
{
    $query = Anggota::query();

    if ($request->filled('nama')) {
        $query->where('nama', 'like', '%' . $request->nama . '%');
    }

    if ($request->filled('email')) {
        $query->where('email', 'like', '%' . $request->email . '%');
    }

    if ($request->filled('id_anggota')) {
        $query->where('id_anggota', $request->id_anggota);
    }

    return response()->json($query->get(), 200, [], JSON_PRETTY_PRINT);
}
```
* **`Anggota::query()`**: Memulai pembuatan query SQL dinamis.
* **`$request->filled('nama')`**: Mengecek apakah parameter query `nama` dikirim dan memiliki nilai (bukan string kosong). Jika ya, ditambahkan klausa SQL `WHERE nama LIKE '%nilai%'`.
* **`$query->get()`**: Mengeksekusi query SQL yang sudah disusun dan mengambil hasilnya dari database.

---

## 2. Modul Buku, Pengarang, & Kategori

### Model: [Buku.php](../backend/app/Models/Buku.php)

```php
class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $timestamps = false;

    protected $fillable = [
        'isbn', 'judul', 'tahun_terbit', 'penerbit', 'stok', 'id_pengarang'
    ];

    public function pengarang()
    {
        return $this->belongsTo(Pengarang::class, 'id_pengarang', 'id_pengarang');
    }

    public function kategori()
    {
        return $this->belongsToMany(
            Kategori::class,
            'buku_kategori',
            'id_buku',
            'id_kategori'
        );
    }
}
```
* **`pengarang()`**: Menentukan relasi **Many-to-One** (`belongsTo`). Menghubungkan foreign key `id_pengarang` di tabel `buku` ke primary key `id_pengarang` di tabel `pengarang`.
* **`kategori()`**: Menentukan relasi **Many-to-Many** (`belongsToMany`). Menghubungkan model `Buku` dengan `Kategori` melalui tabel perantara (pivot) bernama `buku_kategori` dengan foreign key penghubung `id_buku` dan `id_kategori`.

---

### Controller: [BukuController.php](../backend/app/Http/Controllers/BukuController.php)

#### Method `show()`
```php
public function show($id)
{
    return response()->json(
        Buku::with(['pengarang', 'kategori'])->findOrFail($id),
        200,
        [],
        JSON_PRETTY_PRINT
    );
}
```
* **`Buku::with(['pengarang', 'kategori'])`**: Mencegah masalah *N+1 query* dengan melakukan Eager Loading. Query SQL akan langsung menggabungkan data buku beserta data penulis (pengarang) dan kategori-kategorinya dalam satu siklus request.

#### Method `search()`
```php
public function search(Request $request)
{
    $query = Buku::with(['pengarang', 'kategori']);

    if ($request->filled('judul')) {
        $query->where('judul', 'like', '%' . $request->judul . '%');
    }
    // ... filter lainnya ...
    if ($request->filled('pengarang')) {
        $query->whereHas('pengarang', function ($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->pengarang . '%');
        });
    }
    // ...
}
```
* **`whereHas('pengarang', ...)`**: Melakukan query filtering berdasarkan kolom pada tabel relasi. Query ini membatasi pencarian buku hanya untuk buku yang nama pengarangnya mengandung teks pencarian.

---

### Model: [Pengarang.php](../backend/app/Models/Pengarang.php) & [Kategori.php](../backend/app/Models/Kategori.php)

```php
// Pengarang.php
class Pengarang extends Model
{
    protected $table = 'pengarang';
    protected $primaryKey = 'id_pengarang';
    public $timestamps = false;

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_pengarang', 'id_pengarang');
    }
}
```
* **`buku()`**: Relasi **One-to-Many** ke `Buku`. Satu pengarang dapat memiliki banyak buku.

```php
// Kategori.php
class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    public function buku()
    {
        return $this->belongsToMany(
            Buku::class,
            'buku_kategori',
            'id_kategori',
            'id_buku'
        );
    }
}
```
* **`buku()`**: Relasi **Many-to-Many** kembali ke model `Buku` melalui tabel pivot `buku_kategori`.

---

## 3. Modul Transaksi: Peminjaman & Denda

### Model: [Peminjaman.php](../backend/app/Models/Peminjaman.php)

```php
class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    public $timestamps = false;

    protected $fillable = [
        'id_anggota', 'id_buku', 'id_petugas',
        'tgl_pinjam', 'tgl_kembali_rencana', 'tgl_kembali_aktual', 'status'
    ];

    public function anggota() {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota');
    }
    public function buku() {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
    public function denda() {
        return $this->hasOne(Denda::class, 'id_peminjaman', 'id_peminjaman');
    }
    public function pustakawan() {
        return $this->belongsTo(Pustakawan::class, 'id_petugas', 'id_petugas');
    }
}
```
* Menghubungkan transaksi peminjam ke 3 entitas (Anggota, Buku, Pustakawan) menggunakan relasi **Belongs-To**.
* **`denda()`**: Relasi **One-to-One** (`hasOne`). Satu peminjaman maksimal menghasilkan satu record denda apabila terlambat dikembalikan.

---

### Controller: [PeminjamanController.php](../backend/app/Http/Controllers/PeminjamanController.php)

#### Method `store()` (Proses Pinjam)
```php
public function store(Request $request)
{
    $buku = Buku::findOrFail($request->id_buku);

    if ($buku->stok <= 0) {
        return response()->json(['message' => 'Stok buku habis'], 400);
    }

    $peminjaman = Peminjaman::create([
        'id_anggota' => $request->id_anggota,
        'id_buku' => $request->id_buku,
        'id_petugas' => $request->id_petugas,
        'tgl_pinjam' => Carbon::today(),
        'tgl_kembali_rencana' => Carbon::today()->addDays(7),
        'status' => 'dipinjam'
    ]);

    $buku->decrement('stok');

    return response()->json($peminjaman, 201, [], JSON_PRETTY_PRINT);
}
```
1. **`Buku::findOrFail($request->id_buku)`**: Mengambil data buku. Jika tidak ada, menggagalkan proses (mengembalikan status 404).
2. **`if ($buku->stok <= 0)`**: Memvalidasi ketersediaan fisik buku. Jika kosong, mengembalikan response error HTTP `400 Bad Request`.
3. **`Carbon::today()` & `addDays(7)`**: Menentukan tanggal pinjam (hari ini) dan batas pengembalian otomatis (7 hari dari hari ini).
4. **`$buku->decrement('stok')`**: Memperbarui stok buku secara langsung dengan mengurangi nilainya sebanyak 1 di database.

#### Method `kembali()` (Proses Kembalikan)
```php
public function kembali($id)
{
    $peminjaman = Peminjaman::with('buku')->findOrFail($id);

    if ($peminjaman->status != 'dipinjam') {
        return response()->json(['message' => 'Buku sudah dikembalikan'], 400);
    }

    $tanggalKembali = Carbon::today();
    $peminjaman->update(['tgl_kembali_aktual' => $tanggalKembali]);

    $peminjaman->buku->increment('stok');

    $hariTerlambat = Carbon::parse($peminjaman->tgl_kembali_rencana)
        ->diffInDays($tanggalKembali, false);

    if ($hariTerlambat > 0) {
        $jumlahDenda = $hariTerlambat * 1000;

        Denda::create([
            'id_peminjaman' => $peminjaman->id_peminjaman,
            'jumlah_denda' => $jumlahDenda,
            'status_bayar' => 'belum_bayar'
        ]);

        $peminjaman->update(['status' => 'terlambat']);
    } else {
        $peminjaman->update(['status' => 'dikembalikan']);
    }

    return response()->json($peminjaman->fresh(), 200, [], JSON_PRETTY_PRINT);
}
```
1. **`$peminjaman->buku->increment('stok')`**: Menambah kembali stok buku yang telah dikembalikan sebanyak 1 di database.
2. **`Carbon::parse(...)->diffInDays(..., false)`**: Menghitung selisih hari antara batas rencana pengembalian dan tanggal pengembalian riil (aktual). Parameter kedua `false` memastikan nilai selisih bisa bernilai negatif jika dikembalikan lebih awal (tidak terlambat).
3. **`if ($hariTerlambat > 0)`**: Jika selisih hari bernilai positif (terlambat), sistem menghitung denda keterlambatan (hari $\times$ Rp1.000) dan membuat entri denda baru di tabel `denda`.

---

### Controller: [DendaController.php](../backend/app/Http/Controllers/DendaController.php)

#### Method `bayar()`
```php
public function bayar($id)
{
    $denda = Denda::findOrFail($id);

    $denda->update([
        'status_bayar' => 'lunas',
        'tgl_bayar' => now()
    ]);

    return response()->json($denda, 200, [], JSON_PRETTY_PRINT);
}
```
* **`$denda->update([...])`**: Menyelesaikan kewajiban denda dengan mengubah status bayar menjadi `'lunas'` dan mencatat timestamp waktu pembayaran menggunakan helper `now()`.

---

## 4. Modul Pustakawan & Riwayat Aktivitas

### Model: [Pustakawan.php](../backend/app/Models/Pustakawan.php)

```php
class Pustakawan extends Model
{
    protected $table = 'pustakawan';
    protected $primaryKey = 'id_petugas';
    public $timestamps = false;

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_petugas', 'id_petugas');
    }
}
```
* **`peminjaman()`**: Relasi **One-to-Many** yang memetakan seluruh transaksi peminjaman yang dilayani oleh petugas perpustakaan tersebut.

---

### Model: [RiwayatAktivitas.php](../backend/app/Models/RiwayatAktivitas.php)

```php
class RiwayatAktivitas extends Model
{
    protected $table = 'riwayat_aktivitas';
    protected $primaryKey = 'id_aktivitas';
    public $timestamps = false;
}
```
* Model sederhana yang merepresentasikan tabel `riwayat_aktivitas` untuk menyimpan catatan log sistem.

---

## 5. Modul Ulasan (NoSQL / MongoDB)

### Model: [Ulasan.php](../backend/app/Models/Ulasan.php)

```php
use MongoDB\Laravel\Eloquent\Model;

class Ulasan extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'ulasan';

    protected $fillable = [
        'id_anggota', 'nama_anggota', 'id_buku', 'judul_buku',
        'rating', 'teks_ulasan', 'tgl_ulasan', 'tag'
    ];
}
```
* **`use MongoDB\Laravel\Eloquent\Model`**: Mewarisi kelas model MongoDB Laravel (bukan SQL ORM standar).
* **`$connection = 'mongodb'`**: Mengarahkan model untuk membaca dan menulis menggunakan koneksi database MongoDB yang dikonfigurasi di Laravel.

---

### Controller: [UlasanController.php](../backend/app/Http/Controllers/UlasanController.php)

#### Method `store()`
```php
public function store(Request $request)
{
    $request->validate([
        'id_anggota' => 'required',
        'nama_anggota' => 'required',
        'id_buku' => 'required',
        'judul_buku' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'teks_ulasan' => 'nullable|string'
    ]);

    $ulasan = Ulasan::create([
        'id_anggota' => $request->id_anggota,
        'nama_anggota' => $request->nama_anggota,
        'id_buku' => $request->id_buku,
        'judul_buku' => $request->judul_buku,
        'rating' => (int) $request->rating,
        'teks_ulasan' => $request->teks_ulasan ?? '-',
        'tgl_ulasan' => now()->toISOString(),
        'tag' => $request->tag ?? []
    ]);

    return response()->json($ulasan, 201, [], JSON_PRETTY_PRINT);
}
```
1. **`$request->validate([...])`**: Validasi ketat input dari pengguna. Kolom rating wajib diisi, berformat integer, dan berada pada batas minimal 1 serta maksimal 5.
2. **`(int) $request->rating`**: Casting tipe data untuk menjamin rating disimpan sebagai integer di dalam dokumen BSON MongoDB.
3. **`'teks_ulasan' => $request->teks_ulasan ?? '-'`**: Jika teks ulasan kosong/null, otomatis diset dengan karakter default `'-'`.
4. **`now()->toISOString()`**: Menyimpan waktu pembuatan ulasan dalam format standar ISO 8601.
5. **`$request->tag ?? []`**: Jika tag tidak disediakan, maka disimpan sebagai array kosong `[]` (fleksibilitas database dokumen MongoDB).

#### Method `update()`
```php
public function update(Request $request, $id)
{
    $ulasan = Ulasan::findOrFail($id);

    $ulasan->update([
        'id_anggota' => $request->id_anggota ?? $ulasan->id_anggota,
        'nama_anggota' => $request->nama_anggota ?? $ulasan->nama_anggota,
        'id_buku' => $request->id_buku ?? $ulasan->id_buku,
        'judul_buku' => $request->judul_buku ?? $ulasan->judul_buku,
        'rating' => isset($request->rating) ? (int) $request->rating : $ulasan->rating,
        'teks_ulasan' => $request->teks_ulasan ?? $ulasan->teks_ulasan,
        'tag' => $request->tag ?? $ulasan->tag
    ]);

    return response()->json($ulasan, 200, [], JSON_PRETTY_PRINT);
}
```
* **Operator Coalescing (`??`)**: Digunakan untuk mengupdate nilai hanya jika parameter baru dikirimkan di dalam request. Jika tidak ada parameter baru (bernilai `null` / tidak di-pass), maka ia akan mempertahankan nilai lama yang tersimpan di database (`$ulasan->nama_anggota`, dst).
* **`isset($request->rating)`**: Mengecek apakah parameter `rating` ada di dalam request. Jika ya, dikonversi ke integer `(int)`. Jika tidak, memakai rating lama (`$ulasan->rating`).
