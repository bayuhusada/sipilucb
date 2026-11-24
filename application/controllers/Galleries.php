<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galleries extends CI_Controller {

    public function index()
    {
        $this->load->helper('text');
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $lang = current_lang();

        $data['title'] = 'Galeri';
        $data['active_nav'] = 'galeri';
        $data['settings'] = $settings;
        $search = $this->input->get('q');
        $data['search'] = $search;

        $this->load->library('pagination');

        $base_where = array('is_active' => 1, 'lang' => $lang);
        $this->db->where($base_where);
        if ($search) {
            $this->db->group_start()
                ->like('title', $search)
                ->or_like('description', $search)
                ->group_end();
        }
        $total = $this->db->count_all_results('galleries');

        if ($total === 0 && $lang !== 'id') {
            $base_where_id = array('is_active' => 1, 'lang' => 'id');
            $this->db->where($base_where_id);
            if ($search) {
                $this->db->group_start()
                    ->like('title', $search)
                    ->or_like('description', $search)
                    ->group_end();
            }
            $total = $this->db->count_all_results('galleries');
        }

        $config['base_url'] = base_url('galeri');
        $config['total_rows'] = $total;
        $config['per_page'] = 12;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;
        $config['full_tag_open'] = '<div class="pagination">';
        $config['full_tag_close'] = '</div>';
        $config['attributes'] = array('class' => 'pagination-link');
        $config['cur_tag_open'] = '<span class="pagination-link active">';
        $config['cur_tag_close'] = '</span>';
        $this->pagination->initialize($config);

        $page = $this->input->get('page') ? (int) $this->input->get('page') : 0;

        $this->db->where($base_where);
        if ($search) {
            $this->db->group_start()
                ->like('title', $search)
                ->or_like('description', $search)
                ->group_end();
        }
        $data['albums'] = $this->db
            ->order_by('created_at', 'DESC')
            ->limit($config['per_page'], $page)
            ->get('galleries')->result_array();

        if (empty($data['albums']) && $lang !== 'id') {
            $base_where_fallback = array('is_active' => 1, 'lang' => 'id');
            $this->db->where($base_where_fallback);
            if ($search) {
                $this->db->group_start()
                    ->like('title', $search)
                    ->or_like('description', $search)
                    ->group_end();
            }
            $data['albums'] = $this->db
                ->order_by('created_at', 'DESC')
                ->limit($config['per_page'], $page)
                ->get('galleries')->result_array();
        }

        $data['pagination_links'] = $this->pagination->create_links();

        if (!empty($data['albums'])) {
            // map each album to the correct gallery_id for images (ID language's ID)
            $tgid_map = [];
            foreach ($data['albums'] as &$a) {
                $gid = $a['id'];
                if ($a['lang'] !== 'id' && !empty($a['translation_group_id'])) {
                    if (!isset($tgid_map[$a['translation_group_id']])) {
                        $id_row = $this->db->select('id')->from('galleries')
                            ->where('translation_group_id', $a['translation_group_id'])
                            ->where('lang', 'id')->get()->row_array();
                        $tgid_map[$a['translation_group_id']] = $id_row ? $id_row['id'] : $a['id'];
                    }
                    $gid = $tgid_map[$a['translation_group_id']];
                }
                $a['_image_gid'] = $gid;
            }
            // batch load all images for all gallery IDs
            $all_gids = array_unique(array_column($data['albums'], '_image_gid'));
            $all_images = $this->db->where_in('gallery_id', $all_gids)
                ->order_by('sort_order', 'ASC')
                ->get('gallery_images')->result_array();
            $images_by_gid = [];
            foreach ($all_images as $img) {
                $images_by_gid[$img['gallery_id']][] = $img;
            }
            foreach ($data['albums'] as &$a) {
                $a['images'] = $images_by_gid[$a['_image_gid']] ?? [];
                $a['cover'] = !empty($a['cover_image']) ? array('image' => $a['cover_image']) : ($a['images'][0] ?? null);
                $a['image_count'] = count($a['images']);
                unset($a['_image_gid']);
            }
        }

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/galleries/index', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }

    public function album($id)
    {
        $this->load->model('setting_model');
        $settings = $this->setting_model->get_all_lang(current_lang());

        $lang = current_lang();

        $album = $this->db->where('id', $id)->where('is_active', 1)->get('galleries')->row_array();
        if (!$album && $lang !== 'id') {
            $fallback = $this->db->select('translation_group_id')->where('id', $id)->get('galleries')->row_array();
            if ($fallback) {
                $album = $this->db->where('translation_group_id', $fallback['translation_group_id'])
                    ->where('lang', 'id')->where('is_active', 1)
                    ->get('galleries')->row_array();
            }
        }
        if (!$album) show_404();

        // use ID gallery ID for images lookup
        $image_gallery_id = $album['id'];
        if ($album['lang'] !== 'id' && !empty($album['translation_group_id'])) {
            $id_album = $this->db->select('id')->from('galleries')
                ->where('translation_group_id', $album['translation_group_id'])
                ->where('lang', 'id')->get()->row_array();
            if ($id_album) $image_gallery_id = $id_album['id'];
        }

        $data['title'] = $album['title'];
        $data['active_nav'] = 'galeri';
        $data['settings'] = $settings;
        $data['album'] = $album;

        $data['images'] = $this->db
            ->where('gallery_id', $image_gallery_id)
            ->order_by('sort_order', 'ASC')
            ->get('gallery_images')->result_array();

        $this->load->view('template/frontend/header', $data);
        $this->load->view('frontend/galleries/album', $data);
        $this->load->view('template/frontend/footer', $data);
        $this->load->view('template/frontend/js', $data);
    }
}
