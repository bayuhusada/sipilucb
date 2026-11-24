<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LangHook
{
    public function detect()
    {
        $CI =& get_instance();

        $this->_check_maintenance($CI);

        $CI->output->set_header('X-Frame-Options: SAMEORIGIN');
        $CI->output->set_header('X-Content-Type-Options: nosniff');
        $CI->output->set_header('Referrer-Policy: strict-origin-when-cross-origin');

        $first = $CI->uri->segment(1);

        $lang_code = 'id';
        if (in_array($first, ['id', 'en', 'cn', 'de', 'ja'], true)) {
            $lang_code = $first;
            $CI->session->set_userdata('selected_lang', $lang_code);
        } else {
            $saved = $CI->session->userdata('selected_lang');
            if ($saved && in_array($saved, ['id', 'en', 'cn', 'de', 'ja'], true)) {
                $lang_code = $saved;
            }
        }

        $idioms = [
            'id' => 'indonesian',
            'en' => 'english',
            'cn' => 'chinese',
            'de' => 'german',
            'ja' => 'japanese',
        ];
        $idiom = $idioms[$lang_code];

        $CI->config->set_item('current_lang', $lang_code);

        $CI->lang->load('app_lang', $idiom);

        $segments = $CI->uri->segment_array();
        if (isset($segments[1]) && $segments[1] === $lang_code) {
            array_shift($segments);
        }
        $uri_path = implode('/', $segments);
        $CI->config->set_item('uri_path', $uri_path);
    }

    private function _check_maintenance($CI)
    {
        if ($CI->router->class === 'maintenance' || $CI->router->class === 'auth') {
            return;
        }

        $CI->load->model('setting_model');
        $settings = $CI->setting_model->get_all();
        $maintenance = isset($settings['maintenance_mode']) ? $settings['maintenance_mode'] : '0';

        if ($maintenance !== '1') {
            return;
        }

        $user_id = $CI->session->userdata('user_id');
        if ($user_id) {
            $CI->load->model('user_model');
            $user = $CI->user_model->get($user_id);
            if ($user && $user['is_active'] && in_array($user['role'], array('superadmin', 'admin', 'admin_berita', 'admin_prodi'))) {
                return;
            }
        }

        echo $CI->load->view('maintenance', NULL, TRUE);
        exit;
    }
}
