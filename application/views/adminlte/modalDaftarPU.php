    <div class="modal-header bg-success">
        <h5 class="modal-title text-white">
            <i class="fa fa-user"></i> Data Diri Pelaku Usaha
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">
            <span>&times;</span>
        </button>
    </div>

    <!-- Modal Body -->
    <form action="<?= base_url('dashboard/simpanPU/') . $action; ?> " method="post" enctype="multipart/form-data" id="formPU">
        <div class="modal-body">

            <!-- Pernyataan -->
            <div class="card border-warning mb-3">
                <div class="card-body bg-light">
                    <h6 class="text-warning font-weight-bold">Pernyataan Pelaku Usaha :</h6>
                    <ol class="mb-2">
                        <li>Saya secara sadar memberikan data yang benar dan dapat dipertanggungjawabkan.</li>
                        <li>Saya menyatakan bahan-bahan yang digunakan adalah halal.</li>
                    </ol>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="setuju" required>
                        <label class="custom-control-label text-danger font-weight-bold" for="setuju">
                            Saya Setuju dan Paham
                        </label>
                    </div>
                </div>
            </div>
            <?php foreach ($format as $kolom):
                if ($action <> "insert") {
                    $dt = $dtKolom;
                }

            ?>

                <!-- Nama -->
                <?php if ($kolom->type == "rst"): ?>
                    <div class="form-group">
                        <label class="text-upppercase"><?= $kolom->name ?></label> <span class="text-danger"><?= ($kolom->required == 1) ? "*" : "" ?></span>
                        <input type="text" name="<?= $kolom->code ?>" id="<?= $kolom->code; ?>" class="form-control" placeholder="<?= $kolom->placeholder ?>" <?= ($kolom->required == 1) ? "required" : "" ?>>
                    </div>
                <?php endif; ?>
                <?php if ($kolom->type == "user"): ?>
                    <input type="hidden" name="<?= $kolom->code ?>" class="form-control" required id="<?= $kolom->code; ?>" value="<?= $_SESSION['email'] ?>">
                <?php endif; ?>
                <?php if ($kolom->type == "provinsi"): ?>
                    <div class="form-group">
                        <label><?= $kolom->name ?></label>

                        <select id="provinsi_id"
                            class="form-control"
                            name="<?= $kolom->code ?>">

                            <option value="">-- Pilih Provinsi --</option>

                            <?php foreach ($provinsi as $p): ?>
                                <option value="<?= $p->id ?>"
                                    data-nama="<?= $p->nama ?>">
                                    <?= $p->nama ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Hidden Nama -->
                        <input type="hidden"
                            name="provinsi_nama"
                            id="provinsi_nama">
                    </div>
                <?php endif; ?>

                <?php if ($kolom->type == "kabupaten"): ?>
                    <div class="form-group">
                        <label><?= $kolom->name ?></label>

                        <select id="kabupaten_id"
                            class="form-control"
                            name="<?= $kolom->code ?>">
                        </select>

                        <input type="hidden"
                            name="kabupaten_nama"
                            id="kabupaten_nama">
                    </div>
                <?php endif; ?>

                <?php if ($kolom->type == "kecamatan"): ?>
                    <div class="form-group">
                        <label><?= $kolom->name ?></label>

                        <select id="kecamatan_id"
                            class="form-control"
                            name="<?= $kolom->code ?>">
                        </select>

                        <input type="hidden"
                            name="kecamatan_nama"
                            id="kecamatan_nama">
                    </div>
                <?php endif; ?>

                <?php if ($kolom->type == "kelurahan"): ?>
                    <div class="form-group">
                        <label><?= $kolom->name ?></label>

                        <select id="kelurahan_id"
                            class="form-control"
                            name="<?= $kolom->code ?>">
                        </select>

                        <input type="hidden"
                            name="kelurahan_nama"
                            id="kelurahan_nama">
                    </div>
                <?php endif; ?>

                <?php if ($kolom->type == "file"): ?>
                    <div class="form-group">
                        <label class="text-upppercase"><?= $kolom->name ?> </label> <span class="text-danger"><?= ($kolom->required == 1) ? "*" : "" ?></span>
                        <div class="custom-file">
                            <input type="file" name="<?= $kolom->code ?>" class="custom-file-input" id="<?= $kolom->code; ?>">
                            <label class="custom-file-label">Pilih file</label>
                        </div>
                        <small class="text-muted">Format JPG / PNG, max 2MB</small>
                    </div>
                <?php endif; ?>




            <?php endforeach; ?>
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-block">
                Submit
            </button>
        </div>
    </form>
    </div>

    <script>
        $('.custom-file-input').on('change', function() {

            // Ambil nama file
            let fileName = $(this).val().split('\\').pop();

            // Tampilkan ke label
            $(this).next('.custom-file-label')
                .addClass("selected")
                .html(fileName);

        });

        // =========================
        // PROVINSI
        // =========================
        $('#provinsi_id').change(function() {

            let id = $(this).val();
            let nama = $('#provinsi_id option:selected').data('nama');

            // set hidden nama
            $('#provinsi_nama').val(nama);

            // reset bawah
            $('#kabupaten_id').html('<option>Loading...</option>').prop('disabled', true);
            $('#kecamatan_id').html('').prop('disabled', true);
            $('#kelurahan_id').html('').prop('disabled', true);

            $.post("<?= base_url('dashboard/getKabupaten'); ?>", {
                id: id
            }, function(res) {

                let opt = '<option value="">-- Pilih Kabupaten --</option>';

                $.each(JSON.parse(res), function(i, v) {
                    opt += `<option value="${v.id}" data-nama="${v.nama}">
                        ${v.nama}
                    </option>`;
                });

                $('#kabupaten_id').html(opt).prop('disabled', false);
            });
        });


        // =========================
        // KABUPATEN
        // =========================
        $('#kabupaten_id').change(function() {

            let id = $(this).val();
            let nama = $('#kabupaten_id option:selected').data('nama');

            $('#kabupaten_nama').val(nama);

            $('#kecamatan_id').html('<option>Loading...</option>').prop('disabled', true);
            $('#kelurahan_id').html('').prop('disabled', true);

            $.post("<?= base_url('dashboard/getKecamatan'); ?>", {
                id: id
            }, function(res) {

                let opt = '<option value="">-- Pilih Kecamatan --</option>';

                $.each(JSON.parse(res), function(i, v) {
                    opt += `<option value="${v.id}" data-nama="${v.nama}">
                        ${v.nama}
                    </option>`;
                });

                $('#kecamatan_id').html(opt).prop('disabled', false);
            });
        });


        // =========================
        // KECAMATAN
        // =========================
        $('#kecamatan_id').change(function() {

            let id = $(this).val();
            let nama = $('#kecamatan_id option:selected').data('nama');

            $('#kecamatan_nama').val(nama);

            $('#kelurahan_id').html('<option>Loading...</option>').prop('disabled', true);

            $.post("<?= base_url('dashboard/getKelurahan'); ?>", {
                id: id
            }, function(res) {

                let opt = '<option value="">-- Pilih Kelurahan --</option>';

                $.each(JSON.parse(res), function(i, v) {
                    opt += `<option value="${v.id}" data-nama="${v.nama}">
                        ${v.nama}
                    </option>`;
                });

                $('#kelurahan_id').html(opt).prop('disabled', false);
            });
        });


        // =========================
        // KELURAHAN
        // =========================
        $('#kelurahan_id').change(function() {

            let nama = $('#kelurahan_id option:selected').data('nama');

            $('#kelurahan_nama').val(nama);
        });

        $('#modalForm').on('shown.bs.modal', function() {
            $(this).find('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                dropdownParent: $('#modalForm'),
                placeholder: '-- Pilih --',
                allowClear: true
            });
        });
        $('#formPU').on('submit', function(e) {
            e.preventDefault();

            let url = $(this).attr('action');

            // 🔥 Pakai FormData
            let formData = new FormData(this);

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,

                beforeSend: function() {
                    $('button[type=submit]')
                        .prop('disabled', true)
                        .text('Menyimpan...');
                },

                success: function(res) {
                    if (res.status === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('Gagal', res.message, 'warning');
                    }
                },

                error: function() {
                    Swal.fire('Error', 'Server error', 'error');
                },

                complete: function() {
                    $('button[type=submit]')
                        .prop('disabled', false)
                        .text('Submit');
                }
            });
        });
    </script>