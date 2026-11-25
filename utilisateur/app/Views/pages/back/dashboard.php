<?php

$me = current_user();
$total = max(1, $stats['total']);
$roleColors = ['client' => '#E8623D', 'proprietaire' => '#F3C4B4', 'technicien' => '#7C93C3', 'admin' => '#26323A'];
?>
<div class="top">
    <div>
        <h1>Tableau de bord</h1>
        <p>Bonjour <?= e($me['prenom']) ?> · Vue d’ensemble de la plateforme · Grand Tunis</p>
    </div>
    <?php if (can('users.create')): ?>
        <a class="btn btn-primary" href="<?= url('user_create') ?>">+ Ajouter un utilisateur</a>
    <?php endif; ?>
</div>

<div class="k">
    <?php if (can('users.view')): ?>
        <div class="t live"><small>Utilisateurs inscrits</small><b><?= number_format($stats['total'], 0, ',', ' ') ?></b><i>+<?= $stats['nouveaux'] ?> ce mois</i></div>
    <?php endif; ?>
    <?php if (can('places.manage')): ?><div class="t"><small>Réservations du mois</small><b>2 480</b><i>+12 % · 18 640 DT</i></div><?php endif; ?>
    <?php if (can('evenements.manage')): ?><div class="t"><small>Événements à venir</small><b>6</b><i>412 places réservées</i></div><?php endif; ?>
    <?php if (can('forum.moderate')): ?><div class="t"><small>Publications du forum</small><b>384</b><i>+57 ce mois</i></div><?php endif; ?>
    <?php if (can('entretiens.manage')): ?><div class="t w"><small>Entretiens ouverts</small><b>7</b><i>4 en attente</i></div><?php endif; ?>
    <?php if (!can('users.view')): ?>
        <div class="t"><small>Traités ce mois</small><b>21</b><i>délai moyen 26 h</i></div>
        <div class="t w"><small>Matériel en panne</small><b>3</b><i>2 barrières · 1 borne</i></div>
    <?php endif; ?>
</div>

<div class="row">
    <?php if (can('places.manage')): ?>
    <div class="p">
        <h2>Réservations par mois <span class="demo">DÉMO</span><span class="lg"><span><i style="background:#E8623D"></i>Places</span><span><i style="background:#F3C4B4"></i>Événements</span></span></h2>
        <div class="bars">
            <?php foreach ([[8, 30], [6, 38], [12, 40], [14, 35], [16, 46], [12, 58], [15, 62], [20, 72]] as [$ev, $pl]): ?>
                <div><span class="ev" style="height:<?= $ev ?>%"></span><span class="pl" style="height:<?= $pl ?>%"></span></div>
            <?php endforeach; ?>
        </div>
        <div class="x"><span>Avr</span><span>Mai</span><span>Juin</span><span>Juil</span><span>Août</span><span>Sept</span><span>Oct</span><span>Nov</span></div>
    </div>
    <?php endif; ?>

    <?php if (can('users.view')): ?>
        
        <div class="p">
            <h2>Utilisateurs <span class="livetag">EN DIRECT</span><a href="<?= url('users') ?>">Gérer</a></h2>
            <div class="rolebar">
                <?php foreach ($roleColors as $role => $color): ?>
                    <i style="width:<?= round($stats[$role] / $total * 100, 1) ?>%;background:<?= $color ?>"></i>
                <?php endforeach; ?>
            </div>
            <div class="sum">
                <?php foreach (['client', 'proprietaire', 'technicien', 'admin'] as $role): ?>
                    <div><b><?= $stats[$role] ?></b><?= e(role_label($role)) ?>s</div>
                <?php endforeach; ?>
            </div>
            <?php foreach (array_slice($latest, 0, 3) as $u): ?>
                <div class="tk">
                    <div><b><?= e($u->getPrenom() . ' ' . $u->getNom()) ?></b><small><?= e($u->getEmail()) ?> · inscrit le <?= e(format_date($u->getCreatedAt())) ?></small></div>
                    <span class="badge badge-<?= e($u->getStatut() === 'bloque' ? 'bloque' : $u->getRole()) ?>"><?= e($u->getStatut() === 'bloque' ? 'Bloqué' : role_label($u->getRole())) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="p">
            <h2>Entretiens & traitements <span class="demo">DÉMO</span><a href="<?= url('admin_entretiens') ?>">Tout voir</a></h2>
            <div class="sum"><div><b>4</b>En attente</div><div><b>3</b>En cours</div><div><b>21</b>Traités (30 j)</div></div>
            <div class="tk"><div><b>#E-1042 · Barrière automatique</b><small>Résidence Les Jardins du Lac · Tech. Karim B.</small></div><span class="st s2">En cours</span></div>
            <div class="tk"><div><b>#E-1041 · Borne de recharge</b><small>Parking Centre Urbain Nord · non assigné</small></div><span class="st s1">En attente</span></div>
            <div class="tk"><div><b>#E-1039 · Éclairage LED</b><small>Garage privé Ennasr 2 · Tech. Amine H.</small></div><span class="st s3">Traité</span></div>
        </div>
        <?php require __DIR__ . '/_materiel_panel.php'; ?>
    <?php endif; ?>
</div>

<?php if (can('users.view')): ?>
<div class="row3">
    <?php require __DIR__ . '/_materiel_panel.php'; ?>
    <?php if (can('evenements.manage')): ?>
    <div class="p">
        <h2>Événements à venir <span class="demo">DÉMO</span></h2>
        <div class="evi"><div class="evt"><b>Match de football · Radès</b><span>29 nov</span></div><small>86 / 120 places réservées</small><div class="bar"><i style="width:72%"></i></div></div>
        <div class="evi"><div class="evt"><b>Salon de l’habitat · Le Kram</b><span>4 déc</span></div><small>140 / 200 places réservées</small><div class="bar"><i style="width:70%"></i></div></div>
        <div class="evi"><div class="evt"><b>Concert · Théâtre municipal</b><span>12 déc</span></div><small>38 / 60 places réservées</small><div class="bar"><i style="width:63%"></i></div></div>
    </div>
    <?php endif; ?>
    <div class="p">
        <h2>Publications signalées <span class="demo">DÉMO</span></h2>
        <div class="ps"><p>« Place pas chère, contactez-moi en privé »</p><small>Forum Annonces · signalée 3 fois · spam</small><div class="ac"><span class="btn btn-dark btn-sm">Masquer</span><span class="btn btn-sm">Ignorer</span></div></div>
        <div class="ps"><p>« Propriétaire injoignable, à éviter ! »</p><small>Forum Avis · signalée 2 fois · propos abusifs</small><div class="ac"><span class="btn btn-dark btn-sm">Masquer</span><span class="btn btn-sm">Ignorer</span></div></div>
    </div>
</div>
<?php endif; ?>
