<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model untuk tabel lecturer_sync_logs.
 */
class Lecturer_sync_log_model extends CI_Model
{
    public function create_run($sync_type)
    {
        $this->db->insert('lecturer_sync_logs', array(
            'sync_type' => $sync_type,
            'status' => 'running',
            'started_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
        ));
        return (int) $this->db->insert_id();
    }

    /**
     * Menemukan proses yang masih berjalan; null jika tidak ada atau sudah stale (TTL).
     * Baris stale ditandai status='stale' agar riwayat tidak membingungkan.
     */
    public function find_running($ttl_seconds)
    {
        $this->db->where('status', 'running');
        $this->db->order_by('started_at', 'DESC');
        $row = $this->db->get('lecturer_sync_logs')->row_array();

        if (!$row) return null;

        $started = strtotime($row['started_at']);
        if ($started !== false && (time() - $started) > (int) $ttl_seconds) {
            $this->db->where('id', $row['id'])->update('lecturer_sync_logs', array(
                'status' => 'stale',
                'finished_at' => date('Y-m-d H:i:s'),
                'error_message' => 'Proses macet (melebihi TTL) — ditandai stale otomatis.',
            ));
            return null;
        }

        return $row;
    }

    public function finish($id, $data)
    {
        $data['finished_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id)->update('lecturer_sync_logs', $data);
    }

    public function latest()
    {
        return $this->db->order_by('id', 'DESC')->get('lecturer_sync_logs')->row_array();
    }

    public function recent($limit = 10)
    {
        return $this->db->order_by('id', 'DESC')->limit((int) $limit)->get('lecturer_sync_logs')->result_array();
    }
}
