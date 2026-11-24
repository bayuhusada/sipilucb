<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sweeper extends MY_Controller {

    protected $_protected = array('.htaccess', 'index.html');

    public function __construct()
    {
        parent::__construct();
        $this->require_role('superadmin');
    }

    public function index()
    {
        $this->data['title'] = 'Pembersih File Yatim';
        $this->data['referenced'] = $this->_referenced_files();
        $orphans = $this->_find_orphans($this->data['referenced']);

        $total_bytes = 0;
        foreach ($orphans as $o) $total_bytes += $o['size'];

        $this->data['orphans'] = $orphans;
        $this->data['total_orphans'] = count($orphans);
        $this->data['total_bytes'] = $total_bytes;

        if ($this->input->method() === 'post') {
            $deleted = 0;
            $bytes = 0;
            foreach ($orphans as $o) {
                $path = FCPATH . 'uploads/' . $o['file'];
                if (@unlink($path)) {
                    $deleted++;
                    $bytes += $o['size'];
                }
            }
            $mb = number_format($bytes / 1048576, 2);
            $this->session->set_flashdata('success', $deleted . ' file yatim dihapus (' . $mb . ' MB).');
            redirect('admin/sweeper');
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/sweeper/list', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    private function _referenced_files()
    {
        $refs = array();
        $settings_rows = $this->db->select('setting_key, setting_value')->get('settings')->result_array();
        foreach ($settings_rows as $r) {
            if (in_array($r['setting_key'], array('site_logo', 'site_favicon'), true)) {
                $v = trim((string)$r['setting_value']);
                if ($v !== '') $refs[$v] = true;
            }
        }
        $map = array(
            'news'            => array('thumbnail'),
            'banners'         => array('image'),
            'downloads'       => array('file_path'),
            'study_programs'  => array('thumbnail'),
            'lecturers'       => array('photo', 'cv_file'),
            'galleries'       => array('cover_image'),
            'gallery_images'  => array('image'),
        );
        foreach ($map as $table => $columns) {
            foreach ($columns as $col) {
                $rows = $this->db->select($col)->get($table)->result_array();
                foreach ($rows as $r) {
                    $v = trim((string)$r[$col]);
                    if ($v !== '') $refs[$v] = true;
                }
            }
        }
        return array_keys($refs);
    }

    private function _find_orphans($referenced)
    {
        $referenced = array_flip($referenced);
        $orphans = array();
        foreach (glob(FCPATH . 'uploads/*') as $path) {
            if (!is_file($path)) continue;
            $name = pathinfo($path, PATHINFO_BASENAME);
            if (in_array($name, $this->_protected, true)) continue;
            if (isset($referenced[$name])) continue;
            $orphans[] = array('file' => $name, 'size' => (int)@filesize($path));
        }
        usort($orphans, function ($a, $b) { return $b['size'] - $a['size']; });
        return $orphans;
    }
}
