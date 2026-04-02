📚 Web BookShop Sederhana

Project ini dibuat sebagai bagian dari tugas Pra-USK dan Uji Sertifikasi Kompetensi (USK) di SMK Negeri 71 Jakarta.

Aplikasi ini merupakan sistem sederhana untuk penjualan buku berbasis web, yang mencakup fitur seperti manajemen buku, kategori, keranjang, transaksi, hingga laporan.

---

🚀 Fitur Utama

- 🔐 Autentikasi (Login & Register)
- 📖 Manajemen Buku
- 🗂️ Manajemen Kategori
- 🛒 Keranjang Belanja
- 💳 Sistem Order & Pembayaran
- 📊 Laporan Penjualan
- 👨‍💼 Role Admin & Member

---

🛠️ Teknologi yang Digunakan

- PHP (Laravel)
- MySQL / MariaDB
- Bootstrap (Frontend)
- JavaScript

---

⚙️ Instalasi

1. Clone Repository

Buka terminal / CMD, lalu jalankan:

git clone https://github.com/HusniAja211/pra-usk

Atau download dalam bentuk ZIP melalui GitHub.

---

2. Masuk ke Folder Project

cd pra-usk

---

3. Install Dependency Backend

composer install

---

4. Install Dependency Frontend

npm install

---

5. Copy File Environment

cp .env.example .env

---

6. Konfigurasi File ".env"

Buka file ".env", lalu ubah bagian database sesuai dengan konfigurasi lokal kamu:

DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=

---

7. Generate App Key

php artisan key:generate

---

8. Migrasi Database

php artisan migrate

Jika ada seeder:

php artisan db:seed

---

9. Jalankan Vite / Frontend

npm run dev

---

10. Jalankan Server

php artisan serve

Akses di browser:

http://127.0.0.1:8000
---