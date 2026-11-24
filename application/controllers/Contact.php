<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    public function index()
    {
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $data['title'] = 'Kontak';
        $data['active_nav'] = 'kontak';
        $data['settings'] = $settings;

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/contact/index', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }
}
