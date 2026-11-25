<?php

$role = $old['role'] ?? 'client';
?>
<div class="auth">
    <?php require __DIR__ . '/../shared/_auth_side.php'; ?>

    <div class="auth-main">
        <div class="auth-card">
            <h1>Créer un compte</h1>
            <p class="lead">Gratuit, en moins d’une minute.</p>

            <?php require __DIR__ . '/../shared/_errors.php'; ?>

            <form id="form-register" method="POST" action="<?= url('register') ?>">
                <?= csrf_field() ?>

                <div class="field">
                    <label>Je suis</label>
                    <div class="choice-group">
                        <label class="choice"><input type="radio" name="role" value="client" <?= $role === 'client' ? 'checked' : '' ?>><span><b>Automobiliste</b>Je cherche une place</span></label>
                        <label class="choice"><input type="radio" name="role" value="proprietaire" <?= $role === 'proprietaire' ? 'checked' : '' ?>><span><b>Propriétaire</b>Je loue ma place</span></label>
                    </div>
                    <?= field_error($errors, 'role') ?>
                </div>

                <div class="form-grid">
                    <div class="field">
                        <label for="prenom">Prénom</label>
                        <input class="input <?= invalid($errors, 'prenom') ?>" type="text" id="prenom" name="prenom" value="<?= old($old, 'prenom') ?>" autocomplete="given-name">
                        <?= field_error($errors, 'prenom') ?>
                    </div>
                    <div class="field">
                        <label for="nom">Nom</label>
                        <input class="input <?= invalid($errors, 'nom') ?>" type="text" id="nom" name="nom" value="<?= old($old, 'nom') ?>" autocomplete="family-name">
                        <?= field_error($errors, 'nom') ?>
                    </div>
                    <div class="field">
                        <label for="username">Nom d’utilisateur</label>
                        <input class="input <?= invalid($errors, 'username') ?>" type="text" id="username" name="username" value="<?= old($old, 'username') ?>" autocomplete="username">
                        <?= field_error($errors, 'username') ?>
                    </div>
                    <div class="field">
                        <label for="telephone">Téléphone</label>
                        <input class="input <?= invalid($errors, 'telephone') ?>" type="text" id="telephone" name="telephone" value="<?= old($old, 'telephone') ?>" placeholder="22 123 456" autocomplete="tel">
                        <?= field_error($errors, 'telephone') ?>
                    </div>
                    <div class="field full">
                        <label for="email">Adresse email</label>
                        <input class="input <?= invalid($errors, 'email') ?>" type="text" id="email" name="email" value="<?= old($old, 'email') ?>" placeholder="nom@domaine.tn" autocomplete="email">
                        <?= field_error($errors, 'email') ?>
                    </div>
                    <div class="field">
                        <label for="password">Mot de passe</label>
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

                <div class="field">
                    <label class="check"><input type="checkbox" name="terms" value="1" <?= !empty($old['terms']) ? 'checked' : '' ?>> J’accepte les conditions d’utilisation et la politique de confidentialité de ParkShare.</label>
                    <?= field_error($errors, 'terms') ?>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Créer mon compte</button>
            </form>

            <div class="switch-link">Déjà inscrit ? <a href="<?= url('login') ?>">Se connecter</a></div>
        </div>
    </div>
</div>
