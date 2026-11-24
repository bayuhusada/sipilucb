<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autotranslate extends MY_Controller {

    private $_langs = array('id', 'en', 'cn', 'de', 'ja');

    private $_field_map = array(
        'news' => array('title', 'content', 'seo_title', 'seo_description'),
        'agendas' => array('title', 'description', 'location'),
        'faqs' => array('question', 'answer'),
        'banners' => array('title', 'subtitle'),
        'categories' => array('name'),
        'downloads' => array('title', 'description'),
        'galleries' => array('title', 'description'),
        'lecturers' => array('name', 'front_title', 'back_title', 'position', 'expertise', 'education_history', 'publications', 'research', 'community_service'),
        'menus' => array('label'),
        'study_programs' => array('name', 'vision', 'mission', 'description', 'graduate_profile'),
    );

    private $_setting_fields = array(
        'site_name', 'site_description',
        'hero_eyebrow', 'hero_title', 'hero_subtitle', 'hero_cta_text', 'hero_secondary_cta_text',
        'about_eyebrow', 'about_cta_text',
        'section_news_eyebrow', 'section_news_title', 'section_news_subtitle', 'news_view_all_text',
        'section_agenda_eyebrow', 'section_agenda_title', 'section_agenda_subtitle', 'agenda_view_all_text',
        'section_gallery_eyebrow', 'section_gallery_title', 'section_gallery_subtitle', 'gallery_view_all_text',
        'section_faq_eyebrow', 'section_faq_title', 'section_faq_subtitle',
        'section_vm_title', 'section_vm_subtitle',
        'section_featured_eyebrow', 'section_featured_title', 'section_featured_subtitle',
        'feature_1_title', 'feature_1_desc', 'feature_2_title', 'feature_2_desc',
        'feature_3_title', 'feature_3_desc', 'feature_4_title', 'feature_4_desc',
        'feature_5_title', 'feature_5_desc', 'feature_6_title', 'feature_6_desc',
        'section_dosen_eyebrow', 'section_dosen_title', 'section_dosen_subtitle',
        'section_achievement_eyebrow', 'section_achievement_title', 'section_achievement_subtitle',
        'section_testimonial_eyebrow', 'section_testimonial_title', 'section_testimonial_subtitle',
        'subtitle_dosen', 'subtitle_berita', 'subtitle_agenda', 'subtitle_galeri', 'subtitle_download', 'subtitle_kontak',
        'stat_label_dosen', 'stat_label_berita', 'stat_label_kegiatan', 'stat_label_siswa', 'stat_label_lulusan', 'stat_label_sekolah_mitra', 'stat_label_prestasi',
        'contact_label_name', 'contact_label_email', 'contact_label_subject', 'contact_label_message', 'contact_label_submit',
        'contact_info_heading', 'contact_address_label', 'contact_phone_label', 'contact_email_label',
        'footer_copyright', 'footer_credit',
        'cta_band_title', 'cta_band_text', 'cta_band_button_text', 'university_name', 'university_description',
    );

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('superadmin', 'admin', 'admin_berita'));
        $this->load->library('translator');
    }

    public function regenerate()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $field = $this->input->post('field');
        $target_lang = $this->input->post('target_lang');

        if (!$id || !$type || !$field || !$target_lang) {
            echo json_encode(array('status' => 'error', 'message' => 'Parameter tidak lengkap.'));
            return;
        }

        $table_map = array(
            'news' => 'news',
            'agendas' => 'agendas',
            'faqs' => 'faqs',
            'banners' => 'banners',
            'categories' => 'news_categories',
            'downloads' => 'downloads',
            'galleries' => 'galleries',
            'lecturers' => 'lecturers',
            'menus' => 'nav_menus',
            'study_programs' => 'study_programs',
        );

        if (!isset($table_map[$type])) {
            echo json_encode(array('status' => 'error', 'message' => 'Tipe tidak dikenal.'));
            return;
        }

        $table = $table_map[$type];

        if (!isset($this->_field_map[$type]) || !in_array($field, $this->_field_map[$type])) {
            echo json_encode(array('status' => 'error', 'message' => 'Field tidak dikenal.'));
            return;
        }

        if (!in_array($target_lang, $this->_langs)) {
            echo json_encode(array('status' => 'error', 'message' => 'Bahasa target tidak dikenal.'));
            return;
        }

        $item = $this->db->where('id', $id)->get($table)->row_array();
        if (!$item) {
            echo json_encode(array('status' => 'error', 'message' => 'Data tidak ditemukan.'));
            return;
        }

        $translations = $this->_load_translations($table, $item['translation_group_id']);

        if (!isset($translations['id'])) {
            echo json_encode(array('status' => 'error', 'message' => 'Data Bahasa Indonesia tidak ditemukan.'));
            return;
        }

        $source_text = $translations['id'][$field] ?? '';
        if (empty($source_text)) {
            echo json_encode(array('status' => 'error', 'message' => 'Konten sumber kosong.'));
            return;
        }

        try {
            $translated = $this->translator->translate($source_text, $target_lang);

            if (empty($translated)) {
                echo json_encode(array('status' => 'error', 'message' => 'Gagal menerjemahkan. Periksa API Key di Settings.'));
                return;
            }

            if (isset($translations[$target_lang])) {
                $this->db->where('translation_group_id', $item['translation_group_id'])
                    ->where('lang', $target_lang)
                    ->update($table, array($field => $translated));
            } else {
                $data = $translations['id'];
                foreach (array('id', 'created_at', 'updated_at') as $skip) {
                    unset($data[$skip]);
                }
                $data['translation_group_id'] = $item['translation_group_id'];
                $data['lang'] = $target_lang;
                $data[$field] = $translated;
                $this->db->insert($table, $data);
            }

            echo json_encode(array(
                'status' => 'done',
                'result' => $translated,
                'field' => $field . '_' . $target_lang,
            ));
        } catch (Exception $e) {
            echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
        }
    }

    public function regenerate_setting()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $field = $this->input->post('field');
        $target_lang = $this->input->post('target_lang');

        if (!$field || !$target_lang) {
            echo json_encode(array('status' => 'error', 'message' => 'Parameter tidak lengkap.'));
            return;
        }

        if (!in_array($field, $this->_setting_fields)) {
            echo json_encode(array('status' => 'error', 'message' => 'Field tidak dikenal.'));
            return;
        }

        if (!in_array($target_lang, $this->_langs)) {
            echo json_encode(array('status' => 'error', 'message' => 'Bahasa target tidak dikenal.'));
            return;
        }

        $this->load->model('setting_model');

        $source = $this->setting_model->get($field . '_id');
        if (empty($source)) {
            echo json_encode(array('status' => 'error', 'message' => 'Konten sumber (ID) kosong.'));
            return;
        }

        $translated = $this->translator->translate($source, $target_lang);

        if (empty($translated)) {
            echo json_encode(array('status' => 'error', 'message' => 'Gagal menerjemahkan. Periksa API Key di Settings.'));
            return;
        }

        $this->setting_model->set($field . '_' . $target_lang, $translated);

        echo json_encode(array(
            'status' => 'done',
            'result' => $translated,
            'field' => $field . '_' . $target_lang,
        ));
    }

    public function regenerate_all_settings()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $fields = $this->input->post('fields');
        if (empty($fields) || !is_array($fields)) {
            echo json_encode(array('status' => 'error', 'message' => 'Tidak ada field yang dipilih.'));
            return;
        }

        $this->load->model('setting_model');
        $results = array();
        $errors = array();

        $targets = array('en', 'cn', 'de', 'ja');
        foreach ($fields as $field) {
            if (!in_array($field, $this->_setting_fields)) {
                $errors[] = $field . ': field tidak dikenal';
                continue;
            }

            $source = $this->setting_model->get($field . '_id');
            if (empty($source)) {
                $errors[] = $field . ': konten ID kosong';
                continue;
            }

            $results_item = array('field' => $field);
            foreach ($targets as $lang) {
                $translated = $this->translator->translate($source, $lang);
                if (!empty($translated)) {
                    $this->setting_model->set($field . '_' . $lang, $translated);
                    $results_item[$lang] = $translated;
                } else {
                    $errors[] = $field . '_' . $lang . ': gagal';
                    $results_item[$lang] = '';
                }
            }
            $results[] = $results_item;
        }

        echo json_encode(array(
            'status' => empty($errors) ? 'done' : 'partial',
            'results' => $results,
            'errors' => $errors,
            'total' => count($fields),
        ));
    }

    public function test()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $this->load->library('translator');
        $result = $this->translator->test_connection();

        echo json_encode($result);
    }
}
