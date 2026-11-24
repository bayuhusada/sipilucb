<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller {

    public function index()
    {
        $lang = current_lang();

        $this->load->helper('image');
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $faculty = $this->db->get('faculties')->row_array();
        if (!$faculty) $faculty = array('name' => 'Teknik Sipil');

        $prodi = $this->db
            ->where('lang', $lang)
            ->get('study_programs')
            ->row_array();
        if (!$prodi) {
            $prodi = $this->db
                ->where('lang', 'id')
                ->get('study_programs')
                ->row_array();
        }
        if ($prodi && $lang !== 'id') {
            $prodi_id = $this->db->where('lang', 'id')->where('translation_group_id', $prodi['translation_group_id'])->get('study_programs')->row_array();
            if ($prodi_id) {
                foreach (['thumbnail', 'video_url', 'accreditation'] as $f) {
                    if (empty($prodi[$f]) && !empty($prodi_id[$f])) $prodi[$f] = $prodi_id[$f];
                }
            }
        }

        $data['title'] = 'Tentang';
        $data['active_nav'] = 'tentang';
        $data['settings'] = $settings;
        $data['faculty'] = $faculty;
        $data['prodi'] = $prodi ?: array();

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/about/index', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }
}
