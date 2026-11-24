<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Study_programs extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('superadmin', 'admin'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        $item = $this->db->get('study_programs')->row_array();
        if (!$item) {
            $this->session->set_flashdata('error', 'Belum ada data program studi.');
            redirect('admin/dashboard');
        }
        redirect('admin/study_programs/edit/' . $item['id']);
    }

    public function edit($id)
    {
        $item = $this->db->where('id', $id)->get('study_programs')->row_array();
        if (!$item) show_404();

        $this->_ensure_tgid('study_programs', $item);

        $this->data['title'] = 'Profil Program Studi';
        $this->data['row'] = $item;
        $this->data['translations'] = $this->_load_translations('study_programs', $item['translation_group_id']);

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name_id', 'Nama Prodi (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $existing_langs = array_keys($this->data['translations']);
                $is_active = $this->input->post('is_active') ? 1 : 0;

                $thumbnail = $item['thumbnail'];
                if (!empty($_FILES['thumbnail']['name'])) {
                    $thumb = $this->_upload();
                    if ($thumb) {
                        $this->_maybe_unlink($item['thumbnail']);
                        $thumbnail = $thumb;
                    }
                }

                $this->db->trans_start();

                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $name = $this->input->post('name_' . $lang);
                    if (empty($name)) continue;

                    $data = array(
                        'name' => $name,
                        'description' => $this->input->post('description_' . $lang, true),
                        'vision' => $this->input->post('vision_' . $lang, true),
                        'mission' => $this->input->post('mission_' . $lang, true),
                        'accreditation' => $this->input->post('accreditation'),
                        'graduate_profile' => $this->input->post('graduate_profile_' . $lang, true),
                        'thumbnail' => $thumbnail,
                        'video_url' => $this->input->post('video_url'),
                        'is_active' => $is_active,
                    );

                    if (in_array($lang, $existing_langs)) {
                        $this->db->where('translation_group_id', $item['translation_group_id'])
                            ->where('lang', $lang)
                            ->update('study_programs', $data);
                    } else {
                        $data['translation_group_id'] = $item['translation_group_id'];
                        $data['lang'] = $lang;
                        $data['slug'] = $item['slug'];
                        $this->db->insert('study_programs', $data);
                    }
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal memperbarui program studi.');
                    redirect('admin/study_programs');
                }

                $this->data['translations'] = $this->_load_translations('study_programs', $item['translation_group_id']);

                $this->session->set_flashdata('success', 'Program studi berhasil diperbarui.');
                redirect('admin/study_programs');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/study_programs/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    private function _upload()
    {
        $config = array(
            'upload_path' => FCPATH . 'uploads/',
            'allowed_types' => 'jpg|jpeg|png|gif|webp',
            'max_size' => 2048,
            'file_name' => 'prodi_' . time() . '_' . uniqid()
        );
        $this->load->library('upload', $config);
        $this->load->helper('image');
        if ($this->upload->do_upload('thumbnail')) {
            $fname = $this->upload->data('file_name');
            compress_image(FCPATH . 'uploads/' . $fname, 800, 600, 80);
            return $fname;
        }
        return null;
    }
}
