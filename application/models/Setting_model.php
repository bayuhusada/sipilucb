<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {

    public function get_all()
    {
        $result = $this->db->get('settings')->result_array();
        $settings = array();
        foreach ($result as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    public function get($key)
    {
        $row = $this->db->where('setting_key', $key)
            ->get('settings')
            ->row_array();
        return $row ? $row['setting_value'] : null;
    }

    public function get_all_lang($lang = 'id')
    {
        $all = $this->get_all();
        $result = array();
        $suffixes = array('_id', '_en', '_cn', '_de', '_ja');

        foreach ($all as $key => $value) {
            $result[$key] = $value;
        }

        foreach ($suffixes as $suf) {
            foreach ($all as $key => $value) {
                if (substr($key, -strlen($suf)) === $suf) {
                    $base = substr($key, 0, -strlen($suf));
                    if (!isset($result[$base])) {
                        $result[$base] = $value;
                    }
                }
            }
        }

        foreach ($result as $key => $value) {
            $lang_key = $key . '_' . $lang;
            if (isset($all[$lang_key])) {
                $result[$key] = $all[$lang_key];
            }
        }

        return $result;
    }

    public function set($key, $value)
    {
        $exists = $this->db->where('setting_key', $key)
            ->get('settings')
            ->row_array();

        if ($exists) {
            $this->db->where('id', $exists['id'])->update('settings', array('setting_value' => $value));
        } else {
            $this->db->insert('settings', array(
                'setting_key' => $key,
                'setting_value' => $value
            ));
        }
    }
}
