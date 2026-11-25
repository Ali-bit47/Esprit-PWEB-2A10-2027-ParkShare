<!doctype html>
<html lang="fr">
<head>
    <title><?= htmlspecialchars($title ?? 'ParkShare - Administration') ?></title>
    <?php require_once __DIR__ . '/../partials/admin/head.php'; ?>
</head>
<body class="admin-layout">
<?php require_once __DIR__ . '/../partials/spinner.php'; ?>
<?php require_once __DIR__ . '/../partials/admin/sidebar.php'; ?>
<main class="admin-main">
    <?php require_once __DIR__ . '/../partials/admin/header.php'; ?>
    <?= $content ?>
    <?php require_once __DIR__ . '/../partials/admin/footer.php'; ?>
</main>
<?php require_once __DIR__ . '/../partials/admin/scripts.php'; ?>
</body>
</html>
