<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Downloads extends CI_Controller {

    public function index()
    {
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $lang = current_lang();

        $data['title'] = 'Download';
        $data['active_nav'] = 'download';
        $data['settings'] = $settings;
        $data['search'] = substr($this->input->get('q'), 0, 100);

        $this->db->where('is_active', 1)->where('lang', $lang);
        if ($q = $data['search']) {
            $this->db->group_start()
                ->like('title', $q)
                ->or_like('description', $q)
                ->group_end();
        }
        $data['files'] = $this->db
            ->order_by('created_at', 'DESC')
            ->get('downloads')->result_array();

        if (empty($data['files']) && $lang !== 'id') {
            $this->db->where('is_active', 1)->where('lang', 'id');
            if ($q = $data['search']) {
                $this->db->group_start()
                    ->like('title', $q)
                    ->or_like('description', $q)
                    ->group_end();
            }
            $data['files'] = $this->db
                ->order_by('created_at', 'DESC')
                ->get('downloads')->result_array();
        }

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/downloads/index', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }

    public function increment($id)
    {
        $this->db->where('id', $id)->set('download_count', 'download_count+1', FALSE)->update('downloads');
    }
}
