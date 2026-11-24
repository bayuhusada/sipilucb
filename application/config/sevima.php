<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Konfigurasi sinkronisasi SEVIMA (bukan kredensial).
 * Kredensial dibaca dari environment: SEVIMA_APP_KEY / SEVIMA_SECRET_KEY
 * (file .env di root proyek dimuat oleh index.php; server env menang).
 */
$config['base_url']    = 'https://api.sevimaplatform.com/siakadcloud/v1';
$config['app_key']     = (string) getenv('SEVIMA_APP_KEY');
$config['secret_key']  = (string) getenv('SEVIMA_SECRET_KEY');
$config['timeout']     = 60;

// Perlindungan rate limit (429): jumlah percobaan ulang & jeda (detik).
$config['rate_limit_retry'] = 5;
$config['rate_limit_wait']  = 3;
// Jeda antar request halaman (detik) — mencegah 429 saat scan ratusan halaman.
$config['request_delay']    = 0.3;

// Jeda maksimal status "running" sebelum dianggap macet (detik).
$config['lock_ttl'] = 1200;

// Interval minimal scan statistik mahasiswa (detik) — hemat kuota API:
// dilewati jika scan terakhir sukses < interval ini.
$config['stats_min_interval'] = 3600;

// Hanya dosen dengan homebase ini yang disinkronkan (Teknik Sipil UCB).
$config['homebase_id']   = '22201';
$config['homebase_name'] = 'Teknik Sipil';

// id_status_aktif (API) => is_active (website)
// AA = Aktif, TA = Tidak Aktif, TB = Tugas Belajar (tetap dianggap aktif).
$config['status_map'] = array('AA' => 1, 'TA' => 0, 'TB' => 1);
