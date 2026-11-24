<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private function _category_name_select($lang) {
        $e = $this->db->escape($lang);
        return "n.*, COALESCE((SELECT c2.name FROM news_categories c2 WHERE c2.translation_group_id = (SELECT c1.translation_group_id FROM news_categories c1 WHERE c1.id = n.category_id) AND c2.lang = $e), nc.name) as category_name, u.username as author_name";
    }

    public function index()
    {
        $lang = current_lang();

        $this->load->helper(array('text', 'image'));
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $data['title'] = 'Beranda';
        $data['active_nav'] = 'home';
        $data['settings'] = $settings;

        $data['news'] = $this->db
            ->select($this->_category_name_select($lang), FALSE)
            ->from('news n')
            ->join('news_categories nc', 'n.category_id = nc.id', 'left')
            ->join('users u', 'n.created_by = u.id', 'left')
            ->where('n.is_draft', 0)
            ->where('n.lang', $lang)
            ->order_by('n.published_at', 'DESC')
            ->limit(3)
            ->get()->result_array();

        if (empty($data['news']) && $lang !== 'id') {
            $data['news'] = $this->db
                ->select($this->_category_name_select($lang), FALSE)
                ->from('news n')
                ->join('news_categories nc', 'n.category_id = nc.id', 'left')
                ->join('users u', 'n.created_by = u.id', 'left')
                ->where('n.is_draft', 0)
                ->where('n.lang', 'id')
                ->order_by('n.published_at', 'DESC')
                ->limit(3)
                ->get()->result_array();
        }

        $data['lecturers'] = $this->db
            ->where('is_active', 1)
            ->where('lang', $lang)
            ->order_by('sort_order', 'ASC')
            ->limit(4)
            ->get('lecturers')->result_array();

        if (empty($data['lecturers']) && $lang !== 'id') {
            $data['lecturers'] = $this->db
                ->where('is_active', 1)
                ->where('lang', 'id')
                ->order_by('sort_order', 'ASC')
                ->limit(4)
                ->get('lecturers')->result_array();
        }

   $data['galleries'] = $this->db
            ->where('is_active', 1)
            ->where('lang', $lang)
            ->order_by('created_at', 'DESC')
            ->limit(6)
            ->get('galleries')->result_array();

        if (empty($data['galleries']) && $lang !== 'id') {
            $data['galleries'] = $this->db
                ->where('is_active', 1)
                ->where('lang', 'id')
                ->order_by('created_at', 'DESC')
                ->limit(6)
                ->get('galleries')->result_array();
        }

        // Gallery photos live under the Indonesian-language row's id. Map each
        // displayed gallery to its Indonesian partner so the cover shows in
        // every language, preferring the admin-set cover_image.
        if (!empty($data['galleries'])) {
            $id_gid_map = [];
            foreach ($data['galleries'] as &$gal) {
                $gallery_id = $gal['id'];
                if ($gal['lang'] !== 'id' && !empty($gal['translation_group_id'])) {
                    if (!isset($id_gid_map[$gal['translation_group_id']])) {
                        $id_row = $this->db->select('id')->from('galleries')
                            ->where('translation_group_id', $gal['translation_group_id'])
                            ->where('lang', 'id')->get()->row_array();
                        $id_gid_map[$gal['translation_group_id']] = $id_row ? $id_row['id'] : $gal['id'];
                    }
                    $gallery_id = $id_gid_map[$gal['translation_group_id']];
                }
                $gal['cover'] = null;
                if (!empty($gal['cover_image'])) {
                    $gal['cover'] = array('image' => $gal['cover_image']);
                } else {
                    $first_img = $this->db->select('image')->from('gallery_images')
                        ->where('gallery_id', $gallery_id)
                        ->order_by('sort_order', 'ASC')->limit(1)->get()->row_array();
                    if ($first_img) $gal['cover'] = array('image' => $first_img['image']);
                }
            }
            unset($gal);
        }


        $total_lecturers = $this->db->where('is_active', 1)->where('lang', $lang)->count_all_results('lecturers');
        if (!$total_lecturers && $lang !== 'id') {
            $total_lecturers = $this->db->where('is_active', 1)->where('lang', 'id')->count_all_results('lecturers');
        }

        $total_agenda = $this->db->where('lang', $lang)->count_all_results('agendas');
        if (!$total_agenda && $lang !== 'id') {
            $total_agenda = $this->db->where('lang', 'id')->count_all_results('agendas');
        }

        $total_berita = $this->db->where('is_draft', 0)->where('lang', $lang)->count_all_results('news');
        if (!$total_berita && $lang !== 'id') {
            $total_berita = $this->db->where('is_draft', 0)->where('lang', 'id')->count_all_results('news');
        }

        $data['stats'] = array(
            'total_lecturers' => $total_lecturers,
            'total_students' => isset($settings['stats_students']) ? $settings['stats_students'] : '500+',
            'total_alumni' => isset($settings['stats_alumni']) ? $settings['stats_alumni'] : '1200+',
            'total_agenda' => $total_agenda ?: '0',
            'total_berita' => $total_berita ?: '0',
        );

        $data['banners'] = $this->db
            ->where('is_active', 1)->where('lang', $lang)
            ->order_by('sort_order', 'ASC')
            ->get('banners')->result_array();
        if (empty($data['banners']) && $lang !== 'id') {
            $data['banners'] = $this->db
                ->where('is_active', 1)->where('lang', 'id')
                ->order_by('sort_order', 'ASC')
                ->get('banners')->result_array();
        }

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

        $data['about_prodi'] = $this->db
            ->where('lang', $lang)
            ->get('study_programs')
            ->row_array();
        if (!$data['about_prodi'] && $lang !== 'id') {
            $data['about_prodi'] = $this->db
                ->where('lang', 'id')
                ->get('study_programs')
                ->row_array();
        }
        if (!empty($data['about_prodi']) && $lang !== 'id') {
            $prodi_id = $this->db->where('lang', 'id')->where('translation_group_id', $data['about_prodi']['translation_group_id'])->get('study_programs')->row_array();
            if ($prodi_id) {
                foreach (['thumbnail', 'video_url', 'accreditation'] as $f) {
                    if (empty($data['about_prodi'][$f]) && !empty($prodi_id[$f])) $data['about_prodi'][$f] = $prodi_id[$f];
                }
            }
        }

        $data['agendas'] = $this->db
            ->where('lang', $lang)
            ->order_by('start_date', 'DESC')
            ->limit(4)
            ->get('agendas')->result_array();
        if (empty($data['agendas']) && $lang !== 'id') {
            $data['agendas'] = $this->db
                ->where('lang', 'id')
                ->order_by('start_date', 'DESC')
                ->limit(4)
                ->get('agendas')->result_array();
        }

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/home/index', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }

    public function search()
    {
        $lang = current_lang();

        $q = substr($this->input->get('q'), 0, 100);
        if (!$q) redirect('/');

        $this->load->helper('text');
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $data['title'] = 'Pencarian: ' . $q;
        $data['active_nav'] = '';
        $data['settings'] = $settings;
        $data['query'] = $q;

        $data['news'] = $this->db
            ->select($this->_category_name_select($lang), FALSE)
            ->from('news n')
            ->join('news_categories nc', 'n.category_id = nc.id', 'left')
            ->join('users u', 'n.created_by = u.id', 'left')
            ->where('n.is_draft', 0)
            ->where('n.lang', $lang)
            ->group_start()
            ->like('n.title', $q)
            ->or_like('n.content', $q)
            ->group_end()
            ->order_by('n.published_at', 'DESC')
            ->get()->result_array();

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/home/search', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }
}
