<div class="modal-header bg-primary">
    <h5 class="modal-title">Profile (<?= $action  ?>) </h5>
    <button type="button" class="close" data-dismiss="modal">
        <span>&times;</span>
    </button>
</div>


<form id="formUpdateQcEmail" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $row->id_users; ?>">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Hak Akses</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Title</th>
                        <th>Modul</th>
                        <th style="width: 40px">
                            Cek
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $modul = $this->Halal_model->fetch_data('user_menu')->result();
                    $no = 1;
                    foreach ($modul as $m):
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $m->title; ?></td>
                            <td><?= $m->modul; ?></td>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input
                                        class="custom-control-input"
                                        type="checkbox"
                                        id="menu<?= $m->id ?>"
                                        name="menu[]"
                                        value="<?= $m->id ?>"

                                        <?= (in_array($m->id, $akses_menu)) ? 'checked' : '' ?>>

                                    <label for="menu<?= $m->id ?>" class="custom-control-label"></label>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <?php if ($action <> "view") {  ?>
        <div class="modal-footer">
            <button type="button"
                class="btn btn-secondary"
                data-dismiss="modal">Batal</button>

            <button type="submit"
                class="btn btn-primary"><?= $action ?></button>
        </div>
    <?php } else {
        echo "";
    } ?>
</form>

<script>
    $('#formUpdateQcEmail').submit(function(e) {

        e.preventDefault();

        $.ajax({
            url: "<?= base_url('Profile/save_access') ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",

            success: function(res) {

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message
                });

                $('#modalForm').modal('hide');
                $('#modal-xl').modal('hide');
            }

        });

    });
</script>