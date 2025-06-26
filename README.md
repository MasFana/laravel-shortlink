# Laravel ShortLink 🔗

Sebuah aplikasi web Laravel sederhana untuk membuat, mengedit, dan melacak URL pendek seperti Bitly.

---

## 📁 Struktur Proyek

```
laravel-shortlink/
├── app/
│   ├── Http/Controllers/ShortLinkController.php
│   └── Models/ShortLink.php
├── database/
│   ├── migrations/
│   │   └── 2025_06_26_193633_create_short_links_table.php
│   └── seeders/DatabaseSeeder.php
├── resources/views/
│   ├── index.blade.php
│   └── edit.blade.php
├── routes/web.php
├── .env.example
├── composer.json
└── README.md
```

---

## 🧱 Struktur Database

### Tabel: `short_links`

| Kolom        | Tipe Data | Keterangan                           |
| ------------ | --------- | ------------------------------------ |
| id           | BIGINT    | Primary key                          |
| url          | STRING    | URL asli                             |
| code         | STRING    | Kode unik (URL pendek)               |
| click\_count | INTEGER   | Jumlah klik                          |
| timestamps   | TIMESTAMP | created\_at dan updated\_at otomatis |

---

## 🚀 Cara Menjalankan Proyek

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi ini secara lokal:

### 1. Clone dan Masuk ke Folder Proyek

```bash
git clone https://github.com/MasFana/laravel-shortlink
cd laravel-shortlink
```

### 2. Install Dependency

```bash
composer install
```

### 3. Copy File `.env`

```bash
cp .env.example .env
```

### 4. Generate APP\_KEY

```bash
php artisan key:generate
```

### 5. Buat File Database

```bash
touch database/database.sqlite
```

Pastikan di `.env` sudah diatur seperti ini:

```
DB_CONNECTION=sqlite
```

### 6. Migrasi Database

```bash
php artisan migrate:fresh --seed
```


### 7. Jalankan Server

```bash
php artisan serve
```

Aplikasi akan dapat diakses di: `http://localhost:8000`

---

## 🌐 Fitur

* Generate URL pendek dari URL panjang.
* Proteksi terhadap kode pendek tertentu (`masfana`, `lawos`, `repoini`).
* Edit dan hapus URL pendek.
* Redirect otomatis dan pelacakan klik.
