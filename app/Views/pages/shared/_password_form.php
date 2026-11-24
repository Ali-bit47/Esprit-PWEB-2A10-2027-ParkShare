<?php  ?>
<?php require __DIR__ . '/_errors.php'; ?>
<form id="form-password" method="POST" action="<?= url('password') ?>">
    <?= csrf_field() ?>
    <div class="field">
        <label for="current_password">Mot de passe actuel</label>
        <div class="pw-wrap">
            <input class="input <?= invalid($errors, 'current_password') ?>" type="password" id="current_password" name="current_password" autocomplete="current-password">
            <button type="button" class="pw-toggle" data-target="current_password">Afficher</button>
        </div>
        <?= field_error($errors, 'current_password') ?>
    </div>
    <div class="field">
        <label for="password">Nouveau mot de passe</label>
        <div class="pw-wrap">
            <input class="input <?= invalid($errors, 'password') ?>" type="password" id="password" name="password" autocomplete="new-password">
            <button type="button" class="pw-toggle" data-target="password">Afficher</button>
        </div>
        <div class="strength" data-strength="password"><i></i><i></i><i></i><i></i></div>
        <small class="hint">8 caractères min., une majuscule, une minuscule, un chiffre. <b id="password-strength-label"></b></small>
        <?= field_error($errors, 'password') ?>
    </div>
    <div class="field">
        <label for="password_confirm">Confirmer le nouveau mot de passe</label>
        <div class="pw-wrap">
            <input class="input <?= invalid($errors, 'password_confirm') ?>" type="password" id="password_confirm" name="password_confirm" autocomplete="new-password">
            <button type="button" class="pw-toggle" data-target="password_confirm">Afficher</button>
        </div>
        <?= field_error($errors, 'password_confirm') ?>
    </div>
    <div class="form-actions">
        <a class="btn" href="<?= url('profile') ?>">Annuler</a>
        <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
    </div>
</form>
