<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h2>Ymbord se zouporu</h2>

<?php
$nazev = "";
$autor = "";
?>
<form action="<?= base_url('import/update') ?>" method="post" enctype="multipart/form-data">
    Vyber CSV soubor:
    <input type="file" name="csv_file" accept=".csv" required>
    <br><br>
    <input type="submit" name="submit" value="Importovat">
</form>


<?= $this->endSection(); ?>