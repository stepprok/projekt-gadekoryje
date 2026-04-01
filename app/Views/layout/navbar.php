<nav class="navbar navbar-expand-sm bg-light">

    <div class="container-fluid">
        <ul class="navbar-nav">
        <li class="nav-item">
                <a class="navbar-brand" href="<?= base_url() ?>"
                    class="text-decoration-none">
                    Houm pejdž
                </a>
            </li>
            <?php foreach($typKomponent as $row): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('druha/') . $row->url; ?>"
                    class="text-decoration-none">
                    <?= $row->typKomponent; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

</nav>  