<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function index()
    {
        $this->require_login();

        $this->load->model('user_model');
        $this->data['title'] = 'Dashboard';

        // Total counts
        $this->data['total_users'] = $this->db->count_all_results('users');
        $this->data['total_berita'] = $this->db->count_all_results('news');
        $this->data['total_agenda'] = $this->db->count_all_results('agendas');
        $this->data['total_galeri'] = $this->db->count_all_results('galleries');
        $this->data['total_download'] = $this->db->count_all_results('downloads');

        // Berita per bulan (12 bulan terakhir)
        $berita_per_bulan = array();
        for ($i = 11; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-{$i} months"));
            $count = $this->db
                ->like('created_at', $month, 'after')
                ->count_all_results('news');
            $berita_per_bulan[] = array(
                'month' => date('M Y', strtotime($month . '-01')),
                'count' => (int) $count
            );
        }
        $this->data['berita_per_bulan'] = $berita_per_bulan;

        // Dosen (total count — no prodi grouping)
        $this->data['total_dosen'] = $this->db->where('is_active', 1)->where('lang', 'id')->count_all_results('lecturers');

        // Berita draft vs published
        $this->data['berita_draft'] = (int) $this->db->where('is_draft', 1)->count_all_results('news');
        $this->data['berita_published'] = (int) $this->db->where('is_draft', 0)->count_all_results('news');

        // Top 5 berita paling dilihat
        $this->data['top_berita'] = $this->db
            ->select('title, slug, view_count')
            ->where('is_draft', 0)
            ->order_by('view_count', 'DESC')
            ->limit(5)
            ->get('news')->result_array();

        // Page visits
        $this->data['total_visits'] = (int) $this->db->select_sum('hits')->get('page_hits')->row()->hits;
        $today_hits = $this->db->where('hit_date', date('Y-m-d'))->get('page_hits')->row_array();
        $this->data['today_visits'] = $today_hits ? (int) $today_hits['hits'] : 0;

        // Daily visits for chart (30 hari)
        $daily_visits = array();
        for ($i = 29; $i >= 0; $i--) {
            $d = date('Y-m-d', strtotime("-{$i} days"));
            $row = $this->db->where('hit_date', $d)->get('page_hits')->row_array();
            $daily_visits[] = array(
                'date' => date('d M', strtotime($d)),
                'hits' => $row ? (int) $row['hits'] : 0
            );
        }
        $this->data['daily_visits'] = $daily_visits;

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('dashboard/index', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }
}
