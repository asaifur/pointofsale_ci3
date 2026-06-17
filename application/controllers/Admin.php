<?php

class Admin_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Cek login admin
        if (!$this->session->userdata('login')) {
            redirect('admin/login');
        }
    }
}
