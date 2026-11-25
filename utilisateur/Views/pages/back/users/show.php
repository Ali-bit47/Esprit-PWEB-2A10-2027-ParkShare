<?php

$locked = $user->getLockedUntil() && strtotime($user->getLockedUntil()) > time();
?>
<div class="top">
    <div>
        <div class="crumb"><a href="<?= url('admin') ?>">Tableau de bord</a> / <a href="<?= url('users') ?>">Utilisateurs</a> / Fiche</div>
        <h1><?= e($user->getPrenom() . ' ' . $user->getNom()) ?></h1>
        <p>Compte n° <?= $user->getId() ?> · créé le <?= e(format_date($user->getCreatedAt(), true)) ?></p>
    </div>
    <a class="btn" href="<?= url('users') ?>">← Retour à la liste</a>
</div>

<div class="two">
    <div class="p">
        <h2>Informations</h2>
        <dl class="dl">
            <dt>Prénom</dt><dd><?= e($user->getPrenom()) ?></dd>
            <dt>Nom</dt><dd><?= e($user->getNom()) ?></dd>
            <dt>Nom d’utilisateur</dt><dd>@<?= e($user->getUsername()) ?></dd>
            <dt>Adresse email</dt><dd><?= e($user->getEmail()) ?></dd>
            <dt>Téléphone</dt><dd>+216 <?= e(trim(chunk_split($user->getTelephone(), 2, ' '))) ?></dd>
            <dt>Rôle</dt><dd><span class="badge badge-<?= e($user->getRole()) ?>"><?= e(role_label($user->getRole())) ?></span></dd>
            <dt>Statut</dt><dd><span class="badge badge-<?= e($user->getStatut()) ?>"><?= e(statut_label($user->getStatut())) ?></span>
                <?php if ($locked): ?> <span class="badge badge-bloque">Verrouillé jusqu’à <?= e(date('H:i', strtotime($user->getLockedUntil()))) ?></span><?php endif; ?></dd>
            <dt>Dernière connexion</dt><dd><?= e(format_date($user->getLastLogin(), true)) ?></dd>
            <dt>Tentatives échouées</dt><dd><?= $user->getFailedAttempts() ?> / <?= MAX_LOGIN_ATTEMPTS ?></dd>
        </dl>
    </div>

    <div>
        <div class="p idcard">
            <div class="avatar"><?= e(initials($user->getPrenom(), $user->getNom())) ?></div>
            <h2><?= e($user->getPrenom() . ' ' . $user->getNom()) ?></h2>
            <div class="muted"><?= e($user->getEmail()) ?></div>
            <div class="badges">
                <span class="badge badge-<?= e($user->getRole()) ?>"><?= e(role_label($user->getRole())) ?></span>
                <span class="badge badge-<?= e($user->getStatut()) ?>"><?= e(statut_label($user->getStatut())) ?></span>
            </div>
            <div class="stack">
                <?php if (can('users.edit')): ?>
                    <a class="btn btn-primary btn-block" href="<?= url('user_edit', ['id' => $user->getId()]) ?>">Modifier</a>
                <?php endif; ?>
                <?php if (!$isMe && can('users.block')): ?>
                    <form class="js-confirm" method="POST" action="<?= url('user_toggle') ?>"
                          data-confirm="<?= $user->getStatut() === 'actif' ? 'Bloquer' : 'Débloquer' ?> ce compte ?">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= $user->getId() ?>">
                        <input type="hidden" name="back" value="user_show">
                        <button type="submit" class="btn btn-block"><?= $user->getStatut() === 'actif' ? 'Bloquer le compte' : 'Débloquer le compte' ?></button>
                    </form>
                <?php endif; ?>
                <?php if (!$isMe && can('users.delete')): ?>
                    <form class="js-confirm" method="POST" action="<?= url('user_delete') ?>" data-confirm="Supprimer définitivement ce compte ?">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= $user->getId() ?>">
                        <button type="submit" class="btn btn-danger btn-block">Supprimer</button>
                    </form>
                <?php endif; ?>
                <?php if ($isMe): ?><p class="note">C’est votre compte : gérez-le depuis <a href="<?= url('profile') ?>"><b>Mon profil</b></a>.</p><?php endif; ?>
            </div>
        </div>
    </div>
</div>
