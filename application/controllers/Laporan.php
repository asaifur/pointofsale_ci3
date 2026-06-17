<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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
    public function get_detail_jobdesk()
    {
        $id = $this->input->post('id');
        // Ambil data satu baris dari tabel users berdasarkan ID
        $data = $this->db->get_where('jobdesk', ['id' => $id])->row();

        echo json_encode($data);
    }

    public function update_qc_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('qc_status');

        $update = $this->db->where('id', $id)
            ->update('jobdesk', ['qc' => $status]);

        if ($update) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    public function jobdesk()
    {
        $data['title'] = " Quality Control Jobdesk Harian";
        $data['laporan'] = $this->Laporan->get_all_laporan();

        $this->template->load('laporan/jobdesk.php', $data);
    }
    public function user()
    {
        $data['title'] = "Laporan All User";
        $this->template->load('laporan/user.php', $data);
    }

    public function view_all_jobdesk()
    {
        $query = $this->Laporan->get_all_jobdesk();
        echo $query;
    }
    public function export_jobdesk_xls()
    {
        $qc = $this->input->get('qc');
        $session_referal = $this->session->userdata('referal');

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=jobdesk_qc_" . date('Ymd_His') . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // FILTER SAMA DENGAN DATATABLE
        if ($qc !== '' && $qc !== null) {
            $this->db->where('qc', $qc);
        }

        $this->db->where('id_referal', $session_referal);

        $data = $this->db->order_by('created_at', 'DESC')
            ->get('jobdesk')
            ->result();

        echo "<table border='1'>";
        echo "<tr style='background:#f2f2f2;font-weight:bold'>
        <th>ID</th>
        <th>PPPH</th>
        <th>NIB</th>
        <th>NIK</th>
        <th>Nama PU</th>
        <th>Produk 1</th>
        <th>Produk 2</th>
        <th>Source Image</th>
        <th>No Telepon</th>
        <th>User</th>
        <th>ID Referal</th>
        <th>Status QC</th>
        <th>Created At</th>
    </tr>";

        foreach ($data as $row) {

            $imgUrl = base_url('assets/uploads/' . $row->source_image);

            echo "<tr>
            <td>{$row->id}</td>
            <td>{$row->ppph}</td>
            <td>{`$row->nib`}</td>
            <td>{`$row->nik`}</td>
            <td>{$row->namaPU}</td>
            <td>{$row->produk1}</td>
            <td>{$row->produk2}</td>
            <td>{$imgUrl}</td>
            <td>{`$row->noTelepon`}</td>
            <td>{$row->user}</td>
            <td>{$row->id_referal}</td>
            <td>" . ($row->qc == 1 ? 'Sudah QC' : 'Belum QC') . "</td>
            <td>{$row->created_at}</td>
        </tr>";
        }

        echo "</table>";
        exit;
    }


    public function view_all_user()
    {
        $query = $this->Laporan->get_all_user();
        echo $query;
    }
    public function update_check_pkwt()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('check_pkwt');
        $this->db->where('id', $id);
        $update = $this->db->update('users', [
            'pkwt' => $status
        ]);

        echo json_encode([
            'status' => $update
        ]);
    }


    public function print($id)
    {
        // 1. Ambil data dari model
        $dataKontrak = $this->Laporan->get_user_kontrak($id);
        $data['kontrak'] = $dataKontrak;


        // 1. Ambil data dari database berdasarkan ID

        if (!$dataKontrak) {
            show_404();
        }

        // 2. Load Library Dompdf
        // Jika pakai composer cukup: use Dompdf\Dompdf;
        // Jika library diletakkan manual, sesuaikan cara load-nya
        $dompdf = new \Dompdf\Dompdf();

        // 3. Siapkan HTML dari view (pisahkan file view agar rapi)
        // Kita kirim data ke view 'print/v_sppl_pdf'
        $html = $this->load->view('template/pkwt', $data, true);

        // 4. Konfigurasi Dompdf
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 5. Output ke browser (Inline: tampil di browser, Attachment: langsung download)
        $dompdf->stream("PKWT_" . $dataKontrak['username'] . ".pdf", array("Attachment" => false));
    }
    public function proses_update_jobdesk()
    {
        $id = $this->input->post('id');
        $data = [
            'ppph'   => $this->input->post('ppph'),
            'nib'    => $this->input->post('nib'),
            'namaPU' => $this->input->post('namaPU'),
            'produk1' => $this->input->post('produk1'),
            'produk2' => $this->input->post('produk2'),
        ];

        $update = $this->db->where('id', $id)->update('jobdesk', $data);

        if ($update) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}
