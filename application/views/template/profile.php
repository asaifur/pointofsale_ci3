<form id="form-update-profile">
    <div class="row">
        <input type="hidden" name="id" value="<?= $user['id_users']; ?>">

        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Data Autentikasi</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Fullname</label>
                        <input type="text" class="form-control" name="username" value="<?= $user['username']; ?>"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" class="form-control" name="email" value="<?= $user['email']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Supervisi</label>
                        <select id="idreferal" class="form-control" name="referal">
                            <option value="">-- Pilih Supervisi --</option>
                        </select>
                    </div>

                </div>
            </div>

            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Informasi Pajak & Identitas</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" class="form-control" name="nik" value="<?= $user['nik']; ?>">
                    </div>
                    <div class="form-group">
                        <label>NPWP</label>
                        <input type="text" class="form-control" name="npwp" value="<?= $user['npwp']; ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Kontak & Alamat</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input type="text" class="form-control" name="noTelepon" value="<?= $user['noTelepon']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea class="form-control" name="alamat" rows="3"><?= $user['alamat']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Informasi Perbankan</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Bank</label>
                        <input type="text" class="form-control" name="bank" value="<?= $user['bank']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Nomor Rekening</label>
                        <input type="text" class="form-control" name="noRek" value="<?= $user['noRek']; ?>">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" id="btn-save" class="btn btn-primary float-right">Update Profil</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {

        loadReferal();

        function loadReferal() {
            $.ajax({
                url: "<?= base_url('profile/get_referal'); ?>",
                type: "GET",
                dataType: "json",
                success: function(res) {
                    console.log(res); // DEBUG

                    let html = '<option value="">-- Pilih Referal --</option>';

                    if (res.length === 0) {
                        html += '<option value="">Data referal kosong</option>';
                    } else {
                        $.each(res, function(i, item) {
                            let selected = item.id == "<?= $user['referal']; ?>" ? "selected" : "";
                            html += `<option value="${item.id}" ${selected}>${item.name_referal}</option>`;
                        });
                    }

                    $('#idreferal').html(html);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal load referal!');
                }
            });
        }

    });
</script>

<script>
    $(document).ready(function() {
        $('#form-update-profile').on('submit', function(e) {
            e.preventDefault();


            const isiTambah = $('#form-update-profile').serialize();

            $.ajax({
                type: "POST",
                url: `<?= base_url(); ?>profile/update_action`,
                data: isiTambah,
                dataType: "json",
                success: function(response) {
                    console.log(response)
                    if (response.status == true || response.status === "true") {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Profil Anda telah diperbarui.',
                            icon: 'success'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    // Ini akan membantu Anda melihat error di console
                    console.error(xhr.responseText);
                    Swal.fire('Error!', 'Terjadi kesalahan sistem: ' + error, 'error');
                    btn.html('Update Profil').attr('disabled', false);
                }
            });
        });
    });
</script>