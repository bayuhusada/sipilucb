<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function get_by_location($location = 'both', $lang = null)
    {
        if ($lang === null) $lang = current_lang();

        return $this->db
            ->where('lang', $lang)
            ->where('is_active', 1)
            ->group_start()
                ->where('location', $location)
                ->or_where('location', 'both')
            ->group_end()
            ->order_by('sort_order', 'ASC')
            ->get('nav_menus')
            ->result_array();
    }

    public function get_all()
    {
        return $this->db
            ->select('m.*, GROUP_CONCAT(t.lang ORDER BY t.lang SEPARATOR \',\') as lang_list')
            ->from('nav_menus m')
            ->join('nav_menus t', 'm.translation_group_id = t.translation_group_id', 'left')
            ->where('m.lang', 'id')
            ->group_by('m.id')
            ->order_by('m.sort_order', 'ASC')
            ->get()
            ->result_array();
    }

    public function get($id)
    {
        return $this->db->where('id', $id)->get('nav_menus')->row_array();
    }

    public function create($data)
    {
        $this->db->insert('nav_menus', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id)->update('nav_menus', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id)->delete('nav_menus');
    }
}
