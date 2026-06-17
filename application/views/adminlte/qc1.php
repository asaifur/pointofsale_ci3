<div class="row">
    <div class="col-md-12">
        <div class="card card-info card-outline">
            <div class="card-header">
                <button type="button" id="btn-filter" class="btn btn-default bg-maroon ">
                    Filter
                </button>
            </div>

            <div class="card-body">

                <table class="table table-striped table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th> No. </th>
                            <th> Status Pengajuan</th>
                            <th> Email P3H</th>
                            <th> Nama PU </th>
                            <th> No Telepon </th>
                            <th> Alamat PU </th>
                            <th> NIK </th>
                            <th> Email OSS </th>
                            <th> pass OSS </th>
                            <th> Tempat Usaha / Outlet</th>
                            <th> Provinsi</th>
                            <th> Kab / Kota</th>
                            <th> Desa</th>
                            <th> Kec</th>
                            <th> Kode Pos</th>
                            <th> Source Foto KTP</th>
                            <th> Nama Produk 1</th>
                            <th> Source Foto Produk 1 </th>
                            <th> Source Foto Verval Produk 1</th>
                            <th> Video Produk 1</th>
                            <th> Nama Produk 2</th>
                            <th> Source Foto Produk 2 </th>
                            <th> Source Foto Verval Produk 2</th>
                            <th> Video Produk 2</th>
                            <th> Nama Produk 3</th>
                            <th> Source Foto Produk 3 </th>
                            <th> Source Foto Verval Produk 3</th>
                            <th> Video Produk 3</th>
                            <th> Nama Produk 4</th>
                            <th> Source Foto Produk 4 </th>
                            <th> Source Foto Verval Produk 4</th>
                            <th> Video Produk 4</th>
                            <th> Nama Produk 5</th>
                            <th> Source Foto Produk 5 </th>
                            <th> Source Foto Verval Produk 5</th>
                            <th> Video Produk 5</th>
                            <th> Nama Produk 6</th>
                            <th> Source Foto Produk 6 </th>
                            <th> Source Foto Verval Produk 6</th>
                            <th> Video Produk 6</th>
                            <th> Nama Produk 7</th>
                            <th> Source Foto Produk 7 </th>
                            <th> Source Foto Verval Produk 7</th>
                            <th> Video Produk 7</th>
                            <th> Aksi / Revisian</th>
                        </tr>
                    </thead>


                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-content" id="modalAction">
                <!-- AJAX CONTENT -->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalVideo" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Video Produk</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body text-center">

                <video id="videoPlayer" width="100%" controls>
                    <source src="" type="video/mp4">
                    Browser Anda tidak mendukung video.
                </video>

                <br><br>

                <!-- Tombol Download -->
                <a id="btnDownloadVideo" href="#"
                    class="btn btn-success"
                    download>
                    <i class="fa fa-download"></i> Download Video
                </a>

            </div>
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

<div class="modal fade" id="modalFilter" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-maroon">
                <h5 class="modal-title text-white">Filter Data Quality Control Foto</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <form id="formFilter">

                    <div class="form-group">
                        <label>Tanggal Range</label>
                        <input type="text"
                            id="filter_tanggal_range"
                            class="form-control"
                            placeholder="Pilih rentang tanggal">
                    </div>
                    <div class="form-group">
                        <label>Status QC</label>
                        <select id="filter_status" name="status" class="form-control">
                            <option value="">-- Semua Status --</option>
                            <option value="0">Belum QC</option>
                            <option value="1">Sudah QC</option>
                        </select>
                    </div>

                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" id="btnApplyFilter" class="btn bg-maroon text-white">
                    Terapkan Filter
                </button>
            </div>

        </div>
    </div>
</div>


<?php $this->load->view('template/scriptes.php') ?>

<script>
    $(document).ready(function() {

        $('#filter_tanggal_range').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });

        $('#filter_tanggal_range').on('apply.daterangepicker', function(ev, picker) {

            $(this).val(
                picker.startDate.format('YYYY-MM-DD') +
                ' - ' +
                picker.endDate.format('YYYY-MM-DD')
            );

        });

        $('#filter_tanggal_range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });


        $('#btnApplyFilter').on('click', function() {

            tableTransaksi.ajax.reload(null, false);
            $('#modalFilter').modal('hide');

        });

        $('#btnResetFilter').on('click', function() {

            $('#formFilter')[0].reset();

            tableTransaksi.ajax.reload(null, false);

        });
        $('#btn-filter').on('click', function() {
            $('#modalFilter').modal('show');
        });


        $(document).ready(function() {
            tableTransaksi = $('#myTable').DataTable({
                "scrollX": true,
                "processing": true,
                "autoWidth": false,
                "serverSide": true,
                "order": [],

                ajax: {
                    url: "<?= base_url('Dashboard/view_daftar_qc_foto'); ?>",
                    type: "POST",
                    data: function(d) {

                        let range = $('#filter_tanggal_range').val();

                        if (range != '') {

                            let dates = range.split(' - ');
                            d.tgl_dari = dates[0];
                            d.tgl_sampai = dates[1];

                        } else {

                            d.tgl_dari = '';
                            d.tgl_sampai = '';

                        }

                        d.status = $('#filter_status').val();
                    }
                },

                "columns": [{
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        "data": "keterangan_status"
                    },
                    {
                        "data": "namaUser"
                    },
                    {
                        "data": "namaPU"
                    },
                    {
                        "data": "noHP"
                    },
                    {
                        "data": "alamat"
                    },
                    {
                        "data": "nik"
                    },
                    {
                        "data": "email"
                    },
                    {
                        "data": "pass"
                    },
                    {
                        "data": "tempatUsahaName"
                    },
                    {
                        "data": "provinsi_nama"
                    },
                    {
                        "data": "kabupaten_nama"
                    },
                    {
                        "data": "kelurahan_nama"
                    },
                    {
                        "data": "kecamatan_nama"
                    },
                    {
                        "data": "kodepos"
                    },
                    {
                        "data": "fotoKtp",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-info btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat KTP
            </button>
        `;
                        }
                    },
                    {
                        "data": "nameProduk1"
                    },
                    {
                        "data": "fotoProduk1",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
                            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
            </button>
        `;
                        }
                    },
                    {
                        "data": "vervalProduk1",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
            </button>
            `;
                        }
                    },
                    {
                        "data": "videoProduk1",
                        "render": function(data) {

                            if (!data) {
                                return '-';
                            }

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-video"
                data-video="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-play"></i> Lihat Video
                </button>
                `;
                        }
                    },
                    {
                        "data": "nameProduk2"
                    },
                    {
                        "data": "fotoProduk2",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
            </button>
        `;
                        }
                    },
                    {
                        "data": "vervalProduk2",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
            </button>
            `;
                        }
                    },
                    {
                        "data": "videoProduk2",
                        "render": function(data) {

                            if (!data) {
                                return '-';
                            }

                            return `
                            <button class="btn btn-sm btn-primary btn-lihat-video"
                            data-video="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-play"></i> Lihat Video
            </button>
        `;
                        }
                    },
                    {
                        "data": "nameProduk3"
                    },
                    {
                        "data": "fotoProduk3",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
                </button>
                `;
                        }
                    },
                    {
                        "data": "vervalProduk3",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
                            <button class="btn btn-sm btn-primary btn-lihat-foto"
                            data-foto="<?= base_url('assets/uploads/') ?>${data}">
                            <i class="fa fa-eye"></i> Lihat Produk
                            </button>
                            `;
                        }
                    },
                    {
                        "data": "videoProduk3",
                        "render": function(data) {

                            if (!data) {
                                return '-';
                            }

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-video"
                data-video="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-play"></i> Lihat Video
            </button>
        `;
                        }
                    },
                    {
                        "data": "nameProduk4"
                    },
                    {
                        "data": "fotoProduk4",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
                </button>
        `;
                        }
                    },
                    {
                        "data": "vervalProduk4",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
            </button>
        `;
                        }
                    },
                    {
                        "data": "videoProduk4",
                        "render": function(data) {

                            if (!data) {
                                return '-';
                            }

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-video"
            data-video="<?= base_url('assets/uploads/') ?>${data}">
            <i class="fa fa-play"></i> Lihat Video
            </button>
            `;
                        }
                    },

                    {
                        "data": "nameProduk5"
                    },
                    {
                        "data": "fotoProduk5",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
            </button>
        `;
                        }
                    },
                    {
                        "data": "vervalProduk5",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
            </button>
        `;
                        }
                    },
                    {
                        "data": "videoProduk5",
                        "render": function(data) {

                            if (!data) {
                                return '-';
                            }

                            return `
                            <button class="btn btn-sm btn-primary btn-lihat-video"
                data-video="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-play"></i> Lihat Video
            </button>
            `;
                        }
                    },
                    {
                        "data": "nameProduk6"
                    },
                    {
                        "data": "fotoProduk6",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
            </button>
        `;
                        }
                    },
                    {
                        "data": "vervalProduk6",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
            </button>
        `;
                        }
                    },
                    {
                        "data": "videoProduk6",
                        "render": function(data) {

                            if (!data) {
                                return '-';
                            }

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-video"
                data-video="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-play"></i> Lihat Video
            </button>
        `;
                        }
                    },

                    {
                        "data": "nameProduk7"
                    },
                    {
                        "data": "fotoProduk7",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
            </button>
        `;
                        }
                    },
                    {
                        "data": "vervalProduk7",
                        "render": function(data) {

                            if (!data) return '-';

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-foto"
                data-foto="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-eye"></i> Lihat Produk
            </button>
        `;
                        }
                    },
                    {
                        "data": "videoProduk7",
                        "render": function(data) {

                            if (!data) {
                                return '-';
                            }

                            return `
            <button class="btn btn-sm btn-primary btn-lihat-video"
                data-video="<?= base_url('assets/uploads/') ?>${data}">
                <i class="fa fa-play"></i> Lihat Video
            </button>
        `;
                        }
                    },




                    {
                        "data": "aksi",
                        "orderable": false,
                        "searchable": false
                    }
                ]
            });
        });

    });
</script>

<script>
    $(document).on('click', '.btn-lihat-video', function() {

        let videoUrl = $(this).data('video');

        $('#videoPlayer source').attr('src', videoUrl);
        $('#videoPlayer')[0].load();

        // set link download
        $('#btnDownloadVideo').attr('href', videoUrl);

        $('#modalVideo').modal('show');
    });

    // Stop video & reset saat modal ditutup
    $('#modalVideo').on('hidden.bs.modal', function() {

        $('#videoPlayer')[0].pause();
        $('#videoPlayer source').attr('src', '');
        $('#btnDownloadVideo').attr('href', '#');

    });

    $(document).on('click', '.btn-lihat-foto', function() {

        let fotoUrl = $(this).data('foto');

        $('#previewFoto').attr('src', fotoUrl);

        // set link download
        $('#btnDownloadFoto').attr('href', fotoUrl);

        $('#modalFoto').modal('show');
    });

    // Reset saat modal ditutup
    $('#modalFoto').on('hidden.bs.modal', function() {

        $('#previewFoto').attr('src', '');
        $('#btnDownloadFoto').attr('href', '#');

    });


    $('#myTable').on('click', '.btn-view', function(e) {
        e.preventDefault();
        let id = $(this).data('id');

        $.ajax({
            url: "<?= base_url('Dashboard/form_update_qc/view'); ?>",
            type: "POST",
            data: {
                id: id
            },
            beforeSend: function() {
                $('#modalAction').html(`
                <div class="modal-body text-center p-5">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                    <p>Loading...</p>
                </div>
            `);
                $('#modal-xl').modal('show');
            },
            success: function(response) {
                $('#modalAction').html(response);
            },
            error: function() {
                alert('Gagal memuat form');
            }
        });

    });
    $('#myTable').on('click', '.btn-update', function(e) {
        e.preventDefault();
        let id = $(this).data('id');

        $.ajax({
            url: "<?= base_url('Dashboard/form_update_qc/update'); ?>",
            type: "POST",
            data: {
                id: id
            },
            beforeSend: function() {
                $('#modalAction').html(`
                <div class="modal-body text-center p-5">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                    <p>Loading...</p>
                </div>
            `);
                $('#modal-xl').modal('show');
            },
            success: function(response) {
                $('#modalAction').html(response);
            },
            error: function() {
                alert('Gagal memuat form');
            }
        });
    });

    $('#myTable').on('click', '.update-qc', function(e) {
        e.preventDefault();

        // Jika tombol sudah disabled, hentikan
        let id = $(this).data('id');
        $.ajax({
            url: "<?= base_url('Dashboard/form_update_qc/update_qc_foto'); ?>",
            type: "POST",
            data: {
                id: id
            },
            beforeSend: function() {
                $('#modalAction').html(`
                <div class="modal-body text-center p-5">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                    <p>Loading...</p>
                </div>
            `);
                $('#modal-xl').modal('show');
            },
            success: function(response) {
                $('#modalAction').html(response);
            },
            error: function() {
                alert('Gagal memuat form');
            }
        });
    });
</script>