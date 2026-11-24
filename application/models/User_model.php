<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function get_all()
    {
        return $this->db
            ->from('users u')
            ->order_by('u.created_at', 'DESC')
            ->get()
            ->result_array();
    }

    public function get($id)
    {
        return $this->db->where('id', $id)->get('users')->row_array();
    }

    public function get_by_username_email($username_email)
    {
        $this->db->where('username', $username_email);
        $this->db->or_where('email', $username_email);
        return $this->db->get('users')->row_array();
    }

    public function insert($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        $this->db->where('id', $id)->update('users', $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id)->delete('users');
    }

    public function update_last_login($id)
    {
        $this->db->where('id', $id)->update('users', array('last_login' => date('Y-m-d H:i:s')));
    }
}
