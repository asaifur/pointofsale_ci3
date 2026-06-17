<?php
class Halal_model extends CI_Model
{
    public function Transaksi_NIB()
    {
        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');

        $this->datatables->select('id,ppph,namaPU,nik,noTelepon,nomorDaftar,ktp_source,namaUsaha,provinsi,kota,kecamatan,kelurahan,rtrw,kodepos,produk1,fotoProduk1,videoProduk1,vervalProduk1,produk2,fotoProduk2,videoProduk2,vervalProduk2,produk3,fotoProduk3,videoProduk3,vervalProduk3,produk4,fotoProduk4,videoProduk4,vervalProduk4,produk5,fotoProduk5,videoProduk5,vervalProduk5,produk6,fotoProduk6,videoProduk6,vervalProduk6,produk7,fotoProduk7,videoProduk7,vervalProduk7,source_image,user,nib,created_at,id_referal,qc,keterangan,id_database,noUrut,email_baru_dibuat,password_baru_dibuat');

        $email_user = $this->session->userdata('email');
        $referal = $this->session->userdata('referal');
        $this->datatables->from('jobdesk');
        $this->datatables->where('user', $email_user);
        $this->datatables->where('id_referal', $referal);
        // $this->datatables->where("created_at BETWEEN '$today_start' AND '$today_end'");
        // Pastikan order_by diletakkan sebelum generate
        $this->db->order_by('id', 'DESC');
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

    public function get_sppl_datatables()
    {
        // 1. Pilih kolom yang diperlukan
        $this->datatables->select('id, no_sppl, namaPU, noTelepon, created_date, noNIB, nomorNKU');
        $this->datatables->from('sppl');
        $email_user = $this->session->userdata('email');
        $this->datatables->where('created_by', $email_user);

        // 3. Tambahkan kolom aksi
        // Perbaikan: Ganti #1 menjadi $1 agar ID terisi otomatis
        $this->datatables->add_column('aksi', '
        <button type="button" class="btn btn-sm btn-info btn-view" data-id="$1">
            <i class="fas fa-eye"></i> Detail
        </button>
        <button type="button" class="btn btn-sm btn-danger " data-id="$1">
            <i class="fa fa-trash"></i> Hapus
        </button>
        <button type="button" class="btn btn-sm btn-info btn-print" data-id="$1">
            <i class="fas fa-print"></i> Print SPPL
        </button>
    ', 'id');
        $this->db->order_by('id DESC');
        return $this->datatables->generate();
    }

    public function getById($id)
    {
        return $this->db
            ->where('id', $id)
            ->get('jobdesk')
            ->row();
    }

    public function format_action($table, $action, $where = null)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($action, '1');
        if ($where) {
            $this->db->where($where);
        }
        $this->db->order_by('urut', 'ASC');
        $query = $this->db->get();
        return $query;
    }


    public function get_daftar_qc_2()
    {
        $tgl_dari   = $this->input->post('tgl_dari');
        $tgl_sampai = $this->input->post('tgl_sampai');
        $role       = $this->session->userdata('role');
        // FILTER TANGGAL BETWEEN
        if (!empty($tgl_dari) && !empty($tgl_sampai)) {

            $this->db->where('DATE(created_at) >=', $tgl_dari);
            $this->db->where('DATE(created_at) <=', $tgl_sampai);
        }

        // FILTER STATUS
        $this->datatables->select('id,namaUser,userP3H,namaPU,alamat,noHP,nik,email,pass,tempatUsahaName,tempatUsahaAlamat,provinsi_id,provinsi_nama,kabupaten_id,kabupaten_nama,kecamatan_id,kecamatan_nama,kelurahan_id,kelurahan_nama,kodepos,fotoKtp,nameProduk1,fotoProduk1,videoProduk1,vervalProduk1,nameProduk2,fotoProduk2,videoProduk2,vervalProduk2,fotoProduk3,videoProduk3,vervalProduk3,fotoProduk4,vervalProduk4,videoProduk4,fotoProduk5,vervalProduk5,videoProduk5,fotoProduk6,vervalProduk6,videoProduk6,fotoProduk7,vervalProduk7,videoProduk7,nameProduk3,nameProduk4,nameProduk5,nameProduk6,nameProduk7,user,created_at,created_by,qc_foto,update_created_date_qc_foto,update_created_by_qc_foto,qc_email,update_created_date_qc_email,catatan,pembuatan,nib,STTD,keteranganNIB,SH,uploadSH,qc_nib,update_created_date_qc_nib,update_created_by_qc_nib,update_created_by_qc_sh,update_created_date_qc_sh,keterangan_status');
        $this->datatables->from('pemilikusaha');
        $this->datatables->where('qc_foto', 1);
        $this->datatables->where('qc_email', 0);
        $email_user = $this->session->userdata('email');
        if ($role == 2) {
            $this->datatables->where('userP3H', $email_user);
        }
        $this->datatables->add_column('aksi', '
        <button type="button" class="btn btn-sm btn-info btn-update" data-id="$1">
            <i class="fas fa-print"></i> Update Jobdesk
        </button>
          <button type="button"
            class="btn btn-sm btn-success btn-update-qc-email"
            data-id="$1"
            $2>
            <i class="fas fa-check"></i> Check QC
        </button>
    ', 'id');
        $this->db->order_by('id DESC');
        return $this->datatables->generate();
    }


    public function get_daftar_pu()
    {
        $tgl_dari   = $this->input->post('tgl_dari');
        $tgl_sampai = $this->input->post('tgl_sampai');
        $status     = $this->input->post('status');
        $role       = $this->session->userdata('role');
        // FILTER TANGGAL BETWEEN
        if (!empty($tgl_dari) && !empty($tgl_sampai)) {

            $this->db->where('DATE(created_at) >=', $tgl_dari);
            $this->db->where('DATE(created_at) <=', $tgl_sampai);
        }

        // FILTER STATUS
        if ($status !== "") {
            $this->db->where('qc_foto', $status);
        }

        $this->datatables->select('id,namaUser,userP3H,namaPU,alamat,noHP,nik,email,pass,tempatUsahaName,tempatUsahaAlamat,provinsi_id,provinsi_nama,kabupaten_id,kabupaten_nama,kecamatan_id,kecamatan_nama,kelurahan_id,kelurahan_nama,kodepos,fotoKtp,nameProduk1,fotoProduk1,videoProduk1,vervalProduk1,nameProduk2,fotoProduk2,videoProduk2,vervalProduk2,fotoProduk3,videoProduk3,vervalProduk3,fotoProduk4,vervalProduk4,videoProduk4,fotoProduk5,vervalProduk5,videoProduk5,fotoProduk6,vervalProduk6,videoProduk6,fotoProduk7,vervalProduk7,videoProduk7,nameProduk3,nameProduk4,nameProduk5,nameProduk6,nameProduk7,user,created_at,created_by,qc_foto,update_created_date_qc_foto,update_created_by_qc_foto,qc_email,update_created_date_qc_email,catatan,pembuatan,nib,STTD,keteranganNIB,SH,uploadSH,qc_nib,update_created_date_qc_nib,update_created_by_qc_nib,update_created_by_qc_sh,update_created_date_qc_sh,keterangan_status');
        $this->datatables->from('pemilikusaha');
        $email_user = $this->session->userdata('email');
        if ($role == 2) {
            $this->datatables->where('userP3H', $email_user);
        }
        $this->datatables->add_column('aksi', '
    <button type="button" class="btn btn-sm btn-info btn-view" data-id="$1">
        <i class="fas fa-eye"></i> Detail
    </button>

    <?php if ($2 == 0  $3 != null) { ?>
        <button type="button" class="btn btn-sm btn-warning btn-update" data-id="$1">
            <i class="fa fa-pencil-alt"></i> Update PU
        </button>
    <?php } ?>
', 'id,qc_foto,update_created_by_qc_foto');
        $this->db->order_by('id DESC');
        return $this->datatables->generate();
    }

    public function get_daftar_qc_3()
    {
        $tgl_dari   = $this->input->post('tgl_dari');
        $tgl_sampai = $this->input->post('tgl_sampai');
        $role       = $this->session->userdata('role');
        // FILTER TANGGAL BETWEEN
        if (!empty($tgl_dari) && !empty($tgl_sampai)) {

            $this->db->where('DATE(created_at) >=', $tgl_dari);
            $this->db->where('DATE(created_at) <=', $tgl_sampai);
        }

        // FILTER STATUS

        $this->datatables->select('id,namaUser,userP3H,namaPU,alamat,noHP,nik,email,pass,tempatUsahaName,tempatUsahaAlamat,provinsi_id,provinsi_nama,kabupaten_id,kabupaten_nama,kecamatan_id,kecamatan_nama,kelurahan_id,kelurahan_nama,kodepos,fotoKtp,nameProduk1,fotoProduk1,videoProduk1,vervalProduk1,nameProduk2,fotoProduk2,videoProduk2,vervalProduk2,fotoProduk3,videoProduk3,vervalProduk3,fotoProduk4,vervalProduk4,videoProduk4,fotoProduk5,vervalProduk5,videoProduk5,fotoProduk6,vervalProduk6,videoProduk6,fotoProduk7,vervalProduk7,videoProduk7,nameProduk3,nameProduk4,nameProduk5,nameProduk6,nameProduk7,user,created_at,created_by,qc_foto,update_created_date_qc_foto,update_created_by_qc_foto,qc_email,update_created_date_qc_email,catatan,pembuatan,nib,STTD,keteranganNIB,SH,uploadSH,qc_nib,update_created_date_qc_nib,update_created_by_qc_nib,update_created_by_qc_sh,update_created_date_qc_sh,keterangan_status');
        $this->datatables->from('pemilikusaha');
        $email_user = $this->session->userdata('email');
        if ($role == 2) {
            $this->datatables->where('userP3H', $email_user);
        }
        $this->db->where('qc_email', '1');
        $this->db->where('qc_foto', '1');
        $this->db->where('qc_oss', '0');
        $this->datatables->add_column('aksi', '
        <button type="button" class="btn btn-sm btn-info btn-view" data-id="$1">
            <i class="fas fa-eye"></i> Detail
        </button>
        <button type="button" class="btn btn-sm btn-danger " data-id="$1">
            <i class="fa fa-trash"></i> Hapus
        </button>
        <button type="button" class="btn btn-sm btn-info btn-print" data-id="$1">
            <i class="fas fa-print"></i> Print PU
        </button>
          <button type="button"
            class="btn btn-sm btn-success btn-update-qc-oss"
            data-id="$1"
            $2>
            <i class="fas fa-check"></i> Check QC
        </button>
    ', 'id');
        $this->db->order_by('id DESC');
        return $this->datatables->generate();
    }
    public function get_daftar_qc_4()
    {
        $tgl_dari   = $this->input->post('tgl_dari');
        $tgl_sampai = $this->input->post('tgl_sampai');
        $role       = $this->session->userdata('role');
        // FILTER TANGGAL BETWEEN
        if (!empty($tgl_dari) && !empty($tgl_sampai)) {

            $this->db->where('DATE(created_at) >=', $tgl_dari);
            $this->db->where('DATE(created_at) <=', $tgl_sampai);
        }

        // FILTER STATUS

        $this->datatables->select('id,namaUser,userP3H,namaPU,alamat,noHP,nik,email,pass,tempatUsahaName,tempatUsahaAlamat,provinsi_id,provinsi_nama,kabupaten_id,kabupaten_nama,kecamatan_id,kecamatan_nama,kelurahan_id,kelurahan_nama,kodepos,fotoKtp,nameProduk1,fotoProduk1,videoProduk1,vervalProduk1,nameProduk2,fotoProduk2,videoProduk2,vervalProduk2,fotoProduk3,videoProduk3,vervalProduk3,fotoProduk4,vervalProduk4,videoProduk4,fotoProduk5,vervalProduk5,videoProduk5,fotoProduk6,vervalProduk6,videoProduk6,fotoProduk7,vervalProduk7,videoProduk7,nameProduk3,nameProduk4,nameProduk5,nameProduk6,nameProduk7,user,created_at,created_by,qc_foto,update_created_date_qc_foto,update_created_by_qc_foto,qc_email,update_created_date_qc_email,catatan,pembuatan,nib,STTD,keteranganNIB,SH,uploadSH,qc_nib,update_created_date_qc_nib,update_created_by_qc_nib,update_created_by_qc_sh,update_created_date_qc_sh,keterangan_status');
        $this->datatables->from('pemilikusaha');
        $email_user = $this->session->userdata('email');
        if ($role == 2) {
            $this->datatables->where('userP3H', $email_user);
        }
        $this->db->where('qc_email', '1');
        $this->db->where('qc_foto', '1');
        $this->db->where('qc_oss', '1');
        $this->db->where('qc_nib', '0');
        $this->datatables->add_column('aksi', '
        <button type="button" class="btn btn-sm btn-info btn-view" data-id="$1">
            <i class="fas fa-eye"></i> Detail
        </button>
        <button type="button" class="btn btn-sm btn-danger " data-id="$1">
            <i class="fa fa-trash"></i> Hapus
        </button>
        <button type="button" class="btn btn-sm btn-info btn-print" data-id="$1">
            <i class="fas fa-print"></i> Print PU
        </button>
          <button type="button"
            class="btn btn-sm btn-success btn-update-qc-nib"
            data-id="$1"
            $2>
            <i class="fas fa-check"></i> Check QC
        </button>
    ', 'id');
        $this->db->order_by('id DESC');
        return $this->datatables->generate();
    }
    public function get_daftar_qc_5()
    {
        $tgl_dari   = $this->input->post('tgl_dari');
        $tgl_sampai = $this->input->post('tgl_sampai');
        $role       = $this->session->userdata('role');
        // FILTER TANGGAL BETWEEN
        if (!empty($tgl_dari) && !empty($tgl_sampai)) {

            $this->db->where('DATE(created_at) >=', $tgl_dari);
            $this->db->where('DATE(created_at) <=', $tgl_sampai);
        }

        // FILTER STATUS

        $this->datatables->select('id,namaUser,userP3H,namaPU,alamat,noHP,nik,email,pass,tempatUsahaName,tempatUsahaAlamat,provinsi_id,provinsi_nama,kabupaten_id,kabupaten_nama,kecamatan_id,kecamatan_nama,kelurahan_id,kelurahan_nama,kodepos,fotoKtp,nameProduk1,fotoProduk1,videoProduk1,vervalProduk1,nameProduk2,fotoProduk2,videoProduk2,vervalProduk2,fotoProduk3,videoProduk3,vervalProduk3,fotoProduk4,vervalProduk4,videoProduk4,fotoProduk5,vervalProduk5,videoProduk5,fotoProduk6,vervalProduk6,videoProduk6,fotoProduk7,vervalProduk7,videoProduk7,nameProduk3,nameProduk4,nameProduk5,nameProduk6,nameProduk7,user,created_at,created_by,qc_foto,update_created_date_qc_foto,update_created_by_qc_foto,qc_email,update_created_date_qc_email,catatan,pembuatan,nib,STTD,keteranganNIB,SH,uploadSH,qc_nib,update_created_date_qc_nib,update_created_by_qc_nib,update_created_by_qc_sh,update_created_date_qc_sh,keterangan_status');
        $this->datatables->from('pemilikusaha');
        $email_user = $this->session->userdata('email');
        if ($role == 2) {
            $this->datatables->where('userP3H', $email_user);
        }
        $this->db->where('qc_email', '1');
        $this->db->where('qc_foto', '1');
        $this->db->where('qc_oss', '1');
        $this->db->where('qc_nib', '1');
        $this->db->where('qc_sttd', '0');
        $this->datatables->add_column('aksi', '
        <button type="button" class="btn btn-sm btn-info btn-view" data-id="$1">
            <i class="fas fa-eye"></i> Detail
        </button>
        <button type="button" class="btn btn-sm btn-danger " data-id="$1">
            <i class="fa fa-trash"></i> Hapus
        </button>
        <button type="button" class="btn btn-sm btn-info btn-print" data-id="$1">
            <i class="fas fa-print"></i> Print PU
        </button>
          <button type="button"
            class="btn btn-sm btn-success btn-update-qc-sttd"
            data-id="$1"
            $2>
            <i class="fas fa-check"></i> Check QC
        </button>
    ', 'id');
        $this->db->order_by('id DESC');
        return $this->datatables->generate();
    }
    public function get_daftar_qc_6()
    {
        $tgl_dari   = $this->input->post('tgl_dari');
        $tgl_sampai = $this->input->post('tgl_sampai');
        $role       = $this->session->userdata('role');
        // FILTER TANGGAL BETWEEN
        if (!empty($tgl_dari) && !empty($tgl_sampai)) {

            $this->db->where('DATE(created_at) >=', $tgl_dari);
            $this->db->where('DATE(created_at) <=', $tgl_sampai);
        }

        // FILTER STATUS

        $this->datatables->select('id,namaUser,userP3H,namaPU,alamat,noHP,nik,email,pass,tempatUsahaName,tempatUsahaAlamat,provinsi_id,provinsi_nama,kabupaten_id,kabupaten_nama,kecamatan_id,kecamatan_nama,kelurahan_id,kelurahan_nama,kodepos,fotoKtp,nameProduk1,fotoProduk1,videoProduk1,vervalProduk1,nameProduk2,fotoProduk2,videoProduk2,vervalProduk2,fotoProduk3,videoProduk3,vervalProduk3,fotoProduk4,vervalProduk4,videoProduk4,fotoProduk5,vervalProduk5,videoProduk5,fotoProduk6,vervalProduk6,videoProduk6,fotoProduk7,vervalProduk7,videoProduk7,nameProduk3,nameProduk4,nameProduk5,nameProduk6,nameProduk7,user,created_at,created_by,qc_foto,update_created_date_qc_foto,update_created_by_qc_foto,qc_email,update_created_date_qc_email,catatan,pembuatan,nib,STTD,keteranganNIB,SH,uploadSH,qc_nib,update_created_date_qc_nib,update_created_by_qc_nib,update_created_by_qc_sh,update_created_date_qc_sh,keterangan_status');
        $this->datatables->from('pemilikusaha');
        $email_user = $this->session->userdata('email');
        if ($role == 2) {
            $this->datatables->where('userP3H', $email_user);
        }
        $this->db->where('qc_email', '1');
        $this->db->where('qc_foto', '1');
        $this->db->where('qc_oss', '1');
        $this->db->where('qc_nib', '1');
        $this->db->where('qc_sttd', '1');
        $this->db->where('qc_sh', '0');
        $this->datatables->add_column('aksi', '
        <button type="button" class="btn btn-sm btn-info btn-view" data-id="$1">
            <i class="fas fa-eye"></i> Detail
        </button>
        <button type="button" class="btn btn-sm btn-danger " data-id="$1">
            <i class="fa fa-trash"></i> Hapus
        </button>
        <button type="button" class="btn btn-sm btn-info btn-print" data-id="$1">
            <i class="fas fa-print"></i> Print PU
        </button>
          <button type="button"
            class="btn btn-sm btn-success btn-update-qc-sh"
            data-id="$1"
            $2>
            <i class="fas fa-check"></i> Check QC
        </button>
    ', 'id');
        $this->db->order_by('id DESC');
        return $this->datatables->generate();
    }

    public function getProvinsi()
    {
        return $this->db->get('provinsi')->result();
    }

    public function getKabupaten($provinsi_id)
    {
        return $this->db->get_where('kabupaten', [
            'provinsi_id' => $provinsi_id
        ])->result();
    }

    public function getKecamatan($kabupaten_id)
    {
        return $this->db->get_where('kecamatan', [
            'kabupaten_id' => $kabupaten_id
        ])->result();
    }

    public function getKelurahan($kecamatan_id)
    {
        return $this->db->get_where('kelurahan', [
            'kecamatan_id' => $kecamatan_id
        ])->result();
    }

    public function insertData($table, $data)
    {
        $query = $this->db->insert($table, $data);
        return $query;
    }

    // =========================
    // UPDATE
    // =========================
    public function updateData($table, $data, $where)
    {
        $this->db->where($where);
        return $this->db->update($table, $data);
    }

    public function deleteData($table, $where)
    {
        $this->db->where($where);
        return $this->db->delete($table);
    }
    public function fetch_data($table, $where = null)
    {
        if ($where) {
            $this->db->where($where);
        }
        return $this->db->get($table);
    }
    public function fetch_data_by_modul($table, $modul)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->group_by($modul);
        $query = $this->db->get();
        return $query->result();
    }
    public function view_daftar_qc_by_foto()
    {
        $tgl_dari   = $this->input->post('tgl_dari');
        $tgl_sampai = $this->input->post('tgl_sampai');
        $status     = $this->input->post('status');
        $role       = $this->session->userdata('role');
        // FILTER TANGGAL BETWEEN
        if (!empty($tgl_dari) && !empty($tgl_sampai)) {

            $this->db->where('DATE(created_at) >=', $tgl_dari);
            $this->db->where('DATE(created_at) <=', $tgl_sampai);
        }

        // FILTER STATUS
        if ($status !== "") {
            $this->db->where('qc_foto', $status);
        }

        $this->datatables->select('id,namaUser,userP3H,namaPU,alamat,noHP,nik,email,pass,tempatUsahaName,tempatUsahaAlamat,provinsi_id,provinsi_nama,kabupaten_id,kabupaten_nama,kecamatan_id,kecamatan_nama,kelurahan_id,kelurahan_nama,kodepos,fotoKtp,nameProduk1,fotoProduk1,videoProduk1,vervalProduk1,nameProduk2,fotoProduk2,videoProduk2,vervalProduk2,fotoProduk3,videoProduk3,vervalProduk3,fotoProduk4,vervalProduk4,videoProduk4,fotoProduk5,vervalProduk5,videoProduk5,fotoProduk6,vervalProduk6,videoProduk6,fotoProduk7,vervalProduk7,videoProduk7,nameProduk3,nameProduk4,nameProduk5,nameProduk6,nameProduk7,user,created_at,created_by,qc_foto,update_created_date_qc_foto,update_created_by_qc_foto,qc_email,update_created_date_qc_email,catatan,pembuatan,nib,STTD,keteranganNIB,SH,uploadSH,qc_nib,update_created_date_qc_nib,update_created_by_qc_nib,update_created_by_qc_sh,update_created_date_qc_sh,keterangan_status');
        $this->datatables->from('pemilikusaha');
        $email_user = $this->session->userdata('email');
        if ($role == 2) {
            $this->datatables->where('userP3H', $email_user);
        }
        $this->datatables->add_column('aksi', '
    <button type="button" class="btn btn-sm btn-info btn-view" data-id="$1">
        <i class="fas fa-eye"></i> Detail
    </button>

    <?php if ($2 == 0  $3 != null) { ?>
        <button type="button" class="btn btn-sm btn-warning btn-update" data-id="$1">
            <i class="fa fa-pencil-alt"></i> Update PU
        </button>
    <?php } ?>
', 'id,qc_foto,update_created_by_qc_foto');
        $this->db->order_by('id DESC');
        return $this->datatables->generate();
    }
    public function get_daftar_qc_1()
    {
        $tgl_dari   = $this->input->post('tgl_dari');
        $tgl_sampai = $this->input->post('tgl_sampai');
        $role       = $this->session->userdata('role');
        // FILTER TANGGAL BETWEEN
        if (!empty($tgl_dari) && !empty($tgl_sampai)) {

            $this->db->where('DATE(created_at) >=', $tgl_dari);
            $this->db->where('DATE(created_at) <=', $tgl_sampai);
        }

        // FILTER STATUS

        $this->datatables->select('id,namaUser,userP3H,namaPU,alamat,noHP,nik,email,pass,tempatUsahaName,tempatUsahaAlamat,provinsi_id,provinsi_nama,kabupaten_id,kabupaten_nama,kecamatan_id,kecamatan_nama,kelurahan_id,kelurahan_nama,kodepos,fotoKtp,nameProduk1,fotoProduk1,videoProduk1,vervalProduk1,nameProduk2,fotoProduk2,videoProduk2,vervalProduk2,fotoProduk3,videoProduk3,vervalProduk3,fotoProduk4,vervalProduk4,videoProduk4,fotoProduk5,vervalProduk5,videoProduk5,fotoProduk6,vervalProduk6,videoProduk6,fotoProduk7,vervalProduk7,videoProduk7,nameProduk3,nameProduk4,nameProduk5,nameProduk6,nameProduk7,user,created_at,created_by,qc_foto,update_created_date_qc_foto,update_created_by_qc_foto,qc_email,update_created_date_qc_email,catatan,pembuatan,nib,STTD,keteranganNIB,SH,uploadSH,qc_nib,update_created_date_qc_nib,update_created_by_qc_nib,update_created_by_qc_sh,update_created_date_qc_sh,keterangan_status');
        $this->datatables->from('pemilikusaha');
        $email_user = $this->session->userdata('email');
        if ($role == 2) {
            $this->datatables->where('userP3H', $email_user);
        }
        $this->db->where('qc_foto', '0');
        $this->datatables->add_column('aksi', '
        <button type="button" class="btn btn-sm btn-info btn-view" data-id="$1">
            <i class="fas fa-eye"></i> Detail
        </button>
        <button type="button" class="btn btn-sm btn-danger " data-id="$1">
            <i class="fa fa-trash"></i> Hapus
        </button>
        <button type="button" class="btn btn-sm btn-info btn-update" data-id="$1">
            <i class="fas fa-print"></i> Update PU
        </button>
          <button type="button"
            class="btn btn-sm btn-success update-qc"
            data-id="$1"
            $2>
            <i class="fas fa-check"></i> Check QC
        </button>
    ', 'id');
        $this->db->order_by('id DESC');
        return $this->datatables->generate();
    }
}
