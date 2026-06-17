<?php
$user = $this->session->userdata();

?>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<div class="row">
    <div class="col-md-12">
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <?php $total_jobdesk = $this->Halal_model->getCountJobdesk();
                                ?>
                                <h3><?= $total_jobdesk ?></h3>

                                <p>Jobdesk</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-chart-pie mr-1"></i>Daftar Pemilik Usaha</h3>

            </div>
            <div class="card-body">

                <div id="myfirstchart" style="height: 250px;"></div>
            </div>
            <div class="card-header">
                <h3 class="card-title"> <i class="fas fa-chart-pie mr-1"></i> Approve Jobdesk</h3>

            </div>
            <div class="card-body">
                <div id="myfirstchart2" style="height: 250px;"></div>
            </div>

            <?php if ($user['role'] == "3") { ?>
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Fee Bulanan Staff (Semua Karyawan)</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" id="daterange_gaji" class="form-control" placeholder="Pilih Rentang Tanggal">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button id="btnFilterBulan" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                        <br>
                        <div id="table_gaji_container" style="min-height: 250px;"></div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Fee Bulanan Staff</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" id="daterange_gaji_karyawan" class="form-control" placeholder="Pilih Rentang Tanggal">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button id="btnFilterBulan_karyawan" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                        <br>
                        <div id="table_gaji_karyawan" style="min-height: 250px;"></div>
                    </div>
                </div>
            <?php }; ?>
        </div>
    </div>
</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/moment/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script src="https://cdn.jsdelivr.net/gh/rainabba/jquery-table2excel@1.1.1/dist/jquery.table2excel.min.js"></script>
<script>
    $(document).ready(function() {
        $("#btn-export").click(function() {
            $("#tabel-gaji").table2excel({
                exclude: ".noExl", // Jika ada kolom yang tidak ingin diikutkan, beri class ini
                name: "Data Gaji Staff",
                filename: "Laporan_Gaji_Staff_" + new Date().getTime() + ".xls",
                fileext: ".xls",
                preserveColors: true
            });
        });
    });
</script>

<script>
    $(document).ready(function() {

        let startDateKaryawan = '';
        let endDateKaryawan = '';

        // 1. Inisialisasi Daterangepicker untuk Karyawan
        $('#daterange_gaji_karyawan').daterangepicker({
            opens: 'right',
            autoUpdateInput: false, // Biarkan kosong sebelum dipilih
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });

        // Menangkap tanggal saat user selesai memilih
        $('#daterange_gaji_karyawan').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            startDateKaryawan = picker.startDate.format('YYYY-MM-DD');
            endDateKaryawan = picker.endDate.format('YYYY-MM-DD');
        });

        // Membersihkan input jika diklik clear
        $('#daterange_gaji_karyawan').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            startDateKaryawan = '';
            endDateKaryawan = '';
        });

        // 2. Aksi tombol filter
        $('#btnFilterBulan_karyawan').click(function() {
            if (startDateKaryawan === '' || endDateKaryawan === '') {
                alert('Pilih rentang tanggal terlebih dahulu!');
                return;
            }

            loadTableGajikaryawan(startDateKaryawan, endDateKaryawan);
        });

    });

    // 3. Update fungsi AJAX untuk mengirim parameter start dan end
    function loadTableGajikaryawan(start = '', end = '') {
        // Tampilkan loading (opsional tapi disarankan)
        $('#table_gaji_karyawan').html('<p class="text-center text-muted">Memuat data...</p>');

        $.ajax({
            url: "<?= base_url('dashboard/gajiTablekaryawan/'); ?>",
            method: "GET",
            data: {
                start_date: start, // Mengirim data start_date
                end_date: end // Mengirim data end_date
            },
            success: function(response) {
                $('#table_gaji_karyawan').html(response);
            },
            error: function() {
                $('#table_gaji_karyawan').html('<p class="text-center text-danger">Gagal memuat data</p>');
            }
        });
    }
</script>
<script>
    $(function() {
        $.ajax({
            url: "<?= base_url('dashboard/chartJobdesk'); ?>",
            method: "GET",
            dataType: "json",
            success: function(data) {

                // Cek jika data kosong
                if (data.length === 0) {
                    $('#myfirstchart').html(
                        '<p class="text-center">Data belum tersedia</p>'
                    );
                    return;
                }

                // Render chart jika ada data
                new Morris.Line({
                    element: 'myfirstchart',
                    data: data,
                    xkey: 'tanggal',
                    ykeys: ['total'],
                    labels: ['Jumlah Jobdesk'],
                    lineWidth: 2,
                    parseTime: false,
                    resize: true
                });

            },
            error: function() {
                $('#myfirstchart').html(
                    '<p class="text-danger text-center">Gagal mengambil data</p>'
                );
            }
        });
    });
</script>

<script>
    $('#dashboard_gaji').load("<?= base_url("dashboard/gaji_bulanan") ?>");
    $(function() {
        $.ajax({
            url: "<?= base_url('dashboard/chartPemilikUsahaBulanIni'); ?>",
            method: "GET",
            dataType: "json",
            success: function(data) {

                if (data.length === 0) {
                    $('#myfirstchart2').html(
                        '<p class="text-center">Belum ada pendaftar bulan ini</p>'
                    );
                    return;
                }

                new Morris.Line({
                    element: 'myfirstchart',
                    data: data,
                    xkey: 'tanggal',
                    ykeys: ['total'],
                    labels: ['Jumlah Pendaftar'],
                    lineWidth: 2,
                    parseTime: false,
                    resize: true,
                    lineColors: ['#17a2b8']
                });
            },
            error: function() {
                $('#myfirstchart2').html(
                    '<p class="text-danger text-center">Gagal mengambil data</p>'
                );
            }
        });
    });
</script>
<script>
    $(document).ready(function() {


        let startDate = '';
        let endDate = '';

        // Buka modal saat klik filter
        $('#btnFilterGaji').click(function() {
            $('#modalFilterGaji').modal('show');
        });

        // Init daterange
        $('#daterange_gaji').daterangepicker({
            opens: 'left',
            locale: {
                format: 'YYYY-MM-DD'
            }
        }, function(start, end) {
            startDate = start.format('YYYY-MM-DD');
            endDate = end.format('YYYY-MM-DD');
        });

        // Klik Terapkan

        $(document).ready(function() {

            $('#btnFilterBulan').click(function() {

                let bulan = $('#filter_bulan').val();

                if (bulan === '') {
                    alert('Pilih bulan dulu');
                    return;
                }

                loadTableGaji(bulan);

            });

        });



        $(document).ready(function() {

            $('#btnFilterBulan_karyawan').click(function() {

                let bulan = $('#filter_bulan_karyawan').val();

                if (bulan === '') {
                    alert('Pilih bulan dulu');
                    return;
                }

                loadTableGajikaryawan(bulan);

            });

        });


        function loadTableGajikaryawan(bulan = '') {

            $.ajax({
                url: "<?= base_url('dashboard/gajiTablekaryawan/'); ?>",
                method: "GET",
                data: {
                    bulan: bulan
                },
                success: function(response) {
                    $('#table_gaji_karyawan').html(response);
                }
            });

        }


    });
</script>

<script>
    $(document).ready(function() {

        let startDateAll = '';
        let endDateAll = '';

        // 1. Inisialisasi Daterangepicker untuk Semua Karyawan
        $('#daterange_gaji').daterangepicker({
            opens: 'right',
            autoUpdateInput: false,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            }
        });

        // Menangkap tanggal saat user klik 'Apply'
        $('#daterange_gaji').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            startDateAll = picker.startDate.format('YYYY-MM-DD');
            endDateAll = picker.endDate.format('YYYY-MM-DD');
        });

        // Membersihkan input jika klik 'Clear'
        $('#daterange_gaji').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            startDateAll = '';
            endDateAll = '';
        });

        // 2. Aksi tombol filter
        $('#btnFilterBulan').click(function() {
            if (startDateAll === '' || endDateAll === '') {
                alert('Pilih rentang tanggal terlebih dahulu!');
                return;
            }

            loadTableGaji(startDateAll, endDateAll);
        });

    });

    // 3. Update fungsi AJAX
    function loadTableGaji(start = '', end = '') {
        $('#table_gaji_container').html('<p class="text-center text-muted">Memuat data...</p>');

        $.ajax({
            url: "<?= base_url('dashboard/gajiTable'); ?>",
            method: "GET",
            data: {
                start_date: start,
                end_date: end
            },
            success: function(response) {
                $('#table_gaji_container').html(response);
            },
            error: function() {
                $('#table_gaji_container').html('<p class="text-center text-danger">Gagal memuat data</p>');
            }
        });
    }
</script>

<?php $this->load->view('template/scriptes.php') ?>