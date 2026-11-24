<?php  ?>
<?php require __DIR__ . '/_errors.php'; ?>
<form id="form-profile" method="POST" action="<?= url('profile_edit') ?>">
    <?= csrf_field() ?>
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
            <input class="input <?= invalid($errors, 'username') ?>" type="text" id="username" name="username" value="<?= old($old, 'username') ?>">
            <?= field_error($errors, 'username') ?>
        </div>
        <div class="field">
            <label for="telephone">Téléphone</label>
            <input class="input <?= invalid($errors, 'telephone') ?>" type="text" id="telephone" name="telephone" value="<?= old($old, 'telephone') ?>">
            <?= field_error($errors, 'telephone') ?>
        </div>
        <div class="field full">
            <label for="email">Adresse email</label>
            <input class="input <?= invalid($errors, 'email') ?>" type="text" id="email" name="email" value="<?= old($old, 'email') ?>">
            <?= field_error($errors, 'email') ?>
        </div>
    </div>
    <div class="form-actions">
        <a class="btn" href="<?= url('profile') ?>">Annuler</a>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </div>
</form>
