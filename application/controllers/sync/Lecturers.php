<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Sinkronisasi dosen SEVIMA via CLI (cron).
 * Penggunaan: php index.php sync/lecturers
 */
class Lecturers extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if (!is_cli()) {
            show_404();
        }

        require_once APPPATH . 'services/Lecturer_sync_service.php';
        $service = new Lecturer_sync_service();
        $result = $service->sync('cron', true);

        if (isset($result['error']) && $result['error']) {
            echo '[SKIP/GAGAL] ' . $result['error'] . PHP_EOL;
            exit(isset($result['running']) && $result['running'] ? 0 : 1);
        }

        echo '[SELESAI] total=' . $result['total_data']
            . ' baru=' . $result['inserted']
            . ' update=' . $result['updated']
            . ' nonaktif=' . $result['deactivated']
            . ' gagal=' . $result['failed']
            . PHP_EOL;
        echo '[STATS] mahasiswa_aktif=' . (isset($result['students']) ? $result['students'] : '-') . PHP_EOL;
        echo '[AKREDITASI] ' . (isset($result['accreditation']) && $result['accreditation'] !== null ? $result['accreditation'] : 'tidak berubah (kosong)') . PHP_EOL;
    }
}
