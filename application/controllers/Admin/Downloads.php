<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Downloads extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('superadmin', 'admin'));
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['title'] = 'Download';
        $this->data['downloads'] = $this->db->select("d.*, GROUP_CONCAT(DISTINCT t.lang ORDER BY t.lang SEPARATOR ',') as lang_list, GROUP_CONCAT(DISTINCT CONCAT(t.lang, ':', COALESCE(t.file_path, '')) ORDER BY t.lang SEPARATOR '|') as lang_files")
            ->from('downloads d')
            ->join('downloads t', 'd.translation_group_id = t.translation_group_id', 'left')
            ->where('d.lang', 'id')
            ->group_by('d.id')
            ->order_by('d.created_at', 'DESC')
            ->get()->result_array();

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/downloads/list', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function create()
    {
        $this->data['title'] = 'Tambah File Download';

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title_id', 'Judul (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $tgid = $this->_next_tgid();
                $is_active = $this->input->post('is_active') ? 1 : 0;

                $this->db->trans_start();

                $id_saved = false;
                $id_file_path = null;
                $id_file_type = null;
                $id_file_size = null;
                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $title = $this->input->post('title_' . $lang);
                    if (empty($title)) continue;

                    $file_path = null;
                    $file_type = null;
                    $file_size = null;

                    $field = 'file_path_' . $lang;
                    if (!empty($_FILES[$field]['name'])) {
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mime = finfo_file($finfo, $_FILES[$field]['tmp_name']);
                        finfo_close($finfo);

                        $allowed_mimes = array(
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-powerpoint',
                            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                            'application/zip',
                            'application/x-rar-compressed',
                            'application/vnd.rar',
                        );

                        if (!in_array($mime, $allowed_mimes)) {
                            $this->session->set_flashdata('error', 'Tipe file tidak diizinkan (' . strtoupper($lang) . ').');
                            redirect('admin/downloads/create');
                            return;
                        }

                        $config = array(
                            'upload_path' => FCPATH . 'uploads/',
                            'allowed_types' => 'pdf|doc|docx|xls|xlsx|ppt|pptx|zip|rar',
                            'max_size' => 10240,
                            'file_name' => 'download_' . $lang . '_' . time() . '_' . uniqid(),
                            'encrypt_name' => TRUE,
                            'detect_mime' => TRUE
                        );
                        $this->load->library('upload', $config);

                        if ($this->upload->do_upload($field)) {
                            $ud = $this->upload->data();
                            $file_path = $ud['file_name'];
                            $file_type = $ud['file_ext'];
                            $file_size = $ud['file_size'];
                        } else {
                            $this->session->set_flashdata('error', $this->upload->display_errors(null, null));
                            redirect('admin/downloads/create');
                            return;
                        }
                    }

                    if ($lang === 'id') {
                        $id_file_path = $file_path;
                        $id_file_type = $file_type;
                        $id_file_size = $file_size;
                    } elseif (empty($file_path) && $id_file_path) {
                        $file_path = $id_file_path;
                        $file_type = $id_file_type;
                        $file_size = $id_file_size;
                    }

                    $this->db->insert('downloads', array(
                        'translation_group_id' => $tgid,
                        'lang' => $lang,
                        'title' => $title,
                        'description' => $this->input->post('description_' . $lang),
                        'file_path' => $file_path,
                        'file_type' => $file_type,
                        'file_size' => $file_size,
                        'is_active' => $is_active,
                    ));
                    if ($lang === 'id') $id_saved = true;
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal menambahkan file.');
                    redirect('admin/downloads');
                }

                if ($id_saved) {
                    $this->_auto_translate_multi('downloads', $tgid, array(
                        'title' => $this->input->post('title_id'),
                        'description' => $this->input->post('description_id'),
                    ), array('en', 'cn', 'de', 'ja'), 'title');
                }

                $this->session->set_flashdata('success', 'File berhasil ditambahkan.');
                redirect('admin/downloads');
            }
        }

        $this->data['translations'] = [];

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/downloads/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function edit($id)
    {
        $item = $this->db->where('id', $id)->get('downloads')->row_array();
        if (!$item) show_404();

        $this->_ensure_tgid('downloads', $item);

        $this->data['title'] = 'Edit Download';
        $this->data['row'] = $item;
        $this->data['translations'] = $this->_load_translations('downloads', $item['translation_group_id']);

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title_id', 'Judul (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $existing_langs = array_keys($this->data['translations']);
                $is_active = $this->input->post('is_active') ? 1 : 0;

                $this->db->trans_start();

                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $title = $this->input->post('title_' . $lang);
                    if (empty($title)) continue;

                    $t = isset($this->data['translations'][$lang]) ? $this->data['translations'][$lang] : null;

                    $file_path = $t ? $t['file_path'] : null;
                    $file_type = $t ? $t['file_type'] : null;
                    $file_size = $t ? $t['file_size'] : null;

                    if (empty($file_path) && isset($this->data['translations']['id']['file_path'])) {
                        $file_path = $this->data['translations']['id']['file_path'];
                        $file_type = $this->data['translations']['id']['file_type'];
                        $file_size = $this->data['translations']['id']['file_size'];
                    }

                    $field = 'file_path_' . $lang;
if (!empty($_FILES[$field]['name'])) {
                            $finfo = finfo_open(FILEINFO_MIME_TYPE);
                            $mime = finfo_file($finfo, $_FILES[$field]['tmp_name']);
                            finfo_close($finfo);

                            $allowed_mimes = array(
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/vnd.ms-powerpoint',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                'application/zip',
                                'application/x-rar-compressed',
                                'application/vnd.rar',
                            );

                            if (!in_array($mime, $allowed_mimes)) {
                                $this->session->set_flashdata('error', 'Tipe file tidak diizinkan (' . strtoupper($lang) . ').');
                                redirect('admin/downloads/edit/' . $id);
                                return;
                            }

                            $config = array(
                                'upload_path' => FCPATH . 'uploads/',
                                'allowed_types' => 'pdf|doc|docx|xls|xlsx|ppt|pptx|zip|rar',
                                'max_size' => 10240,
                                'file_name' => 'download_' . $lang . '_' . time() . '_' . uniqid(),
                                'encrypt_name' => TRUE,
                                'detect_mime' => TRUE
                            );
                            $this->load->library('upload', $config);

                            if ($this->upload->do_upload($field)) {
                            $ud = $this->upload->data();
                            if ($t && $t['file_path']) {
                                $this->_maybe_unlink($t['file_path']);
                            }
                            $file_path = $ud['file_name'];
                            $file_type = $ud['file_ext'];
                            $file_size = $ud['file_size'];
                        } else {
                            $this->session->set_flashdata('error', $this->upload->display_errors(null, null));
                            redirect('admin/downloads/edit/' . $id);
                            return;
                        }
                    }

                    $data = array(
                        'title' => $title,
                        'description' => $this->input->post('description_' . $lang),
                        'file_path' => $file_path,
                        'file_type' => $file_type,
                        'file_size' => $file_size,
                        'is_active' => $is_active,
                    );

                    if (in_array($lang, $existing_langs)) {
                        $this->db->where('translation_group_id', $item['translation_group_id'])
                            ->where('lang', $lang)
                            ->update('downloads', $data);
                    } else {
                        $data['translation_group_id'] = $item['translation_group_id'];
                        $data['lang'] = $lang;
                        $this->db->insert('downloads', $data);
                    }
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal memperbarui file.');
                    redirect('admin/downloads');
                }

                $this->_auto_translate_multi('downloads', $item['translation_group_id'], array(
                    'title' => $this->input->post('title_id'),
                    'description' => $this->input->post('description_id'),
                ), array('en', 'cn', 'de', 'ja'), 'title', true);

                $this->session->set_flashdata('success', 'File berhasil diperbarui.');
                redirect('admin/downloads');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/downloads/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function delete($id)
    {
        if ($this->input->method() !== 'post') show_404();

        $item = $this->db->where('id', $id)->get('downloads')->row_array();
        if (!$item) show_404();

        $translations = $this->db->where('translation_group_id', $item['translation_group_id'])
            ->get('downloads')->result_array();

        foreach ($translations as $t) {
            $this->_maybe_unlink($t['file_path']);
        }

        $this->db->trans_start();
        $this->_delete_translation_group('downloads', $item['translation_group_id']);
        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'File berhasil dihapus.');
        redirect('admin/downloads');
    }
}
