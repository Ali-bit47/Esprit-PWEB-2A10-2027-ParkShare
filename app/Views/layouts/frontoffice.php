<!doctype html>
<html lang="fr">
<head>
    <title><?= htmlspecialchars($title ?? 'ParkShare') ?></title>
    <?php require_once __DIR__ . '/../partials/front/head.php'; ?>
</head>
<body>
<?php require_once __DIR__ . '/../partials/spinner.php'; ?>
<?php require_once __DIR__ . '/../partials/front/navbar.php'; ?>
<?= $content ?>
<?php require_once __DIR__ . '/../partials/front/footer.php'; ?>
<?php require_once __DIR__ . '/../partials/front/scripts.php'; ?>
</body>
</html>
