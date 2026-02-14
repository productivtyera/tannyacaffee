## Techstack Tannya Coffee ☕

### 🎨 Brand Identity & Color Palette
Berdasarkan logo yang komunikatif dan playful, berikut palet warna unik yang diaplikasikan agar terlihat modern:

| Primary (Green) | Secondary (Red) | Accent (Cream) | Dark Neutral (Text) |
| :--- | :--- | :--- | :--- |
| ![#2D5A27](https://placehold.co/15x15/2D5A27/2D5A27.png) `#2D5A27` | ![#BC3B3B](https://placehold.co/15x15/BC3B3B/BC3B3B.png) `#BC3B3B` | ![#F5F5DC](https://placehold.co/15x15/F5F5DC/F5F5DC.png) `#F5F5DC` | ![#2B1B17](https://placehold.co/15x15/2B1B17/2B1B17.png) `#2B1B17` |

---

### 📋 Techstack List

#### **Frontend (Design Unik & Interaktif)**
- **Language:** Blade Engine.
- **Styling:** **Tailwind CSS** (dengan custom configuration).
- **Interactivity:** **Alpine.js** (ringan untuk animasi UI).
- **Advanced Animation:** **GSAP** atau **AOS (Animate On Scroll)** untuk kesan website premium.
- **Design Tools:** **Figma** (untuk eksplorasi layout sebelum coding).

#### **Backend (The Core Engine)**
- **Framework:** **Laravel 11** (LTS/Stable).
- **Language:** PHP 8.2+.
- **State Management:** **Livewire 3** (memungkinkan fitur real-time tanpa JS rumit).

#### **Database & Storage**
- **Database:** **MySQL** (Standar & stabil untuk Hostinger).
- **Storage:** Local File Storage (menggunakan `php artisan storage:link`).

#### **Integration & Deployment**
- **Payment Gateway:** **Midtrans** atau **Xendit** (pilihan terbaik untuk pasar Indonesia).
- **Hosting:** **Hostinger** (via Git Deployment atau SSH).
- **Real-time Engine:** **Laravel Reverb** (untuk update status pesanan secara live).

---

### 🚀 Catatan Deployment (Hostinger)
1. Pastikan versi PHP di panel Hostinger diset ke **8.2 ke atas**.
2. Konfigurasi file `.env` untuk koneksi MySQL Hostinger.
3. Jalankan `php artisan storage:link` via SSH untuk handle gambar produk.