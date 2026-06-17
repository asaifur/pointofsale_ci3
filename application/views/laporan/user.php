<div class="card">
    <div class="card-header">
        <h4> Table <?= $title ?></h4>
    </div>
    <div class="card-body">

        <table class="table table-striped table-bordered" id="myTable">
            <thead>
                <tr>
                    <th> No. </th>
                    <th> Nama User </th>
                    <th> NIK</th>
                    <th> Email</th>
                    <th> No Telepon</th>
                    <th> Aksi </th>
                    <th> Kirim Email</th>
                </tr>
            </thead>


            <tbody></tbody>
        </table>
    </div>
</div>


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

        tableTransaksi = $('#myTable').DataTable({
            "scrollX": true,
            "processing": true,
            "autoWidth": false,
            "serverSide": true,
            "order": [],
            // 🔹 Pagination & limit data
            "paging": true,
            "pageLength": 10, // tampil 10 data per halaman
            "lengthChange": false, // sembunyikan dropdown jumlah data
            "searching": true,
            "info": true,

            "ajax": {
                "url": "<?= base_url('Laporan/view_all_user'); ?>",
                "type": "POST",
                "data": function(data) {
                    // Anda bisa menambahkan parameter custom di sini jika perlu
                }
            },
            "columns": [{
                    "data": "id_users",
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                }, // Pastikan kurung kurawal penutup ada di sini
                {
                    "data": "username"
                },
                {
                    "data": "nik"
                },
                {
                    "data": "email"
                },
                {
                    "data": "noTelepon"
                },
                {
                    "data": "id_users",
                    "orderable": false,
                    "searchable": false,
                    "render": function(data, type, row) {

                        return `
                <button 
                    class="btn btn-sm btn-primary btn-print"
                    data-id="${data}">
                    <i class="fa fa-print"></i> Print
                </button>
            `;
                    }
                },
                {
                    data: 'check_pkwt',
                    orderable: false,
                    searchable: false
                }

            ]
        }); // Penutup DataTable

        $('#myTable').on('click', '.btn-print', function() {
            var id = $(this).data('id');
            window.open("<?= base_url('Laporan/print/'); ?>" + id, '_blank');
        });

        $('#myTable').on('click', '.btn-send-email', function(e) {

            let checkbox = $(this);
            let id = checkbox.data('id');

            // Cegah langsung ter-check
            e.preventDefault();

            Swal.fire({
                title: 'Kirim PKWT?',
                text: 'PKWT akan ditandai terkirim dan tidak bisa diubah kembali.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Kirim',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#dc3545'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "<?= base_url('Laporan/update_check_pkwt'); ?>",
                        type: "POST",
                        data: {
                            id: id,
                            check_pkwt: 1
                        },
                        dataType: "json",
                        success: function(res) {
                            $('#myTable').DataTable().ajax.reload();
                            if (res.status) {
                                checkbox
                                    .prop('checked', true)
                                    .prop('disabled', true);

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'PKWT berhasil dikirim & dikunci',
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                            } else {
                                Swal.fire('Gagal', res.message ?? 'Tidak bisa update PKWT', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Terjadi kesalahan server', 'error');
                        }
                    });

                }
            });

        });

    });
</script>