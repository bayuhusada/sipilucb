<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role('superadmin');
        $this->load->model('user_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->data['users'] = $this->user_model->get_all();
        $this->data['title'] = 'Manajemen Users';
        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/users/list', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function create()
    {
        $this->data['title'] = 'Tambah User';

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|callback_password_check');
            $this->form_validation->set_rules('role', 'Role', 'required');

            if ($this->form_validation->run()) {
                $data = array(
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'role' => $this->input->post('role'),
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                );
                $this->user_model->insert($data);
                $this->session->set_flashdata('success', 'User berhasil ditambahkan.');
                redirect('admin/users');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/users/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function edit($id)
    {
        $user = $this->user_model->get($id);
        if (!$user) show_404();

        $this->data['row'] = $user;
        $this->data['title'] = 'Edit User';

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('role', 'Role', 'required');
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password', 'min_length[8]|callback_password_check');
            }

            if ($this->form_validation->run()) {
                $data = array(
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'password' => $this->input->post('password'),
                    'role' => $this->input->post('role'),
                    'is_active' => $this->input->post('is_active') ? 1 : 0,
                );
                $this->user_model->update($id, $data);
                $this->session->set_flashdata('success', 'User berhasil diperbarui.');
                redirect('admin/users');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/users/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function delete($id)
    {
        if ($this->input->method() !== 'post') show_404();

        $user = $this->user_model->get($id);
        if (!$user) show_404();

        if ($user['id'] == $this->user['id']) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus akun sendiri.');
            redirect('admin/users');
        }

        $this->user_model->delete($id);
        $this->session->set_flashdata('success', 'User berhasil dihapus.');
        redirect('admin/users');
    }

    public function password_check($password)
    {
        if (!preg_match('/[A-Z]/', $password)) {
            $this->form_validation->set_message('password_check', 'Password harus mengandung minimal 1 huruf kapital.');
            return FALSE;
        }
        if (!preg_match('/[a-z]/', $password)) {
            $this->form_validation->set_message('password_check', 'Password harus mengandung minimal 1 huruf kecil.');
            return FALSE;
        }
        if (!preg_match('/[0-9]/', $password)) {
            $this->form_validation->set_message('password_check', 'Password harus mengandung minimal 1 angka.');
            return FALSE;
        }
        return TRUE;
    }

}
