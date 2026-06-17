<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Data Baru Pemilik Usaha</title>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/dist/') ?>css/adminlte.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        .card {
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        body {
            background: linear-gradient(135deg, #dbeafe, #eff6ff);
            min-height: 100vh;

        }

        body,
        input,
        textarea,
        select,
        button {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>
</head>

<body class="hold-transition">
    <div class="container mt-5">
        <div class="card card-outline card-success shadow">

            <!-- Top border hijau -->
            <div class="card-header text-center border-0">
                <h4 class="text-danger font-weight-bold">
                    <i class="fas fa-lock text-warning"></i>
                    FORMULIR PENDAFTARAN SERTIFIKASI HALAL (SELF DECLARE)
                    <br>
                    PT SATRIA HALAL INDONESIA
                </h4>
            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-outline card-primary">
                    <div class="card border-warning mb-12">
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
                    <div class="card-body">
                        <p class="login-box-msg">Form Register Data Pelaku Usaha</p>

                        <form id="registerForm" enctype="multipart/form-data">
                            <div class="card card-primary card-outline">
                                <div class="card-body" id="umum">
                                </div>
                            </div>

                            <div class="form-group row">

                            </div>
                            <div class="card card-success card-outline">
                                <div class="card-body">
                                    <div class="text-center"> Masukan Produk (* Maksimal 7 Produk )</div>
                                    <div class="produk-group" id="currentprod">
                                    </div>
                                    <div class="produk-group d-none" id="produk">
                                    </div>
                                </div>
                                <button class="tambahProduk btn-success btn" id="tambahProduk"><i class="fas fa-plus"></i>Tambah Produk</button>
                            </div>
                            <div class="card card-info card-outline">
                                <div class="card-body d-block" id="akhir">
                                </div>
                            </div>
                            <div class="card card-warning card-outline">
                                <div class="card-body " id="NIB">
                                </div>
                            </div>
                            <div class="card card-warning card-outline">
                                <div class="card-body " id="HALAL">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <button type="submit"
                                        id="btnSubmit"
                                        class="btn btn-purple">
                                        TAMBAH DATA PEMILIK USAHA
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div><!-- /.card -->
    <!-- /.register-box -->
    <script src="<?= base_url('assets/plugins/') ?>jquery/jquery.min.js"></script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url('assets/plugins/') ?>bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="<?= base_url('assets/dist/') ?>/js/adminlte.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.18/dist/sweetalert2.all.min.js"></script>

    <script>
        let maxProduk = 7;
        let currentProduk = 1; // produk1 sudah ada / default
        $('#registerForm').on('submit', function(e) {
            e.preventDefault();

            // Validasi checkbox persetujuan
            if (!$('#setuju').is(':checked')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Persetujuan Diperlukan',
                    text: 'Anda harus menyetujui pernyataan terlebih dahulu.'
                });
                return;
            }
            // ==============================
            // VALIDASI PRODUK 2 - 7
            // ==============================

            for (let i = 2; i <= currentProduk; i++) {

                let nama = $('#nameProduk' + i).val()?.trim() || '';

                let fotoInput = $('input[name="fotoProduk' + i + '"]')[0];
                let vervalInput = $('input[name="vervalProduk' + i + '"]')[0];
                let videoInput = $('input[name="videoProduk' + i + '"]')[0];

                let foto = fotoInput ? fotoInput.files.length : 0;
                let verval = vervalInput ? vervalInput.files.length : 0;
                let video = videoInput ? videoInput.files.length : 0;

                if (nama !== '') {

                    if (foto === 0 || verval === 0 || video === 0) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Data Produk ' + i + ' Belum Lengkap',
                            html: `
                <div style="text-align:left">
                    Jika Nama Produk ${i} diisi, maka wajib upload:
                    <ul>
                        <li>Foto Produk ${i}</li>
                        <li>Dokumen Verval Produk ${i}</li>
                        <li>Video Produk ${i}</li>
                    </ul>
                </div>
                `
                        });

                        return;
                    }
                }
            }

            let btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).text('Menyimpan...');

            // Gunakan FormData agar file ikut terkirim
            let formData = new FormData(this);

            $.ajax({
                url: "<?= base_url('auth/proses_register_pemilik_usaha'); ?>",
                type: "POST",
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                cache: false,

                success: function(res) {

                    if (res.status === 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            html: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "<?= base_url('FormHalal'); ?>";
                        });

                    } else {

                        let errorMessages = '';

                        if (typeof res.errors === 'object') {
                            $.each(res.errors, function(key, value) {
                                errorMessages += '<div style="text-align:left;">• ' + value + '</div>';
                            });
                        } else {
                            errorMessages = res.errors;
                        }

                        Swal.fire({
                            icon: 'warning',
                            title: 'Validasi Gagal',
                            html: errorMessages
                        });
                    }
                },

                error: function(xhr) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Terjadi kesalahan pada server.'
                    });

                    btn.prop('disabled', false)
                        .text('TAMBAH DATA PEMILIK USAHA');
                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#umum').load("<?= base_url('FormHalal/Masterplan/umum/') ?>");
            $('#NIB').load("<?= base_url('FormHalal/Masterplan/NIB/') ?>");
            $('#currentprod').load("<?= base_url('FormHalal/Masterplan/currentprod/') ?>");

            $('#HALAL').load("<?= base_url('FormHalal/Masterplan/HALAL/') ?>");
            $('#akhir').load("<?= base_url('FormHalal/Masterplan/akhir/') ?>");



            $('#tambahProduk').click(function(e) {
                e.preventDefault();

                if (currentProduk >= maxProduk) {
                    return;
                }

                currentProduk++;

                // tampilkan container kalau masih hidden
                $('#produk').removeClass('d-none');

                // load view sesuai nomor produk
                $('#produk').append(
                    $('<div>', {
                        id: 'produk' + currentProduk,
                        class: 'mb-3'
                    }).load("<?= base_url('FormHalal/Masterplan/produk/') ?>" + currentProduk)
                );

                // disable tombol kalau sudah 7
                if (currentProduk == maxProduk) {
                    $('#tambahProduk').prop('disabled', true);
                }

            });

            function toggleAkunNIB() {
                let value = $('#have_akun_nib').val();

                if (value === "1") {
                    $('#wrap_akunnib').removeClass('d-none');
                    $('#wrap_passnib').removeClass('d-none');
                    $('#akunnib').prop('required', true);
                } else {
                    $('#wrap_akunnib').addClass('d-none');
                    $('#wrap_passnib').addClass('d-none');
                    $('#akunnib').prop('required', false).val('');
                }
            }

            // Jalankan saat berubah
            $(document).on('change', '#have_akun_nib', function() {
                toggleAkunNIB();
            });

            // Jalankan saat pertama load
            toggleAkunNIB();

            function toggleAkunHalal() {
                let value = $('#have_akun_halal').val();

                if (value === "1") {
                    $('#wrap_akun_halal').removeClass('d-none');
                    $('#wrap_pass_halal').removeClass('d-none');
                    $('#akun_halal').prop('required', true);
                } else {
                    $('#wrap_akun_halal').addClass('d-none');
                    $('#wrap_pass_halal').addClass('d-none');
                    $('#akun_halal').prop('required', false).val('');
                }
            }

            // Jalankan saat berubah
            $(document).on('change', '#have_akun_halal', function() {
                toggleAkunHalal();
            });

            // Jalankan saat pertama load
            toggleAkunHalal();


        });
    </script>
</body>

</html>