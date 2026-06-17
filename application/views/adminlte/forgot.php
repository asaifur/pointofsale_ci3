<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Forgot Password - HTPSINERGI</title>

    <link rel="stylesheet" href="<?= base_url('assets/assets/'); ?>css/adminlte.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <b>Forgot</b> Password
            </div>
            <div class="card-body">
                <p class="login-box-msg">Masukkan email terdaftar untuk reset password</p>

                <form id="forgotForm">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Kirim OTP</button>
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
        $('#forgotForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= base_url('auth/send_otp'); ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(res) {
                    if (res.status == 'success') {
                        Swal.fire('Berhasil', res.message, 'success').then(() => {
                            window.location.href = "<?= base_url('auth/verify_otp'); ?>";
                        });
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                }
            })
        })
    </script>
</body>

</html>