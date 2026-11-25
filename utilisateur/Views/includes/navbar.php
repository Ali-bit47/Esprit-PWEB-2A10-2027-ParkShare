<?php

$currentPage = $currentPage ?? 'home';
$me = current_user();
?>
<header class="topnav">
    <div class="wrap">
        <a class="logo" href="<?= url('home') ?>"><img src="<?= asset('img/logo.png') ?>" alt="ParkShare"></a>

        <nav class="links" aria-label="Navigation principale">
            <a class="<?= isActive('home', $currentPage) ?>" href="<?= url('home') ?>">Trouver une place</a>
            <a class="<?= isActive('evenements', $currentPage) ?>" href="<?= url('evenements') ?>">Événements</a>
            <a class="<?= isActive('forum', $currentPage) ?>" href="<?= url('forum') ?>">Forum</a>
            <a class="<?= isActive('materiel', $currentPage) ?>" href="<?= url('materiel') ?>">Matériel</a>
            <?php if ($me): ?>
                <a class="<?= isActive('reservations', $currentPage) ?>" href="<?= url('reservations') ?>">Mes réservations</a>
            <?php endif; ?>
        </nav>

        <div class="actions">
            <?php if ($me): ?>
                <?php if (can('backoffice')): ?>
                    <a class="btn btn-dark btn-sm" href="<?= url('admin') ?>">Back office</a>
                <?php endif; ?>
                <a class="user-chip <?= isActive(['profile', 'profile_edit', 'password'], $currentPage) ?>" href="<?= url('profile') ?>">
                    <span class="avatar"><?= e(initials($me['prenom'], $me['nom'])) ?></span>
                    <?= e($me['prenom']) ?>
                </a>
                <form class="inline" method="POST" action="<?= url('logout') ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm">Déconnexion</button>
                </form>
            <?php else: ?>
                <a class="btn <?= $currentPage === 'login' ? 'btn-dark' : '' ?>" href="<?= url('login') ?>">Connexion</a>
                <a class="btn btn-primary" href="<?= url('register') ?>">S’inscrire</a>
            <?php endif; ?>
        </div>
    </div>
</header>
