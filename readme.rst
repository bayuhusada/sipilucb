#############################################
SIPIL UCB
#############################################

Universitas Citra Bangsa. Dibangun dengan CodeIgniter 3 + Sneat Bootstrap 5 Admin Template.

********
Fitur
********

- **Frontend publik**: Beranda, Profil, Program Studi, Dosen, Berita, Agenda,
  Galeri, Download, Kontak, FAQ
- **Admin dashboard**: 15+ controller dengan RBAC (superadmin, admin,
  admin_berita, admin_prodi)
- **Manajemen konten**: Berita (5 bahasa), kategori, agenda, galeri
  (multi-upload), download, dosen, program studi, banner, FAQ
- **Multi-bahasa**: 5 bahasa (Indonesia, English, 中文, Deutsch, 日本語)
  dengan auto-translate (LibreTranslate/Google/Gemini/OpenRouter)
- **Pengaturan website**: Hero, CTA, statistik, sosial media, section labels,
  SEO meta, footer, maintenance mode, translator toggle
- **Program Unggulan**: 6 item dengan icon SVG picker, per bahasa
- **Tema warna**: Easy mode (1 accent → auto 6 derived colors) + Advanced mode
  (13 token manual), live preview
- **Menu dinamis**: Header & footer menu via database
- **Image compression otomatis**: GD bawaan per konten
- **Pagination & search**: Berita, agenda, galeri, dosen, download
- **Pesan kontak**: Inbox superadmin

************
Tech Stack
************

- **Framework**: CodeIgniter 3 (PHP ≥5.3.7)
- **Admin template**: Sneat Bootstrap 5
- **Dependencies**: PhpSpreadsheet 1.21
- **Database**: MySQL

****************
Persyaratan Server
****************

- PHP 7.4+ (PHP 8.0 tested)
- MySQL 5.7+
- mod_rewrite (Apache)
- Ekstensi PHP: GD, mbstring, mysqli, curl, json

**************
Instalasi
**************

1. Clone repo ke document root::

    git clone https://github.com/your-org/pgsducb.git

2. Install dependencies::

    composer install --no-scripts

3. Import database ``.sql`` ke MySQL

4. Sesuaikan konfigurasi database di ``application/config/database.php``

5. Generate encryption key di ``application/config/config.php``

6. Akses ``http://localhost/pgsducb``

**********************
Akun Default
**********************

============= ========== ==========
Role          Username   Password
============= ========== ==========
Super Admin   superadmin  admin123
============= ========== ==========

*******
Lisensi
*******

Hak cipta milik Universitas Citra Bangsa.
