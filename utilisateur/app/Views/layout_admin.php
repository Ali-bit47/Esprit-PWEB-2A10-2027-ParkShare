<?php

require_once __DIR__ . '/partials/head.php';
require_once __DIR__ . '/partials/sidebar.php';
?>

<div class="main">
    <?php require_once __DIR__ . '/partials/header.php'; ?>

    <div class="content">
        <?php foreach (get_flashes() as $f): ?>
            <div class="alert alert-<?= e($f['type']) ?>" role="status"><?= e($f['message']) ?></div>
        <?php endforeach; ?>

        <?= $content ?>
    </div>

    <?php require_once __DIR__ . '/partials/footer.php'; ?>
</div>

<?php require_once __DIR__ . '/partials/scripts.php'; ?>
