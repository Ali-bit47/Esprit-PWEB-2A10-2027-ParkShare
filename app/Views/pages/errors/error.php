<?php

$titles = [403 => 'Accès refusé', 404 => 'Page introuvable', 405 => 'Action non autorisée'];
?>
<div class="<?= can('backoffice') ? '' : 'wrap' ?>">
    <div class="module-box">
        <div class="icon"><?= (int) $code ?></div>
        <h1><?= e($titles[$code] ?? 'Erreur') ?></h1>
        <p><?= e($message ?: 'Une erreur est survenue.') ?></p>
        <?php if (current_user()): ?>
            <a class="btn btn-primary" href="<?= url(can('backoffice') ? 'admin' : 'home') ?>">Retour à mon espace</a>
        <?php else: ?>
            <a class="btn btn-primary" href="<?= url('login') ?>">Se connecter</a>
        <?php endif; ?>
    </div>
</div>
