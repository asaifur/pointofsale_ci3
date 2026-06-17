<?php
$action = $action;
$readonly = '';
if ($action == "view") {
    $readonly = "readonly";
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.17/dist/sweetalert2.min.css">
<div class="modal-header">
    <h5 class="modal-title " style="text-transform: capitalize;"><?= $action; ?> Data Jobdesk Entry </h5>
    <button type="button" class="close" data-dismiss="modal">
        <span>&times;</span>
    </button>
</div>
<form id="form-nib">
    <div class="modal-body">
        <?php foreach ($format as $kolom):

            $value = isset($dtKolom->{$kolom->code})
                ? $dtKolom->{$kolom->code}
                : "";


        ?>
            <div class="form-group">
                <?php if ($kolom->type == "hidden"): ?>
                    <input type="hidden" value="<?= $value; ?>" name="<?= $kolom->code ?>" id="<?= $kolom->code ?>" class="form-control" placeholder="<?= $kolom->placeholder ?>">
                <?php endif; ?>
                <?php if ($kolom->type == "rst") : ?>
                    <label><?= $kolom->name; ?></label>
                    <input <?= $readonly; ?> type="text" value="<?= $value; ?>" name="<?= $kolom->code ?>" id="<?= $kolom->code ?>" class="form-control" placeholder="<?= $kolom->placeholder ?>">
                    <?= ($kolom->check == 1) ? '<small id="msg_nib" class="form-text"></small>' : '' ?>
                <?php endif; ?>
            </div>
            <?php if ($kolom->type == "file") : ?>
                <div class="form-group">
                    <label>Upload File</label>

                    <input <?= $readonly; ?> type="file" name="file" id="file" class="form-control">

                    <?php if (!empty($value)) : ?>
                        <small class="text-success d-block mt-2">
                            File saat ini :
                            <a href="<?= base_url('assets/uploads/') . $value; ?>" target="_blank">
                                <?= $value; ?>
                            </a>
                        </small>

                        <!-- Preview jika gambar -->
                        <?php
                        $ext = pathinfo($value, PATHINFO_EXTENSION);
                        $img_ext = ['jpg', 'jpeg', 'png'];
                        ?>

                        <?php if (in_array(strtolower($ext), $img_ext)) : ?>
                            <img src="<?= base_url('assets/uploads/') . $value; ?>"
                                class="img-thumbnail mt-2"
                                style="max-height:150px;">
                        <?php endif; ?>

                    <?php endif; ?>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
    <?php if ($action == "view") {
        echo ' Tidak ada Aksi';
    } else { ?>
        <input type="hidden" name="action" value="<?= $action ?>">
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-info" id="btn-simpan"><?= $action; ?></button>
        </div>
    <?php } ?>
</form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.17/dist/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $('#nib').on('input', function() {
            // Mengambil nilai input dan menghapus semua selain angka (0-9)
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $('#nib').on('keyup', function() {
            var nib = $(this).val();

            // Minimal panjang karakter sebelum cek (misal 4 digit) agar tidak terlalu berat
            if (nib.length >= 4) {
                $.ajax({
                    url: "<?= base_url('Dashboard/check_nib_exists'); ?>",
                    type: "POST",
                    data: {
                        nib: nib
                    },
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.exists) {
                            $('#msg_nib').html('NIB sudah ada dalam database!').addClass('text-danger').removeClass('text-success');

                        } else {
                            $('#msg_nib').html('NIB tersedia').addClass('text-success').removeClass('text-danger');
                            $('#nib').removeClass('is-invalid').addClass('is-valid');
                            $('#btn-simpan').attr('disabled', false); // Aktifkan tombol

                        }
                    }
                });
            } else {
                $('#msg_nib').html('');
                $('#nib').removeClass('is-invalid is-valid');
            }
        });
    });
    $('#form-nib').on('submit', function(e) {
        e.preventDefault(); // Mencegah reload halaman
        var action = "<?= $action ?>";

        // Menggunakan FormData untuk menangani upload file
        var formData = new FormData(this);

        $.ajax({
            url: "<?= base_url('Dashboard/insert_nib/');  ?>", // Arahkan ke method controller
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,

            success: function(response) {
                var res = jQuery.parseJSON(response);

                if (res.status == true) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {

                        $('#form-nib')[0].reset(); // Reset form
                        $('#modal-default').modal('hide'); // Tutup modal

                        if ($.fn.DataTable.isDataTable('#myTable')) {
                            $('#myTable').DataTable().ajax.reload(null, false);
                        }

                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: res.message
                    });

                }
            },

            error: function() {
                alert("Terjadi kesalahan pada server.");
            },
            complete: function() {
                $('#btn-simpan').attr('disabled', false).html('Simpan');
            }
        });
    });
</script>