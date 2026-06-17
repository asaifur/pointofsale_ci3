<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
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

<body class="login-page">

    <div class="login-box">
        <div class="card card-outline card-danger">
            <div class="card-header text-center">Reset Password</div>
            <div class="card-body">

                <form id="resetForm">
                    <input type="hidden" name="reset_email" value="<?= $email ?>">
                    <input type="password" name="password" class="form-control mb-2" placeholder="Password Baru" required>
                    <input type="password" name="confirm" class="form-control mb-2" placeholder="Konfirmasi Password" required>
                    <button class="btn btn-primary btn-block">Reset Password</button>
                </form>

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
        $('#resetForm').submit(function(e) {
            e.preventDefault();
            $.post("<?= base_url('auth/reset_password_process'); ?>", $(this).serialize(), function(res) {
                res = JSON.parse(res);
                if (res.status == 'success') {
                    Swal.fire('Berhasil', res.message, 'success').then(() => {
                        window.location.href = "<?= base_url('auth'); ?>"
                    });
                } else Swal.fire('Gagal', res.message, 'error');
            });
        });
    </script>
</body>

</html>