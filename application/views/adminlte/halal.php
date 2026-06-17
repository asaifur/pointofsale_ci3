<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary bg-gradient-secondary btn-sm" id="btn-filter"><i class="fa fa-filter"></i>Filter Data</button>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped text-center" id="myTable">
                <thead class="thead-dark bg-primary text-white">
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th>NOMOR STTD</th>
                        <th>P3H</th>
                        <th>No Telepon</th>
                        <th>No NIK</th>
                        <th>Nama PU</th>
                        <th>nama Usaha </th>
                        <th>LINK KTP </th>
                        <th> provinsi:</th>
                        <th> kota:</th>
                        <th> kecamatan:</th>
                        <th> kelurahan:</th>
                        <th> rtrw:</th>
                        <th> kodepos:</th>
                        <th> produk1:</th>
                        <th> fotoProduk1:</th>
                        <th> videoProduk1:</th>
                        <th> vervalProduk1:</th>
                        <th> produk2</th>
                        <th> fotoProduk2</th>
                        <th> videoProduk2</th>
                        <th> vervalProduk2</th>
                        <th> produk3</th>
                        <th> fotoProduk3</th>
                        <th> videoProduk3</th>
                        <th> vervalProduk3</th>
                        <th> produk4</th>
                        <th> fotoProduk4</th>
                        <th> videoProduk4</th>
                        <th> vervalProduk4</th>
                        <th> produk5</th>
                        <th> fotoProduk5</th>
                        <th> videoProduk5</th>
                        <th> vervalProduk5</th>
                        <th> produk6</th>
                        <th> fotoProduk6</th>
                        <th> videoProduk6</th>
                        <th> vervalProduk6</th>
                        <th> produk7</th>
                        <th> fotoProduk7</th>
                        <th> videoProduk7</th>
                        <th> vervalProduk7</th>
                        <th> email_baru_dibuat</th>
                        <th> password_baru_dibuat</th>
                        <th> nib</th>
                        <th>Date Created</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                </tbody>
            </table>
        </div>

        <style>
            /* Agar isi tabel rata tengah secara vertikal */
            #myTable td {
                vertical-align: middle !important;
            }
        </style>
    </div>
</div>
<!-- Optional JavaScript -->
<!-- Optional JavaScript -->

<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="isiModalSedang">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-filter">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="isiFilter">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalFoto" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Foto</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body text-center">

                <img id="previewFoto" src="" class="img-fluid rounded shadow">

                <br><br>

                <!-- Tombol Download -->
                <a id="btnDownloadFoto"
                    href="#"
                    class="btn btn-success"
                    download>
                    <i class="fa fa-download"></i> Download Foto
                </a>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalShowImage" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Detail Dokumen</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <p class="text-muted mb-0">Nomor NIB:</p>
                    <h3 id="display-nib-top" class="font-weight-bold text-primary"></h3>
                    <hr>
                    <p class="text-muted mb-0">Nama PU</p>
                    <h3 id="display-name-top" class="font-weight-bold text-primary"></h3>
                    <hr>
                    <p class="text-muted mb-0">Nama NIK</p>
                    <h3 id="display-nik-top" class="font-weight-bold text-primary"></h3>
                    <p class="text-muted mb-0">No Telepon</p>
                    <h3 id="display-noTelp-top" class="font-weight-bold text-primary"></h3>
                    <p class="text-muted mb-0">Nama P3H</p>
                    <h3 id="display-p3h-top" class="font-weight-bold text-primary"></h3>
                </div>

                <img src="" id="show-source-image" class="img-fluid img-thumbnail shadow-sm" style="max-height: 500px;"
                    alt="Source Image">

                <div id="no-image-text" class="mt-3 text-danger" style="display:none;">
                    <i class="fas fa-exclamation-circle"></i> Tidak ada file gambar untuk NIB ini.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <a href="" id="btn-download-image" class="btn btn-success" download>
                    <i class="fas fa-download"></i> Download Gambar
                </a>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<?php $this->load->view('template/scriptes.php') ?>
<!-- SCRIPT KAMU (PALING BAWAH) -->

<script>
    $(document).ready(function() {
        $('#btn-tambah').on('click', function() {
            $('#isiModalSedang').html('');
            var action = "insert";
            Swal.fire({
                icon: 'info',
                title: 'Pemberitahuan',
                text: 'Sedang memuat form tambah data...',
                showConfirmButton: false
            });

            $.post(
                '<?= base_url("Dashboard/addJobdesk/insert"); ?>', {

                },
                function(data) {
                    $('#isiModalSedang').html(data);
                    Swal.close();
                },
                'html'
            );

            $('#modal-default').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });


        var tabel = null;

        tableTransaksi = $('#myTable').DataTable({

            "scrollX": true,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "autoWidth": true,

            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": '<?php echo site_url('Dashboard/view_job'); ?>',
                "type": "POST",
                "data": function(data) {}
            },

            //Set column definition initialisation properties.
            "columns": [{
                    data: 'id',
                    sortable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "nomorDaftar",
                    render: function(data, type, row) {

                        if (data === null || data === "" || data === undefined) {
                            return '<span class="text-danger">Belum dibuat</span>';
                        }

                        return data;
                    }
                },
                {
                    data: "ppph"
                },
                {
                    data: "noTelepon"
                },
                {
                    data: "nik"
                },
                {
                    data: "namaPU",
                    render: function(data, type, row) {
                        return data ? data.toUpperCase() : '';
                    }
                },
                {
                    data: "namaUsaha",
                    render: function(data, type, row) {
                        return data ? data.toUpperCase() : '';
                    }
                },
                {
                    data: "ktp_source",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                        data-foto="${data}">
                        <i class="fa fa-eye"></i> Lihat KTP
                        </button>
                        `;
                    }
                },
                {
                    data: "provinsi"
                },
                {
                    data: "kota"
                },
                {
                    data: "kecamatan"
                },
                {
                    data: "kelurahan"
                },
                {
                    data: "rtrw"
                },
                {
                    data: "kodepos"
                },
                {
                    data: "produk1"
                },
                {
                    "data": "fotoProduk1",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                        data-foto="${data}">
                        <i class="fa fa-eye"></i> Lihat fotoProduk1
                        </button>
                        `;
                    }
                },
                {
                    "data": "videoProduk1",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                        data-foto="${data}">
                        <i class="fa fa-eye"></i> Lihat videoProduk1
                        </button>
                        `;
                    }
                },
                {
                    "data": "vervalProduk1",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat vervalProduk1
                </button>
                `;
                    }
                },
                {
                    data: "produk2"
                },
                {
                    "data": "fotoProduk2",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat fotoProduk2
                </button>
                `;
                    }
                },
                {
                    "data": "videoProduk2",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat videoProduk2
                </button>
                `;
                    }
                },
                {
                    "data": "vervalProduk2",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat vervalProduk2
                </button>
                `;
                    }
                },

                {
                    data: "produk3"
                },
                {
                    "data": "fotoProduk3",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat fotoProduk3
                </button>
                `;
                    }
                },
                {
                    "data": "videoProduk3",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat videoProduk3
                </button>
                `;
                    }
                },
                {
                    "data": "vervalProduk3",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat vervalProduk3
                </button>
                `;
                    }
                },
                {
                    data: "produk4"
                },
                {
                    "data": "fotoProduk4",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat fotoProduk4
                </button>
                `;
                    }
                },
                {
                    "data": "videoProduk4",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat videoProduk4
                </button>
                `;
                    }
                },
                {
                    "data": "vervalProduk4",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat vervalProduk4
                </button>
                `;
                    }
                },
                {
                    data: "produk5"
                },
                {
                    "data": "fotoProduk5",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat fotoProduk5
                </button>
                `;
                    }
                },
                {
                    "data": "videoProduk5",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat videoProduk5
                </button>
                `;
                    }
                },
                {
                    "data": "vervalProduk5",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat vervalProduk5
                </button>
                `;
                    }
                },
                {
                    data: "produk6"
                },

                {
                    "data": "fotoProduk6",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat fotoProduk6
                </button>
                `;
                    }
                },

                {
                    "data": "videoProduk6",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat videoProduk6
                </button>
                `;
                    }
                },

                {
                    "data": "vervalProduk6",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat vervalProduk6
                </button>
                `;
                    }
                },

                {
                    data: "produk7"
                },

                {
                    "data": "fotoProduk7",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat fotoProduk7
                </button>
                `;
                    }
                },

                {
                    "data": "videoProduk7",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat videoProduk7
                </button>
                `;
                    }
                },

                {
                    "data": "vervalProduk7",
                    "render": function(data) {

                        if (!data) return '-';

                        return `
                        <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="${data}">
                <i class="fa fa-eye"></i> Lihat vervalProduk7
                </button>
                `;
                    }
                },
                {
                    data: "email_baru_dibuat"
                },
                {
                    data: "password_baru_dibuat"
                },
                {
                    data: "nib"
                },
                {
                    data: "created_at"
                },
                // ⬇️ kolom aksi
                {
                    data: "id",
                    render: function(data, type, row) {
                        let btnDelete = '';

                        if (row.qc == 1) {
                            btnDelete = `
                    <button class="btn btn-sm btn-secondary" disabled>
                        <i class="fas fa-lock"></i> Delete
                    </button>
                `;
                        } else {
                            btnDelete = `
                    <button class="btn btn-sm btn-danger btn-delete"
                        data-id="${data}"
                        data-nib="${row.nib}">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                `;
                        }

                        return `
                <button class="btn btn-sm btn-info btn-update"
                    data-id="${data}">
                    <i class="fas fa-edit"></i> Update
                </button>

                <button class="btn btn-sm btn-primary btn-view-image"
                    data-id="${data}">
                    <i class="fas fa-eye"></i> Show
                </button>

                ${btnDelete}
            `;
                    }
                }
            ]


        });



        $('#myTable').on('click', '.btn-view-image', function() {
            var id = $(this).data('id');
            $('#isiModalSedang').html('');
            Swal.fire({
                icon: 'info',
                title: 'Pemberitahuan',
                text: 'Sedang memuat form tambah data...',
                showConfirmButton: false
            });


            $.ajax({
                url: "<?= base_url('Dashboard/addJobdesk/view'); ?>",
                method: "POST",
                data: {
                    id: id,
                    'action': 'view'

                },
                dataType: 'html',
                success: function(data) {
                    $('#isiModalSedang').html(data);
                    Swal.close();

                    $('#modal-default').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memuat form update.'
                    });
                }
            });
        });


        $('#myTable').on('click', '.btn-update', function() {
            var id = $(this).data('id');
            $('#isiModalSedang').html('');
            Swal.fire({
                icon: 'info',
                title: 'Pemberitahuan',
                text: 'Sedang memuat form tambah data...',
                showConfirmButton: false
            });


            $.ajax({
                url: "<?= base_url('Dashboard/addJobdesk/update'); ?>",
                method: "POST",
                data: {
                    id: id,
                    'action': 'update'

                },
                dataType: 'html',
                success: function(data) {
                    $('#isiModalSedang').html(data);
                    Swal.close();

                    $('#modal-default').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal memuat form update.'
                    });
                }
            });
        });

        // Menangani Klik Tombol Delete
        $('#myTable').on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            var nib = $(this).data('nib');

            if (confirm("Apakah Anda yakin ingin menghapus data NIB: " + nib + "?")) {
                $.ajax({
                    url: "<?= base_url('Dashboard/delete_nib'); ?>",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        var res = JSON.parse(response);
                        if (res.status == 'success') {
                            alert(res.message);
                            tableTransaksi.ajax.reload(null, false); // Reload tabel tanpa reset paging
                        } else {
                            alert("Gagal menghapus data.");
                        }
                    },
                    error: function() {
                        alert("Terjadi kesalahan pada server.");
                    }
                });
            }
        });

        $(document).on('click', '.btn-lihat-foto', function() {

            let fotoUrl = $(this).data('foto');

            $('#previewFoto').attr('src', fotoUrl);

            // set link download
            $('#btnDownloadFoto')
                .attr('href', fotoUrl)
                .attr('target', '_blank') // buka tab baru
                .attr('rel', 'noopener noreferrer'); // keamanan

            $('#modalFoto').modal('show');
        });
        $('#modalFoto').on('hidden.bs.modal', function() {

            $('#previewFoto').attr('src', '');
            $('#btnDownloadFoto').attr('href', '#');

        });
    });
</script>