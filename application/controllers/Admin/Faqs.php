<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faqs extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->require_role(array('superadmin', 'admin', 'admin_berita'));
    }

    public function index()
    {
        $this->data['title'] = 'FAQ';
        $this->data['faqs'] = $this->db->select('f.*, GROUP_CONCAT(t.lang ORDER BY t.lang SEPARATOR \',\') as lang_list')
            ->from('faqs f')
            ->join('faqs t', 'f.translation_group_id = t.translation_group_id', 'left')
            ->where('f.lang', 'id')
            ->group_by('f.id')
            ->order_by('f.sort_order', 'ASC')
            ->get()->result_array();

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/faqs/list', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function create()
    {
        $this->data['title'] = 'Tambah FAQ';
        $this->data['translations'] = [];

        if ($this->input->method() === 'post') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('question_id', 'Pertanyaan (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $tgid = $this->_next_tgid();

                $this->db->trans_start();

                $id_saved = false;
                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $question = $this->input->post('question_' . $lang);
                    if (empty($question)) continue;

                    $this->db->insert('faqs', array(
                        'translation_group_id' => $tgid,
                        'lang' => $lang,
                        'question' => $question,
                        'answer' => $this->input->post('answer_' . $lang),
                        'sort_order' => $this->input->post('sort_order') ?: 0,
                        'is_active' => $this->input->post('is_active') ? 1 : 0,
                    ));
                    if ($lang === 'id') $id_saved = true;
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal menambahkan FAQ.');
                    redirect('admin/faqs');
                }

                if ($id_saved) {
                    $this->_auto_translate_multi('faqs', $tgid, array(
                        'question' => $this->input->post('question_id'),
                        'answer' => $this->input->post('answer_id'),
                    ), array('en', 'cn', 'de', 'ja'), 'question');
                }

                $this->session->set_flashdata('success', 'FAQ berhasil ditambahkan.');
                redirect('admin/faqs');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/faqs/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function edit($id)
    {
        $item = $this->db->where('id', $id)->get('faqs')->row_array();
        if (!$item) show_404();

        $this->_ensure_tgid('faqs', $item);

        $this->data['title'] = 'Edit FAQ';
        $this->data['row'] = $item;
        $this->data['translations'] = $this->_load_translations('faqs', $item['translation_group_id']);

        if ($this->input->method() === 'post') {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('question_id', 'Pertanyaan (Indonesia)', 'required');

            if ($this->form_validation->run()) {
                $existing_langs = array_keys($this->data['translations']);

                $this->db->trans_start();

                foreach (['id', 'en', 'cn', 'de', 'ja'] as $lang) {
                    $question = $this->input->post('question_' . $lang);
                    if (empty($question)) continue;

                    $data = array(
                        'question' => $question,
                        'answer' => $this->input->post('answer_' . $lang),
                        'sort_order' => $this->input->post('sort_order') ?: 0,
                        'is_active' => $this->input->post('is_active') ? 1 : 0,
                    );

                    if (in_array($lang, $existing_langs)) {
                        $this->db->where('translation_group_id', $item['translation_group_id'])
                            ->where('lang', $lang)
                            ->update('faqs', $data);
                    } else {
                        $data['translation_group_id'] = $item['translation_group_id'];
                        $data['lang'] = $lang;
                        $this->db->insert('faqs', $data);
                    }
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() === FALSE) {
                    $this->session->set_flashdata('error', 'Gagal memperbarui FAQ.');
                    redirect('admin/faqs');
                }

                $this->_auto_translate_multi('faqs', $item['translation_group_id'], array(
                    'question' => $this->input->post('question_id'),
                    'answer' => $this->input->post('answer_id'),
                ), array('en', 'cn', 'de', 'ja'), 'question', true);

                $this->session->set_flashdata('success', 'FAQ berhasil diperbarui.');
                redirect('admin/faqs');
            }
        }

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/faqs/form', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function delete($id)
    {
        if ($this->input->method() !== 'post') show_404();

        $item = $this->db->where('id', $id)->get('faqs')->row_array();
        if (!$item) show_404();

        $this->db->trans_start();
        $this->_delete_translation_group('faqs', $item['translation_group_id']);
        $this->db->trans_complete();

        $this->session->set_flashdata('success', 'FAQ berhasil dihapus.');
        redirect('admin/faqs');
    }
}
