<?php  ?>
<div class="module-box">
    <div class="icon">⚙</div>
    <h1><?= e($name) ?></h1>
    <p>Module des entités <b><?= e($entities) ?></b>, développé par un autre membre de l’équipe.
       L’accès à cette page est déjà protégé par sa permission (<code>config/permissions.php</code>).</p>
    <p>Pour l’intégrer : ajouter son contrôleur et ses vues, puis remplacer sa ligne dans <code>app/routes.php</code>.</p>
    <a class="btn btn-primary" href="<?= url('admin') ?>">Retour au tableau de bord</a>
</div>
