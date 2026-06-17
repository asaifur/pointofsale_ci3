<form id="formUpdateStaff">

    <div class="modal-header bg-info text-white">
        <h5 class="modal-title">
            <i class="fa fa-user-edit"></i> Update Entry Staff Admin
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
    </div>

    <div class="modal-body">

        <input type="hidden" name="id_jobdesk" id="id_jobdesk" value="<?= $jobdesk->id ?>">

        <div class="form-group">
            <label>Pilih Staff Entry</label>
            <input type="text"
                class="form-control pilihStaff"
                id="pilihStaff"
                placeholder="Pilih Staff Entry"
                autocomplete="off"
                required>

            <input type="hidden" name="pilihStaffHidden" id="pilihStaffHidden">
        </div>

    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Simpan
        </button>
    </div>

</form>
<!-- 3️⃣ JQUERY UI JS -->

<script>
    $(document).ready(function() {

        $("#pilihStaff").autocomplete({
            minLength: 1,
            delay: 200,
            appendTo: "#modalUpdateStaff",

            source: function(request, response) {
                $.ajax({
                    url: "<?= base_url('jobdesk/search_staff'); ?>",
                    type: "GET",
                    dataType: "json",
                    data: {
                        term: request.term // harus "term"
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },

            select: function(event, ui) {
                $("#pilihStaff").val(ui.item.label);
                $("#pilihStaffHidden").val(ui.item.value);
                return false;
            }
        });

    });
</script>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    $('#formUpdateStaff').on('submit', function(e) {
        e.preventDefault();

        let id_jobdesk = $('#id_jobdesk').val();

        let user_id = $('#pilihStaffHidden').val();

        if (!user_id) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Silakan pilih staff terlebih dahulu'
            });
            return;
        }

        $.ajax({
            url: "<?= base_url('jobdesk/update_staff'); ?>",
            type: "POST",
            dataType: "json",
            data: {
                id_jobdesk: id_jobdesk,
                user_id: user_id
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Menyimpan...',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
            },
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    $('#modalUpdateStaff').modal('hide');
                    $('#formUpdateStaff')[0].reset();

                    if (typeof tableTransaksi !== 'undefined') {
                        tableTransaksi.ajax.reload(null, false);
                    }

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: res.message
                    });
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
</script>