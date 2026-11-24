<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agendas extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('superadmin', 'admin', 'admin_berita'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['title'] = 'Agenda';
        $this->data['agendas'] = $this->db->select('a.*, GROUP_CONCAT(t.lang ORDER BY t.lang SEPARATOR \',\') as lang_list')
            ->from('agendas a')
            ->join('agendas t', 'a.translation_group_id = t.translation_group_id', 'left')
            ->where('a.lang', 'id')
            ->group_by('a.id')
            ->order_by('a.start_date', 'DESC')
            ->get()->result_array();

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/agendas/list', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function create()
    {
        $this->data['title'] = 'Tambah Agenda';
        $this->data['translations'] = [];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title_id', 'Judul (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $tgid = $this->_next_tgid();
                $slug = url_title($this->input->post('title_id'), 'dash', true);

                $this->db->trans_start();

                $id_saved = false;
                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $title = $this->input->post('title_' . $lang);
                    if (empty($title)) continue;

                    $this->db->insert('agendas', array(
                        'translation_group_id' => $tgid,
                        'lang' => $lang,
                        'title' => $title,
                        'slug' => $slug,
                        'description' => $this->input->post('description_' . $lang),
                        'location' => $this->input->post('location_' . $lang),
                        'start_date' => $this->input->post('start_date'),
                        'end_date' => $this->input->post('end_date'),
                        'is_active' => $this->input->post('is_active') ? 1 : 0,
                    ));
                    if ($lang === 'id') $id_saved = true;
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal menambahkan agenda.');
                    redirect('admin/agendas');
                }

                if ($id_saved) {
                    $this->_auto_translate_multi('agendas', $tgid, array(
                        'title' => $this->input->post('title_id'),
                        'description' => $this->input->post('description_id'),
                        'location' => $this->input->post('location_id'),
                    ), array('en', 'cn', 'de', 'ja'), 'title');
                }

                $this->session->set_flashdata('success', 'Agenda berhasil ditambahkan.');
                redirect('admin/agendas');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/agendas/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function edit($id)
    {
        $item = $this->db->where('id', $id)->get('agendas')->row_array();
        if (!$item) show_404();

        $this->_ensure_tgid('agendas', $item);

        $this->data['title'] = 'Edit Agenda';
        $this->data['row'] = $item;
        $this->data['translations'] = $this->_load_translations('agendas', $item['translation_group_id']);

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title_id', 'Judul (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $existing_langs = array_keys($this->data['translations']);
                $slug = url_title($this->input->post('title_id'), 'dash', true);

                $this->db->trans_start();

                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $title = $this->input->post('title_' . $lang);
                    if (empty($title)) continue;

                    $data = array(
                        'title' => $title,
                        'slug' => $slug,
                        'description' => $this->input->post('description_' . $lang),
                        'location' => $this->input->post('location_' . $lang),
                        'start_date' => $this->input->post('start_date'),
                        'end_date' => $this->input->post('end_date'),
                        'is_active' => $this->input->post('is_active') ? 1 : 0,
                    );

                    if (in_array($lang, $existing_langs)) {
                        $this->db->where('translation_group_id', $item['translation_group_id'])
                            ->where('lang', $lang)
                            ->update('agendas', $data);
                    } else {
                        $data['translation_group_id'] = $item['translation_group_id'];
                        $data['lang'] = $lang;
                        $this->db->insert('agendas', $data);
                    }
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal memperbarui agenda.');
                    redirect('admin/agendas');
                }

                $this->_auto_translate_multi('agendas', $item['translation_group_id'], array(
                    'title' => $this->input->post('title_id'),
                    'description' => $this->input->post('description_id'),
                    'location' => $this->input->post('location_id'),
                ), array('en', 'cn', 'de', 'ja'), 'title', true);

                $this->session->set_flashdata('success', 'Agenda berhasil diperbarui.');
                redirect('admin/agendas');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/agendas/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function delete($id)
    {
        if ($this->input->method() !== 'post') show_404();

        $item = $this->db->where('id', $id)->get('agendas')->row_array();
        if (!$item) show_404();

        $this->db->trans_start();
        $this->_delete_translation_group('agendas', $item['translation_group_id']);
        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Agenda berhasil dihapus.');
        redirect('admin/agendas');
    }
}
