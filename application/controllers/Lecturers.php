<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lecturers extends CI_Controller {

    public function index()
    {
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $lang = current_lang();
        $data['title'] = 'Dosen';
        $data['active_nav'] = 'dosen';
        $data['settings'] = $settings;
        $search = substr($this->input->get('q'), 0, 100);
        $data['search'] = $search;

        $this->load->library('pagination');

        $this->db->from('lecturers l');
        $this->db->where('l.is_active', 1);
        $this->db->where('l.lang', $lang);
        if ($search) {
            $this->db->group_start()
                ->like('l.name', $search)
                ->or_like('l.nidn', $search)
                ->or_like('l.position', $search)
                ->or_like('l.front_title', $search)
                ->or_like('l.back_title', $search)
                ->group_end();
        }
        $total = $this->db->count_all_results();

        if ($total === 0 && $lang !== 'id') {
            $this->db->from('lecturers l');
            $this->db->where('l.is_active', 1);
            $this->db->where('l.lang', 'id');
            if ($search) {
                $this->db->group_start()
                    ->like('l.name', $search)
                    ->or_like('l.nidn', $search)
                    ->or_like('l.position', $search)
                    ->or_like('l.front_title', $search)
                    ->or_like('l.back_title', $search)
                    ->group_end();
            }
            $total = $this->db->count_all_results();
        }

        $config['base_url'] = base_url('dosen');
        $config['total_rows'] = $total;
        $config['per_page'] = 12;
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

        $this->db->select('l.*');
        $this->db->from('lecturers l');
        $this->db->where('l.is_active', 1);
        $this->db->where('l.lang', $lang);
        if ($search) {
            $this->db->group_start()
                ->like('l.name', $search)
                ->or_like('l.nidn', $search)
                ->or_like('l.position', $search)
                ->or_like('l.front_title', $search)
                ->or_like('l.back_title', $search)
                ->group_end();
        }
        $data['lecturers'] = $this->db
            ->order_by('l.sort_order', 'ASC')
            ->limit($config['per_page'], $page)
            ->get()->result_array();

        if (empty($data['lecturers']) && $lang !== 'id') {
            $this->db->select('l.*');
            $this->db->from('lecturers l');
            $this->db->where('l.is_active', 1);
            $this->db->where('l.lang', 'id');
            if ($search) {
                $this->db->group_start()
                    ->like('l.name', $search)
                    ->or_like('l.nidn', $search)
                    ->or_like('l.position', $search)
                    ->or_like('l.front_title', $search)
                    ->or_like('l.back_title', $search)
                    ->group_end();
            }
            $data['lecturers'] = $this->db
                ->order_by('l.sort_order', 'ASC')
                ->limit($config['per_page'], $page)
                ->get()->result_array();
        }

        $data['pagination_links'] = $this->pagination->create_links();

        if (!empty($data['lecturers'])) {
            $need_photo = [];
            foreach ($data['lecturers'] as $l) {
                if (!$l['photo'] && !empty($l['translation_group_id'])) {
                    $need_photo[$l['translation_group_id']] = true;
                }
            }
            if ($need_photo) {
                $fb_map = [];
                $r = $this->db->select('translation_group_id, photo')
                    ->from('lecturers')
                    ->where_in('translation_group_id', array_keys($need_photo))
                    ->where('lang', 'id')
                    ->where('photo IS NOT NULL')
                    ->get()->result_array();
                foreach ($r as $fb) {
                    $fb_map[$fb['translation_group_id']] = $fb['photo'];
                }
                foreach ($data['lecturers'] as &$l) {
                    if (!$l['photo'] && isset($fb_map[$l['translation_group_id']])) {
                        $l['photo'] = $fb_map[$l['translation_group_id']];
                    }
                }
            }
        }

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/lecturers/index', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }

    public function detail($slug)
    {
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $lang = current_lang();

        $lecturer = $this->db
            ->select('l.*')
            ->from('lecturers l')
            ->where('l.slug', $slug)
            ->where('l.lang', $lang)
            ->where('l.is_active', 1)
            ->get()->row_array();

        if (!$lecturer && $lang !== 'id') {
            $lecturer = $this->db
                ->select('l.*')
                ->from('lecturers l')
                ->where('l.slug', $slug)
                ->where('l.lang', 'id')
                ->where('l.is_active', 1)
                ->get()->row_array();
        }

        if (!$lecturer) show_404();

        if (!$lecturer['photo'] && !empty($lecturer['translation_group_id'])) {
            $fb = $this->db->select('photo')
                ->from('lecturers')
                ->where('translation_group_id', $lecturer['translation_group_id'])
                ->where('lang', 'id')
                ->where('photo IS NOT NULL')
                ->get()->row_array();
            if ($fb) $lecturer['photo'] = $fb['photo'];
        }

        $data['title'] = $lecturer['name'];
        $data['active_nav'] = 'dosen';
        $data['settings'] = $settings;
        $data['lecturer'] = $lecturer;

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/lecturers/detail', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }
}
