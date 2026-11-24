<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('superadmin', 'admin', 'admin_berita'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['title'] = 'Berita';
        $this->data['news'] = $this->db->select('n.*, nc.name as category_name, GROUP_CONCAT(t.lang ORDER BY t.lang SEPARATOR \',\') as lang_list')
            ->from('news n')
            ->join('news_categories nc', 'n.category_id = nc.id', 'left')
            ->join('news t', 'n.translation_group_id = t.translation_group_id', 'left')
            ->where('n.lang', 'id')
            ->group_by('n.id')
            ->order_by('n.created_at', 'DESC')
            ->get()->result_array();

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/news/list', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function create()
    {
        $this->data['title'] = 'Tulis Berita';
        $this->data['categories'] = $this->db->where('is_active', 1)->where('lang', 'id')->get('news_categories')->result_array();
        $this->data['translations'] = [];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title_id', 'Judul (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $tgid = $this->_next_tgid();
                $now = date('Y-m-d H:i:s');
                $slug = url_title($this->input->post('title_id'), 'dash', true);
                $thumbnail = null;

                if (!empty($_FILES['thumbnail']['name'])) {
                    $thumb = $this->_upload('thumbnail');
                    if ($thumb) $thumbnail = $thumb;
                }

                $category_id = $this->input->post('category_id');
                $is_draft = $this->input->post('is_draft') ? 1 : 0;
                $is_highlight = $this->input->post('is_highlight') ? 1 : 0;

                $this->db->trans_start();

                $id_saved = false;
                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $title = $this->input->post('title_' . $lang);
                    if (empty($title)) continue;

                    $this->db->insert('news', array(
                        'translation_group_id' => $tgid,
                        'lang' => $lang,
                        'created_by' => $this->user['id'],
                        'category_id' => $category_id,
                        'title' => $title,
                        'slug' => $slug,
                        'content' => $this->input->post('content_' . $lang, true),
                        'source_url' => $this->input->post('source_url_' . $lang),
                        'thumbnail' => $thumbnail,
                        'is_draft' => $is_draft,
                        'is_highlight' => $is_highlight,
                        'seo_title' => $this->input->post('seo_title_' . $lang),
                        'seo_description' => $this->input->post('seo_description_' . $lang),
                        'published_at' => $is_draft ? null : $now,
                    ));
                    if ($lang === 'id') $id_saved = true;
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->_maybe_unlink($thumbnail);
                    $this->session->set_flashdata('error', 'Gagal menyimpan berita.');
                    redirect('admin/news');
                }

                if ($id_saved) {
                    $this->_auto_translate_multi('news', $tgid, array(
                        'title' => $this->input->post('title_id'),
                        'content' => $this->input->post('content_id', true),
                        'source_url' => $this->input->post('source_url_id'),
                        'seo_title' => $this->input->post('seo_title_id'),
                        'seo_description' => $this->input->post('seo_description_id'),
                    ), array('en', 'cn', 'de', 'ja'), 'title');
                }

                $this->session->set_flashdata('success', 'Berita berhasil disimpan.');
                redirect('admin/news');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/news/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function edit($id)
    {
        $item = $this->db->where('id', $id)->get('news')->row_array();
        if (!$item) show_404();

        $this->_ensure_tgid('news', $item);

        $this->data['title'] = 'Edit Berita';
        $this->data['row'] = $item;
        $this->data['categories'] = $this->db->where('is_active', 1)->where('lang', 'id')->get('news_categories')->result_array();
        $this->data['translations'] = $this->_load_translations('news', $item['translation_group_id']);

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title_id', 'Judul (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $now = date('Y-m-d H:i:s');
                $thumbnail = $item['thumbnail'];
                $existing_langs = array_keys($this->data['translations']);

                if (!empty($_FILES['thumbnail']['name'])) {
                    $thumb = $this->_upload('thumbnail');
                    if ($thumb) {
                        $this->_maybe_unlink($item['thumbnail']);
                        $thumbnail = $thumb;
                    }
                }

                $category_id = $this->input->post('category_id');
                $is_draft = $this->input->post('is_draft') ? 1 : 0;
                $is_highlight = $this->input->post('is_highlight') ? 1 : 0;

                $this->db->trans_start();

                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $title = $this->input->post('title_' . $lang);
                    if (empty($title)) continue;

                    $data = array(
                        'category_id' => $category_id,
                        'title' => $title,
                        'content' => $this->input->post('content_' . $lang, true),
                        'source_url' => $this->input->post('source_url_' . $lang),
                        'thumbnail' => $thumbnail,
                        'is_draft' => $is_draft,
                        'is_highlight' => $is_highlight,
                        'seo_title' => $this->input->post('seo_title_' . $lang),
                        'seo_description' => $this->input->post('seo_description_' . $lang),
                        'published_at' => ($is_draft || $item['published_at']) ? $item['published_at'] : $now,
                    );

                    if (in_array($lang, $existing_langs)) {
                        $this->db->where('translation_group_id', $item['translation_group_id'])
                            ->where('lang', $lang)
                            ->update('news', $data);
                    } else {
                        $data['translation_group_id'] = $item['translation_group_id'];
                        $data['lang'] = $lang;
                        $data['created_by'] = $this->user['id'];
                        $data['slug'] = $item['slug'];
                        $this->db->insert('news', $data);
                    }
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal memperbarui berita.');
                    redirect('admin/news');
                }

                $this->_auto_translate_multi('news', $item['translation_group_id'], array(
                    'title' => $this->input->post('title_id'),
                    'content' => $this->input->post('content_id', true),
                    'source_url' => $this->input->post('source_url_id'),
                    'seo_title' => $this->input->post('seo_title_id'),
                    'seo_description' => $this->input->post('seo_description_id'),
                ), array('en', 'cn', 'de', 'ja'), 'title', true);

                $this->session->set_flashdata('success', 'Berita berhasil diperbarui.');
                redirect('admin/news');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/news/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function delete($id)
    {
        if ($this->input->method() !== 'post') show_404();

        $item = $this->db->where('id', $id)->get('news')->row_array();
        if (!$item) show_404();

        $this->db->trans_start();
        $this->_maybe_unlink($item['thumbnail']);
        $this->_delete_translation_group('news', $item['translation_group_id']);
        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Berita berhasil dihapus.');
        redirect('admin/news');
    }

    public function publish($id)
    {
        if ($this->input->method() !== 'post') show_404();

        $item = $this->db->where('id', $id)->get('news')->row_array();
        if (!$item) show_404();

        $this->_ensure_tgid('news', $item);

        $now = date('Y-m-d H:i:s');

        $this->db->trans_start();
        $this->db->where('translation_group_id', $item['translation_group_id'])
            ->update('news', array('is_draft' => 0, 'published_at' => $now));
        $this->db->trans_complete();

        redirect('admin/news');
    }

    private function _upload($field)
    {
        $config = array(
            'upload_path' => FCPATH . 'uploads/',
            'allowed_types' => 'jpg|jpeg|png|gif|webp',
            'max_size' => 2048,
            'file_name' => 'berita_' . time() . '_' . uniqid()
        );
        $this->load->library('upload', $config);
        $this->load->helper('image');
        if ($this->upload->do_upload($field)) {
            $fname = $this->upload->data('file_name');
            compress_image(FCPATH . 'uploads/' . $fname, 1200, 900, 80);
            return $fname;
        }
        return null;
    }
}
