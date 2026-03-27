<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $this->include('layout/css'); ?>
    <title>Velký projekt pro pana učitele Hrdinu</title>
</head>

<body><br>
    <div class="container">
        <?= $this->renderSection('content'); ?>
    </div>

    <?= $this->include('layout/js'); ?>
</body>

</html>