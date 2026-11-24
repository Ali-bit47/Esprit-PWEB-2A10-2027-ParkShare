<?php

?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?php require __DIR__ . '/includes/head.php'; ?>
</head>
<body class="front" id="top">
<?php require __DIR__ . '/includes/navbar.php'; ?>

<main class="site-main">
    <?php $flashes = get_flashes(); if ($flashes): ?>
        <div class="wrap flash-zone">
            <?php foreach ($flashes as $f): ?>
                <div class="alert alert-<?= e($f['type']) ?>" role="status"><?= e($f['message']) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?= $content ?>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
<?php require __DIR__ . '/includes/scripts.php'; ?>
</body>
</html>
