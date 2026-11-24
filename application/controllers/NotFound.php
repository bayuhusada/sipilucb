<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotFound extends CI_Controller {

    public function index()
    {
        $this->load->model('setting_model');
        $data['title'] = '404 - Halaman Tidak Ditemukan';
        $data['settings'] = $this->setting_model->get_all_lang(current_lang());

        $this->output->set_status_header(404);

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/errors/404', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }
}
