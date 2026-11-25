<?php

?>
<div class="wrap">
    <div class="module-box">
        <div class="icon">P</div>
        <h1><?= e($name) ?></h1>

        <?php if ($search !== null): ?>
            <?php if ($searchErrors): ?>
                <div class="alert alert-error" style="text-align:left">
                    Recherche refusée par le contrôle serveur :
                    <ul><?php foreach ($searchErrors as $msg): ?><li><?= e($msg) ?></li><?php endforeach; ?></ul>
                </div>
            <?php else: ?>
                <div class="alert alert-success">
                    Recherche valide : <?= e($search['lieu']) ?>, le <?= e($search['date']) ?>, pendant <?= e($search['duree']) ?> h.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <p>Ce module (entités <b><?= e($entities) ?></b>) est développé par un autre membre de l’équipe
           et sera branché ici lors de l’intégration Git.</p>
        <p>Pour l’intégrer : créer son contrôleur dans <code>app/Controllers</code>, ses vues dans
           <code>app/Views/pages/front</code>, puis remplacer sa ligne dans <code>app/routes.php</code>.</p>
        <a class="btn btn-primary" href="<?= url('home') ?>">Retour à l’accueil</a>
    </div>
</div>
