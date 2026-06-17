<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify OTP</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/assets/'); ?>plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/assets/'); ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/assets/'); ?>css/adminlte.min.css">
    <style>
        body.login-page {
            background-image: url('<?= base_url('assets/img/') ?>bc.png');
            /* Ganti dengan URL gambar Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }

        /* Opsional: Membuat box login sedikit transparan agar terlihat modern */
        .login-box .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body class="hold-transition login-page">

    <div class="login-box">
        <div class="card card-outline card-secondary">
            <div class="card-header text-center">
                <b>Verifikasi</b> OTP
            </div>

            <div class="card-body">
                <p class="login-box-msg">Masukkan kode OTP yang dikirim ke email Anda</p>

                <form id="otpForm">
                    <div class="input-group mb-3">
                        <input type="text" name="otp" class="form-control" placeholder="6 Digit OTP" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Verifikasi</button>
                </form>

                <div class="text-center mt-3">
                    <a href="<?= base_url('auth/forgot_password'); ?>">Kirim ulang OTP</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/assets/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/assets/'); ?>js/adminlte.min.js"></script>
    <script>
        $('#otpForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= base_url('auth/verify_otp_process'); ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(res) {
                    if (res.status == 'success') {
                        Swal.fire('Berhasil', res.message, 'success').then(() => {
                            window.location.href = "<?= base_url('auth/reset_password'); ?>";
                        })
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                }
            })
        });
    </script>

</body>

</html>