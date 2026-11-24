<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faculties extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role('superadmin');
        $this->load->library('form_validation');
        $this->load->model('faculty_model');
    }

    public function index()
    {
        $this->data['title'] = 'Fakultas';
        $this->data['faculties'] = $this->faculty_model->get_all();

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/faculties/list', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function create()
    {
        $this->data['title'] = 'Tambah Fakultas';

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', 'Nama Fakultas', 'required');

            if ($this->form_validation->run()) {
                $this->db->insert('faculties', array(
                    'name' => $this->input->post('name'),
                ));

                $this->session->set_flashdata('success', 'Fakultas berhasil ditambahkan.');
                redirect('admin/faculties');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/faculties/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function edit($id)
    {
        $faculty = $this->faculty_model->get($id);
        if (!$faculty) show_404();

        $this->data['title'] = 'Edit Fakultas';
        $this->data['row'] = $faculty;

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', 'Nama Fakultas', 'required');

            if ($this->form_validation->run()) {
                $this->db->where('id', $id)->update('faculties', array(
                    'name' => $this->input->post('name'),
                ));

                $this->session->set_flashdata('success', 'Fakultas berhasil diperbarui.');
                redirect('admin/faculties');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/faculties/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function delete($id)
    {
        $faculty = $this->faculty_model->get($id);
        if (!$faculty) show_404();

        $this->db->where('id', $id)->delete('faculties');
        $this->session->set_flashdata('success', 'Fakultas berhasil dihapus.');
        redirect('admin/faculties');
    }
}
