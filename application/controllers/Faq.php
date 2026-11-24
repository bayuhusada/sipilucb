<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

    public function index()
    {
        $lang = current_lang();

        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang($lang);

        $data['title'] = lang('faq');
        $data['active_nav'] = 'faq';
        $data['settings'] = $settings;

        $data['faqs'] = $this->db
            ->where('is_active', 1)->where('lang', $lang)
            ->order_by('sort_order', 'ASC')
            ->get('faqs')->result_array();

        if (empty($data['faqs']) && $lang !== 'id') {
            $data['faqs'] = $this->db
                ->where('is_active', 1)->where('lang', 'id')
                ->order_by('sort_order', 'ASC')
                ->get('faqs')->result_array();
        }

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/faq/index', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }
}