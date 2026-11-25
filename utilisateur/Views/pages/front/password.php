<?php 
$currentPage = 'password';
?>
<div class="wrap page">
    <div class="page-head"><div><h1>Changer mon mot de passe</h1><p>Choisissez un mot de passe que vous n’utilisez pas ailleurs.</p></div></div>
    <div class="profile-grid">
        <?php require __DIR__ . '/_profile_menu.php'; ?>
        <div class="card"><?php require __DIR__ . '/../shared/_password_form.php'; ?></div>
    </div>
</div>
