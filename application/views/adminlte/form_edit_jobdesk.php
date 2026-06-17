<div class="modal-header bg-info text-white">

    <h5 class="modal-title">

        <i class="fas fa-edit"></i> Update Data Jobdesk

    </h5>

    <button type="button" class="close text-white" data-dismiss="modal">

        <span>&times;</span>

    </button>

</div>



<form id="form-update-jobdesk" enctype="multipart/form-data">

    <div class="modal-body">



        <input type="hidden" name="id" value="<?= $job->id; ?>">



        <div class="form-group">

            <label>P3H</label>

            <input type="text" name="ppph" class="form-control"

                value="<?= $job->ppph; ?>" required>

        </div>



        <div class="form-group">

            <label>NIB</label>

            <input type="text" name="nib" class="form-control"

                value="<?= $job->nib; ?>" readonly>

        </div>



        <div class="form-group">

            <label>Nama PU</label>

            <input type="text" name="namaPU" class="form-control"

                value="<?= $job->namaPU; ?>" required>

        </div>

        <div class="form-group">

            <label>Nomor NIK</label>

            <input type="text" name="nik" class="form-control"

                value="<?= $job->nik; ?>" required>

        </div>

        <div class="form-group">

            <label>Nomor Telepon</label>

            <input type="text" name="noTelepon" class="form-control"

                value="<?= $job->noTelepon; ?>" required>

        </div>

        <div class="form-group">

            <label>Nama Produk 1</label>

            <input type="text" name="produk1" class="form-control"

                value="<?= $job->produk1; ?>" required>

        </div>

        <div class="form-group">

            <label>Nama Produk 2</label>

            <input type="text" name="produk2" class="form-control"

                value="<?= $job->produk2; ?>" required>

        </div>



        <div class="form-group">

            <label>Source Image</label>

            <input type="file" name="source_image" class="form-control" accept="image/*">



            <?php if (!empty($job->source_image)) : ?>

                <small class="text-muted d-block mt-2">Gambar saat ini:</small>

                <img src="<?= base_url('assets/uploads/' . $job->source_image); ?>"

                    class="img-thumbnail mt-1" style="max-height:150px;">

                <input type="hidden" name="old_image" value="<?= $job->source_image; ?>">

            <?php endif; ?>

        </div>



    </div>



    <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">

            <i class="fas fa-times"></i> Batal

        </button>

        <button type="submit" class="btn btn-success">

            <i class="fas fa-save"></i> Update

        </button>

    </div>

</form>

<script>

    $('input[type="text"]').on('input', function() {

        // Jika input BUKAN email

        if ($(this).attr('name') !== 'email' && $(this).attr('type') !== 'email') {

            this.value = this.value.toUpperCase();

        }

    });

    $('#form-update-jobdesk').on('submit', function(e) {

        e.preventDefault();



        let formData = new FormData(this);



        Swal.fire({

            title: 'Konfirmasi',

            text: 'Yakin ingin memperbarui data ini?',

            icon: 'question',

            showCancelButton: true,

            confirmButtonText: 'Ya, Update'

        }).then((result) => {

            if (result.isConfirmed) {



                $.ajax({

                    url: "<?= base_url('Dashboard/updateJobdesk'); ?>",

                    type: "POST",

                    data: formData,

                    contentType: false,

                    processData: false,

                    dataType: "json",

                    beforeSend: function() {

                        Swal.fire({

                            title: 'Menyimpan...',

                            text: 'Mohon tunggu',

                            allowOutsideClick: false,

                            didOpen: () => {

                                Swal.showLoading();

                            }

                        });

                    },

                    success: function(res) {

                        if (res.status === 'success') {

                            Swal.fire('Berhasil', res.message, 'success');

                            $('#modal-default').modal('hide');

                            tableTransaksi.ajax.reload(null, false);

                        } else {

                            Swal.fire('Gagal', res.message, 'error');

                        }

                    },

                    error: function() {

                        Swal.fire('Error', 'Terjadi kesalahan server', 'error');

                    }

                });



            }

        });

    });

</script>