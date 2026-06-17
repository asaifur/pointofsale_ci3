<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pages_model');
    }

    public function view($slug = null)
    {
        if (!$slug) {
            show_404();
        }

        // Ambil domain_id (sesuaikan dengan sistem kamu)
        $domain_id = $this->domain_id;

        $page = $this->Pages_model->get_page_by_slug($slug, $domain_id);

        if (!$page) {
            show_404();
        }

        // Set meta SEO
        $data['meta_title']       = $page->meta_title ?: $page->nama_halaman;
        $data['meta_description'] = $page->meta_description;
        $data['meta_keywords']    = $page->meta_keywords;
        $data['meta_robots']      = $page->meta_robots;
        $data['og_title']         = $page->og_title;
        $data['og_description']   = $page->og_description;
        $data['og_image']         = $page->og_image;
        $data['canonical_url']    = $page->canonical_url ?: base_url($page->slug);

        $data['page'] = $page;

        $this->load->view('template/header', $data);
        $this->load->view('pages/view', $data);
        $this->load->view('template/footer');
    }
}
