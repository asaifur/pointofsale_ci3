<div class="modal-header bg-primary">
    <h5 class="modal-title">Profile (<?= $action  ?>) </h5>
    <button type="button" class="close" data-dismiss="modal">
        <span>&times;</span>
    </button>
</div>

<form id="formUpdateQcEmail" enctype="multipart/form-data">

    <div class="modal-body">

        <input type="hidden" name="id" value="<?= $row->id_users; ?>">

        <?php foreach ($format as $kolom): ?>
            <?php $dtKolomcode = $kolom->code;
            $valueCode = $row->$dtKolomcode;
            ?>
            <?php if ($kolom->type == "RST") : ?>
                <div class="form-group">
                    <label for="<?= $kolom->code ?>"><?= $kolom->name ?></label>
                    <input name="<?= $kolom->code ?>" class="form-control" id="<?= $kolom->code ?>" type="text" value="<?= $valueCode ?>" placeholder="<?= $kolom->placeholder; ?>">
                    <small id="msg_<?= $kolom->code ?>" class="form-text"></small>
                </div>

            <?php endif; ?>
            <?php if ($kolom->type == "FILE"): ?>
                <div class="col-md-12 mb-3">
                    <label for="<?= $kolom->code ?>"><?= $kolom->name ?></label>

                    <?php if (!empty($valueCode)): ?>
                        <div class="mb-2">
                            <?php
                            $ext = pathinfo($valueCode, PATHINFO_EXTENSION);
                            $fileUrl = base_url('assets/uploads/' . $valueCode);
                            ?>

                            <?php if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp'])): ?>
                                <img src="<?= $fileUrl ?>"
                                    class="img-fluid mb-2"
                                    style="max-height:150px; border-radius:8px;">
                            <?php else: ?>
                                <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-file"></i> Lihat File
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file"
                                class="custom-file-input"
                                id="<?= $kolom->code ?>"
                                name="<?= $kolom->code ?>">
                            <label class="custom-file-label"
                                for="<?= $kolom->code ?>">
                                <?= !empty($valueCode) ? 'Ganti file...' : 'Choose file' ?>
                            </label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($kolom->type == 'SELECTQC'): ?>
                <div class="form-group">
                    <label for="<?= $kolom->code ?>"> Select <?= $kolom->name ?></label>
                    <select class="form-control" name="<?= $kolom->code ?>" id="<?= $kolom->code ?>" required>
                        <option value="0">Belum Di Approve</option>
                        <option value="1"> Approve</option>
                    </select>
                </div>

            <?php endif; ?>
            <?php if ($kolom->type == "SELECT_STATUS"): ?>
                <div class="form-group">
                    <label for="<?= $kolom->code ?>"> Select <?= $kolom->name ?></label>
                    <select class="form-control" name="<?= $kolom->code ?>" id="<?= $kolom->code ?>" required>
                        <?php foreach ($keterangan as $ket): ?>
                            <option value="<?= $ket->keterangan_status ?>"> <?= $ket->keterangan_status ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            <?php endif; ?>
            <?php if ($kolom->type == "FILEMP4"): ?>
                <div class="col-md-12 mb-3">
                    <label for="<?= $kolom->code ?>"><?= $kolom->name ?></label>

                    <?php if (!empty($valueCode)): ?>
                        <div class="mb-2">
                            <?php $videoUrl = base_url('assets/uploads/' . $valueCode); ?>

                            <video width="100%" height="250" controls style="border-radius:8px;">
                                <source src="<?= $videoUrl ?>" type="video/mp4">
                                Browser Anda tidak mendukung video.
                            </video>

                            <div class="mt-2">
                                <a href="<?= $videoUrl ?>" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file"
                                class="custom-file-input"
                                id="<?= $kolom->code ?>"
                                name="<?= $kolom->code ?>"
                                accept="video/mp4">
                            <label class="custom-file-label"
                                for="<?= $kolom->code ?>">
                                <?= !empty($valueCode) ? 'Ganti video...' : 'Choose file' ?>
                            </label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
    <?php if ($action <> "view") {  ?>
        <div class="modal-footer">
            <button type="button"
                class="btn btn-secondary"
                data-dismiss="modal">Batal</button>

            <button type="submit"
                class="btn btn-primary"><?= $action ?></button>
        </div>
    <?php } else {
        echo "";
    } ?>

</form>

<script>
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
    $('.custom-file-input').on('change', function() {

        // Ambil nama file
        let fileName = $(this).val().split('\\').pop();

        // Tampilkan ke label
        $(this).next('.custom-file-label')
            .addClass("selected")
            .html(fileName);

    });
    $(document).on('submit', '#formUpdateQcEmail', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let action = "<?= $action; ?>";

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: "Pastikan data sudah benar",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?= base_url('Dashboard/update_qc_detail/'); ?>" + action,
                    type: "POST",
                    data: formData,
                    dataType: "JSON",
                    processData: false, // WAJIB untuk upload file
                    contentType: false, // WAJIB untuk upload file
                    beforeSend: function() {

                        Swal.fire({
                            title: 'Menyimpan...',
                            text: 'Mohon tunggu',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                    },
                    success: function(response) {

                        Swal.close();

                        if (response.success) {

                            $('#modal-xl').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data berhasil diperbarui',
                                timer: 1500,
                                showConfirmButton: false
                            });

                            tableTransaksi.ajax.reload(null, false);

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });

                        }
                    },
                    error: function() {

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan server'
                        });

                    }
                });

            }

        });

    });
</script>