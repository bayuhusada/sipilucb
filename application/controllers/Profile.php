<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_login();
        $this->load->library('form_validation');
        $this->load->model('user_model');
    }

    public function index()
    {
        $this->data['title'] = 'Profil Saya';
        $user = $this->db->where('id', $this->user['id'])->get('users')->row_array();
        $this->data['row'] = $user;

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

            if ($this->form_validation->run()) {
                $update = array(
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                );

                $password = $this->input->post('password');
                if (!empty($password)) {
                    $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
                    if ($this->form_validation->run() !== false) {
                        $update['password'] = $password;
                    }
                }

                // Check username unique (except current user)
                $exists = $this->db
                    ->where('username', $update['username'])
                    ->where('id !=', $this->user['id'])
                    ->get('users')->row_array();
                if ($exists) {
                    $this->data['error'] = 'Username sudah digunakan.';
                } else {
                    $this->user_model->update($this->user['id'], $update);

                    // Refresh session
                    $this->session->set_userdata('username', $update['username']);
                    $this->data['user']['username'] = $update['username'];

                    $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
                    redirect('profile');
                }
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('profile/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }
}
