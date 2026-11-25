<?php  ?>
<h2>Supprimer mon compte</h2>
<p>Cette action est définitive : votre profil et vos données personnelles seront effacés.</p>
<form id="form-delete-account" class="js-confirm" data-confirm="Supprimer définitivement votre compte ParkShare ?" method="POST" action="<?= url('profile_delete') ?>">
    <?= csrf_field() ?>
    <div class="field">
        <label class="sr-only" for="confirm_password">Mot de passe</label>
        <input class="input" type="password" id="confirm_password" name="confirm_password" placeholder="Votre mot de passe" autocomplete="current-password">
        <small class="field-error" data-for="confirm_password"></small>
    </div>
    <button type="submit" class="btn btn-danger">Supprimer mon compte</button>
</form>
