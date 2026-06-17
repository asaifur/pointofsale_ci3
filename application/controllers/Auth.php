<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model'); // Load model
        $this->load->helper('tanggal_helper');
    }

    public function getKabupaten()
    {
        $id = $this->input->post('id');
        echo json_encode($this->Halal_model->getKabupaten($id));
    }

    public function getKecamatan()
    {
        $id = $this->input->post('id');
        echo json_encode($this->Halal_model->getKecamatan($id));
    }

    public function getKelurahan()
    {
        $id = $this->input->post('id');
        echo json_encode($this->Halal_model->getKelurahan($id));
    }
    public function index()
    {

        if ($this->session->userdata('role')) {
            // Jika session sudah ada, lempar ke Controller Dashboard
            redirect('dashboard');
        }

        // Jika belum login, tampilkan halaman login
        $this->load->view('adminlte/login');
    }
    public function cek_field()
    {
        $type = $this->input->post('type');
        $value = $this->input->post('value');

        if ($type == 'Nomor Telepon') {
            $exists = $this->db->get_where('users', ['noTelepon' => $value])->num_rows() > 0;
        } else {
            $exists = $this->db->get_where('users', ['email' => $value])->num_rows() > 0;
        }

        echo json_encode(['exists' => $exists]);
    }


    public function proses_login()
    {
        $username = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->User_model->check_login($username);

        if ($user) {

            // =========================
            // CEK STATUS AKTIF
            // =========================
            if ($user['active'] != 1) {

                echo json_encode([
                    'status'  => 'inactive',
                    'message' => 'Akun belum aktif! Silakan verifikasi OTP terlebih dahulu.',
                    'email'   => $user['email']
                ]);
                return;
            }

            // =========================
            // CEK PASSWORD
            // =========================
            if (password_verify($password, $user['password'])) {

                // Simpan session
                $this->session->set_userdata($user);

                $response = [
                    'status'  => 'success',
                    'message' => 'Login berhasil',
                    'nama'    => $user['username'],
                    'salam'   => waktu()
                ];

                echo json_encode($response);
            } else {

                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Password Salah!'
                ]);
            }
        } else {

            echo json_encode([
                'status'  => 'error',
                'message' => 'Email tidak terdaftar!'
            ]);
        }
    }


    public function register()
    {
        $this->load->view('adminlte/register');
    }

    public function proses_register_pemilik_usaha()
    {
        $this->load->library('form_validation');

        // ==========================
        // VALIDATION
        // ==========================
        $this->form_validation->set_rules('namaPU', 'Nama', 'required|trim');
        $this->form_validation->set_rules('nik', 'NIK', 'required|numeric|exact_length[16]');
        $this->form_validation->set_rules('noHP', 'Nomor HP', 'required');

        $this->form_validation->set_error_delimiters('', '');

        if ($this->form_validation->run() == FALSE) {

            $errors = [];
            foreach ($_POST as $key => $value) {
                if (form_error($key)) {
                    $errors[$key] = form_error($key);
                }
            }

            echo json_encode([
                'status' => 'error',
                'errors' => $errors
            ]);
            return;
        }

        // ==========================
        // CEK DUPLIKAT NIK
        // ==========================
        $cekNik = $this->db->get_where('pemilikusaha', [
            'nik' => $this->input->post('nik')
        ])->row();

        if ($cekNik) {
            echo json_encode([
                'status' => 'error',
                'errors' => ['nik' => 'NIK sudah terdaftar']
            ]);
            return;
        }

        // ==========================
        // SIAPKAN DATA
        // ==========================
        $data = [];
        $uploadData = []; // ✅ DECLARE DI SINI

        $format = $this->Halal_model->format_action('format_tambah_pu', 'insert')->result();

        foreach ($format as $kolom) {

            // ================= DATE =================
            if ($kolom->type == "DATE") {

                $data[$kolom->code] = date('Y-m-d H:i:s');
            }

            // ================= FILE =================
            else if ($kolom->type == "FILE") {

                if (!empty($_FILES[$kolom->code]['name'])) {

                    $config['upload_path']   = './assets/uploads/';
                    $config['allowed_types'] = 'jpg|jpeg|png|JPG|JPEG|PNG';
                    $config['max_size']      = 1024; // 50MB kalau mp4
                    $config['encrypt_name']  = TRUE;

                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload($kolom->code)) {

                        echo json_encode([
                            'status' => 'error',
                            'message' => strip_tags($this->upload->display_errors())
                        ]);
                        return;
                    }

                    $data[$kolom->code] = $this->upload->data('file_name');
                }
            } else if ($kolom->type == "FILEMP4") {

                if (!empty($_FILES[$kolom->code]['name'])) {

                    $config['upload_path']   = './assets/uploads/';
                    $config['allowed_types'] = 'mp4|mov|H.264|| MPEG-4|M4V';
                    $config['max_size']      = 51200; // 50MB kalau mp4
                    $config['encrypt_name']  = TRUE;

                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload($kolom->code)) {

                        echo json_encode([
                            'status' => 'error',
                            'message' => strip_tags($this->upload->display_errors())
                        ]);
                        return;
                    }

                    $data[$kolom->code] = $this->upload->data('file_name');
                }
            }

            // ================= TEXT =================
            else {
                if ($kolom->code == "keterangan_status") {
                    $data[$kolom->code] = "Pengajuan Baru";
                } else {
                    $data[$kolom->code] = $this->input->post($kolom->code, TRUE);
                }
            }
        }

        $data['created_at'] = date('Y-m-d H:i:s');

        // ================= INSERT =================
        $query = $this->Halal_model->insertData('pemilikusaha', $data);

        if ($query) {

            echo json_encode([
                'status' => 'success',
                'message' => 'Data berhasil didaftarkan!'
            ]);
        } else {

            echo json_encode([
                'status' => 'error',
                'message' => 'Data gagal disimpan!'
            ]);
        }
    }

    public function proses_register()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|valid_email|is_unique[users.email]'
        );

        $this->form_validation->set_rules('password1', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'required|matches[password1]');

        if ($this->form_validation->run() == FALSE) {

            echo json_encode([
                'status' => 'error',
                'message' => validation_errors("- ", "")
            ]);
        } else {

            // Generate OTP 6 digit
            $otp = rand(100000, 999999);

            $data = [
                'username' => $this->input->post('username'),
                'bank' => $this->input->post('bank'),
                'noTelepon' => $this->input->post('noTelepon'),
                'noRek' => $this->input->post('noRek'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password1'), PASSWORD_BCRYPT),
                'role' => $this->input->post('petugas'),
                'otp' => $otp,
                'otp_expired' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
                'date_created' => date('Y-m-d H:i:s'),
                'active' => '0'
            ];

            $this->db->insert('users', $data);

            // Kirim Email OTP
            $this->_sendOTP($this->input->post('email'), $otp);

            echo json_encode([
                'status' => 'success',
                'message' => 'OTP telah dikirim ke email. Silakan verifikasi.'
            ]);
        }
    }

    private function _sendOTP($email, $otp)
    {
        $this->load->library('email');

        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://mail.htpsinergi.com',
            'smtp_port' => 465,
            'smtp_user' => 'admin@htpsinergi.com',
            'smtp_pass' => '22Mei2013@',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",
            'crlf'      => "\r\n"
        ];

        $this->email->initialize($config);

        $this->email->from('admin@htpsinergi.com', 'Verifikasi Akun');
        $this->email->to($email);
        $this->email->subject('Kode OTP Verifikasi Email');

        $message = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Verifikasi Email</title>
</head>
<body style="margin:0; padding:0; background:#f4f6f9; font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9; padding:20px 0;">
<tr>
<td align="center">

    <!-- CARD -->
    <table width="500" cellpadding="0" cellspacing="0"
        style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.1);">

        <!-- HEADER -->
        <tr>
            <td style="background:#007bff; padding:20px; text-align:center; color:#ffffff;">
                <h2 style="margin:0;">Verifikasi Email</h2>
                <p style="margin:5px 0 0;">Sistem Registrasi Akun</p>
            </td>
        </tr>

        <!-- BODY -->
        <tr>
            <td style="padding:30px; text-align:center; color:#333333;">

                <h3>Halo 👋</h3>

                <p>
                    Terima kasih telah melakukan pendaftaran.<br>
                    Gunakan kode OTP berikut untuk verifikasi email Anda:
                </p>

                <!-- OTP BOX -->
                <div style="
                    display:inline-block;
                    padding:15px 30px;
                    margin:20px 0;
                    font-size:32px;
                    letter-spacing:5px;
                    font-weight:bold;
                    color:#007bff;
                    border:2px dashed #007bff;
                    border-radius:8px;
                    background:#f1f8ff;
                ">
                    ' . $otp . '
                </div>

                <p style="margin-top:10px;">
                    Kode ini berlaku selama <b>10 menit</b>.
                </p>

                <p style="font-size:13px; color:#888;">
                    Jangan bagikan kode ini kepada siapa pun.
                </p>

            </td>
        </tr>

        <!-- FOOTER -->
        <tr>
            <td style="
                background:#f9f9f9;
                padding:20px;
                text-align:center;
                font-size:12px;
                color:#777;
            ">
                © ' . date('Y') . ' HTP Sinergi - PT Hendevane Indonesia<br>
                Email ini dikirim otomatis oleh sistem.
            </td>
        </tr>

    </table>

</td>
</tr>
</table>

</body>
</html>
';


        $this->email->message($message);
        $this->email->send();
    }



    public function verifikasi_otp()
    {
        $email = $this->input->post('email');
        $otp   = $this->input->post('otp');

        $user = $this->db->get_where('users', [
            'email' => $email
        ])->row();

        if (!$user) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Email tidak ditemukan'
            ]);
            return;
        }

        if ($user->otp != $otp) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Kode OTP salah'
            ]);
            return;
        }

        if (strtotime($user->otp_expired) < time()) {
            echo json_encode([
                'status' => 'error',
                'message' => 'OTP sudah kadaluarsa'
            ]);
            return;
        }

        // Aktifkan akun
        $this->db->where('email', $email);
        $this->db->update('users', [
            'active' => 1,
            'otp' => null,
            'otp_expired' => null
        ]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Email berhasil diverifikasi'
        ]);
    }
    public function verifikasi_otp_view()
    {
        $this->load->view('auth/verifikasi_otp');
    }


    public function resend_otp()
    {
        $email = $this->input->post('email');

        $user = $this->db->get_where('users', [
            'email' => $email
        ])->row();

        if (!$user) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Email tidak terdaftar'
            ]);
            return;
        }

        // Generate OTP baru
        $otp = rand(100000, 999999);

        $this->db->where('email', $email);
        $this->db->update('users', [
            'otp' => $otp,
            'otp_expired' => date('Y-m-d H:i:s', strtotime('+10 minutes'))
        ]);

        // Kirim Email
        $this->_sendOTP($email, $otp);

        echo json_encode([
            'status' => 'success',
            'message' => 'OTP baru berhasil dikirim'
        ]);
    }



    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
    public function forgot_password()
    {
        $this->load->view('auth/forgot_password');
    }
    public function send_otp()
    {
        $this->load->library('email');

        $emailUser = $this->input->post('email');
        $user = $this->db->get_where('users', ['email' => $emailUser])->row();

        if (!$user) {
            echo json_encode(['status' => 'error', 'message' => 'Email tidak terdaftar']);
            return;
        }

        $otp = rand(100000, 999999);

        $this->db->update('users', [
            'otp' => $otp,
            'otp_expired' => date('Y-m-d H:i:s', strtotime('+5 minutes'))
        ], ['email' => $emailUser]);
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://mail.htpsinergi.com',
            'smtp_port' => 465,
            'smtp_user' => 'admin@htpsinergi.com',
            'smtp_pass' => '22Mei2013@',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",
            'crlf'      => "\r\n"
        ];

        $this->email->initialize($config);
        $email_template = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Reset Password - HTPSINERGI</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f9;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9;padding:30px 0;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">
<tr>
<td style="background:#007bff;color:#ffffff;padding:20px;text-align:center;font-size:22px;font-weight:bold;">
HTPSINERGI
</td>
</tr>

<tr>
<td style="padding:30px;color:#333;">
<p>Halo,</p>

<p>Kami menerima permintaan untuk reset password akun Anda.</p>

<p>Gunakan kode OTP berikut untuk melanjutkan proses reset password:</p>

<div style="text-align:center;margin:30px 0;">
<span style="font-size:36px;font-weight:bold;letter-spacing:5px;color:#007bff;">' . $otp . '</span>
</div>

<p>Kode ini berlaku selama <b>5 menit</b>. Jangan bagikan kode ini kepada siapa pun.</p>

<p>Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini.</p>

<br>
<p>Salam hormat,<br><b>Tim HTPSINERGI</b></p>
</td>
</tr>

<tr>
<td style="background:#f1f1f1;padding:15px;text-align:center;font-size:12px;color:#666;">
© ' . date('Y') . ' HTPSINERGI. All rights reserved.
</td>
</tr>

</table>

</td>
</tr>
</table>
</body>
</html>
';

        $this->email->from('admin@htpsinergi.com', 'HTPSINERGI');
        $this->email->to($emailUser);
        $this->email->subject('OTP Reset Password');
        $this->email->message($email_template);

        if ($this->email->send()) {
            echo json_encode(['status' => 'success', 'message' => 'OTP berhasil dikirim ke email Anda']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $this->email->print_debugger()]);
        }
    }

    public function verify_otp()
    {

        $this->load->view('auth/verify_otp');
    }

    public function verify_otp_process()
    {
        $otp = $this->input->post('otp');
        $user = $this->db->get_where('users', ['otp' => $otp])->row();

        if ($user && strtotime($user->otp_expired) > time()) {
            $this->session->set_userdata('reset_email', $user->email);
            echo json_encode(['status' => 'success', 'message' => 'OTP valid']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'OTP salah atau kadaluarsa']);
        }
    }

    public function reset_password()
    {
        $email = $this->session->userdata('reset_email');
        $data['email'] = $email;
        $this->load->view('auth/reset_password_view', $data);
    }
    public function reset_password_process()
    {
        $email = $this->session->userdata('reset_email');
        $pass = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

        $this->db->update('users', [
            'password' => $pass,
            'otp' => null,
            'otp_expired' => null
        ], ['email' => $email]);

        echo json_encode(['status' => 'success', 'message' => 'Password berhasil direset']);
    }
}
