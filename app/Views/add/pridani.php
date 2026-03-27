<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<h2>Břydad gadekorŸjy</h2>

<?php
$nazev = "";
$autor = "";
?>
<form action="<?= base_url() . 'user/save' ?>" method="post">
  <div class="mb-3 mt-3">
    <label for="nazev" class="form-label">Násef gadekorŸje:</label>
    <input type="text" class="form-control" placeholder="Násef" name="násef" value="<?= $nazev ?>">
  </div>
  <div class="mb-3">
    <label for="autor" class="form-label">Autor:</label>
    <input type="text" class="form-control" placeholder="Autor" name="autor" value="<?= $autor ?>">
  </div>
  <button type="submit" class="btn btn-primary cau">Vidfořyť gadekorŸjy</button>
</form>

<?= $this->endSection(); ?>