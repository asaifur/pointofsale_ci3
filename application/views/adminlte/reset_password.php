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
    <link rel="stylesheet" href="<?= base_url('assets/assets/'); ?>plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/assets/'); ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/assets/'); ?>css/adminlte.min.css">
    <form id="resetForm">
        <input type="password" name="password" class="form-control mb-2" placeholder="Password Baru" required>
        <input type="password" name="confirm" class="form-control mb-2" placeholder="Konfirmasi Password" required>
        <button class="btn btn-primary btn-block">Reset Password</button>
    </form>

    <script>
        $('#resetForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('auth/reset_password_process'); ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(res) {
                    if (res.status == 'success') {
                        Swal.fire('Berhasil', res.message, 'success').then(() => {
                            window.location.href = "<?= base_url('auth'); ?>";
                        })
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                }
            });
        })
    </script>