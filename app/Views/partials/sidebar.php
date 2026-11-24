<?php

$currentPage = $currentPage ?? 'admin';
$me = current_user();

$menu = [
    'PRINCIPAL' => [
        ['admin', 'Tableau de bord', 'dashboard.view', ['admin']],
        ['users', 'Utilisateurs', 'users.view', ['users', 'user_create', 'user_show', 'user_edit']],
    ],
    'MODULES' => [
        ['admin_places', 'Places & réservations', 'places.manage', ['admin_places']],
        ['admin_evenements', 'Événements', 'evenements.manage', ['admin_evenements']],
        ['admin_forum', 'Forum & publications', 'forum.moderate', ['admin_forum']],
        ['admin_materiel', 'Matériel & catégories', 'materiel.manage', ['admin_materiel']],
        ['admin_entretiens', 'Entretiens & traitements', 'entretiens.manage', ['admin_entretiens']],
    ],
    'MON COMPTE' => [
        ['profile', 'Mon profil', 'backoffice', ['profile', 'profile_edit', 'password']],
        ['home', 'Voir le site', 'backoffice', []],
    ],
];
?>

<aside class="sidebar">
    <a class="brand" href="<?= url('admin') ?>">Park<span>Share</span></a>
    <div class="role"><?= $me && $me['role'] === 'admin' ? 'ADMINISTRATION' : 'ESPACE TECHNICIEN' ?></div>

    <nav aria-label="Menu du back office">
        <?php foreach ($menu as $section => $items): ?>
            <?php $visible = array_filter($items, fn($i) => can($i[2])); ?>
            <?php if ($visible): ?>
                <div class="sec"><?= e($section) ?></div>
                <?php foreach ($visible as [$action, $label, , $pages]): ?>
                    <a class="m <?= isActive($pages, $currentPage) ?>" href="<?= url($action) ?>"><?= e($label) ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>

    <?php if ($me): ?>
        <div class="me">
            <div class="avatar"><?= e(initials($me['prenom'], $me['nom'])) ?></div>
            <div><b><?= e($me['prenom'] . ' ' . $me['nom']) ?></b><small><?= e(role_label($me['role'])) ?></small></div>
        </div>
    <?php endif; ?>
</aside>

