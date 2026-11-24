<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Theme extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role('superadmin');
        $this->load->model('setting_model');
    }

    public function index()
    {
        $this->data['title'] = 'Warna Tema';
        $this->data['settings'] = $this->setting_model->get_all();

        if ($this->input->method() === 'post') {
            $accent = $this->input->post('color_accent');
            $mode = $this->input->post('mode'); // 'easy' or 'advanced'

            if ($mode === 'easy' && $accent) {
                if (!preg_match('/^#[0-9a-fA-F]{3,8}$/', $accent)) {
                    $this->session->set_flashdata('error', 'Warna aksen harus berupa kode hex valid (contoh: #2563EB).');
                    redirect('admin/theme');
                }

                $colors = array(
                    'color_accent'        => $accent,
                    'color_accent_hover'  => $this->_adjust_brightness($accent, -8),
                    'color_accent_light'  => $this->_adjust_brightness($accent, 20),
                    'color_accent_soft'   => $this->_adjust_brightness($accent, 35),
                    'color_primary'       => '#111111',
                    'color_surface_dark'  => '#1a1a1a',
                    'color_canvas'        => '#f5f5f5',
                    'color_canvas_soft'   => '#e5e5e5',
                    'color_canvas_hover'  => '#d4d4d4',
                    'color_on_dark'       => '#ffffff',
                    'color_wa_bg'         => '#25d366',
                );
            } else {
                $color_keys = array(
                    'color_accent', 'color_accent_hover', 'color_accent_light', 'color_accent_soft',
                    'color_accent_lime', 'color_accent_pink',
                    'color_primary', 'color_surface_dark',
                    'color_canvas', 'color_canvas_soft',
                    'color_canvas_hover',
                    'color_ink', 'color_ink_muted',
                    'color_on_dark', 'color_on_dark_muted',
                    'color_hairline_violet', 'color_hairline_cloud',
                    'color_wa_bg',
                );
                $colors = array();
                foreach ($color_keys as $key) {
                    $val = $this->input->post($key);
                    if ($val) {
                        if (!preg_match('/^#[0-9a-fA-F]{3,8}$/', $val) && strpos($val, 'rgba(') !== 0) {
                            $this->session->set_flashdata('error', 'Nilai warna tidak valid. Gunakan kode hex (contoh: #2563EB).');
                            redirect('admin/theme');
                        }
                        $colors[$key] = $val;
                    }
                }
            }

            foreach ($colors as $key => $val) {
                $this->setting_model->set($key, $val);
            }

            $this->session->set_flashdata('success', 'Warna tema berhasil disimpan.');
            redirect('admin/theme');
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/theme/index', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    private function _adjust_brightness($hex, $percent)
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        if ($percent >= 0) {
            $r = round($r + (255 - $r) * $percent / 100);
            $g = round($g + (255 - $g) * $percent / 100);
            $b = round($b + (255 - $b) * $percent / 100);
        } else {
            $f = (100 + $percent) / 100;
            $r = round($r * $f);
            $g = round($g * $f);
            $b = round($b * $f);
        }

        $r = max(0, min(255, $r));
        $g = max(0, min(255, $g));
        $b = max(0, min(255, $b));

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }

}
