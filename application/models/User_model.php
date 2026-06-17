<?php
class User_model extends CI_Model
{
    public function check_login($username)
    {
        return $this->db->get_where('users', ['email' => $username])->row_array();
    }
    public function register($data)
    {
        return $this->db->insert('users', $data);
    }
    public function getMenuByRole($role_id)
    {
        $this->db->select('user_menu.*');
        $this->db->from('user_menu');
        $this->db->join('user_access_menu', 'user_menu.id = user_access_menu.menu_id');
        $this->db->where('user_access_menu.role_id', $role_id);
        $this->db->where('user_menu.is_active', 1);
        $this->db->order_by('urut', 'asc');
        $this->db->order_by('modul', 'ASC');
        return $this->db->get()->result();
    }


    public function getMenu($admin, $role_id)
    {
        if ($admin == 1) {

            $this->db->select('user_menu.*');
            $this->db->from('user_menu');
            $this->db->where('user_menu.is_active', 1);
            $this->db->order_by('urut', 'asc');
            $this->db->order_by('modul', 'ASC');
        } else {
            $this->db->select('user_menu.*');
            $this->db->from('user_menu');
            $this->db->join('user_access_menu', 'user_menu.id = user_access_menu.menu_id');
            $this->db->where('user_access_menu.role_id', $role_id);
            $this->db->where('user_menu.is_active', 1);
            $this->db->order_by('urut', 'asc');
            $this->db->order_by('modul', 'ASC');
        }
        return $this->db->get()->result();
    }

    public function fetch_data_by_modul($table, $modul)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->group_by($modul);
        $query = $this->db->get();
        return $query->result();
    }
    public function view_all_user_access()
    {
        $session_referal = $this->session->userdata('referal');
        $this->datatables->select('id_users,username,password,email,role,date_created,noTelepon,bank,noRek,alamat,nik,npwp,referal,IF(
            pkwt = 1,
            "<span class=\'badge bg-success\'>PKWT Terkirim</span>",
            "<span class=\'badge bg-warning text-dark\'>Belum Dikirim</span>"
        ) AS check_pkwt');
        $this->datatables->from('users');
        // Perbaikan: Ganti #1 menjadi $1 agar ID terisi otomatis
        $this->datatables->add_column('aksi', '
        <button type="button" class="btn btn-sm btn-info btn-view" data-id="$1">
            <i class="fas fa-eye"></i> Detail
        </button>
        <button type="button" class="btn btn-sm btn-success btn-update" data-id="$1">
            <i class="fa fa-pencil-alt"></i> Update
        </button>
        <button type="button" class="btn btn-sm btn-warning btn-update-akses" data-id="$1">
            <i class="fa fa-user-tie"></i> Tambah Hak Akses
        </button>
    ', 'id_users');
        $this->db->order_by('id_users DESC');
        return $this->datatables->generate();
    }
}
