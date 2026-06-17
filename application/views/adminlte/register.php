<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/') ?>css/adminlte.min.css">
    <style>
        body.register-page {
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

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>HTP </b>SINERGI</a>
                <P> PT HENDEVANE INDONESIA</P>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form id="registerForm">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Full name">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" id="noTelepon" class="form-control" name="noTelepon"
                            placeholder="Phone Number">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <small id="msg_telepon" style="display:none; margin-top:-10px; margin-bottom:10px;"></small>


                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="bank" placeholder="Bank">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="noRek" placeholder="No Rekening Bank">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" id="email" class="form-control" name="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelectRounded0">Management User</label>
                        <select name="petugas" class="custom-select rounded-0" id="exampleSelectRounded0">
                            <option value="4">Admin Entry</option>
                            <option value="2">P3H</option>
                        </select>
                    </div>
                    <small id="msg_email" style="display:none; margin-top:-10px; margin-bottom:10px;"></small>
                    <div class="input-group mb-0">
                        <input type="password" class="form-control" name="password1" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted mb-3 d-block">Min. 8 Karakter (A-z, 0-9)</small>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password2" placeholder="Retype password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/assets/') ?>js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function cekField(type, value, target, input) {
            $.ajax({
                url: "<?= base_url('auth/cek_field'); ?>",
                type: "POST",
                data: {
                    type: type,
                    value: value
                },
                dataType: "JSON",
                success: function(res) {
                    if (res.exists) {
                        $(target).html(type + ' sudah terdaftar!').css('color', 'red').show();
                        $(input).addClass('is-invalid').removeClass('is-valid');
                    } else {
                        $(target).html(type + ' tersedia').css('color', 'green').show();
                        $(input).addClass('is-valid').removeClass('is-invalid');
                    }
                }
            });
        }

        $('#noTelepon').on('blur', function() {
            if ($(this).val() != '') cekField('Nomor Telepon', $(this).val(), '#msg_telepon', '#noTelepon');
        });

        $('#email').on('blur', function() {
            if ($(this).val() != '') cekField('Email', $(this).val(), '#msg_email', '#email');
        });

        $('#registerForm').on('submit', function(e) {
            e.preventDefault();

            // Tambahkan loading state pada tombol
            let btn = $(this).find('button');
            btn.prop('disabled', true).text('Processing...');

            $.ajax({
                url: "<?php echo base_url('auth/proses_register'); ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(res) {
                    if (res.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            html: res.message,
                        }).then(() => {
                            window.location.href = "<?php echo base_url('auth/verifikasi_otp_view'); ?>";
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validasi Gagal',
                            html: res.message, // Menampilkan list error dari CI3
                        });
                        btn.prop('disabled', false).text('Register');
                    }
                }
            });
        });
    </script>
</body>

</html>