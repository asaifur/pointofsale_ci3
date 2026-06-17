<?php

defined('BASEPATH') or exit('No direct script access allowed');



class FormHalal extends CI_Controller

{

    public function index()
    {
        $umum = $this->Halal_model->format_action('format_tambah_pu', "insert")->result();

        $data = [
            'action' => "insert",
            'format' => $umum,
            'provinsi' => $this->Halal_model->getProvinsi(),
            'user' => $this->Halal_model->fetch_data('users', ['role' => 2])
        ];
        $this->load->view('adminlte/databaru', $data);
    }

    public function cek_field()
    {
        $type  = strtolower($this->input->post('type'));
        $value = $this->input->post('value');

        if ($type == 'nik') {

            $cek = $this->db->get_where('pemilikusaha', [
                'nik' => $value
            ])->row();

            echo json_encode(['exists' => $cek ? true : false]);
        }

        if ($type == 'nohp') {

            $cek = $this->db->get_where('pemilikusaha', [
                'noHP' => $value
            ])->row();

            echo json_encode(['exists' => $cek ? true : false]);
        }
    }
    public function get_user_autocomplete()
    {
        $keyword = $this->input->post('keyword');

        $this->db->select('id_users, username, email');
        $this->db->from('users');
        $this->db->like('username', $keyword);
        $this->db->or_like('email', $keyword);
        $this->db->where('role', '2');
        $this->db->limit(10);

        $query = $this->db->get();
        $data = [];

        foreach ($query->result() as $row) {
            $data[] = [
                "label" => $row->username . " - (" . $row->id_users . ")",
                "value" => $row->username, // ini yg masuk ke input utama
                "nama"  => $row->username,
                "email" => $row->email
            ];
        }

        echo json_encode($data);
    }

    public function MasterPlan($kelompok, $produk = null)
    {
        // Jika kelompok adalah produk dan ada nomor produk
        if ($kelompok == 'produk' && $produk != null) {
            $group = 'produk' . $produk;
        } else {
            $group = $kelompok;
        }

        $query = $this->Halal_model
            ->format_action('format_tambah_pu', "insert", ['group' => $group])
            ->result();

        $data['provinsi'] = $this->Halal_model->getProvinsi();
        $data['format'] = $query;
        $data['group']  = $group; // optional kalau mau dipakai di view

        $this->load->view('adminlte/MasterPlan', $data);
    }
}
