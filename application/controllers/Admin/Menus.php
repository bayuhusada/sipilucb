<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role('superadmin');
        $this->load->model('menu_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['title'] = 'Menu Navigasi';
        $this->data['menus'] = $this->menu_model->get_all();

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/menus/list', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function create()
    {
        $this->data['title'] = 'Tambah Menu';
        $this->data['translations'] = [];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('label_id', 'Label (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $tgid = $this->_next_tgid();
                $url = $this->input->post('url');
                $sort_order = $this->input->post('sort_order');
                $location = $this->input->post('location');
                $target = $this->input->post('target');
                $is_active = $this->input->post('is_active') ? 1 : 0;

                $this->db->trans_start();

                $this->db->insert('nav_menus', array(
                    'translation_group_id' => $tgid,
                    'lang' => 'id',
                    'label' => $this->input->post('label_id'),
                    'url' => $url,
                    'sort_order' => $sort_order,
                    'location' => $location,
                    'target' => $target,
                    'is_active' => $is_active,
                ));

                $this->load->library('translator');

                foreach (['en', 'cn', 'de', 'ja'] as $target_lang) {
                    $translated = $this->translator->translate($this->input->post('label_id'), $target_lang);
                    if (!empty($translated)) {
                        $this->db->insert('nav_menus', array(
                            'translation_group_id' => $tgid,
                            'lang' => $target_lang,
                            'label' => $translated,
                            'url' => $url,
                            'sort_order' => $sort_order,
                            'location' => $location,
                            'target' => $target,
                            'is_active' => $is_active,
                        ));
                    }
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal menambahkan menu.');
                    redirect('admin/menus');
                }

                $this->session->set_flashdata('success', 'Menu berhasil ditambahkan.');
                redirect('admin/menus');
            }
        }

        $this->data['next_order'] = $this->db->count_all_results('nav_menus') + 1;

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/menus/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function edit($id)
    {
        $item = $this->menu_model->get($id);
        if (!$item) show_404();

        $this->_ensure_tgid('nav_menus', $item);

        $this->data['title'] = 'Edit Menu';
        $this->data['row'] = $item;
        $this->data['translations'] = $this->_load_translations('nav_menus', $item['translation_group_id']);

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('label_id', 'Label (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $existing_langs = array_keys($this->data['translations']);

                $this->db->trans_start();

                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $label = $this->input->post('label_' . $lang);
                    if (empty($label)) continue;

                    $data = array(
                        'label' => $label,
                        'url' => $this->input->post('url'),
                        'sort_order' => $this->input->post('sort_order'),
                        'location' => $this->input->post('location'),
                        'target' => $this->input->post('target'),
                        'is_active' => $this->input->post('is_active') ? 1 : 0,
                    );

                    if (in_array($lang, $existing_langs)) {
                        $this->db->where('translation_group_id', $item['translation_group_id'])
                            ->where('lang', $lang)
                            ->update('nav_menus', $data);
                    } else {
                        $data['translation_group_id'] = $item['translation_group_id'];
                        $data['lang'] = $lang;
                        $this->db->insert('nav_menus', $data);
                    }
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal memperbarui menu.');
                    redirect('admin/menus');
                }

                $this->session->set_flashdata('success', 'Menu berhasil diperbarui.');
                redirect('admin/menus');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/menus/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function delete($id)
    {
        if ($this->input->method() !== 'post') show_404();

        $item = $this->menu_model->get($id);
        if (!$item) show_404();

        $this->db->trans_start();
        $this->_delete_translation_group('nav_menus', $item['translation_group_id']);
        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Menu berhasil dihapus.');
        redirect('admin/menus');
    }
}
