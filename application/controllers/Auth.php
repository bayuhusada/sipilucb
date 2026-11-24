<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    private $max_attempts = 5;
    private $lockout_time = 900; // 15 minutes

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('user_model');
        $this->load->helper('security');
    }

    public function index()
    {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }

        $this->load->view('auth/login');
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $ip = $this->input->ip_address();

        if ($this->_is_locked_out($ip, $username)) {
            $this->session->set_flashdata('error', 'Akun Anda terkunci karena terlalu banyak percobaan login. Silakan coba lagi dalam 15 menit.');
            redirect('auth');
            return;
        }

        if (!$username || !$password) {
            $this->session->set_flashdata('error', 'Username dan password harus diisi.');
            redirect('auth');
            return;
        }

        $user = $this->user_model->get_by_username_email($username);

        if ($user && $user['is_active'] && password_verify($password, $user['password'])) {
            $this->_clear_attempts($ip, $username);

            $session_data = array(
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'logged_in' => TRUE,
            );
            $this->session->set_userdata($session_data);

            $this->user_model->update_last_login($user['id']);

            redirect('dashboard');
        } else {
            $this->_record_attempt($ip, $username);
            $this->session->set_flashdata('error', 'Username/Email atau password salah.');
            redirect('auth');
        }
    }

    public function logout()
    {
        if ($this->input->method() !== 'post') show_404();

        $this->session->sess_destroy();
        redirect('auth');
    }

    private function _is_locked_out($ip, $login)
    {
        $window = time() - $this->lockout_time;

        $this->db->where('time >', $window);
        $this->db->where('ip_address', $ip);
        $this->db->where('login', $login);
        $count = $this->db->count_all_results('login_attempts');

        return $count >= $this->max_attempts;
    }

    private function _record_attempt($ip, $login)
    {
        $this->db->insert('login_attempts', array(
            'ip_address' => $ip,
            'login' => $login,
            'time' => time()
        ));
    }

    private function _clear_attempts($ip, $login)
    {
        $this->db->where('ip_address', $ip);
        $this->db->where('login', $login);
        $this->db->delete('login_attempts');
    }
}
