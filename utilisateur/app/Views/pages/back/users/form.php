<?php

$isEdit = $mode === 'edit';
$isMe = $isMe ?? false;
$action = $isEdit ? url('user_edit', ['id' => $user->getId()]) : url('user_create');
$roles = can('users.role') ? AuthController::ALL_ROLES : AuthController::PUBLIC_ROLES;
?>
<div class="top">
    <div>
        <div class="crumb"><a href="<?= url('admin') ?>">Tableau de bord</a> / <a href="<?= url('users') ?>">Utilisateurs</a> / <?= $isEdit ? 'Modifier' : 'Ajouter' ?></div>
        <h1><?= $isEdit ? 'Modifier ' . e($user->getPrenom() . ' ' . $user->getNom()) : 'Ajouter un utilisateur' ?></h1>
        <p><?= $isEdit ? 'Laissez le mot de passe vide pour le conserver.' : 'Le compte pourra se connecter immédiatement.' ?></p>
    </div>
</div>

<div class="two">
    <div class="p">
        <?php require __DIR__ . '/../../shared/_errors.php'; ?>

        <form id="form-user" data-mode="<?= $isEdit ? 'edit' : 'create' ?>" method="POST" action="<?= $action ?>">
            <?= csrf_field() ?>

            <div class="section-title">Identité</div>
            <div class="form-grid">
                <div class="field">
                    <label for="prenom">Prénom</label>
                    <input class="input <?= invalid($errors, 'prenom') ?>" type="text" id="prenom" name="prenom" value="<?= old($old, 'prenom') ?>">
                    <?= field_error($errors, 'prenom') ?>
                </div>
                <div class="field">
                    <label for="nom">Nom</label>
                    <input class="input <?= invalid($errors, 'nom') ?>" type="text" id="nom" name="nom" value="<?= old($old, 'nom') ?>">
                    <?= field_error($errors, 'nom') ?>
                </div>
                <div class="field">
                    <label for="username">Nom d’utilisateur</label>
                    <input class="input <?= invalid($errors, 'username') ?>" type="text" id="username" name="username" value="<?= old($old, 'username') ?>" autocomplete="off">
                    <?= field_error($errors, 'username') ?>
                </div>
                <div class="field">
                    <label for="telephone">Téléphone</label>
                    <input class="input <?= invalid($errors, 'telephone') ?>" type="text" id="telephone" name="telephone" value="<?= old($old, 'telephone') ?>" placeholder="22 123 456">
                    <?= field_error($errors, 'telephone') ?>
                </div>
                <div class="field full">
                    <label for="email">Adresse email</label>
                    <input class="input <?= invalid($errors, 'email') ?>" type="text" id="email" name="email" value="<?= old($old, 'email') ?>" autocomplete="off">
                    <?= field_error($errors, 'email') ?>
                </div>
            </div>

            <div class="section-title">Accès</div>
            <div class="form-grid">
                <div class="field">
                    <label for="role">Rôle</label>
                    <select class="select <?= invalid($errors, 'role') ?>" id="role" name="role">
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= e($role) ?>" <?= ($old['role'] ?? '') === $role ? 'selected' : '' ?>><?= e(role_label($role)) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if ($isMe): ?><small class="hint">Vous ne pouvez pas modifier votre propre rôle.</small><?php endif; ?>
                    <?= field_error($errors, 'role') ?>
                </div>
                <div class="field">
                    <label for="statut">Statut</label>
                    <select class="select <?= invalid($errors, 'statut') ?>" id="statut" name="statut">
                        <option value="actif" <?= ($old['statut'] ?? '') === 'actif' ? 'selected' : '' ?>>Actif</option>
                        <option value="bloque" <?= ($old['statut'] ?? '') === 'bloque' ? 'selected' : '' ?>>Bloqué</option>
                    </select>
                    <?= field_error($errors, 'statut') ?>
                </div>
                <div class="field">
                    <label for="password">Mot de passe <?php if ($isEdit): ?><span class="opt">(facultatif)</span><?php endif; ?></label>
                    <div class="pw-wrap">
                        <input class="input <?= invalid($errors, 'password') ?>" type="password" id="password" name="password" autocomplete="new-password">
                        <button type="button" class="pw-toggle" data-target="password">Afficher</button>
                    </div>
                    <div class="strength" data-strength="password"><i></i><i></i><i></i><i></i></div>
                    <small class="hint">8 caractères min., une majuscule, une minuscule, un chiffre. <b id="password-strength-label"></b></small>
                    <?= field_error($errors, 'password') ?>
                </div>
                <div class="field">
                    <label for="password_confirm">Confirmer le mot de passe</label>
                    <div class="pw-wrap">
                        <input class="input <?= invalid($errors, 'password_confirm') ?>" type="password" id="password_confirm" name="password_confirm" autocomplete="new-password">
                        <button type="button" class="pw-toggle" data-target="password_confirm">Afficher</button>
                    </div>
                    <?= field_error($errors, 'password_confirm') ?>
                </div>
            </div>

            <div class="form-actions">
                <a class="btn" href="<?= $isEdit ? url('user_show', ['id' => $user->getId()]) : url('users') ?>">Annuler</a>
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Enregistrer les modifications' : 'Créer le compte' ?></button>
            </div>
        </form>
    </div>

    <div class="p">
        <h2>Rôles et droits</h2>
        <div class="z"><span><span class="badge badge-client">Automobiliste</span></span><small class="muted">Front Office · réserver</small></div>
        <div class="z"><span><span class="badge badge-proprietaire">Propriétaire</span></span><small class="muted">Front Office · louer ses places</small></div>
        <div class="z"><span><span class="badge badge-technicien">Technicien</span></span><small class="muted">Back Office · entretiens</small></div>
        <div class="z"><span><span class="badge badge-admin">Administrateur</span></span><small class="muted">Back Office · tout</small></div>
        <p class="note" style="margin-top:14px">Un compte bloqué ne peut plus se connecter et sa session en cours est fermée à la requête suivante.</p>
    </div>
</div>
