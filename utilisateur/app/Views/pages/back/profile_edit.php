<?php  ?>
<div class="top">
    <div><div class="crumb"><a href="<?= url('profile') ?>">Mon profil</a> / Modifier</div><h1>Modifier mon profil</h1></div>
</div>
<div class="two">
    <div class="p"><?php require __DIR__ . '/../shared/_profile_form.php'; ?></div>
    <div class="p"><h2>Rôle</h2><p class="note">Votre rôle (<?= e(role_label($user->getRole())) ?>) ne peut être modifié que par un autre administrateur.</p></div>
</div>
