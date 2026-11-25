<?php

?>
<div class="auth">
    <?php require __DIR__ . '/../shared/_auth_side.php'; ?>

    <div class="auth-main">
        <div class="auth-card narrow">
            <h1>Connexion</h1>
            <p class="lead">Heureux de vous revoir sur ParkShare.</p>

            <?php if ($registered): ?>
                <div class="alert alert-success">Compte créé avec succès, vous pouvez maintenant vous connecter.</div>
            <?php endif; ?>
            <?php require __DIR__ . '/../shared/_errors.php'; ?>

            <form id="form-login" method="POST" action="<?= url('login') ?>">
                <?= csrf_field() ?>

                <div class="field">
                    <label for="email">Adresse email</label>
                    <input class="input <?= invalid($errors, 'email') ?>" type="text" id="email" name="email" value="<?= old($old, 'email') ?>" autocomplete="email" placeholder="nom@domaine.tn">
                    <?= field_error($errors, 'email') ?>
                </div>

                <div class="field">
                    <label for="password">Mot de passe</label>
                    <div class="pw-wrap">
                        <input class="input <?= invalid($errors, 'password') ?>" type="password" id="password" name="password" autocomplete="current-password">
                        <button type="button" class="pw-toggle" data-target="password">Afficher</button>
                    </div>
                    <?= field_error($errors, 'password') ?>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </form>

            <div class="switch-link">Pas encore de compte ? <a href="<?= url('register') ?>">Créer un compte</a></div>

            <div class="demo-box">
                <b>Comptes de démonstration</b> (voir README) : admin@parkshare.tn · technicien@parkshare.tn · proprietaire@parkshare.tn · client@parkshare.tn
            </div>
        </div>
    </div>
</div>
