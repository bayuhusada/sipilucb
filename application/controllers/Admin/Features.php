<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Features extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role('superadmin');
        $this->load->model('setting_model');
    }

    public function index()
    {
        $this->data['title'] = 'Program Unggulan';
        $this->data['settings'] = $this->setting_model->get_all();

        if ($this->input->method() === 'post') {
            $this->_save();
            $this->session->set_flashdata('success', 'Program unggulan berhasil disimpan.');
            redirect('admin/features');
        }

        $this->load->helper('lang');
        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/features/index', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    private function _save()
    {
        $fields = array();
        for ($i = 1; $i <= 6; $i++) {
            $fields[] = 'feature_' . $i . '_title';
            $fields[] = 'feature_' . $i . '_desc';
        }

        foreach ($fields as $field) {
            foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                $val = $this->input->post($field . '_' . $lang);
                $this->setting_model->set($field . '_' . $lang, $val);
            }
        }

        for ($i = 1; $i <= 6; $i++) {
            $icon = $this->input->post('feature_' . $i . '_icon');
            if ($icon) {
                $this->setting_model->set('feature_' . $i . '_icon', $icon);
            }
        }
    }
}