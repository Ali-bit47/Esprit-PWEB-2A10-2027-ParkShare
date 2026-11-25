<?php  ?>
<div class="top">
    <div><h1>Mon profil</h1><p>Vos informations et la sécurité de votre compte.</p></div>
    <div style="display:flex;gap:10px">
        <a class="btn" href="<?= url('password') ?>">Changer mon mot de passe</a>
        <a class="btn btn-primary" href="<?= url('profile_edit') ?>">Modifier</a>
    </div>
</div>
<div class="two">
    <div class="p"><h2>Informations</h2><?php require __DIR__ . '/../shared/_profile_details.php'; ?></div>
    <div class="p danger-zone"><?php require __DIR__ . '/../shared/_delete_account.php'; ?></div>
</div>
