<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_model extends CI_Model
{

    public function get_all_laporan()
    {
        // Fetching data ordered by newest entry
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('jobdesk')->result_array();
    }
    public function get_all_user()
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
        <button type="button" class="btn btn-sm btn-danger btn-send-email" data-id="$1">
            <i class="fa fa-envelope"></i> Kirim PKWT
        </button>
        <button type="button" class="btn btn-sm btn-info btn-print" data-id="$1">
            <i class="fas fa-print"></i> Print Kontrak Kerja
        </button>
    ', 'id_users');
        $this->datatables->where('referal', $session_referal);
        $this->db->order_by('id_users DESC');
        return $this->datatables->generate();
    }

    public function getCountJobdesk()
    {
        $this->db->select('COUNT(*) as total_jobdesk');
        $this->db->from('jobdesk');
        $this->db->where('created_at >=', date('Y-m-01'));
        $this->db->where('created_at <=', date('Y-m-t'));
        $query = $this->db->get()->row();
        return $query->total_jobdesk;
    }
    public function get_all_jobdesk()
    {
        $session_referal = $this->session->userdata('referal');
        $qc_status       = $this->input->post('qc_status');
        $keyword = $this->input->post('keyword');


        /* =========================
         * SELECT DATA (AMAN SEARCH)
         * ========================= */
        $this->datatables->select("
    jobdesk.id,
    jobdesk.ppph,
    jobdesk.namaPU,
    jobdesk.nik,
    jobdesk.noTelepon,
    jobdesk.nomorDaftar,
    jobdesk.ktp_source,
    jobdesk.namaUsaha,
    jobdesk.provinsi,
    jobdesk.kota,
    jobdesk.kecamatan,
    jobdesk.kelurahan,
    jobdesk.rtrw,
    jobdesk.kodepos,

    jobdesk.produk1, jobdesk.fotoProduk1, jobdesk.videoProduk1, jobdesk.vervalProduk1,
    jobdesk.produk2, jobdesk.fotoProduk2, jobdesk.videoProduk2, jobdesk.vervalProduk2,
    jobdesk.produk3, jobdesk.fotoProduk3, jobdesk.videoProduk3, jobdesk.vervalProduk3,
    jobdesk.produk4, jobdesk.fotoProduk4, jobdesk.videoProduk4, jobdesk.vervalProduk4,
    jobdesk.produk5, jobdesk.fotoProduk5, jobdesk.videoProduk5, jobdesk.vervalProduk5,
    jobdesk.produk6, jobdesk.fotoProduk6, jobdesk.videoProduk6, jobdesk.vervalProduk6,
    jobdesk.produk7, jobdesk.fotoProduk7, jobdesk.videoProduk7, jobdesk.vervalProduk7,

    jobdesk.source_image,
    jobdesk.user,
    jobdesk.nib,
    jobdesk.created_at,
    jobdesk.id_referal,
    jobdesk.qc,
    jobdesk.keterangan,
    jobdesk.id_database,
    jobdesk.noUrut,
    jobdesk.email_baru_dibuat,
    jobdesk.password_baru_dibuat,

    users.username AS user_name,

    IF(
        jobdesk.qc = 1,
        '<span class=\"badge bg-success\">Sudah QC</span>',
        '<span class=\"badge bg-warning text-dark\">Belum QC</span>'
    ) AS check_qc
", false);

        $this->datatables->from('jobdesk');
        $this->db->join(
            'users',
            'users.email = jobdesk.user',
            'left' // pakai left join supaya data tetap tampil walau user tidak ada
        );

        $this->datatables->where('jobdesk.id_referal', $session_referal);
        if ($qc_status != '') {
            $this->datatables->where('jobdesk.qc', $qc_status);
        }

        /* =========================
         * KOLOM TAMBAHAN
         * ========================= */
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('jobdesk.ppph', $keyword);
            $this->db->or_like('jobdesk.namaPU', $keyword);
            $this->db->or_like('jobdesk.nib', $keyword);
            $this->db->or_like('jobdesk.nik', $keyword);
            $this->db->or_like('jobdesk.produk1', $keyword);
            $this->db->or_like('jobdesk.produk2', $keyword);
            $this->db->or_like('jobdesk.noTelepon', $keyword);
            $this->db->or_like('users.username', $keyword); // 🔹 search username
            $this->db->group_end();
        }
        // 🔹 Tombol Lihat Gambar
        $this->datatables->add_column(
            'buttonImg',
            '
        <button type="button" class="row-img btn btn-sm btn-secondary" data-img="$1">
            <i class="fas fa-image"></i> Lihat Gambar
        </button>
        ',
            'source_image'
        );


        $this->db->order_by('jobdesk.id', 'DESC');
        /* =========================
         * OUTPUT
         * ========================= */
        return $this->datatables->generate();
    }

    function get_user_kontrak($id)
    {
        return $this->db->get_where('users', ['id_users' => $id])->row_array();
    }

    public function view_transaksi_supervisi()
    {
        $this->datatables->select('id, nib,ppph, noTelepon,source_image, user, namaPU, nik, produk1, produk2, created_at');
        $referal = $this->session->userdata('referal');
        $this->datatables->from('jobdesk');
        $this->datatables->where('id_referal', $referal);
        $this->datatables->where('qc', '0');

        // Pastikan order_by diletakkan sebelum generate
        $this->db->order_by('id', 'DESC');
        return $this->datatables->generate();
    }

    public function get_data($table, $where = null)
    {
        $this->db->select('*');
        $this->db->from($table);
        if ($where) {
            $this->db->where($where);
        }
        $query = $this->db->get();
        return $query;
    }

    public function delete_data_by($table, $where)
    {
        $query = $this->db->delete($table, $where);
        return $query;
    }
}
