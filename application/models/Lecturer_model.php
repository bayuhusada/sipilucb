<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model untuk tabel lecturers — khusus operasi yang dipakai sinkronisasi SEVIMA.
 */
class Lecturer_model extends CI_Model
{
    protected $langs = array('id', 'en', 'cn', 'de', 'ja');

    /**
     * Baris master (bahasa Indonesia) berdasarkan vendor_id.
     */
    public function get_master_by_vendor_id($vendor_id)
    {
        return $this->db->where('vendor_id', $vendor_id)
            ->where('lang', 'id')
            ->get('lecturers')
            ->row_array();
    }

    /**
     * Semua baris bahasa dalam satu grup terjemahan.
     */
    public function get_group_rows($translation_group_id)
    {
        return $this->db->where('translation_group_id', $translation_group_id)
            ->get('lecturers')
            ->result_array();
    }

    /**
     * Menyisipkan dosen baru: 5 baris bahasa (nama identik, tidak diterjemahkan).
     */
    public function insert_vendor($vendor)
    {
        $tgid = time() . rand(100, 999);
        $slug = $this->unique_slug($vendor['name']);

        foreach ($this->langs as $lang) {
            $this->db->insert('lecturers', array(
                'lang' => $lang,
                'translation_group_id' => $tgid,
                'vendor_id' => $vendor['vendor_id'],
                'name' => $vendor['name'],
                'slug' => $slug,
                'front_title' => $vendor['front_title'],
                'back_title' => $vendor['back_title'],
                'gender' => $vendor['gender'],
                'nidn' => $vendor['nidn'],
                'nip' => $vendor['nip'],
                'position' => $vendor['position'],
                'position_id' => $vendor['position_id'],
                'employment_status' => $vendor['employment_status'],
                'homebase_id' => $vendor['homebase_id'],
                'homebase_name' => $vendor['homebase_name'],
                'phone' => $vendor['phone'],
                'email' => $vendor['email'],
                'is_active' => $vendor['is_active'],
                'vendor_created_at' => $vendor['vendor_created_at'],
                'vendor_updated_at' => $vendor['vendor_updated_at'],
                'synced_at' => date('Y-m-d H:i:s'),
                'sort_order' => 0,
            ));
        }

        return $tgid;
    }

    /**
     * Memperbarui HANYA field vendor pada semua baris grup.
     * Field konten website (photo, slug, expertise, dll.) tidak disentuh.
     */
    public function update_vendor_fields($rows, $vendor)
    {
        $data = array(
            'name' => $vendor['name'],
            'front_title' => $vendor['front_title'],
            'back_title' => $vendor['back_title'],
            'gender' => $vendor['gender'],
            'nidn' => $vendor['nidn'],
            'nip' => $vendor['nip'],
            'position' => $vendor['position'],
            'position_id' => $vendor['position_id'],
            'employment_status' => $vendor['employment_status'],
            'homebase_id' => $vendor['homebase_id'],
            'homebase_name' => $vendor['homebase_name'],
            'phone' => $vendor['phone'],
            'email' => $vendor['email'],
            'is_active' => $vendor['is_active'],
            'vendor_updated_at' => $vendor['vendor_updated_at'],
            'synced_at' => date('Y-m-d H:i:s'),
        );

        foreach ($rows as $row) {
            $this->db->where('id', $row['id'])->update('lecturers', $data);
        }
    }

    /**
     * Slug unik berbasis nama (hindari duplikat dengan data manual).
     */
    public function unique_slug($name)
    {
        $base = url_title($name, 'dash', true);
        if ($base === '') $base = 'dosen';

        $slug = $base;
        $i = 2;
        while ($this->db->where('slug', $slug)->count_all_results('lecturers') > 0) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }
}
