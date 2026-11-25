<?php  ?>
<div class="card profile-id">
    <div class="avatar lg"><?= e(initials($user->getPrenom(), $user->getNom())) ?></div>
    <h2><?= e($user->getPrenom() . ' ' . $user->getNom()) ?></h2>
    <div class="muted">@<?= e($user->getUsername()) ?></div>
    <span class="badge badge-<?= e($user->getRole()) ?>"><?= e(role_label($user->getRole())) ?></span>
    <nav class="menu-list">
        <a class="<?= isActive('profile', $currentPage) ?>" href="<?= url('profile') ?>">Mon profil</a>
        <a class="<?= isActive('profile_edit', $currentPage) ?>" href="<?= url('profile_edit') ?>">Modifier mes informations</a>
        <a class="<?= isActive('password', $currentPage) ?>" href="<?= url('password') ?>">Changer mon mot de passe</a>
        <a href="<?= url('reservations') ?>">Mes réservations</a>
        <?php if (can('places.publish')): ?><a href="<?= url('places') ?>">Mes places en location</a><?php endif; ?>
    </nav>
</div>
