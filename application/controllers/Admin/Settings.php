<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role('superadmin');
        $this->load->model('setting_model');
    }

    public function index()
    {
        redirect('admin/settings/umum');
    }

    public function umum()     { $this->_form('umum'); }
    public function hero()      { $this->_form('hero'); }
    public function sections()  { $this->_form('sections'); }
    public function stats()     { $this->_form('stats'); }
    public function kontak()    { $this->_form('kontak'); }
    public function sosmed()    { $this->_form('sosmed'); }
    public function footer()    { $this->_form('footer'); }
    public function lainnya()   { $this->_form('lainnya'); }

    private function _form($tab)
    {
        $this->data['title'] = 'Pengaturan Website';
        $this->data['settings'] = $this->setting_model->get_all();
        $this->data['active_tab'] = $tab;
        $groups = $this->_field_groups();
        $this->data['translatable_fields'] = isset($groups[$tab]) ? $groups[$tab]['translatable'] : array();

        if ($this->input->method() === 'post') {
            $this->_save($tab);
            $this->session->set_flashdata('success', 'Pengaturan berhasil disimpan.');
            redirect('admin/settings/' . $tab);
        }

        $this->load->helper('lang');
        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/settings/' . $tab, $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    private function _save($tab)
    {
        $groups = $this->_field_groups();

        if (!isset($groups[$tab])) return;

        $g = $groups[$tab];

        foreach ($g['translatable'] as $field) {
            foreach (array('id', 'en', 'cn', 'de', 'ja') as $lang) {
                $val = $this->input->post($field . '_' . $lang);
                $this->setting_model->set($field . '_' . $lang, $val);
            }
        }

        foreach ($g['non_translatable'] as $field) {
            $val = $this->input->post($field);
            if ($field === 'translator_endpoint_libre' && !empty($val) && !preg_match('#^https?://#', $val)) continue;
            if (in_array($field, array('translator_endpoint_libre', 'translator_api_key_libre')) && empty($val)) continue;
            $this->setting_model->set($field, $val);
        }

        if (!empty($_FILES['site_logo']['name'])) {
            $old_logo = $this->setting_model->get('site_logo');
            $logo = $this->_upload('site_logo', 'logo');
            if ($logo) {
                if ($old_logo) $this->_maybe_unlink($old_logo);
                $this->setting_model->set('site_logo', $logo);
            }
        }

        if (!empty($_FILES['site_favicon']['name'])) {
            $old_fav = $this->setting_model->get('site_favicon');
            $fav = $this->_upload('site_favicon', 'favicon');
            if ($fav) {
                if ($old_fav) $this->_maybe_unlink($old_fav);
                $this->setting_model->set('site_favicon', $fav);
            }
        }
    }

    private function _field_groups()
    {
        return array(
            'umum' => array(
                'translatable' => array('site_name', 'site_description'),
                'non_translatable' => array('site_email', 'site_phone', 'site_whatsapp', 'site_address'),
            ),
            'hero' => array(
                'translatable' => array('hero_eyebrow', 'hero_title', 'hero_subtitle', 'hero_cta_text', 'hero_secondary_cta_text'),
                'non_translatable' => array('hero_cta_link', 'hero_secondary_cta_link'),
            ),
            'sections' => array(
                'translatable' => array(
                    'about_eyebrow', 'about_cta_text',
                    'section_news_eyebrow', 'section_news_title', 'section_news_subtitle',
                    'news_view_all_text',
                    'section_agenda_eyebrow', 'section_agenda_title', 'section_agenda_subtitle',
                    'agenda_view_all_text',
                    'section_gallery_eyebrow', 'section_gallery_title', 'section_gallery_subtitle',
                    'gallery_view_all_text',
                    'section_faq_eyebrow', 'section_faq_title', 'section_faq_subtitle',
                    'section_vm_title', 'section_vm_subtitle',
                    'section_featured_eyebrow', 'section_featured_title', 'section_featured_subtitle',
                    'section_dosen_eyebrow', 'section_dosen_title', 'section_dosen_subtitle',
                    'section_achievement_eyebrow', 'section_achievement_title', 'section_achievement_subtitle',
                    'section_testimonial_eyebrow', 'section_testimonial_title', 'section_testimonial_subtitle',
                    'subtitle_dosen', 'subtitle_berita', 'subtitle_agenda', 'subtitle_galeri', 'subtitle_download', 'subtitle_kontak',
                ),
                'non_translatable' => array('about_cta_link', 'news_view_all_link', 'agenda_view_all_link', 'gallery_view_all_link', 'dosen_view_all_link'),
            ),
            'stats' => array(
                'translatable' => array('stat_label_dosen', 'stat_label_berita', 'stat_label_kegiatan', 'stat_label_siswa', 'stat_label_lulusan', 'stat_label_sekolah_mitra', 'stat_label_prestasi'),
                'non_translatable' => array('stats_students', 'stats_alumni', 'stats_school_partners', 'stats_achievements'),
            ),
            'kontak' => array(
                'translatable' => array(
                    'contact_label_name', 'contact_label_email', 'contact_label_subject',
                    'contact_label_message', 'contact_label_submit',
                    'contact_info_heading', 'contact_address_label', 'contact_phone_label', 'contact_email_label',
                ),
                'non_translatable' => array('contact_map_url'),
            ),
            'sosmed' => array(
                'translatable' => array(),
                'non_translatable' => array('social_facebook', 'social_instagram', 'social_youtube', 'social_twitter', 'social_tiktok'),
            ),
            'footer' => array(
                'translatable' => array('footer_copyright', 'footer_credit'),
                'non_translatable' => array(),
            ),
            'lainnya' => array(
                'translatable' => array('cta_band_title', 'cta_band_text', 'cta_band_button_text', 'university_name', 'university_description'),
                'non_translatable' => array('cta_band_button_link', 'university_url',
                    'translator_api_key_openrouter', 'translator_api_key_gemini', 'translator_api_key_google', 'translator_api_key_libre', 'translator_endpoint_libre', 'translator_provider', 'translator_model', 'translator_enabled', 'maintenance_mode'),
            ),
        );
    }

    private function _upload($field, $prefix)
    {
        $config = array(
            'upload_path' => FCPATH . 'uploads/',
            'allowed_types' => 'jpg|jpeg|png|ico|gif|svg',
            'max_size' => 2048,
            'file_name' => $prefix . '_' . time() . '_' . uniqid()
        );
        $this->load->library('upload', $config);
        $this->load->helper('image');

        if ($this->upload->do_upload($field)) {
            $fname = $this->upload->data('file_name');
            $ext = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
            if (in_array($ext, array('jpg', 'jpeg', 'png', 'webp'))) {
                $max_w = ($prefix === 'favicon') ? 256 : 400;
                compress_image(FCPATH . 'uploads/' . $fname, $max_w, $max_w, 80);
            }
            return $fname;
        }
        return null;
    }
}
