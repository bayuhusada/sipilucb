<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agendas extends CI_Controller {

    public function index()
    {
        $this->load->helper('text');
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $lang = current_lang();

        $data['title'] = 'Agenda';
        $data['active_nav'] = 'agenda';
        $data['settings'] = $settings;

        $this->load->library('pagination');
        $config['base_url'] = base_url('agenda');
        $config['total_rows'] = $this->db
            ->where('is_active', 1)->where('lang', $lang)
            ->count_all_results('agendas');
        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['attributes'] = array('class' => 'pagination-link');
        $config['cur_tag_open'] = '<span class="pagination-link active">';
        $config['cur_tag_close'] = '</span>';
        $this->pagination->initialize($config);

        $page = $this->input->get('page') ? (int) $this->input->get('page') : 0;

        $data['agendas'] = $this->db
            ->where('is_active', 1)
            ->where('lang', $lang)
            ->order_by('start_date', 'DESC')
            ->limit($config['per_page'], $page)
            ->get('agendas')->result_array();

        if (empty($data['agendas']) && $lang !== 'id') {
            $data['agendas'] = $this->db
                ->where('is_active', 1)
                ->where('lang', 'id')
                ->order_by('start_date', 'DESC')
                ->limit($config['per_page'], $page)
                ->get('agendas')->result_array();
        }

        $data['pagination_links'] = $this->pagination->create_links();

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/agendas/index', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }
}
