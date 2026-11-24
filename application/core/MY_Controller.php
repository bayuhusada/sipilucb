<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $data = array();
    protected $user = null;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

        $user_id = $this->session->userdata('user_id');
        if ($user_id) {
            $this->load->model('user_model');
            $user = $this->user_model->get($user_id);
            if ($user && $user['is_active']) {
                $this->user = $user;
                $this->data['user'] = $user;
            } else {
                $this->session->sess_destroy();
            }
        }
    }

    protected function require_login()
    {
        if (!$this->user) {
            redirect('auth');
        }
    }

    protected function require_role($roles)
    {
        $this->require_login();
        $roles = is_array($roles) ? $roles : array($roles);
        if (!in_array($this->user['role'], $roles)) {
            show_error('Akses ditolak. Anda tidak memiliki izin untuk halaman ini.', 403);
        }
    }

    protected function _maybe_unlink($filename)
    {
        if ($filename && file_exists(FCPATH . 'uploads/' . $filename)) {
            unlink(FCPATH . 'uploads/' . $filename);
        }
    }

    protected function _next_tgid()
    {
        return time() . rand(100, 999);
    }

    protected function _load_translations($table, $tgid)
    {
        $rows = $this->db->where('translation_group_id', $tgid)->get($table)->result_array();
        $by_lang = [];
        foreach ($rows as $r) {
            $by_lang[$r['lang']] = $r;
        }
        return $by_lang;
    }

    protected function _delete_translation_group($table, $tgid)
    {
        $this->db->where('translation_group_id', $tgid)->delete($table);
    }

    protected function _ensure_tgid($table, &$item)
    {
        if (empty($item['translation_group_id'])) {
            $tgid = $this->_next_tgid();
            $this->db->where('id', $item['id'])->update($table, array('translation_group_id' => $tgid));
            $item['translation_group_id'] = $tgid;
        }
    }

    protected $_settings_cache = null;

    protected function _get_settings()
    {
        if ($this->_settings_cache === null) {
            $this->load->model('setting_model');
            $this->_settings_cache = $this->setting_model->get_all();
        }
        return $this->_settings_cache;
    }

    protected function _auto_translate($table, $tgid, $source_texts, $target_lang)
    {
        if (empty($source_texts)) return array();

        $settings = $this->_get_settings();
        $translator_enabled = isset($settings['translator_enabled']) ? $settings['translator_enabled'] : '0';
        if ($translator_enabled === '0') return array();

        $this->load->library('translator');

        $results = array();
        foreach ($source_texts as $field => $value) {
            if (empty($value)) continue;

            $translated = $this->translator->translate($value, $target_lang);
            if (!empty($translated)) {
                $results[$field] = $translated;
            }
        }

        if (!empty($results)) {
            $data = $results;
            $data['translation_group_id'] = $tgid;
            $data['lang'] = $target_lang;

            $existing = $this->db->where('translation_group_id', $tgid)
                ->where('lang', $target_lang)
                ->get($table)
                ->row_array();

            if ($existing) {
                $this->db->where('translation_group_id', $tgid)
                    ->where('lang', $target_lang)
                    ->update($table, $results);
            } else {
                $source = $this->db->where('translation_group_id', $tgid)
                    ->where('lang', 'id')
                    ->get($table)
                    ->row_array();
                if ($source) {
                    foreach (array('id', 'lang', 'translation_group_id', 'created_at', 'updated_at') as $skip) {
                        unset($source[$skip]);
                    }
                    $data = array_merge($source, $results);
                    $data['translation_group_id'] = $tgid;
                    $data['lang'] = $target_lang;
                    $this->db->insert($table, $data);
                }
            }
        }

        return $results;
    }

    protected function _auto_translate_multi($table, $tgid, $source_texts, $targets, $check_field = 'title', $force = false)
    {
        foreach ($targets as $target_lang) {
            if (!$force) {
                $manual = $this->input->post($check_field . '_' . $target_lang);
                if (!empty($manual)) continue;
            }
            $this->_auto_translate($table, $tgid, $source_texts, $target_lang);
        }
    }

    protected function _get_id_texts($fields, $prefix = 'id')
    {
        $texts = array();
        foreach ($fields as $field) {
            $val = $this->input->post($field . '_' . $prefix);
            if (!empty($val)) {
                $texts[$field] = $val;
            }
        }
        return $texts;
    }
}
