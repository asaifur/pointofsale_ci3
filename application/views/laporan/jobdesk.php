<style>
    button.update-qc:disabled {
        pointer-events: none;
        opacity: 0.6;
    }
</style>
<div class="card">
    <div class="card-header">
        <h4> Table <?= $title ?></h4>
        <div class="form-group">
            <label>Search</label>
            <input type="text" id="keyword" class="form-control" placeholder="Keyword ...">
        </div>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary" id="btn-filter"><i class="fa fa-filter"> Filter</i></button>
        <button type="button" class="btn btn-success" id="btn-export"><i class="fa fa-download"> Download</i></button>
        <table class="table table-striped table-bordered" id="myTable">
            <thead>
                <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 15%;">Aksi</th>
                    <th>User</th>
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
                </tr>
            </thead>


            <tbody></tbody>
        </table>
    </div>

</div>
<div class="modal fade" id="modalfilter" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Filter Datatable</h5>
            </div>
            <div class="modal-body text-center">
                <form id="formFilterQC">
                    <div class="form-group text-left">
                        <label>Status Aksi QC</label>
                        <select class="form-control" id="filter_qc">
                            <option value="">-- Semua --</option>
                            <option value="1">Sudah QC (1)</option>
                            <option value="2">Draft QC (2)</option>
                            <option value="0">Belum QC (0)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">
                        Terapkan Filter
                    </button>
                    <button type="button" class="btn btn-secondary mt-2" id="resetFilter">
                        Reset Filter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-xl" id="modalGambar" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Preview Gambar</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center">
                <img id="viewImageTag" src="" class="img-fluid" alt="Source Image">
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="isiModalSedang">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Data Jobdesk</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formUpdateJobdesk">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>PPPH</label>
                                <input type="text" name="ppph" id="edit-ppph" class="form-group form-control">
                            </div>
                            <div class="form-group">
                                <label>NIB</label>
                                <input type="text" name="nib" id="edit-nib" class="form-group form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama PU</label>
                                <input type="text" name="namaPU" id="edit-namaPU" class="form-group form-control">
                            </div>
                            <div class="form-group">
                                <label>Produk 1</label>
                                <input type="text" name="produk1" id="edit-produk1" class="form-group form-control">
                            </div>
                            <div class="form-group">
                                <label>Produk 2</label>
                                <input type="text" name="produk2" id="edit-produk2" class="form-group form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpanUpdate">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
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


<?php $this->load->view('template/scriptes.php') ?>
<script>
    $(document).ready(function() {
        $('#myTable').on('click', '.btn-print', function() {
            var id = $(this).data('id');
            window.open("<?= base_url('Laporan/print/'); ?>" + id, '_blank');
        });

        $('#btn-filter').on('click', function(e) {
            e.preventDefault();
            $('#modalfilter').modal('show');
        });
        $('input[type="text"]').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Jika Anda ingin mengecualikan email (email biasanya lowercase)
        $('input[type="email"]').on('input', function() {
            this.value = this.value.toLowerCase();
        });
        // 1. Inisialisasi DataTable
        var tableTransaksi; // Gunakan satu nama variabel yang konsisten



        $('#myTable').on('click', '.btn-detail', function() {
            var dataid = $(this).data('id');

        })

        var qcFilter = '';
        $('#formFilterQC').on('submit', function(e) {
            e.preventDefault();

            qcFilter = $('#filter_qc').val(); // ambil nilai 1 / 2 / 0 / ''

            tableTransaksi.ajax.reload(null, true); // reload + reset pagination
            $('#modalfilter').modal('hide');
        });

        $('#resetFilter').on('click', function() {
            // PERBAIKAN: Set ke string kosong agar memunculkan 'Semua'
            qcFilter = '';
            $('#filter_qc').val('');
            tableTransaksi.ajax.reload(null, true);
            $('#modalfilter').modal('hide');
        });



        var tableTransaksi = $('#myTable').DataTable({

            "scrollX": true,
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ajax": {
                "url": "<?= base_url('Laporan/view_all_jobdesk'); ?>",
                "type": "POST",
                "data": function(d) {
                    d.qc_status = qcFilter; // kirim ke controller
                    d.keyword = $('#keyword').val(); // kirim keyword ke server
                }
            },
            "columns": [{
                    data: 'id',
                    sortable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: "id",
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {

                        let disabled = (row.qc == 1) ? 'disabled' : '';

                        return `
            <button class="btn btn-sm btn-info btn-detail"
                data-id="${data}">
                <i class="fas fa-eye"></i> Detail
            </button>
        
            <button class="btn btn-sm btn-warning btn-update"
                data-id="${data}">
                <i class="fas fa-edit"></i> Update Entry Staff
            </button>
        
            <button class="btn btn-sm btn-danger btn-delete"
                data-id="${data}"
                data-nib="${row.nib}">
                <i class="fas fa-trash"></i> Delete Data
            </button>
        
            <button class="btn btn-sm btn-success update-qc"
                data-id="${data}" >
                <i class="fas fa-check"></i> Check QC
            </button>
        `;
                    }
                },
                {
                    data: "user_name"
                }, {
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
            ]
        });

        let typingTimer;
        $('#keyword').on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function() {
                tableTransaksi.ajax.reload();
            }, 400); // 400ms setelah berhenti ngetik
        });

        $('#keyword').on('keypress', function(e) {
            if (e.which === 13) {
                tableTransaksi.ajax.reload();
            }
        });


        $('#myTable').on('click', '.update-qc', function(e) {
            e.preventDefault();

            // Jika tombol sudah disabled, hentikan
            if ($(this).is(':disabled')) return;

            let id = $(this).data('id');

            Swal.fire({
                title: 'Konfirmasi QC',
                text: 'Apakah Anda yakin ingin MENYETUJUI QC job ini?',
                icon: 'question',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check-circle"></i> Submit QC',
                denyButtonText: '<i class="fas fa-file-alt"></i> Draft QC',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28a745', // Hijau untuk Submit
                denyButtonColor: '#ffc107', // Kuning/Warning untuk Draft
                cancelButtonColor: '#6c757d' // Abu-abu untuk Batal
            }).then((result) => {

                if (result.isConfirmed) {
                    // 1. Aksi untuk SUBMIT QC (Kirim status 1)
                    prosesStatusQC(id, 1, 'Submit QC');

                } else if (result.isDenied) {
                    // 2. Aksi untuk DRAFT QC (Kirim status 2 atau sesuaikan dengan database)
                    // Ubah angka "2" di bawah sesuai dengan kode status "Draft" di backend Anda
                    prosesStatusQC(id, 2, 'Draft QC');
                }
                // 3. Jika Batal, SweetAlert otomatis tertutup tanpa aksi tambahan
            });
        });

        // Fungsi terpisah untuk memproses AJAX agar kode tidak berulang (DRY)
        function prosesStatusQC(id, status_qc, namaAksi) {
            Swal.fire({
                title: 'Memproses...',
                text: 'Mohon tunggu sebentar.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "<?= base_url('Laporan/update_qc_status'); ?>",
                type: "POST",
                data: {
                    id: id,
                    qc_status: status_qc
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: namaAksi + ' berhasil disetujui',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Reload tabel tanpa reset halaman
                        tableTransaksi.ajax.reload(null, false);
                    } else {
                        Swal.fire('Gagal', 'Gagal update status QC', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                }
            });
        }

        $('#myTable').on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            $('#isiModalSedang').html('');
            Swal.fire({
                icon: 'info',
                title: 'Pemberitahuan',
                text: 'Sedang memuat form Delete data...',
                showConfirmButton: false
            });


            $.ajax({
                url: "<?= base_url('Dashboard/addJobdesk/delete'); ?>",
                method: "POST",
                data: {
                    id: id,
                    'action': 'delete'

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
        // --- EVENT LISTENER UNTUK MODAL ---

        // 1. Modal Detail
        $('#myTable').on('click', '.btn-detail', function() {
            var id = $(this).data('id');

            $.ajax({
                url: "<?= base_url('Laporan/get_detail_jobdesk'); ?>",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    // Isi data ke dalam elemen modal
                    $('#detail-ppph').text(data.ppph);
                    $('#detail-nib').text(data.nib);
                    $('#detail-namaPU').text(data.namaPU);
                    $('#detail-produk1').text(data.produk1);
                    $('#detail-produk2').text(data.produk2);

                    // Untuk gambar
                    var imgSrc = "<?= base_url('assets/uploads/'); ?>" + data.source_image;
                    $('#detail-img').attr('src', imgSrc);

                    // Tampilkan modal
                    $('#modalDetail').modal('show');
                },
                error: function() {
                    alert('Gagal mengambil data');
                }
            });
        });

        // 2. Modal Lihat Gambar
        $('#myTable').on('click', '.row-img', function() {
            var imgName = $(this).data('img');
            var fullPath = "<?= base_url('assets/uploads/'); ?>" + imgName;

            $('#viewImageTag').attr('src', fullPath);
            $('#modalGambar').modal('show');
        });

        // 3. Konfirmasi Hapus (SweetAlert2 atau Modal)
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




        // 2. Proses Simpan Update
        $('#formUpdateJobdesk').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('Laporan/proses_update_jobdesk'); ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "JSON",
                success: function(response) {
                    if (response.success) {
                        alert('Data berhasil diperbarui!');
                        $('#modalUpdate').modal('hide');
                        tableTransaksi.ajax.reload(); // Refresh tabel otomatis
                    } else {
                        alert('Gagal memperbarui data.');
                    }
                }
            });
        });


        $('#btn-export').on('click', function() {

            let url = "<?= base_url('Laporan/export_jobdesk_xls'); ?>";

            if (qcFilter !== '') {
                url += "?qc=" + qcFilter;
            }

            window.location.href = url;
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