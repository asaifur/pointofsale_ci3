<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public $domain;

    public function __construct()
    {
        parent::__construct();

        $this->load->database();

        // Detect domain
        $host = $_SERVER['HTTP_HOST'];

        // Ambil data domain dari database
        $this->domain = $this->db
            ->where('url_domain', $host)
            ->where('is_active', 1)
            ->get('table_domain')
            ->row_array();

        // Jika domain tidak terdaftar
        if (!$this->domain) {
            show_404();
        }

        // Share ke semua view
        $this->load->vars([
            'domain' => $this->domain
        ]);
    }
}
