<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Orkestrasi sinkronisasi dosen SEVIMA → database lokal.
 * Dipakai bersama oleh cron (sync/lecturers) dan tombol manual (admin).
 */
class Lecturer_sync_service
{
    protected $CI;
    protected $per_page = 100;

    public function __construct()
    {
        if (function_exists('set_time_limit')) set_time_limit(0);
        $this->CI =& get_instance();
        $this->CI->config->load('sevima', true);
        $this->CI->load->model('Lecturer_model', 'lecturer_model');
        $this->CI->load->model('Lecturer_sync_log_model', 'lecturer_sync_log_model');
        $this->CI->load->model('Setting_model', 'setting_model');
        $this->CI->load->library('Sevima_api');
    }

    /**
     * Menjalankan sinkronisasi. Mengembalikan array statistik
     * (atau ['error' => ..., 'running' => bool] jika gagal/terkunci).
     * $verbose mengaktifkan progress output (CLI).
     */
    public function sync($sync_type = 'manual', $verbose = false)
    {
        $lock_ttl = (int) $this->CI->config->item('lock_ttl', 'sevima');
        $homebase_id = (string) $this->CI->config->item('homebase_id', 'sevima');
        $status_map = (array) $this->CI->config->item('status_map', 'sevima');
        $stats_min_interval = (int) $this->CI->config->item('stats_min_interval', 'sevima');

        if ($this->CI->lecturer_sync_log_model->find_running($lock_ttl)) {
            return array('error' => 'Sinkronisasi sedang berjalan. Silakan tunggu sampai proses selesai.', 'running' => true);
        }

        $log_id = $this->CI->lecturer_sync_log_model->create_run($sync_type);
        $stats = array('total_data' => 0, 'inserted' => 0, 'updated' => 0, 'deactivated' => 0, 'failed' => 0, 'students' => 0, 'accreditation' => null);
        $errors = array();

        try {
            $items = $this->CI->sevima_api->fetch_all_dosen();
            $stats['total_data'] = count($items);

            foreach ($items as $item) {
                try {
                    $vendor = $this->_map_item($item, $homebase_id, $status_map);
                    if ($vendor === null) continue; // bukan homebase PGSD, dihapus vendor, atau nama kosong

                    $master = $this->CI->lecturer_model->get_master_by_vendor_id($vendor['vendor_id']);

                    if ($master) {
                        $was_active = (int) $master['is_active'];
                        $this->CI->lecturer_model->update_vendor_fields(
                            $this->CI->lecturer_model->get_group_rows($master['translation_group_id']),
                            $vendor
                        );
                        $stats['updated']++;
                        if ($was_active === 1 && (int) $vendor['is_active'] === 0) {
                            $stats['deactivated']++;
                        }
                    } else {
                        $this->CI->lecturer_model->insert_vendor($vendor);
                        $stats['inserted']++;
                    }
                } catch (Exception $e) {
                    $stats['failed']++;
                    $errors[] = $this->_redact($e->getMessage());
                }
            }

            try {
                if ($this->_stats_fresh($stats_min_interval)) {
                    $stats['students'] = (int) $this->CI->setting_model->get('stats_students');
                    if ($verbose) {
                        echo '[STATS] dilewati: scan mahasiswa terakhir < ' . $stats_min_interval . ' dtk lalu. ';
                        echo 'Gunakan angka tersimpan (' . $stats['students'] . ").\n";
                    }
                } else {
                    $stats['students'] = $this->_sync_students_stats($homebase_id, $verbose);
                    $this->CI->setting_model->set('stats_students', (string) $stats['students']);
                    $this->CI->setting_model->set('stats_students_sync_at', date('Y-m-d H:i:s'));
                }
            } catch (Exception $e) {
                $stats['failed']++;
                $errors[] = 'Statistik mahasiswa: ' . $this->_redact($e->getMessage());
            }

            try {
                $stats['accreditation'] = $this->_sync_accreditation($homebase_id, $verbose);
            } catch (Exception $e) {
                $stats['failed']++;
                $errors[] = 'Akreditasi prodi: ' . $this->_redact($e->getMessage());
            }

            $this->CI->lecturer_sync_log_model->finish($log_id, array(
                'status' => $stats['failed'] > 0 ? 'partial' : 'success',
                'total_data' => $stats['total_data'],
                'inserted' => $stats['inserted'],
                'updated' => $stats['updated'],
                'deactivated' => $stats['deactivated'],
                'students_count' => $stats['students'],
                'failed' => $stats['failed'],
                'error_message' => implode("\n", array_slice($errors, 0, 10)),
            ));
        } catch (Exception $e) {
            $this->CI->lecturer_sync_log_model->finish($log_id, array(
                'status' => 'failed',
                'error_message' => $this->_redact($e->getMessage()),
            ));
            return array('error' => $this->_redact($e->getMessage()), 'running' => false);
        }

        return $stats + array('error' => null, 'running' => false);
    }

    /**
     * Sinkronisasi akreditasi program studi dari /program-studi ke
     * study_programs.accreditation (semua baris bahasa pada grup yang sama).
     * Kode API → teks: U→Unggul (U), B→Baik Sekali (B), G→Baik (G).
     */
    protected function _sync_accreditation($homebase_id, $verbose = false)
    {
        $prodi = $this->CI->sevima_api->fetch_program_studi($homebase_id);
        if ($prodi === null) {
            throw new Exception('Program studi ' . $homebase_id . ' tidak ditemukan di /program-studi.');
        }

        $a = (isset($prodi['attributes']) && is_array($prodi['attributes'])) ? $prodi['attributes'] : $prodi;
        $code = trim((string) (isset($a['akreditasi']) ? $a['akreditasi'] : ''));
        if ($code === '') return null;

        $map = array('U' => 'Unggul (U)', 'B' => 'Baik Sekali (B)', 'G' => 'Baik (G)');
        $label = isset($map[$code]) ? $map[$code] : $code;

        $this->CI->db->where('lang', 'id');
        $this->CI->db->where('slug', 'sipil');
        $master = $this->CI->db->get('study_programs')->row_array();

        if (!$master || empty($master['translation_group_id'])) {
            throw new Exception('Baris induk program studi (lang=id) tidak ditemukan di tabel study_programs.');
        }

        $this->CI->db->where('translation_group_id', $master['translation_group_id']);
        $this->CI->db->update('study_programs', array('accreditation' => $label));

        if ($verbose) {
            echo '[AKREDITASI] ' . $label . " (dari /program-studi id " . $homebase_id . ")\n";
        }

        return $label;
    }

    /**
     * True jika scan statistik terakhir masih segar (di dalam stats_min_interval).
     */
    protected function _stats_fresh($stats_min_interval)
    {
        if ($stats_min_interval <= 0) return false;

        $last = $this->CI->setting_model->get('stats_students_sync_at');
        if (!$last) return false;

        $ts = strtotime($last);
        return $ts !== false && (time() - $ts) < $stats_min_interval;
    }

    /**
     * Menghitung mahasiswa aktif prodi: scan seluruh kelas (/kelas),
     * kumpulkan NIM unik dengan id_program_studi = PGSD dan status Aktif.
     */
    protected function _sync_students_stats($homebase_id, $verbose = false)
    {
        $nims = array();
        $page = 1;
        $last_page = null;

        while (true) {
            $response = $this->CI->sevima_api->fetch_kelas_page($page);
            $batch = (isset($response['data']) && is_array($response['data'])) ? $response['data'] : array();
            if (empty($batch)) break;

            if ($last_page === null && isset($response['meta']['last_page'])) {
                $last_page = (int) $response['meta']['last_page'];
            }

            if ($verbose && $last_page !== null && $page % 10 === 0) {
                echo '[STATS] kelas halaman ' . $page . '/' . $last_page . "...\n";
            }

            foreach ($batch as $kelas) {
                $a = (isset($kelas['attributes']) && is_array($kelas['attributes'])) ? $kelas['attributes'] : $kelas;
                if (!isset($a['id_program_studi']) || (string) $a['id_program_studi'] !== (string) $homebase_id) continue;

                $peserta = (isset($a['relation']['peserta']) && is_array($a['relation']['peserta']))
                    ? $a['relation']['peserta']
                    : array();

                foreach ($peserta as $p) {
                    if (isset($p['status_mahasiswa'], $p['nim'])
                        && (string) $p['status_mahasiswa'] === 'Aktif'
                        && trim((string) $p['nim']) !== '') {
                        $nims[(string) $p['nim']] = true;
                    }
                }
            }

            if ($last_page !== null && $page >= $last_page) break;
            if ($last_page === null && count($batch) < $this->per_page) break;
            $page++;
        }

        if ($verbose) {
            echo '[STATS] selesai: ' . count($nims) . " mahasiswa aktif (NIM unik PGSD).\n";
        }

        return count($nims);
    }

    /**
     * Memetakan satu item API → array field vendor (hanya homebase PGSD).
     * Mengembalikan null jika item dilewati.
     */
    protected function _map_item($item, $homebase_id, $status_map)
    {
        if (!is_array($item)) return null;

        $a = (isset($item['attributes']) && is_array($item['attributes'])) ? $item['attributes'] : $item;
        $vendor_id = isset($item['id']) ? $item['id'] : (isset($a['id_pegawai']) ? $a['id_pegawai'] : null);
        if ($vendor_id === null) return null;

        if (isset($a['is_deleted']) && (string) $a['is_deleted'] === '1') return null;
        if ((string) (isset($a['id_home_base']) ? $a['id_home_base'] : '') !== (string) $homebase_id) return null;

        $name = trim((string) (isset($a['nama']) ? $a['nama'] : ''));
        if ($name === '') return null;

        $is_active = 0;
        $status_key = (string) (isset($a['id_status_aktif']) ? $a['id_status_aktif'] : '');
        if (array_key_exists($status_key, $status_map)) {
            $is_active = (int) $status_map[$status_key];
        } elseif (isset($a['status_aktif']) && stripos((string) $a['status_aktif'], 'aktif') !== false) {
            $is_active = 1;
        }

        return array(
            'vendor_id' => (string) $vendor_id,
            'name' => $name,
            'nidn' => trim((string) (isset($a['nidn']) ? $a['nidn'] : '')),
            'nip' => trim((string) (isset($a['nip']) ? $a['nip'] : '')),
            'front_title' => trim((string) (isset($a['gelar_depan']) ? $a['gelar_depan'] : '')),
            'back_title' => trim((string) (isset($a['gelar_belakang']) ? $a['gelar_belakang'] : '')),
            'gender' => trim((string) (isset($a['jenis_kelamin']) ? $a['jenis_kelamin'] : '')),
            'homebase_id' => trim((string) (isset($a['id_home_base']) ? $a['id_home_base'] : '')),
            'homebase_name' => trim((string) (isset($a['home_base']) ? $a['home_base'] : '')),
            'position_id' => trim((string) (isset($a['id_jabatan_fungsional']) ? $a['id_jabatan_fungsional'] : '')),
            'position' => trim((string) (isset($a['jabatan_fungsional']) ? $a['jabatan_fungsional'] : '')),
            'employment_status' => trim((string) (isset($a['status_kepegawaian']) ? $a['status_kepegawaian'] : '')),
            'phone' => $this->_first(isset($a['nomor_hp']) ? $a['nomor_hp'] : '', isset($a['telepon']) ? $a['telepon'] : ''),
            'email' => $this->_first(isset($a['email']) ? $a['email'] : '', isset($a['email_kampus']) ? $a['email_kampus'] : ''),
            'is_active' => $is_active,
            'vendor_created_at' => $this->_dt(isset($a['created_at']) ? $a['created_at'] : ''),
            'vendor_updated_at' => $this->_dt(isset($a['updated_at']) ? $a['updated_at'] : ''),
        );
    }

    protected function _first($a, $b)
    {
        $a = trim((string) $a);
        return $a !== '' ? $a : trim((string) $b);
    }

    protected function _dt($value)
    {
        $value = trim((string) $value);
        return $value === '' ? null : substr($value, 0, 19);
    }

    protected function _redact($message)
    {
        $app_key = (string) $this->CI->config->item('app_key', 'sevima');
        $secret_key = (string) $this->CI->config->item('secret_key', 'sevima');
        if ($app_key !== '') $message = str_replace($app_key, '[REDACTED]', $message);
        if ($secret_key !== '') $message = str_replace($secret_key, '[REDACTED]', $message);
        return $message;
    }
}
