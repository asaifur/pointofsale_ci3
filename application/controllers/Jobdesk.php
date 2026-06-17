<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jobdesk extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        }
        // Load the model
        $this->load->model('Laporan_model', 'Laporan');
    }
    public function index()
    {
        $data = ['title' => "Jobdesk Harian"];
        $this->template->load('projects_list', $data);
    }

    public function search_staff()
    {
        // Set header JSON
        header('Content-Type: application/json');

        $term = $this->input->get('term');

        if (!$term) {
            echo json_encode([]);
            return;
        }

        // Ambil data staff berdasarkan keyword
        $this->db->select('username, email');
        $this->db->from('users'); // sesuaikan dengan nama tabel Anda
        $this->db->like('username', $term);
        $this->db->where('active', 1); // jika ada status aktif
        $this->db->where('referal', $_SESSION['referal']);
        $this->db->limit(10);
        $query = $this->db->get();

        $result = [];

        foreach ($query->result() as $row) {
            $result[] = [
                'label' => $row->username, // tampil di dropdown
                'value' => $row->email     // dikirim ke hidden input
            ];
        }

        echo json_encode($result);
    }

    public function import_excel()
    {
        $post = $this->input->post('data');
        $user = $this->session->userdata();

        if (!$post) {
            echo json_encode([
                'status' => false,
                'message' => 'Data kosong'
            ]);
            return;
        }

        $insert = [];

        foreach ($post as $row) {

            if (empty($row['nik'])) continue;

            $insert[] = [
                'ppph'       => $row['p3h'] ?? '',
                'namaPU'       => $row['namaPU'] ?? '',
                'nik'       => $row['nik'] ?? '',
                'noTelepon'       => $row['noTelepon'] ?? '',
                'ktp_source'       => $row['ktp_source'] ?? '',
                'namaUsaha'       => $row['namaUsaha'] ?? '',
                'provinsi'       => $row['provinsi'] ?? '',
                'kota'       => $row['kota'] ?? '',
                'kecamatan'       => $row['kecamatan'] ?? '',
                'kelurahan'       => $row['kelurahan'] ?? '',
                'rtrw'       => $row['rtrw'] ?? '',
                'kodepos'       => $row['kodepos'] ?? '',
                'produk1'       => $row['produk1'] ?? '',
                'fotoProduk1'       => $row['fotoProduk1'] ?? '',
                'videoProduk1'       => $row['videoProduk1'] ?? '',
                'vervalProduk1'       => $row['vervalProduk1'] ?? '',
                'produk2'       => $row['produk2'] ?? '',
                'fotoProduk2'       => $row['fotoProduk2'] ?? '',
                'videoProduk2'       => $row['videoProduk2'] ?? '',
                'vervalProduk2'       => $row['vervalProduk2'] ?? '',
                'produk3'       => $row['produk3'] ?? '',
                'fotoProduk3'       => $row['fotoProduk3'] ?? '',
                'videoProduk3'       => $row['videoProduk3'] ?? '',
                'vervalProduk3'       => $row['vervalProduk3'] ?? '',
                'produk4'       => $row['produk4'] ?? '',
                'fotoProduk4'       => $row['fotoProduk4'] ?? '',
                'videoProduk4'       => $row['videoProduk4'] ?? '',
                'vervalProduk4'       => $row['vervalProduk4'] ?? '',
                'produk5'       => $row['produk5'] ?? '',
                'fotoProduk5'       => $row['fotoProduk5'] ?? '',
                'videoProduk5'       => $row['videoProduk5'] ?? '',
                'vervalProduk5'       => $row['vervalProduk5'] ?? '',
                'produk6'       => $row['produk6'] ?? '',
                'fotoProduk6'       => $row['fotoProduk6'] ?? '',
                'videoProduk6'       => $row['videoProduk6'] ?? '',
                'vervalProduk6'       => $row['vervalProduk6'] ?? '',
                'produk7'       => $row['produk7'] ?? '',
                'fotoProduk7'       => $row['fotoProduk7'] ?? '',
                'videoProduk7'       => $row['videoProduk7'] ?? '',
                'vervalProduk7'       => $row['vervalProduk7'] ?? '',
                'email_baru_dibuat'       => $row['email_baru_dibuat'] ?? '',
                'password_baru_dibuat'       => $row['password_baru_dibuat'] ?? '',
                'nib'       => $row['nib'] ?? '',
                'id_referal'       => $_SESSION['referal'],
                'created_at'       => date("y-m-d H:i:s"),
            ];
        }
        $totalData = count($insert);

        if ($totalData == 0) {
            echo json_encode([
                'status' => false,
                'message' => 'Tidak ada data valid'
            ]);
            return;
        }

        // compile query insert_batch
        $this->db->insert_batch('jobdesk', $insert);
        echo json_encode([
            'status'   => true,
            'message'  => 'Import selesai',
            'total'    => $totalData,

        ]);
    }

    public function view_jobdesk_supervisi()
    {
        echo $this->Laporan->view_transaksi_supervisi();
    }

    public function get_users()
    {
        $keyword = $this->input->get('keyword');
        $data['products'] = $this->Laporan->get_products($keyword); // Panggil Model
        echo json_encode($data['products']);
    }


    public function modal_update_staff()
    {
        $id = $this->input->post('id');
        $referal = $this->session->userdata('referal');
        $data['jobdesk'] = $this->db
            ->get_where('jobdesk', ['id' => $id])
            ->row();
        $data['staff'] = $this->Laporan->get_data('users', ['referal' => $referal])->result();
        $this->load->view('laporan/modal_update_staff', $data);
    }

    public function update_entry_staff()
    {
        $id_jobdesk = $this->input->post('id_jobdesk');
        $user_id    = $this->input->post('user_id');

        if (!$id_jobdesk || !$user_id) {
            echo json_encode([
                'status' => false,
                'message' => 'Data tidak lengkap'
            ]);
            return;
        }

        $this->db->where('id', $id_jobdesk);
        $this->db->update('jobdesk', [
            'user_id' => $user_id
        ]);

        echo json_encode([
            'status' => true,
            'message' => 'Entry staff berhasil diperbarui'
        ]);
    }
    public function update_staff()
    {
        $id_jobdesk = $this->input->post('id_jobdesk');
        $user_id    = $this->input->post('user_id');

        if (!$id_jobdesk || !$user_id) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Data tidak lengkap'
            ]);
            return;
        }

        $this->db->where('id', $id_jobdesk);
        $update = $this->db->update('jobdesk', [
            'user' => $user_id
        ]);

        if ($update) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Staff entry berhasil diperbarui'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal memperbarui staff'
            ]);
        }
    }
    function delete_jobdesk()
    {
        $id = $this->input->post('id');
        $where = ['id' => $id];
        $delete = $this->Laporan->delete_data_by('jobdesk', $where);
        if ($delete) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Staff entry berhasil DiDelete'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal memperbarui staff'
            ]);
        }
    }
}
