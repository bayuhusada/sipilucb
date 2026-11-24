<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculty_model extends CI_Model {

    public function get_all()
    {
        return $this->db->get('faculties')->result_array();
    }

    public function get($id)
    {
        return $this->db->where('id', $id)->get('faculties')->row_array();
    }

    public function create($data)
    {
        $this->db->insert('faculties', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id)->update('faculties', $data);
        return $this->db->affected_rows();
    }
}
