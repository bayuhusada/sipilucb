<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lecturers extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('superadmin', 'admin'));
        $this->load->library('form_validation');
        $this->config->load('sevima', true);
    }

    public function index()
    {
        $this->data['title'] = 'Dosen';

        $this->db->select('l.*, GROUP_CONCAT(t.lang ORDER BY t.lang SEPARATOR \',\') as lang_list');
        $this->db->from('lecturers l');
        $this->db->join('lecturers t', 'l.translation_group_id = t.translation_group_id', 'left');
        $this->db->where('l.lang', 'id');
        $this->db->group_by('l.id');

        $this->data['lecturers'] = $this->db->order_by('l.sort_order', 'ASC')->get()->result_array();

        $this->load->model('Lecturer_sync_log_model');
        $this->data['sync_log'] = $this->Lecturer_sync_log_model->latest();
        $this->data['sync_logs'] = $this->Lecturer_sync_log_model->recent(3);

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/lecturers/list', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function sync_logs()
    {
        $this->data['title'] = 'Riwayat Sinkronisasi';

        $this->load->model('Lecturer_sync_log_model');
        $this->data['sync_logs'] = $this->Lecturer_sync_log_model->recent(100);

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/lecturers/sync_logs', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function sync_now()
    {
        if ($this->input->method() !== 'post') show_404();

        require_once APPPATH . 'services/Lecturer_sync_service.php';
        $service = new Lecturer_sync_service();
        $result = $service->sync('manual');

        if (isset($result['error']) && $result['error']) {
            $this->session->set_flashdata('error', $result['error']);
        } else {
            $this->session->set_flashdata('success', 'Sinkronisasi selesai: ' . $result['inserted'] . ' dosen baru, ' . $result['updated'] . ' diperbarui, ' . $result['deactivated'] . ' dinonaktifkan, mahasiswa aktif ' . (isset($result['students']) ? $result['students'] : '-') . ', ' . $result['failed'] . ' gagal.');
        }

        redirect('admin/lecturers');
    }

    public function create()
    {
        $this->data['title'] = 'Tambah Dosen';
        $this->data['translations'] = [];

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name_id', 'Nama (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $tgid = $this->_next_tgid();
                $slug = url_title($this->input->post('name_id'), 'dash', true);
                $photo = $this->_upload('photo');
                $cv = $this->_upload_file('cv_file');

                $this->db->trans_start();

                $id_saved = false;
                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $name = $this->input->post('name_' . $lang);
                    if (empty($name)) continue;

                    $this->db->insert('lecturers', array(
                        'translation_group_id' => $tgid,
                        'lang' => $lang,
                        'name' => $name,
                        'slug' => $slug,
                        'nidn' => $this->input->post('nidn'),
                        'front_title' => $this->input->post('front_title_' . $lang),
                        'back_title' => $this->input->post('back_title_' . $lang),
                        'position' => $this->input->post('position_' . $lang),
                        'expertise' => $this->input->post('expertise_' . $lang),
                        'education_history' => $this->input->post('education_history_' . $lang),
                        'publications' => $this->input->post('publications_' . $lang),
                        'research' => $this->input->post('research_' . $lang),
                        'community_service' => $this->input->post('community_service_' . $lang),
                        'phone' => $this->input->post('phone'),
                        'email' => $this->input->post('email'),
                        'social_media' => $this->input->post('social_media'),
                        'google_scholar' => $this->input->post('google_scholar'),
                        'sinta_id' => $this->input->post('sinta_id'),
                        'scopus_id' => $this->input->post('scopus_id'),
                        'orcid' => $this->input->post('orcid'),
                        'photo' => $photo,
                        'cv_file' => $cv,
                        'sort_order' => $this->input->post('sort_order') ?: 0,
                        'is_active' => $this->input->post('is_active') ? 1 : 0,
                    ));
                    if ($lang === 'id') $id_saved = true;
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->_maybe_unlink($photo);
                    $this->_maybe_unlink($cv);
                    $this->session->set_flashdata('error', 'Gagal menambahkan dosen.');
                    redirect('admin/lecturers');
                }

                if ($id_saved) {
                    $this->_auto_translate_multi('lecturers', $tgid, array(
                        'name' => $this->input->post('name_id'),
                        'front_title' => $this->input->post('front_title_id'),
                        'back_title' => $this->input->post('back_title_id'),
                        'position' => $this->input->post('position_id'),
                        'expertise' => $this->input->post('expertise_id'),
                        'education_history' => $this->input->post('education_history_id'),
                    ), array('en', 'cn', 'de', 'ja'), 'name');
                }

                $this->session->set_flashdata('success', 'Dosen berhasil ditambahkan.');
                redirect('admin/lecturers');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/lecturers/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function edit($id)
    {
        $lecturer = $this->db->where('id', $id)->get('lecturers')->row_array();
        if (!$lecturer) show_404();

        $this->_ensure_tgid('lecturers', $lecturer);

        $this->data['title'] = 'Edit Dosen';
        $this->data['row'] = $lecturer;
        $this->data['translations'] = $this->_load_translations('lecturers', $lecturer['translation_group_id']);

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name_id', 'Nama (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $existing_langs = array_keys($this->data['translations']);
                $photo = $lecturer['photo'];
                $cv = $lecturer['cv_file'];

                $new_photo = $this->_upload('photo');
                if ($new_photo) {
                    $this->_maybe_unlink($lecturer['photo']);
                    $photo = $new_photo;
                }

                $new_cv = $this->_upload_file('cv_file');
                if ($new_cv) {
                    $this->_maybe_unlink($lecturer['cv_file']);
                    $cv = $new_cv;
                }

                $this->db->trans_start();

                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $name = $this->input->post('name_' . $lang);
                    if (empty($name)) continue;

                    $data = array(
                        'name' => $name,
                        'nidn' => $this->input->post('nidn'),
                        'front_title' => $this->input->post('front_title_' . $lang),
                        'back_title' => $this->input->post('back_title_' . $lang),
                        'position' => $this->input->post('position_' . $lang),
                        'expertise' => $this->input->post('expertise_' . $lang),
                        'education_history' => $this->input->post('education_history_' . $lang),
                        'publications' => $this->input->post('publications_' . $lang),
                        'research' => $this->input->post('research_' . $lang),
                        'community_service' => $this->input->post('community_service_' . $lang),
                        'phone' => $this->input->post('phone'),
                        'email' => $this->input->post('email'),
                        'social_media' => $this->input->post('social_media'),
                        'google_scholar' => $this->input->post('google_scholar'),
                        'sinta_id' => $this->input->post('sinta_id'),
                        'scopus_id' => $this->input->post('scopus_id'),
                        'orcid' => $this->input->post('orcid'),
                        'photo' => $photo,
                        'cv_file' => $cv,
                        'sort_order' => $this->input->post('sort_order') ?: 0,
                        'is_active' => $this->input->post('is_active') ? 1 : 0,
                    );

                    if (in_array($lang, $existing_langs)) {
                        $this->db->where('translation_group_id', $lecturer['translation_group_id'])
                            ->where('lang', $lang)
                            ->update('lecturers', $data);
                    } else {
                        $data['translation_group_id'] = $lecturer['translation_group_id'];
                        $data['lang'] = $lang;
                        $data['slug'] = url_title($this->input->post('name_id'), 'dash', true);
                        $this->db->insert('lecturers', $data);
                    }
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal memperbarui dosen.');
                    redirect('admin/lecturers');
                }

                $this->_auto_translate_multi('lecturers', $lecturer['translation_group_id'], array(
                    'name' => $this->input->post('name_id'),
                    'front_title' => $this->input->post('front_title_id'),
                    'back_title' => $this->input->post('back_title_id'),
                    'position' => $this->input->post('position_id'),
                    'expertise' => $this->input->post('expertise_id'),
                    'education_history' => $this->input->post('education_history_id'),
                ), array('en', 'cn', 'de', 'ja'), 'name', true);

                $this->session->set_flashdata('success', 'Dosen berhasil diperbarui.');
                redirect('admin/lecturers');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/lecturers/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function delete($id)
    {
        if ($this->input->method() !== 'post') show_404();

        $lecturer = $this->db->where('id', $id)->get('lecturers')->row_array();
        if (!$lecturer) show_404();
        $this->_maybe_unlink($lecturer['photo']);
        $this->_maybe_unlink($lecturer['cv_file']);

        $this->db->trans_start();
        $this->_delete_translation_group('lecturers', $lecturer['translation_group_id']);
        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'Dosen berhasil dihapus.');
        redirect('admin/lecturers');
    }

    private function _upload($field)
    {
        $config = array(
            'upload_path' => FCPATH . 'uploads/',
            'allowed_types' => 'jpg|jpeg|png|gif|webp',
            'max_size' => 2048,
            'file_name' => 'dosen_' . time() . '_' . uniqid()
        );
        $this->load->library('upload', $config);
        $this->load->helper('image');
        if ($this->upload->do_upload($field)) {
            $fname = $this->upload->data('file_name');
            compress_image(FCPATH . 'uploads/' . $fname, 600, 800, 80);
            return $fname;
        }
        return null;
    }

    private function _upload_file($field)
    {
        $config = array(
            'upload_path' => FCPATH . 'uploads/',
            'allowed_types' => 'pdf|doc|docx',
            'max_size' => 5120,
            'file_name' => 'cv_' . time() . '_' . uniqid()
        );
        $this->load->library('upload', $config);
        return $this->upload->do_upload($field) ? $this->upload->data('file_name') : null;
    }
}
