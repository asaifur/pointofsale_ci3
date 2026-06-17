<div class="card">
  <div class="card-header">
    <button type="button" class="btn btn-primary bg-gradient-primary btn-sm" id="btn-tambah"><i class="fa fa-plus"></i> Import Data</button>
  </div>
  <div class="card-body">

    <div class="table-responsive">
      <table class="table table-hover table-bordered table-striped text-center" id="myTable" style="width: 100%;">
        <thead class="bg-primary">
          <tr>
            <th style="width: 5%;">No.</th>
            <th>P3H</th>
            <th>Nama PU</th>
            <th>No telepon</th>
            <th>NIK</th>
            <th>Staff Entry</th>
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
<div class="modal fade" id="modalPreview" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">
          <i class="fa fa-eye"></i> Preview Data Excel
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-sm text-center" id="previewTable">
            <thead class="bg-light">
              <tr>
                <th>No</th>
                <th>P3H</th>
                <th>Nama PU</th>
                <th>NIK</th>
                <th>No Telepon</th>
                <th>linkFotoKTP</th>
                <th>NAMA USAHA</th>
                <th>PROVINSI</th>
                <th>KOTA/KABUPATEN</th>
                <th>KECAMATAN</th>
                <th>KELURAHAN</th>
                <th>RT/RW</th>
                <th>KODE POS</th>
                <th>NAMA PRODUK 1</th>
                <th>FOTO PRODUK 1</th>
                <th>VIDEO PRODUK 1</th>
                <th>VERVAL PRODUK 1</th>
                <th>NAMA PRODUK 2</th>
                <th>FOTO PRODUK 2</th>
                <th>VIDEO PRODUK 2</th>
                <th>VERVAL PRODUK 2</th>
                <th>NAMA PRODUK 3</th>
                <th>FOTO PRODUK 3</th>
                <th>VIDEO PRODUK 3</th>
                <th>VERVAL PRODUK 3</th>
                <th>NAMA PRODUK 4</th>
                <th>FOTO PRODUK 4</th>
                <th>VIDEO PRODUK 4</th>
                <th>VERVAL PRODUK 4</th>
                <th>NAMA PRODUK 5</th>
                <th>FOTO PRODUK 5</th>
                <th>VIDEO PRODUK 5</th>
                <th>VERVAL PRODUK 5</th>
                <th>NAMA PRODUK 6</th>
                <th>FOTO PRODUK 6</th>
                <th>VIDEO PRODUK 6</th>
                <th>VERVAL PRODUK 6</th>
                <th>NAMA PRODUK 7</th>
                <th>FOTO PRODUK 7</th>
                <th>VIDEO PRODUK 7</th>
                <th>VERVAL PRODUK 7</th>
                <th>EMAIL</th>
                <th>PASS</th>
                <th>NIB</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button class="btn btn-primary" id="btnImportFinal">
          <i class="fa fa-upload"></i> Import Sekarang
        </button>
      </div>

    </div>
  </div>
</div>
<div class="modal fade" id="modalImport" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <form id="formImport" enctype="multipart/form-data">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">
            <i class="fa fa-file-excel"></i> Import Data
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>File Excel</label>
            <input type="file" name="file" class="form-control" accept=".xls,.xlsx" required>
            <small class="text-muted">
              Format: P3H | NAMA PU | NIK | NO TELEPON | NIB
            </small>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-upload"></i> Import
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="modalUpdateStaff" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content" id="isiModalUpdateStaff">

    </div>
  </div>
</div>

<?php $this->load->view('template/scriptes.php') ?>
<script>
  $(document).ready(function() {



    tableTransaksi = $('#myTable').DataTable({

      "scrollX": true,
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": '<?php echo site_url('jobdesk/view_jobdesk_supervisi'); ?>',
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
          data: "ppph"
        }, // PASTIKAN ADA DI JSON
        {
          data: "namaPU"
        },
        {
          data: "noTelepon"
        },
        {
          data: "nik"
        },
        {
          data: "user"
        },
        {
          data: "id",
          render: function(data, type, row) {
            return `
                <button class="btn btn-sm btn-info btn-update"
                data-id="${data}">
                <i class="fas fa-edit"></i> Update Entry Staff
            </button>
           
                <button class="btn btn-sm btn-danger btn-delete"
                    data-id="${data}"
                    data-nib="${row.nib}">
                    <i class="fas fa-trash"></i> Delete Data
                </button>`;
          }
        }
      ],

    });
    // ================== KLIK BUTTON UPDATE ==================
    $('#myTable').on('click', '.btn-delete', function() {
      let id = $(this).data('id');

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Data yang dihapus tidak dapat dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '<?= base_url('') ?>jobdesk/delete_jobdesk',
            type: 'POST',
            data: {
              id: id
            },
            dataType: 'json',
            success: function(response) {
              if (response.status === "success") {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil!',
                  text: 'Data berhasil dihapus',
                  timer: 1500,
                  showConfirmButton: false
                });

                tableTransaksi.ajax.reload(null, false);
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Gagal!',
                  text: 'Data gagal dihapus'
                });
              }
            },
            error: function() {
              Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Terjadi kesalahan pada server'
              });
            }
          });
        }
      });
    });


    $('#myTable').on('click', '.btn-update', function() {

      let id = $(this).data('id');

      // reset isi modal
      $('#isiModalUpdateStaff').html(`
    <div class="modal-body text-center">
      <i class="fa fa-spinner fa-spin fa-2x"></i>
      <p>Loading...</p>
    </div>
  `);

      $('#modalUpdateStaff').modal('show');

      $.ajax({
        url: "<?= base_url('jobdesk/modal_update_staff'); ?>",
        type: "POST",
        data: {
          id: id
        },
        dataType: "html",
        success: function(response) {
          $('#isiModalUpdateStaff').html(response);
        },
        error: function() {
          $('#isiModalUpdateStaff').html(`
        <div class="modal-body text-danger text-center">
          <i class="fa fa-times-circle fa-2x"></i>
          <p>Gagal memuat data</p>
        </div>
      `);
        }
      });

    });


    let excelData = [];

    $('#formImport input[type="file"]').on('change', function(e) {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();

      reader.onload = function(evt) {
        const data = new Uint8Array(evt.target.result);
        const workbook = XLSX.read(data, {
          type: 'array'
        });
        const sheet = workbook.Sheets[workbook.SheetNames[0]];
        const json = XLSX.utils.sheet_to_json(sheet, {
          header: 1
        });

        excelData = [];
        $('#previewTable tbody').html('');

        for (let i = 1; i < json.length; i++) {
          if (!json[i][0]) continue;

          excelData.push({
            p3h: json[i][0],
            namaPU: json[i][1],
            nik: json[i][2],
            noTelepon: json[i][3],
            ktp_source: json[i][4],
            namaUsaha: json[i][5],
            provinsi: json[i][6],
            kota: json[i][7],
            kecamatan: json[i][8],
            kelurahan: json[i][9],
            rtrw: json[i][10],
            kodepos: json[i][11],
            produk1: json[i][12],
            fotoProduk1: json[i][13],
            videoProduk1: json[i][14],
            vervalProduk1: json[i][15],
            produk2: json[i][16],
            fotoProduk2: json[i][17],
            videoProduk2: json[i][18],
            vervalProduk2: json[i][19],
            produk3: json[i][20],
            fotoProduk3: json[i][21],
            videoProduk3: json[i][22],
            vervalProduk3: json[i][23],
            produk4: json[i][24],
            fotoProduk4: json[i][25],
            videoProduk4: json[i][26],
            vervalProduk4: json[i][27],
            produk5: json[i][28],
            fotoProduk5: json[i][29],
            videoProduk5: json[i][30],
            vervalProduk5: json[i][31],
            produk6: json[i][32],
            fotoProduk6: json[i][33],
            videoProduk6: json[i][34],
            vervalProduk6: json[i][35],
            produk7: json[i][36],
            fotoProduk7: json[i][37],
            videoProduk7: json[i][38],
            vervalProduk7: json[i][39],
            email_baru_dibuat: json[i][40],
            password_baru_dibuat: json[i][41],
            nib: json[i][42],
          });

          $('#previewTable tbody').append(`
                <tr>
                    <td>${i}</td>
                    <td>${json[i][0]}</td>
                    <td>${json[i][1]}</td>
                    <td>${json[i][2]}</td>
                    <td>${json[i][3]}</td>
                    <td>${json[i][4]}</td>
                    <td>${json[i][5]}</td>
                    <td>${json[i][6]}</td>
                    <td>${json[i][7]}</td>
                    <td>${json[i][8]}</td>
                    <td>${json[i][9]}</td>
                    <td>${json[i][10]}</td>
                    <td>${json[i][11]}</td>
                    <td>${json[i][12]}</td>
                    <td>${json[i][13]}</td>
                    <td>${json[i][14]}</td>
                    <td>${json[i][15]}</td>
                    <td>${json[i][16]}</td>
                    <td>${json[i][17]}</td>
                    <td>${json[i][18]}</td>
                    <td>${json[i][19]}</td>
                    <td>${json[i][20]}</td>
                    <td>${json[i][21]}</td>
                    <td>${json[i][22]}</td>
                    <td>${json[i][23]}</td>
                    <td>${json[i][24]}</td>
                    <td>${json[i][25]}</td>
                    <td>${json[i][26]}</td>
                    <td>${json[i][27]}</td>
                    <td>${json[i][28]}</td>
                    <td>${json[i][29]}</td>
                    <td>${json[i][30]}</td>
                    <td>${json[i][31]}</td>
                    <td>${json[i][32]}</td>
                    <td>${json[i][33]}</td>
                    <td>${json[i][34]}</td>
                    <td>${json[i][35]}</td>
                    <td>${json[i][36]}</td>
                    <td>${json[i][37]}</td>
                    <td>${json[i][38]}</td>
                    <td>${json[i][39]}</td>
                    <td>${json[i][40]}</td>
                    <td>${json[i][41]}</td>
                    <td>${json[i][42]}</td>
                </tr>
            `);
        }

        $('#modalImport').modal('hide');
        $('#modalPreview').modal('show');
      };

      reader.readAsArrayBuffer(file);
    });

    // ================= SHOW MODAL =================
    $('#btn-tambah').on('click', function() {
      $('#modalImport').modal('show');
    });

    // ================= SUBMIT IMPORT =================
    $('#formImport').on('submit', function(e) {
      e.preventDefault();

      let formData = new FormData(this);

      $.ajax({
        url: "<?= base_url('jobdesk/import_excel'); ?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON",

        beforeSend: function() {
          Swal.fire({
            title: 'Mengimport...',
            text: 'Mohon tunggu',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });
        },

        success: function(res) {

          if (res.status) {

            Swal.fire({
              icon: 'success',
              title: 'Import Berhasil',
              html: `
                        Total Data : <b>${res.total}</b><br>
                        Berhasil Masuk : <b style="color:green">${res.berhasil}</b><br>
                        Duplikat NIK : <b style="color:red">${res.duplikat}</b>
                    `
            });

            $('#modalImport').modal('hide');
            $('#formImport')[0].reset();

            tableTransaksi.ajax.reload(null, false);

          } else {
            Swal.fire('Gagal', res.message, 'error');
          }

        },

        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Terjadi kesalahan server'
          });
        }

      });

    });
    $('#btnImportFinal').on('click', function() {

      $.ajax({
        url: "<?= base_url('jobdesk/import_excel'); ?>",
        type: "POST",
        data: {
          data: excelData
        },
        dataType: "JSON",
        beforeSend: function() {
          Swal.fire({
            title: 'Mengimport data...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
          });
        },
        success: function(res) {
          if (res.status) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: res.message,
              timer: 1500,
              showConfirmButton: false
            });

            $('#modalPreview').modal('hide');
            tableTransaksi.ajax.reload(null, false);
          } else {
            Swal.fire('Gagal', res.message, 'error');
          }
        },
        error: function() {
          Swal.fire('Error', 'Terjadi kesalahan server atau data Duplikat', 'error');
        }
      });

    });

    $('#formUpdateStaff').on('submit', function(e) {
      e.preventDefault();

      $.ajax({
        url: "<?= base_url('jobdesk/update_entry_staff'); ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "JSON",
        success: function(res) {
          if (res.status) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: res.message,
              timer: 1500,
              showConfirmButton: false
            });

            $('#modalUpdateStaff').modal('hide');
            $('#myTable').DataTable().ajax.reload(null, false);
          } else {
            Swal.fire('Gagal', res.message, 'error');
          }
        },
        error: function() {
          Swal.fire('Error', 'Terjadi kesalahan server', 'error');
        }
      });

    });

  });
</script>