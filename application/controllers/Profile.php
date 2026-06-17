<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/userguide3/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        // Pastikan library session sudah di-load (bisa juga di autoload.php)
        $this->load->library('session');

        // Proteksi: Jika tidak ada session, tendang ke login
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
    }

    public function get_referal()
    {
        $data = $this->db->get('referal')->result();

        echo json_encode($data);
    }

    public function user()
    {
        $data['user'] = $this->session->userdata();
        $data['title'] = "Data Profile";
        $this->template->load('template/profile', $data);
    }
    public function update_action()
    {
        $id = $this->input->post('id');

        // Siapkan data dari POST
        $data = [
            'nik' => $this->input->post('nik'),
            'npwp' => $this->input->post('npwp'),
            'noTelepon' => $this->input->post('noTelepon'),
            'alamat' => $this->input->post('alamat'),
            'bank' => $this->input->post('bank'),
            'noRek' => $this->input->post('noRek'),
            'referal' => $this->input->post('referal'),
        ];
        $this->db->where('id', $id);
        $update = $this->db->update('users', $data); // Ganti user_table_name sesuai nama tabel Anda

        if ($update) {
            // PENTING: Update data session agar tampilan header/profil langsung berubah
            $current_session = $this->session->userdata();
            $new_session = array_merge($current_session, $data);
            $this->session->set_userdata($new_session);

            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Database error']);
        }
    }

    public function MasterAkses($action)
    {
        $id_users = $this->input->post('id');

        $data['row'] = $this->db->get_where('users', ['id_users' => $id_users])->row();
        $data['format'] = $this->Halal_model->format_action('format_tambah_users', $action)->result();
        $data['action'] = $action;
        $this->load->view('profile/viewProfile', $data);
    }
    public function MasterAksesData($action)
    {
        $id_users = $this->input->post('id');

        $data['row'] = $this->db->get_where('users', ['id_users' => $id_users])->row();
        $data['menus'] = $this->db->get('user_menu')->result();

        $akses = $this->db->get_where('user_access_menu', [
            'role_id' => $id_users
        ])->result();

        $akses_menu = [];

        foreach ($akses as $a) {
            $akses_menu[] = $a->menu_id;
        }
        $data['akses_menu'] = $akses_menu;

        $data['format'] = $this->Halal_model->format_action('format_tambah_users', $action)->result();
        $data['modul'] = $this->Halal_model->fetch_data_by_modul('user_menu', 'modul');
        $data['action'] = $action;
        $this->load->view('profile/viewAkses', $data);
    }

    public function save_access()
    {
        $role_id = $this->input->post('id');
        $menus   = $this->input->post('menu'); // menu yang dicentang

        // ambil semua menu
        $all_menu = $this->db->get('user_menu')->result();

        foreach ($all_menu as $menu) {

            $menu_id = $menu->id;

            if (is_array($menus) && in_array($menu_id, $menus)) {

                // cek apakah sudah ada
                $exist = $this->db->get_where('user_access_menu', [
                    'role_id' => $role_id,
                    'menu_id' => $menu_id
                ])->row();

                if (!$exist) {

                    // jika belum ada → insert
                    $this->db->insert('user_access_menu', [
                        'role_id' => $role_id,
                        'menu_id' => $menu_id
                    ]);
                }
            } else {

                // jika tidak dicentang → hapus akses
                $this->db->where('role_id', $role_id);
                $this->db->where('menu_id', $menu_id);
                $this->db->delete('user_access_menu');
            }
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Hak akses berhasil disimpan'
        ]);
    }
}
