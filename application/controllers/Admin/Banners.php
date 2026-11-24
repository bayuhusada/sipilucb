<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banners extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('superadmin', 'admin', 'admin_berita'));
    }

    public function index()
    {
        $this->data['title'] = 'Banner';
        $this->data['banners'] = $this->db->select('b.*, GROUP_CONCAT(t.lang ORDER BY t.lang SEPARATOR \',\') as lang_list')
            ->from('banners b')
            ->join('banners t', 'b.translation_group_id = t.translation_group_id', 'left')
            ->where('b.lang', 'id')
            ->group_by('b.id')
            ->order_by('b.sort_order', 'ASC')
            ->get()->result_array();

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/banners/list', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function create()
    {
        $this->data['title'] = 'Tambah Banner';
        $this->data['translations'] = [];

        if ($this->input->method() === 'post') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title_id', 'Judul (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $tgid = $this->_next_tgid();
                $image = null;

                if (!empty($_FILES['image']['name'])) {
                    $img = $this->_upload();
                    if ($img) $image = $img;
                }

                $this->db->trans_start();

                $id_saved = false;
                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $title = $this->input->post('title_' . $lang);
                    if (empty($title)) continue;

                    $this->db->insert('banners', array(
                        'translation_group_id' => $tgid,
                        'lang' => $lang,
                        'title' => $title,
                        'subtitle' => $this->input->post('subtitle_' . $lang),
                        'image' => $image,
                        'link' => $this->input->post('link'),
                        'sort_order' => $this->input->post('sort_order') ?: 0,
                        'is_active' => $this->input->post('is_active') ? 1 : 0,
                    ));
                    if ($lang === 'id') $id_saved = true;
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->_maybe_unlink($image);
                    $this->session->set_flashdata('error', 'Gagal menambahkan banner.');
                    redirect('admin/banners');
                }

                if ($id_saved) {
                    $this->_auto_translate_multi('banners', $tgid, array(
                        'title' => $this->input->post('title_id'),
                        'subtitle' => $this->input->post('subtitle_id'),
                    ), array('en', 'cn', 'de', 'ja'), 'title');
                }

                $this->session->set_flashdata('success', 'Banner berhasil ditambahkan.');
                redirect('admin/banners');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/banners/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function edit($id)
    {
        $item = $this->db->where('id', $id)->get('banners')->row_array();
        if (!$item) show_404();

        $this->_ensure_tgid('banners', $item);

        $this->data['title'] = 'Edit Banner';
        $this->data['row'] = $item;
        $this->data['translations'] = $this->_load_translations('banners', $item['translation_group_id']);
        $existing_langs = array_keys($this->data['translations']);

        if ($this->input->method() === 'post') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('title_id', 'Judul (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $image = $item['image'];

                if (!empty($_FILES['image']['name'])) {
                    $img = $this->_upload();
                    if ($img) {
                        $this->_maybe_unlink($item['image']);
                        $image = $img;
                    }
                }

                $this->db->trans_start();

                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $title = $this->input->post('title_' . $lang);
                    if (empty($title)) continue;

                    $data = array(
                        'title' => $title,
                        'subtitle' => $this->input->post('subtitle_' . $lang),
                        'image' => $image,
                        'link' => $this->input->post('link'),
                        'sort_order' => $this->input->post('sort_order') ?: 0,
                        'is_active' => $this->input->post('is_active') ? 1 : 0,
                    );

                    if (in_array($lang, $existing_langs)) {
                        $this->db->where('translation_group_id', $item['translation_group_id'])
                            ->where('lang', $lang)
                            ->update('banners', $data);
                    } else {
                        $data['translation_group_id'] = $item['translation_group_id'];
                        $data['lang'] = $lang;
                        $this->db->insert('banners', $data);
                    }
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal memperbarui banner.');
                    redirect('admin/banners');
                }

                $this->_auto_translate_multi('banners', $item['translation_group_id'], array(
                    'title' => $this->input->post('title_id'),
                    'subtitle' => $this->input->post('subtitle_id'),
                ), array('en', 'cn', 'de', 'ja'), 'title', true);

                $this->session->set_flashdata('success', 'Banner berhasil diperbarui.');
                redirect('admin/banners');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/banners/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function delete($id)
    {
        if ($this->input->method() !== 'post') show_404();

        $item = $this->db->where('id', $id)->get('banners')->row_array();
        if (!$item) show_404();

        $translations = $this->_load_translations('banners', $item['translation_group_id']);
        foreach ($translations as $t) {
            $this->_maybe_unlink($t['image']);
        }
        $this->_maybe_unlink($item['image']);

        $this->db->trans_start();
        $this->_delete_translation_group('banners', $item['translation_group_id']);
        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Banner berhasil dihapus.');
        redirect('admin/banners');
    }

    private function _upload()
    {
        $config = array(
            'upload_path' => FCPATH . 'uploads/',
            'allowed_types' => 'jpg|jpeg|png|gif|webp',
            'max_size' => 4096,
            'file_name' => 'banner_' . time() . '_' . uniqid()
        );
        $this->load->library('upload', $config);
        $this->load->helper('image');
        if ($this->upload->do_upload('image')) {
            $fname = $this->upload->data('file_name');
            compress_image(FCPATH . 'uploads/' . $fname, 1200, 600, 80);
            return $fname;
        }
        return null;
    }
}
