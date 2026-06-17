<div class="modal-header bg-primary">
    <h5 class="modal-title">Update QC Email</h5>
    <button type="button" class="close" data-dismiss="modal">
        <span>&times;</span>
    </button>
</div>

<form id="formUpdateQcEmail">

    <div class="modal-body">

        <input type="hidden" name="id" value="<?= $row->id; ?>">

        <?php foreach ($format as $kolom): ?>
            <?php $dtKolomcode = $kolom->code;
            $valueCode = $row->$dtKolomcode;
            ?>
            <?php if ($kolom->type == "rst") : ?>
                <div class="form-group">
                    <label for="<?= $kolom->code ?>"><?= $kolom->name ?></label>
                    <input name="<?= $kolom->code ?>" class="form-control" id="<?= $kolom->code ?>" type="text" value="<?= $valueCode ?>">
                </div>

            <?php endif; ?>

        <?php endforeach; ?>
    </div>

    <div class="modal-footer">
        <button type="button"
            class="btn btn-secondary"
            data-dismiss="modal">Batal</button>

        <button type="submit"
            class="btn btn-primary">Simpan</button>
    </div>

</form>