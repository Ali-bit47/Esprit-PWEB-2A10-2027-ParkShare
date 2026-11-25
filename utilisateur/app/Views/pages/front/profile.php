<?php  $currentPage = 'profile'; ?>
<div class="wrap page">
    <div class="page-head">
        <div><h1>Mon espace</h1><p>Gérez vos informations personnelles et la sécurité de votre compte.</p></div>
    </div>
    <div class="profile-grid">
        <?php require __DIR__ . '/_profile_menu.php'; ?>
        <div>
            <div class="card">
                <div class="page-head" style="margin-bottom:6px"><h2>Mes informations</h2><a class="btn btn-sm" href="<?= url('profile_edit') ?>">Modifier</a></div>
                <?php require __DIR__ . '/../shared/_profile_details.php'; ?>
            </div>
            <div class="card danger-zone"><?php require __DIR__ . '/../shared/_delete_account.php'; ?></div>
        </div>
    </div>
</div>
