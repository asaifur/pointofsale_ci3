<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HTPSINERGI</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/'); ?>css/adminlte.min.css">
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
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>HTP</b>SINERGI</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form id="loginForm">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="col-8">
                    <a href="<?= base_url('auth/forgot_password'); ?>">Forgot password?</a>
                </div>
                <div class="col-8">
                    <a href="<?= base_url('auth/register'); ?>"> New Account</a>
                </div>
                <div class="col-8">
                    <a href="<?= base_url('auth/verifikasi_otp_view'); ?>"> Verifikasi OTP Akun</a>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/plugins'); ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/dist/'); ?>js/adminlte.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "<?php echo base_url('auth/proses_login'); ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                html: response.message +
                                    '<br><strong>Selamat ' + response.salam + '</strong>' +
                                    '<br>' + response.nama,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.href = "<?php echo base_url('dashboard'); ?>";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>