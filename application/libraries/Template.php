<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Template
{
    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function load($view, $data = array())
    {
        // PERBAIKAN: Pastikan $data adalah array
        if (!is_array($data)) {
            $data = array('title' => $data); // Jika $data string, masukkan ke index title
        }

        // Ambil role dari session
        $userdata = $this->ci->session->userdata();
        $role_id = $userdata['id_users'];
        $admin = $userdata['is_admin'];
        // Load model & ambil menu secara otomatis
        $this->ci->load->model('User_model');

        // Baris 22: Sekarang aman karena $data sudah pasti array
        $data['modul'] = $this->ci->User_model->fetch_data_by_modul('user_menu', 'modul');
        $menus = $this->ci->User_model->getMenu($admin, $role_id);
        $groupedMenus = [];

        foreach ($menus as $m) {
            $groupedMenus[$m->modul][] = $m;
        }
        $data['menus'] = $groupedMenus;
        // Load konten utama ke dalam variabel 'contents'
        $data['contents'] = $this->ci->load->view($view, $data, TRUE);

        // Load file wrapper utama (main.php)
        return $this->ci->load->view('template/main', $data);
    }
}
