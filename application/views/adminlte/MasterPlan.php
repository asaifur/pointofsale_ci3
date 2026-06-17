<?php foreach ($format as $kolom): ?>

    <?php if ($kolom->type == "HIDDEN"): ?>
        <input type="hidden"
            id="<?= $kolom->code ?>"
            name="<?= $kolom->code ?>">
    <?php endif; ?>

    <!-- ========================= -->
    <!-- TYPE RST -->
    <!-- ========================= -->
    <?php if ($kolom->type == "RST"): ?>
        <div class="<?= $kolom->lebar ?> <?= ($kolom->d == 1) ? "d-none" : "" ?>" id="wrap_<?= $kolom->code ?>">
            <div class="form-group">
                <label>
                    <?= $kolom->name ?>
                    <?= ($kolom->required == 1) ? "<span class='text-danger'>*</span>" : "" ?>
                </label>

                <input type="text"
                    name="<?= $kolom->code ?>"
                    id="<?= $kolom->code ?>"
                    class="form-control"
                    placeholder="<?= $kolom->placeholder ?>"
                    <?= ($kolom->required == 1) ? "required" : "" ?>>

                <div id="msg_<?= $kolom->code ?>"></div>
            </div>
        </div>
    <?php endif; ?>



    <!-- ========================= -->
    <!-- TYPE TEXTAREA -->
    <!-- ========================= -->
    <?php if ($kolom->type == "TEXTAREA"): ?>
        <div class="<?= $kolom->lebar ?>">
            <div class="form-group">
                <label><?= $kolom->name ?></label>
                <textarea class="form-control"
                    name="<?= $kolom->code ?>"
                    rows="3"
                    placeholder="<?= $kolom->placeholder ?>"></textarea>
            </div>
        </div>
    <?php endif; ?>

    <!-- ========================= -->
    <!-- TYPE SELECTUSER -->
    <!-- ========================= -->
    <?php if ($kolom->type == "SELECTUSER"): ?>
        <div class="<?= $kolom->lebar ?>">
            <div class="form-group">
                <label><?= $kolom->name ?></label>
                <input type="text"
                    id="<?= $kolom->code ?>"
                    name="<?= $kolom->code ?>"
                    placeholder="<?= $kolom->placeholder ?>"
                    class="autocomplete form-control">
            </div>
        </div>
    <?php endif; ?>

    <?php if ($kolom->type == "SELECT_AKUN"): ?>
        <div class="<?= $kolom->lebar ?>">
            <div class="form-group"> <label>
                    <?= $kolom->name ?></label>
                <select id="<?= $kolom->code ?>" required class="form-control" name="<?= $kolom->code ?>">
                    <option value="0">-- Tidak ada Akun --</option>
                    <option value="1">-- Ada Akun --</option>
                </select> <!-- HIDDEN Nama -->
            </div>
        </div>
    <?php endif; ?>
    <!-- ========================= -->
    <!-- TYPE PROVINSI -->
    <?php if ($kolom->type == "PROVINSI"): ?>
        <div class="<?= $kolom->lebar ?>">
            <div class="form-group"> <label>
                    <?= $kolom->name ?></label>
                <select id="provinsi_id" class="form-control" name="<?= $kolom->code ?>">
                    <option value="">-- Pilih Provinsi --</option> <?php foreach ($provinsi as $p): ?>
                        <option value="<?= $p->id ?>" data-nama="<?= $p->nama ?>">
                            <?= $p->nama ?> </option>
                    <?php endforeach; ?>
                </select> <!-- HIDDEN Nama -->
            </div>
        </div> <?php endif; ?>
    <?php if ($kolom->type == "KABUPATEN"): ?>
        <div class="<?= $kolom->lebar ?>">
            <div class="form-group">
                <label><?= $kolom->name ?></label>
                <select id="kabupaten_id" class="form-control" name="<?= $kolom->code ?>"> </select>
            </div>
        </div> <?php endif; ?>
    <?php if ($kolom->type == "KECAMATAN"): ?>
        <div class="<?= $kolom->lebar ?>">
            <div class="form-group">
                <label><?= $kolom->name ?></label>
                <select id="kecamatan_id" class="form-control" name="<?= $kolom->code ?>">
                </select>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($kolom->type == "KELURAHAN"): ?>
        <div class="<?= $kolom->lebar ?>">
            <div class="form-group">
                <label><?= $kolom->name ?>
                </label>
                <select id="kelurahan_id" class="form-control" name="<?= $kolom->code ?>"> </select>
            </div> <?php endif; ?>

        <!-- ========================= -->
        <!-- TYPE FILE -->
        <!-- ========================= -->
        <?php if ($kolom->type == "FILE"): ?>
            <div class="col-md-12">
                <div class="form-group">
                    <label><?= $kolom->name ?></label>
                    <input type="file" id="<?= $kolom->code ?>"
                        class="form-control"
                        name="<?= $kolom->code ?>" <?= ($kolom->required == 1) ? "required" : "" ?>>
                </div>
            </div>
        <?php endif; ?>

        <!-- ========================= -->
        <!-- TYPE FILEMP4 -->
        <!-- ========================= -->
        <?php if ($kolom->type == "FILEMP4"): ?>
            <div class="col-md-12">
                <div class="form-group">
                    <label><?= $kolom->name ?></label>
                    <input type="file" id="<?= $kolom->code ?>"
                        class="form-control"
                        name="<?= $kolom->code ?>"
                        accept="video/mp4" <?= ($kolom->required == 1) ? "required" : "" ?>>
                </div>
            </div>
        <?php endif; ?>

    <?php endforeach; ?>

    <script>
        $('.autocomplete').each(function() {

            var inputField = $(this);

            inputField.autocomplete({
                minLength: 2,
                delay: 300,

                source: function(request, response) {
                    $.ajax({
                        url: "<?= base_url('FormHalal/get_user_autocomplete'); ?>",
                        type: "POST",
                        dataType: "json",
                        data: {
                            keyword: request.term
                        },
                        success: function(data) {
                            console.log(data);
                            response(data);
                        }
                    });
                },

                select: function(event, ui) {
                    $('#namaUser').val(ui.item.nama);
                    $('#userP3H').val(ui.item.email);
                    return false;
                }

            });

        });

        document.querySelectorAll('.toggle-card').forEach(function(button) {
            button.addEventListener('click', function() {
                let target = document.querySelector(this.dataset.target);
                target.classList.toggle('show');

                let icon = this.querySelector('i');
                icon.classList.toggle('fa-chevron-down');
                icon.classList.toggle('fa-chevron-up');
            });
        });
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

            // set HIDDEN nama
            $('#provinsi_nama').val(nama);

            // reset bawah
            $('#kabupaten_id').html('<option>Loading...</option>').prop('disabled', true);
            $('#kecamatan_id').html('').prop('disabled', true);
            $('#kelurahan_id').html('').prop('disabled', true);

            $.post("<?= base_url('Auth/getKabupaten'); ?>", {
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

            $.post("<?= base_url('Auth/getKecamatan'); ?>", {
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

            $.post("<?= base_url('Auth/getKelurahan'); ?>", {
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

        $('#noHP').on('keyup', function() {

            let nohp = $(this).val();

            // hanya angka
            nohp = nohp.replace(/[^0-9]/g, '');
            $(this).val(nohp);

            if (nohp.length < 10) {
                $('#msg_noHP')
                    .html('<small class="text-danger">Nomor HP minimal 10 digit</small>')
                    .show();

                $(this).addClass('is-invalid').removeClass('is-valid');
                return;
            }

            $.ajax({
                url: "<?= base_url('FormHalal/cek_field'); ?>",
                type: "POST",
                data: {
                    type: 'noHP',
                    value: nohp
                },
                dataType: "JSON",
                success: function(res) {
                    if (res.exists) {

                        $('#msg_noHP')
                            .html('<small class="text-danger">Nomor HP sudah terdaftar, silakan gunakan nomor lain.</small>')
                            .show();

                        $('#noHP')
                            .addClass('is-invalid')
                            .removeClass('is-valid');

                    } else {

                        $('#msg_noHP')
                            .html('<small class="text-success">Nomor HP tersedia dan dapat digunakan</small>')
                            .show();

                        $('#noHP')
                            .addClass('is-valid')
                            .removeClass('is-invalid');
                    }
                }
            });

        });


        function validasiAngka(fieldId, msgId, type, minLength, pesanKurang) {

            const btnSubmit = $('#btnSubmit');

            $(fieldId).on('keyup', function() {

                let value = $(this).val().trim();

                // hanya angka
                value = value.replace(/[^0-9]/g, '');
                $(this).val(value);

                if (value.length < minLength) {

                    $(msgId)
                        .html('<small class="text-danger">' + pesanKurang + '</small>')
                        .show();

                    $(this).addClass('is-invalid').removeClass('is-valid');

                    btnSubmit.prop('disabled', true);
                    return;
                }

                $.ajax({
                    url: "<?= base_url('FormHalal/cek_field'); ?>",
                    type: "POST",
                    data: {
                        type: type,
                        value: value
                    },
                    dataType: "JSON",
                    success: function(res) {

                        if (res.exists) {

                            $(msgId)
                                .html('<small class="text-danger">' + type.toUpperCase() + ' sudah terdaftar, silakan gunakan yang lain.</small>')
                                .show();

                            $(fieldId)
                                .addClass('is-invalid')
                                .removeClass('is-valid');

                            btnSubmit.prop('disabled', true);

                        } else {

                            $(msgId)
                                .html('<small class="text-success">' + type.toUpperCase() + ' tersedia dan dapat digunakan</small>')
                                .show();

                            $(fieldId)
                                .addClass('is-valid')
                                .removeClass('is-invalid');

                            cekSemuaValid(); // cek semua field sebelum aktifkan button
                        }
                    }
                });

            });

        }

        function cekSemuaValid() {

            const btnSubmit = $('#btnSubmit');

            let nikValid = $('#nik').hasClass('is-valid');
            let hpValid = $('#noHP').hasClass('is-valid');

            if (nikValid && hpValid) {
                btnSubmit.prop('disabled', false);
            } else {
                btnSubmit.prop('disabled', true);
            }
        }

        $('#namaPU, #alamat,#tempatUsahaName,#tempatUsahaAlamat').on('input', function() {
            this.value = this.value.toUpperCase();
        })

        function forceUppercase(fieldId) {

            $(fieldId).on('input', function() {

                let value = $(this).val();

                // trim spasi depan belakang
                value = value.trimStart();

                // ubah ke uppercase
                value = value.toUpperCase();

                $(this).val(value);
            });

        }


        $('.d-none').each(function() {
            $(this).find('input, select, textarea').prop('required', false);
        });


        function disableRequired(wrapperId) {

            $(wrapperId).find('input, select, textarea').each(function() {
                $(this).prop('required', false);
            });

        }
        forceUppercase('#namaPU');
        forceUppercase('#alamat');

        // NIK (16 digit)
        validasiAngka(
            '#nik',
            '#msg_nik',
            'nik',
            16,
            'NIK harus 16 digit'
        );

        // Nomor HP (minimal 10 digit)
        validasiAngka(
            '#noHP',
            '#msg_noHP',
            'nohp',
            10,
            'Nomor HP minimal 10 digit'
        );

        $('#nik').on('keyup', function() {

            let nik = $(this).val();

            // hanya angka
            nik = nik.replace(/[^0-9]/g, '');
            $(this).val(nik);

            if (nik.length < 16) {
                $('#msg_nik')
                    .html('<small class="text-danger">NIK harus 16 digit</small>')
                    .show();

                $(this).addClass('is-invalid').removeClass('is-valid');
                return;
            }

            $.ajax({
                url: "<?= base_url('FormHalal/cek_field'); ?>",
                type: "POST",
                data: {
                    type: 'nik',
                    value: nik
                },
                dataType: "JSON",
                success: function(res) {

                    if (res.exists) {

                        $('#msg_nik')
                            .html('<small class="text-danger">NIK sudah terdaftar, silakan gunakan NIK lain.</small>')
                            .show();

                        $('#nik')
                            .addClass('is-invalid')
                            .removeClass('is-valid');

                    } else {

                        $('#msg_nik')
                            .html('<small class="text-success">NIK tersedia dan dapat digunakan</small>')
                            .show();

                        $('#nik')
                            .addClass('is-valid')
                            .removeClass('is-invalid');
                    }
                }
            });

        });
    </script>