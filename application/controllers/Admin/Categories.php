<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('superadmin', 'admin', 'admin_berita'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['title'] = 'Kategori Berita';
        $this->data['categories'] = $this->db
            ->select('nc.*, GROUP_CONCAT(t.lang ORDER BY t.lang SEPARATOR \',\') as lang_list')
            ->from('news_categories nc')
            ->join('news_categories t', 'nc.translation_group_id = t.translation_group_id', 'left')
            ->where('nc.lang', 'id')
            ->group_by('nc.id')
            ->order_by('nc.name', 'ASC')
            ->get()->result_array();

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name_id', 'Nama Kategori', 'required');
            if ($this->form_validation->run()) {
                $name_id = $this->input->post('name_id');
                $slug = url_title($name_id, 'dash', true);
                $tgid = $this->_next_tgid();

                $this->db->trans_start();

                $id_saved = false;
                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $name = $this->input->post('name_' . $lang);
                    if (empty($name)) continue;
                    $this->db->insert('news_categories', array(
                        'translation_group_id' => $tgid,
                        'lang' => $lang,
                        'name' => $name,
                        'slug' => $slug,
                    ));
                    if ($lang === 'id') $id_saved = true;
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal menambahkan kategori.');
                    redirect('admin/categories');
                }

                if ($id_saved) {
                    $this->_auto_translate_multi('news_categories', $tgid, array(
                        'name' => $this->input->post('name_id'),
                    ), array('en', 'cn', 'de', 'ja'), 'name');
                }

                $this->session->set_flashdata('success', 'Kategori berhasil ditambahkan.');
                redirect('admin/categories');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/categories/index', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function edit($id)
    {
        $item = $this->db->where('id', $id)->get('news_categories')->row_array();
        if (!$item) show_404();

        $this->_ensure_tgid('news_categories', $item);

        $this->data['title'] = 'Edit Kategori';
        $this->data['row'] = $item;
        $this->data['translations'] = $this->_load_translations('news_categories', $item['translation_group_id']);

        if ($this->input->method() === 'post') {
            $existing_langs = array_keys($this->data['translations']);

            $this->db->trans_start();

            foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                $name = $this->input->post('name_' . $lang);
                if (empty($name)) continue;

                $data = array('name' => $name);

                if (in_array($lang, $existing_langs)) {
                    $this->db->where('translation_group_id', $item['translation_group_id'])
                        ->where('lang', $lang)
                        ->update('news_categories', $data);
                } else {
                    $data['translation_group_id'] = $item['translation_group_id'];
                    $data['lang'] = $lang;
                    $data['slug'] = $item['slug'];
                    $this->db->insert('news_categories', $data);
                }
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->session->set_flashdata('error', 'Gagal memperbarui kategori.');
                redirect('admin/categories');
            }

                $this->_auto_translate_multi('news_categories', $item['translation_group_id'], array(
                    'name' => $this->input->post('name_id'),
                ), array('en', 'cn', 'de', 'ja'), 'name', true);

                $this->session->set_flashdata('success', 'Kategori berhasil diperbarui.');
            redirect('admin/categories');
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/categories/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function delete($id)
    {
        if ($this->input->method() !== 'post') show_404();

        $item = $this->db->where('id', $id)->get('news_categories')->row_array();
        if (!$item) show_404();
        $this->_ensure_tgid('news_categories', $item);

        $this->db->trans_start();
        $this->_delete_translation_group('news_categories', $item['translation_group_id']);
        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Kategori berhasil dihapus.');
        redirect('admin/categories');
    }
}
