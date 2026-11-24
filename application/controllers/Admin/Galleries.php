<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galleries extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('superadmin', 'admin'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['title'] = 'Galeri';
        $this->data['galleries'] = $this->db->select('g.*, GROUP_CONCAT(t.lang ORDER BY t.lang SEPARATOR \',\') as lang_list')
            ->from('galleries g')
            ->join('galleries t', 'g.translation_group_id = t.translation_group_id', 'left')
            ->where('g.lang', 'id')
            ->group_by('g.id')
            ->order_by('g.created_at', 'DESC')
            ->get()->result_array();

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/galleries/list', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function create()
    {
        $this->data['title'] = 'Tambah Album';

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title_id', 'Judul (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $tgid = $this->_next_tgid();
                $cover_image = null;

                if (!empty($_FILES['cover_image']['name'])) {
                    $cover = $this->_upload('cover_image');
                    if ($cover) $cover_image = $cover;
                }

                $is_active = $this->input->post('is_active') ? 1 : 0;

                $this->db->trans_start();

                $id_saved = false;
                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $title = $this->input->post('title_' . $lang);
                    if (empty($title)) continue;

                    $this->db->insert('galleries', array(
                        'translation_group_id' => $tgid,
                        'lang' => $lang,
                        'title' => $title,
                        'description' => $this->input->post('description_' . $lang),
                        'cover_image' => $cover_image,
                        'is_active' => $is_active,
                    ));
                    if ($lang === 'id') $id_saved = true;
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->_maybe_unlink($cover_image);
                    $this->session->set_flashdata('error', 'Gagal menambahkan album.');
                    redirect('admin/galleries');
                }

                if ($id_saved) {
                    $this->_auto_translate_multi('galleries', $tgid, array(
                        'title' => $this->input->post('title_id'),
                        'description' => $this->input->post('description_id'),
                    ), array('en', 'cn', 'de', 'ja'), 'title');
                }

                $this->session->set_flashdata('success', 'Album berhasil ditambahkan.');
                redirect('admin/galleries');
            }
        }

        $this->data['translations'] = [];

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/galleries/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function edit($id)
    {
        $item = $this->db->where('id', $id)->get('galleries')->row_array();
        if (!$item) show_404();

        $this->_ensure_tgid('galleries', $item);

        $this->data['title'] = 'Edit Album';
        $this->data['row'] = $item;
        $this->data['translations'] = $this->_load_translations('galleries', $item['translation_group_id']);
        $this->data['images'] = $this->db->where('gallery_id', $id)->order_by('sort_order', 'ASC')->get('gallery_images')->result_array();

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title_id', 'Judul (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $existing_langs = array_keys($this->data['translations']);
                $cover_image = $item['cover_image'];

                if (!empty($_FILES['cover_image']['name'])) {
                    $cover = $this->_upload('cover_image');
                    if ($cover) {
                        $this->_maybe_unlink($item['cover_image']);
                        $cover_image = $cover;
                    }
                }

                $is_active = $this->input->post('is_active') ? 1 : 0;

                $this->db->trans_start();

                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $title = $this->input->post('title_' . $lang);
                    if (empty($title)) continue;

                    $data = array(
                        'title' => $title,
                        'description' => $this->input->post('description_' . $lang),
                        'cover_image' => $cover_image,
                        'is_active' => $is_active,
                    );

                    if (in_array($lang, $existing_langs)) {
                        $this->db->where('translation_group_id', $item['translation_group_id'])
                            ->where('lang', $lang)
                            ->update('galleries', $data);
                    } else {
                        $data['translation_group_id'] = $item['translation_group_id'];
                        $data['lang'] = $lang;
                        $this->db->insert('galleries', $data);
                    }
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal memperbarui album.');
                    redirect('admin/galleries');
                }

                if (!empty($_FILES['images']['name'][0])) {
                    $this->_upload_images($id);
                }

                $this->_auto_translate_multi('galleries', $item['translation_group_id'], array(
                    'title' => $this->input->post('title_id'),
                    'description' => $this->input->post('description_id'),
                ), array('en', 'cn', 'de', 'ja'), 'title', true);

                $this->session->set_flashdata('success', 'Album berhasil diperbarui.');
                redirect('admin/galleries');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/galleries/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function delete($id)
    {
        if ($this->input->method() !== 'post') show_404();

        $item = $this->db->where('id', $id)->get('galleries')->row_array();
        if (!$item) show_404();

        $translations = $this->db->where('translation_group_id', $item['translation_group_id'])->get('galleries')->result_array();
        $ids = array_column($translations, 'id');

        foreach ($translations as $t) {
            $this->_maybe_unlink($t['cover_image']);
        }

        $this->db->trans_start();

        if (!empty($ids)) {
            $images = $this->db->where_in('gallery_id', $ids)->get('gallery_images')->result_array();
            foreach ($images as $img) {
                $this->_maybe_unlink($img['image']);
            }
            $this->db->where_in('gallery_id', $ids)->delete('gallery_images');
        }

        $this->_delete_translation_group('galleries', $item['translation_group_id']);

        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Album berhasil dihapus.');
        redirect('admin/galleries');
    }

    public function delete_image($id)
    {
        if ($this->input->method() !== 'post') show_404();

        $img = $this->db->where('id', $id)->get('gallery_images')->row_array();
        if ($img) {
            $this->_maybe_unlink($img['image']);
            $this->db->where('id', $id)->delete('gallery_images');
        }

        $return = $this->input->post('return_url');
        redirect($return ? urldecode($return) : 'admin/galleries');
    }

    private function _upload($field)
    {
        $config = array(
            'upload_path' => FCPATH . 'uploads/',
            'allowed_types' => 'jpg|jpeg|png|gif|webp',
            'max_size' => 2048,
            'file_name' => 'gallery_' . time() . '_' . uniqid()
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

    private function _upload_images($gallery_id)
    {
        $files = $_FILES['images'];
        $count = count($files['name']);
        $this->load->library('upload');
        $this->load->helper('image');

        for ($i = 0; $i < $count; $i++) {
            $_FILES['file']['name'] = $files['name'][$i];
            $_FILES['file']['type'] = $files['type'][$i];
            $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['file']['error'] = $files['error'][$i];
            $_FILES['file']['size'] = $files['size'][$i];

            $config = array(
                'upload_path' => FCPATH . 'uploads/',
                'allowed_types' => 'jpg|jpeg|png|gif|webp',
                'max_size' => 2048,
                'file_name' => 'gal_' . time() . '_' . uniqid() . '_' . $i
            );
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $fname = $this->upload->data('file_name');
                compress_image(FCPATH . 'uploads/' . $fname, 1600, 1200, 80);
                $this->db->insert('gallery_images', array(
                    'gallery_id' => $gallery_id,
                    'image' => $fname,
                    'sort_order' => $i
                ));
            }
        }
    }
}
