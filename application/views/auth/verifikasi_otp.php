<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi OTP</title>

    <!-- Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/dist/') ?>css/adminlte.min.css">

    <style>
        body {
            background-image: url('<?= base_url('assets/img/') ?>bc.png');
            /* Ganti dengan URL gambar Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .login-box .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            border-radius: 10px;
        }
    </style>
</head>

<body class="hold-transition login-page">

    <div class="login-box">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h3><b>Verifikasi OTP</b></h3>
                <p>Masukkan kode OTP yang dikirim ke email</p>
            </div>

            <div class="card-body">

                <form id="formOTP">

                    <div class="input-group mb-3">
                        <input type="email" name="email" id="email"
                            class="form-control"
                            placeholder="Masukkan Email"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="text" name="otp" id="otp"
                            class="form-control"
                            placeholder="Kode OTP"
                            maxlength="6"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-key"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">
                        Verifikasi
                    </button>

                </form>

                <hr>

                <button id="resendOTP" class="btn btn-warning btn-block">
                    Kirim Ulang OTP
                </button>

            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/dist/') ?>js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        /* =========================
   SUBMIT VERIFIKASI OTP
========================= */
        $('#formOTP').on('submit', function(e) {
            e.preventDefault();

            let btn = $(this).find('button');
            btn.prop('disabled', true).text('Processing...');

            $.ajax({
                url: "<?= base_url('auth/verifikasi_otp'); ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(res) {

                    if (res.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message
                        }).then(() => {
                            window.location.href = "<?= base_url('auth'); ?>";
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message
                        });

                        btn.prop('disabled', false).text('Verifikasi');
                    }
                }
            });
        });


        /* =========================
           RESEND OTP
        ========================= */
        $('#resendOTP').on('click', function() {

            let email = $('#email').val();

            if (email == '') {
                Swal.fire('Warning', 'Isi email dulu', 'warning');
                return;
            }

            let btn = $(this);
            btn.prop('disabled', true).text('Mengirim...');

            $.ajax({
                url: "<?= base_url('auth/resend_otp'); ?>",
                type: "POST",
                data: {
                    email: email
                },
                dataType: "JSON",
                success: function(res) {

                    if (res.status == 'success') {
                        Swal.fire('Berhasil', res.message, 'success');
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }

                    btn.prop('disabled', false).text('Kirim Ulang OTP');
                }
            });
        });
    </script>

</body>

</html>