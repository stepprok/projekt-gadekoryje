<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->include('layout/css'); ?>
    <title>Velký projekt pro pana učitele Hrdinu</title>
</head>

<body>
    <?= $this->include('layout/navbar'); ?>
    <br>
    <div class="container">
        <?= $this->renderSection('content'); ?>
    </div>

    <?= $this->include('layout/js'); ?>
</body>

</html>