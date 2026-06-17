<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HTPSINERGI - Verify OTP</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/assets/'); ?>plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/assets/'); ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/assets/'); ?>css/adminlte.min.css">
    <form id="otpForm">
        <input type="text" name="otp" placeholder="Masukkan OTP" class="form-control mb-2" required>
        <button class="btn btn-success btn-block">Verifikasi OTP</button>
    </form>
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