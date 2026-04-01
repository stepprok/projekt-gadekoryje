<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<h2>Едытoфат фытcэ нa йeтнoу</h2>

<form method="post" action="">
    <?php foreach ($typKomponent as $row): ?>
        <p>
            <strong><?= $row->typKomponent; ?></strong>
            <input type="checkbox" name="komponenty[]" value="<?= $row->idKomponent ?>">
        </p>
    <?php endforeach; ?>

    <button type="button" data-bs-toggle="modal" data-bs-target="#dalsivec" class="btn-primary">
        cmнэнит
    </button>

    <div class="modal fade" id="dalsivec">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Zmňěňde násef tjěghdo vjetsý</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <input type="submit" value="Konec">
                </div>

            </div>
        </div>
    </div>

</form>

<?= $this->endSection(); ?>