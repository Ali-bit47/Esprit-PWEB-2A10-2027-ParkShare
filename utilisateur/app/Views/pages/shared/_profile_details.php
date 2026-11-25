<?php  ?>
<dl class="dl">
    <dt>Prénom et nom</dt><dd><?= e($user->getPrenom() . ' ' . $user->getNom()) ?></dd>
    <dt>Nom d’utilisateur</dt><dd><?= e($user->getUsername()) ?></dd>
    <dt>Adresse email</dt><dd><?= e($user->getEmail()) ?></dd>
    <dt>Téléphone</dt><dd>+216 <?= e(trim(chunk_split($user->getTelephone(), 2, ' '))) ?></dd>
    <dt>Rôle</dt><dd><span class="badge badge-<?= e($user->getRole()) ?>"><?= e(role_label($user->getRole())) ?></span></dd>
    <dt>Membre depuis</dt><dd><?= e(format_date($user->getCreatedAt())) ?></dd>
    <dt>Dernière connexion</dt><dd><?= e(format_date($user->getLastLogin(), true)) ?></dd>
</dl>
