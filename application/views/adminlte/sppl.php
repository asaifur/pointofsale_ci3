<div class="card">
    <div class="card-header">
        <h4> Table <?= $title ?></h4>
        <button type="button" class="btn btn-block bg-gradient-primary btn-sm" id="btn-tambah">Tambah Data</button>
    </div>
    <div class="card-body">

        <table class="table table-striped table-bordered" id="myTable">
            <thead>
                <tr>
                    <th> No. </th>
                    <th> No SPPL </th>
                    <th> Nama Pelaku Usaha</th>
                    <th> No Telepon</th>
                    <th> Date Created</th>
                    <th> Aksi </th>
                </tr>
            </thead>


            <tbody></tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Input Data SPPL Database</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="form-tambah-sppl" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nama Pelaku Usaha (namaPU)</label>
                            <input type="text" name="namaPU" class="form-control" placeholder="NAMA PU" required>

                            <label class="mt-2">No. Telepon</label>
                            <input type="text" name="noTelepon" class="form-control" placeholder="NO TELEPON">

                            <label class="mt-2">No. NIB</label>
                            <input type="text" name="noNIB" class="form-control" placeholder="Dalam Proses / Nomor NIB">

                            <label class="mt-2">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="EMAIL@email.com">
                        </div>
                        <div class="col-md-6">
                            <label>Nomor NKU</label>
                            <input type="text" name="nomorNKU" class="form-control" placeholder="202601-...">

                            <label class="mt-2">Kode KBLI</label>
                            <input type="text" name="kode_kbli" class="form-control" placeholder="47112">

                            <label class="mt-2">Judul KBLI</label>
                            <input type="text" name="judul_kbli" class="form-control" placeholder="Industri Kerupuk...">

                            <label class="mt-2">Kota</label>
                            <input type="text" name="kota" class="form-control" placeholder="Kota Garut">
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Source TTD</label>
                            <input type="file" name="source_ttd" class="form-control" placeholder="Nama Penandatangan">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Simpan Ke Database</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Optional JavaScript -->

<?php $this->load->view('template/scriptes.php') ?>
<script>
    $(document).ready(function() {

        // Mengubah input menjadi uppercase saat user mengetik
        $('input[type="text"]').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Jika Anda ingin mengecualikan email (email biasanya lowercase)
        $('input[type="email"]').on('input', function() {
            this.value = this.value.toLowerCase();
        });
        // 1. Inisialisasi DataTable
        var tableTransaksi; // Gunakan satu nama variabel yang konsisten

        $(document).ready(function() {
            tableTransaksi = $('#myTable').DataTable({
                "scrollX": true,
                "processing": true,
                "autoWidth": false,
                "serverSide": true,
                "order": [],

                "ajax": {
                    "url": "<?= base_url('Dashboard/view_sppl_json'); ?>",
                    "type": "POST",
                    "data": function(data) {
                        // Anda bisa menambahkan parameter custom di sini jika perlu
                    }
                },
                "columns": [{
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    }, // Pastikan kurung kurawal penutup ada di sini
                    {
                        "data": "no_sppl"
                    },
                    {
                        "data": "namaPU"
                    },
                    {
                        "data": "noTelepon"
                    },
                    {
                        "data": "created_date"
                    },
                    {
                        "data": "aksi",
                        "orderable": false,
                        "searchable": false
                    }
                ]
            }); // Penutup DataTable
        });
        // 2. Fungsi Tambah Data (Submit AJAX)
        $('#form-tambah-sppl').on('submit', function(e) {
            e.preventDefault();

            // 1. Validasi Ukuran File di Sisi Client (Opsional tapi disarankan)
            var fileInput = $('input[name="source_ttd"]')[0];
            if (fileInput.files.length > 0) {
                var fileSize = fileInput.files[0].size / 1024; // KB
                if (fileSize > 200) {
                    alert('Gagal: Ukuran file maksimal 200 KB. File Anda: ' + Math.round(fileSize) + ' KB');
                    return false;
                }
            }

            var formData = new FormData(this);

            $.ajax({
                url: "<?php echo base_url('Dashboard/simpan_sppl'); ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    if (data.status == 'success') {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message); // Akan muncul alert jika > 200KB atau error lainnya
                    }
                },
                error: function() {
                    alert("Terjadi kesalahan sistem.");
                }
            });
        });
        // 3. Fungsi Delete (AJAX)
        $('#myTable').on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            if (confirm("Hapus data SPPL ini?")) {
                $.ajax({
                    url: "<?= base_url('Dashboard/delete_sppl'); ?>",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function() {
                        tableSppl.ajax.reload(null, false);
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {

        // 1. Tombol Delete (Perbaikan penutup kurung kurawal)
        $('#myTable').on('click', '.btn-delete', function() {
            var id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini? File TTD juga akan dihapus permanen.')) {
                $.ajax({
                    url: "<?= base_url('Dashboard/delete_sppl/'); ?>" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(response) {
                        if (response.status == 'success') {
                            alert(response.message);
                            tableTransaksi.ajax.reload(null, false);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat menghapus data.');
                    }
                });
            }
        }); // <-- Penutup click handler yang sebelumnya hilang

        // 2. Tampilkan Modal
        $('#btn-tambah').on('click', function() {
            $('#form-tambah-sppl')[0].reset();
            $('#modal-tambah').modal('show');
        });

        // 3. Hanya Angka
        $('#telp_sppl').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // 4. Proses Submit AJAX (Perbaikan Utama: Gunakan FormData)
        $('#form-tambah-sppl').on('submit', function(e) {
            e.preventDefault();

            var btn = $('#btn-save-sppl');
            // WAJIB menggunakan FormData untuk mengirim FILE/GAMBAR
            var formData = new FormData(this);

            $.ajax({
                url: "<?= base_url('Dashboard/simpan_sppl'); ?>",
                type: "POST",
                data: formData, // Gunakan variabel formData
                contentType: false, // WAJIB false jika pakai FormData
                processData: false, // WAJIB false jika pakai FormData
                beforeSend: function() {
                    btn.attr('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
                },
                success: function(response) {
                    // Tambahkan pengecekan jika response sudah objek atau masih string
                    var res = (typeof response === 'object') ? response : JSON.parse(response);

                    if (res.status == 'success') {
                        $('#modal-tambah').modal('hide');
                        alert(res.message);
                        if (typeof tableTransaksi !== 'undefined') tableTransaksi.ajax.reload(null, false);
                    } else {
                        alert(res.message);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert("Koneksi server terputus atau terjadi kesalahan sistem.");
                },
                complete: function() {
                    btn.attr('disabled', false).html('<i class="fas fa-save mr-1"></i> Simpan Data SPPL');
                }
            });
        });
        $('#myTable').on('click', '.btn-print', function() {
            var id = $(this).data('id');
            // Membuka PDF di tab baru
            window.open("<?= base_url('Dashboard/print_sppl/'); ?>" + id, '_blank');
        });
    });
</script>