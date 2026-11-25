<?php  ?>
<div class="top">
    <div><div class="crumb"><a href="<?= url('profile') ?>">Mon profil</a> / Mot de passe</div><h1>Changer mon mot de passe</h1></div>
</div>
<div class="two">
    <div class="p"><?php require __DIR__ . '/../shared/_password_form.php'; ?></div>
    <div class="p"><h2>Conseils</h2><p class="note">Utilisez au moins 12 caractères en mélangeant lettres, chiffres et symboles. Le mot de passe est stocké uniquement sous forme de hachage bcrypt.</p></div>
</div>
