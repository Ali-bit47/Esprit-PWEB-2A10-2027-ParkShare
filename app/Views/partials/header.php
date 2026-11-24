<?php  ?>
<?php $me = current_user(); ?>
<header class="header">
    <?php if (can('users.view')): ?>
        <form class="q" id="form-header-search" method="GET" action="index.php" role="search">
            <input type="hidden" name="action" value="users">
            <label class="sr-only" for="header-q">Rechercher un utilisateur</label>
            <input type="text" id="header-q" name="q" placeholder="Rechercher un utilisateur…" autocomplete="off">
        </form>
    <?php endif; ?>
    <a class="site" href="<?= url('home') ?>">Voir le site</a>
    <?php if ($me): ?>
        <a class="who" href="<?= url('profile') ?>">
            <span><?= e($me['prenom']) ?><small><?= e(role_label($me['role'])) ?></small></span>
            <span class="av"><?= e(initials($me['prenom'], $me['nom'])) ?></span>
        </a>
        <form class="inline" method="POST" action="<?= url('logout') ?>">
            <?= csrf_field() ?>
            <button type="submit" class="logout">Déconnexion</button>
        </form>
    <?php endif; ?>
</header>
