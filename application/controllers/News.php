<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    private function _category_name_select($lang) {
        $e = $this->db->escape($lang);
        return "n.*, COALESCE((SELECT c2.name FROM news_categories c2 WHERE c2.translation_group_id = (SELECT c1.translation_group_id FROM news_categories c1 WHERE c1.id = n.category_id) AND c2.lang = $e), nc.name) as category_name, u.username as author_name";
    }

    public function index()
    {
        $this->load->helper('text');
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $lang = current_lang();
        $page = $this->input->get('page') ?: 1;
        $per_page = 6;
        $offset = ($page - 1) * $per_page;

        $data['title'] = lang('news');
        $data['active_nav'] = 'berita';
        $data['settings'] = $settings;

        $data['news'] = $this->db
            ->select($this->_category_name_select($lang), FALSE)
            ->from('news n')
            ->join('news_categories nc', 'n.category_id = nc.id', 'left')
            ->join('users u', 'n.created_by = u.id', 'left')
            ->where('n.is_draft', 0)
            ->where('n.lang', $lang)
            ->order_by('n.published_at', 'DESC')
            ->limit($per_page, $offset)
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
                ->limit($per_page, $offset)
                ->get()->result_array();
        }

        $total = $this->db
            ->where('is_draft', 0)
            ->where('lang', $lang)
            ->count_all_results('news');

        if ($total === 0 && $lang !== 'id') {
            $total = $this->db
                ->where('is_draft', 0)
                ->where('lang', 'id')
                ->count_all_results('news');
        }

        $data['pagination'] = array(
            'page' => $page,
            'per_page' => $per_page,
            'total' => $total,
            'total_pages' => ceil($total / $per_page),
        );

        $data['categories'] = $this->db->where('is_active', 1)->where('lang', $lang)->get('news_categories')->result_array();
        if (empty($data['categories']) && $lang !== 'id') {
            $data['categories'] = $this->db->where('is_active', 1)->where('lang', 'id')->get('news_categories')->result_array();
        }

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/news/index', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }

    public function category($slug)
    {
        $this->load->helper('text');
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $lang = current_lang();
        $cat = $this->db->where('slug', $slug)->where('is_active', 1)->get('news_categories')->row_array();
        if (!$cat) show_404();
        // use ID category ID for filtering (news records always reference the ID category)
        $filter_cat_id = $cat['id'];
        if ($cat['lang'] !== 'id' && !empty($cat['translation_group_id'])) {
            $id_cat = $this->db->select('id')
                ->from('news_categories')
                ->where('translation_group_id', $cat['translation_group_id'])
                ->where('lang', 'id')
                ->get()->row_array();
            if ($id_cat) $filter_cat_id = $id_cat['id'];
        }

        $page = $this->input->get('page') ?: 1;
        $per_page = 6;
        $offset = ($page - 1) * $per_page;

        $data['title'] = lang('news') . ': ' . $cat['name'];
        $data['active_nav'] = 'berita';
        $data['settings'] = $settings;

        $data['news'] = $this->db
            ->select($this->_category_name_select($lang), FALSE)
            ->from('news n')
            ->join('news_categories nc', 'n.category_id = nc.id', 'left')
            ->join('users u', 'n.created_by = u.id', 'left')
            ->where('n.is_draft', 0)
            ->where('n.lang', $lang)
            ->where('n.category_id', $filter_cat_id)
            ->order_by('n.published_at', 'DESC')
            ->limit($per_page, $offset)
            ->get()->result_array();

        if (empty($data['news']) && $lang !== 'id') {
            $data['news'] = $this->db
                ->select($this->_category_name_select($lang), FALSE)
                ->from('news n')
                ->join('news_categories nc', 'n.category_id = nc.id', 'left')
                ->join('users u', 'n.created_by = u.id', 'left')
                ->where('n.is_draft', 0)
                ->where('n.lang', 'id')
                ->where('n.category_id', $filter_cat_id)
                ->order_by('n.published_at', 'DESC')
                ->limit($per_page, $offset)
                ->get()->result_array();
        }

        $total = $this->db
            ->where('is_draft', 0)->where('lang', $lang)->where('category_id', $filter_cat_id)
            ->count_all_results('news');

        if ($total === 0 && $lang !== 'id') {
            $total = $this->db
                ->where('is_draft', 0)->where('lang', 'id')->where('category_id', $filter_cat_id)
                ->count_all_results('news');
        }

        $data['pagination'] = array(
            'page' => $page, 'per_page' => $per_page, 'total' => $total,
            'total_pages' => ceil($total / $per_page),
        );
        $data['current_category'] = $cat;
        $data['categories'] = $this->db->where('is_active', 1)->where('lang', $lang)->get('news_categories')->result_array();
        if (empty($data['categories']) && $lang !== 'id') {
            $data['categories'] = $this->db->where('is_active', 1)->where('lang', 'id')->get('news_categories')->result_array();
        }

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/news/index', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }

    public function detail($slug)
    {
        $this->load->helper('text');
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $lang = current_lang();
        $item = $this->db
            ->select($this->_category_name_select($lang), FALSE)
            ->from('news n')
            ->join('news_categories nc', 'n.category_id = nc.id', 'left')
            ->join('users u', 'n.created_by = u.id', 'left')
            ->where('n.slug', $slug)
            ->where('n.lang', $lang)
            ->where('n.is_draft', 0)
            ->get()->row_array();

        if (!$item && $lang !== 'id') {
            $item = $this->db
                ->select($this->_category_name_select($lang), FALSE)
                ->from('news n')
                ->join('news_categories nc', 'n.category_id = nc.id', 'left')
                ->join('users u', 'n.created_by = u.id', 'left')
                ->where('n.slug', $slug)
                ->where('n.lang', 'id')
                ->where('n.is_draft', 0)
                ->get()->row_array();
        }
        if (!$item) show_404();

        $this->db->where('translation_group_id', $item['translation_group_id'])
            ->set('view_count', 'view_count+1', FALSE)->update('news');

        $data['title'] = $item['title'];
        $data['active_nav'] = 'berita';
        $data['settings'] = $settings;
        $data['news'] = $item;
        $data['meta_description'] = $item['seo_description'] ?: character_limiter(strip_tags($item['content']), 160);
        $data['og_title'] = $item['title'];
        $data['og_type'] = 'article';
        $data['og_image'] = $item['thumbnail'] ? base_url('uploads/' . $item['thumbnail']) : '';

        $data['recent'] = $this->db
            ->where('is_draft', 0)->where('lang', $lang)
            ->where('translation_group_id !=', $item['translation_group_id'])
            ->order_by('published_at', 'DESC')
            ->limit(3)->get('news')->result_array();

        if (empty($data['recent']) && $lang !== 'id') {
            $data['recent'] = $this->db
                ->where('is_draft', 0)->where('lang', 'id')
                ->where('translation_group_id !=', $item['translation_group_id'])
                ->order_by('published_at', 'DESC')
                ->limit(3)->get('news')->result_array();
        }

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/news/detail', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }
}
