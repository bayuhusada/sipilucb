<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translate extends MY_Controller {

    private $tables = array(
        'news' => array('title', 'content', 'source_url', 'seo_title', 'seo_description'),
        'agendas' => array('title', 'location', 'description'),
        'faqs' => array('question', 'answer'),
        'banners' => array('title', 'subtitle'),
        'news_categories' => array('name'),
        'downloads' => array('title', 'description'),
        'galleries' => array('title', 'description'),
        'lecturers' => array('name', 'front_title', 'back_title', 'position', 'expertise', 'education_history'),
        'nav_menus' => array('label'),
        'study_programs' => array('name', 'description', 'vision', 'mission', 'graduate_profile'),
    );

    public function __construct()
    {
        parent::__construct();
        $this->require_role('superadmin');
    }

    public function index()
    {
        $this->data['title'] = 'Auto Translate';

        $tables = $this->tables;

        $stats = array();
        foreach ($tables as $table => $fields) {
            $id_rows = $this->db->where('lang', 'id')->get($table)->result_array();
            $total = count($id_rows);

            $tgids = array_column($id_rows, 'translation_group_id');
            $tgids = array_filter($tgids);
            if (empty($tgids)) {
                $stats[] = array(
                    'table' => $table,
                    'label' => ucfirst(str_replace('_', ' ', $table)),
                    'fields' => $fields,
                    'total' => 0,
                    'missing_en' => 0,
                    'missing_cn' => 0,
                    'missing_de' => 0,
                    'missing_ja' => 0,
                );
                continue;
            }

            // Single query: get all existing langs per group
            $existing_rows = $this->db->select('translation_group_id, GROUP_CONCAT(lang) as langs')
                ->where_in('translation_group_id', $tgids)
                ->where_in('lang', array('en', 'cn', 'de', 'ja'))
                ->group_by('translation_group_id')
                ->get($table)
                ->result_array();

            $existing_by_tgid = array();
            foreach ($existing_rows as $r) {
                $existing_by_tgid[$r['translation_group_id']] = explode(',', $r['langs']);
            }

            $missing_en = $missing_cn = $missing_de = $missing_ja = 0;
            foreach ($tgids as $tgid) {
                $langs = $existing_by_tgid[$tgid] ?? array();
                if (!in_array('en', $langs)) $missing_en++;
                if (!in_array('cn', $langs)) $missing_cn++;
                if (!in_array('de', $langs)) $missing_de++;
                if (!in_array('ja', $langs)) $missing_ja++;
            }

            // Single query: get all translations at once
            $all_rows = $this->db->where_in('translation_group_id', $tgids)
                ->get($table)
                ->result_array();

            $translations_by_tgid = array();
            foreach ($all_rows as $r) {
                $tgid = $r['translation_group_id'];
                $lang = $r['lang'];
                unset($r['translation_group_id'], $r['lang'], $r['id'], $r['created_at']);
                $translations_by_tgid[$tgid][$lang] = $r;
            }

            $missing_en_content = $missing_cn_content = $missing_de_content = $missing_ja_content = 0;
            $check_field = in_array('title', $fields) ? 'title' : (in_array('name', $fields) ? 'name' : (in_array('label', $fields) ? 'label' : null));

            foreach ($id_rows as $id_row) {
                $tgid = $id_row['translation_group_id'];
                $tl = $translations_by_tgid[$tgid] ?? array();
                $en = $tl['en'] ?? null;
                $cn = $tl['cn'] ?? null;
                $de = $tl['de'] ?? null;
                $ja = $tl['ja'] ?? null;
                if (!$en || ($check_field && empty($en[$check_field]))) $missing_en_content++;
                if (!$cn || ($check_field && empty($cn[$check_field]))) $missing_cn_content++;
                if (!$de || ($check_field && empty($de[$check_field]))) $missing_de_content++;
                if (!$ja || ($check_field && empty($ja[$check_field]))) $missing_ja_content++;
            }

            $stats[] = array(
                'table' => $table,
                'label' => ucfirst(str_replace('_', ' ', $table)),
                'fields' => $fields,
                'total' => $total,
                'missing_en' => $missing_en_content,
                'missing_cn' => $missing_cn_content,
                'missing_de' => $missing_de_content,
                'missing_ja' => $missing_ja_content,
            );
        }

        $this->data['stats'] = $stats;
        $this->data['tables'] = $tables;

        $this->load->view('template/header', $this->data);
        $this->load->view('template/aside', $this->data);
        $this->load->view('admin/translate/index', $this->data);
        $this->load->view('template/footers', $this->data);
        $this->load->view('template/js', $this->data);
    }

    public function generate_all()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $table = $this->input->post('table');
        $target = $this->input->post('target'); // 'en', 'cn', 'de', or 'ja'

        $tables = $this->tables;

        if (!isset($tables[$table]) || !in_array($target, array('en', 'cn', 'de', 'ja'))) {
            echo json_encode(array('status' => 'error', 'message' => 'Parameter tidak valid.'));
            return;
        }

        $fields = $tables[$table];

        $id_rows = $this->db->where('lang', 'id')->get($table)->result_array();

        $translated = 0;
        $errors = 0;

        $this->load->library('translator');

        foreach ($id_rows as $id_row) {
            $tgid = $id_row['translation_group_id'];
            $translations = $this->_load_translations($table, $tgid);

            $existing = $translations[$target] ?? null;
            $title_field = in_array('title', $fields) ? 'title' : (in_array('name', $fields) ? 'name' : (in_array('label', $fields) ? 'label' : null));

            if ($existing && $title_field && !empty($existing[$title_field])) {
                continue; // already translated
            }

            $source_texts = array();
            foreach ($fields as $field) {
                if (!empty($id_row[$field])) {
                    $source_texts[$field] = $id_row[$field];
                }
            }

            if (empty($source_texts)) continue;

            $results = $this->_auto_translate($table, $tgid, $source_texts, $target);

            if (!empty($results)) {
                $translated++;
            } else {
                $errors++;
            }
        }

        $label = $target === 'en' ? 'English' : ($target === 'cn' ? '中文' : ($target === 'de' ? 'Deutsch' : '日本語'));

        echo json_encode(array(
            'status' => 'done',
            'message' => "{$label}: {$translated} item berhasil diterjemahkan" . ($errors ? ", {$errors} gagal." : ".")
        ));
    }
}
