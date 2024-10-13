# Book Review API

Book Review API adalah aplikasi berbasis RESTful API yang memungkinkan pengguna untuk melakukan operasi CRUD (Create, Read, Update, Delete) pada buku dan ulasan. Aplikasi ini menggunakan Laravel sebagai framework backend dan **Sanctum** untuk autentikasi berbasis token.

## Fitur Utama
- **Manajemen Buku**: Pengguna dapat melihat daftar buku dan detail buku. Hanya admin yang bisa menambah, mengubah, dan menghapus buku.
- **Manajemen Ulasan**: Pengguna yang sudah login dapat membuat, mengubah, dan menghapus ulasan untuk buku yang mereka baca.
- **Autentikasi**: Menggunakan Laravel Sanctum untuk login, register, dan manajemen token.
- **Role-based Access Control**: Hanya admin yang memiliki akses untuk operasi pada buku, sementara pengguna biasa hanya dapat mengakses fitur ulasan.

## Dependency
Proyek ini menggunakan beberapa dependency penting yang perlu diperhatikan:
- **PHP** >= 8.0
- **Laravel** >= 8.x
- **MySQL** atau **MariaDB** sebagai database
- **Laravel Sanctum** untuk autentikasi token
- **Composer** untuk manajemen dependency

## Instalasi

### Prasyarat
Sebelum memulai, pastikan Anda sudah menginstal beberapa hal berikut:
- **PHP** versi 8.0 atau lebih baru
- **Composer** (https://getcomposer.org/)
- **MySQL** atau **MariaDB**

### Langkah Instalasi

1. **Clone repository**:
    ```bash
    git clone https://github.com/Ulung32/Book-review
    cd book-review
    ```

2. **Install dependencies**:
    ```bash
    composer install
    ```

3. **Salin file `.env.example` menjadi `.env`**:
    ```bash
    cp .env.example .env
    ```

4. **Generate aplikasi key**:
    ```bash
    php artisan key:generate
    ```

5. **Konfigurasi environment**: Buka file `.env` dan masukkan informasi database Anda:
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_database
    DB_USERNAME=username_database
    DB_PASSWORD=password_database

    ADMIN_EMAIL=admin@gmail.com
    ADMIN_PASSWORD=admin
    ```

6. **Migrasi dan Seed database**:
    ```bash
    php artisan migrate --seed
    ```

7. **Install Sanctum**:
    ```bash
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    php artisan migrate
    ```

8. **Jalankan server lokal**:
    ```bash
    php artisan serve
    ```

9. **Pengujian API**:
    Anda dapat menguji API menggunakan tools seperti **Postman** atau **Insomnia**. 

    - **Register**: `POST /api/v1/register`
    - **Login**: `POST /api/v1/login`
    - **Get Buku**: `GET /api/v1/book`
    - **Get Ulasan**: `GET /api/v1/review`

    Pastikan untuk menyertakan token pada endpoint yang memerlukan autentikasi.

## Struktur API

### Books
- **GET** `/api/v1/book`: Mengambil daftar semua buku (publik).
- **GET** `/api/v1/book/{id}`: Mengambil detail buku berdasarkan ID (publik).
- **POST** `/api/v1/book`: Menambahkan buku baru (hanya admin).
- **PUT** `/api/v1/book/{id}`: Mengubah buku berdasarkan ID (hanya admin).
- **DELETE** `/api/v1/book/{id}`: Menghapus buku berdasarkan ID (hanya admin).

### Reviews
- **GET** `/api/v1/review`: Mengambil daftar ulasan (publik).
- **POST** `/api/v1/review`: Menambahkan ulasan baru (hanya pengguna terautentikasi).
- **PUT** `/api/v1/review/{id}`: Mengubah ulasan berdasarkan ID (hanya pengguna terautentikasi yang membuat ulasan).
- **DELETE** `/api/v1/review/{id}`: Menghapus ulasan berdasarkan ID (hanya pengguna terautentikasi yang membuat ulasan).

## Manajemen User dan Role
Dalam proyek ini, terdapat dua jenis pengguna:
1. **Admin**: Dapat membuat, mengubah, dan menghapus buku serta ulasan.
2. **User Biasa**: Dapat membuat, mengubah, dan menghapus ulasan, tetapi hanya dapat melihat buku.
