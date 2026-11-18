<aside class="sidebar">
    <div class="brand">Park<span>Share</span></div>
    <p class="role">ADMINISTRATION</p>
    <a class="<?= ($currentPage ?? '') === 'admin' ? 'active' : '' ?>" href="index.php?page=admin">Tableau de bord</a>
    <a href="#utilisateurs">Utilisateurs</a>
    <a href="index.php?page=tables">Parkings <b>4</b></a>
    <a href="#reservations">Réservations</a>
    <a href="#paiements">Paiements</a>
    <a href="#avis">Avis</a>
    <a class="<?= ($currentPage ?? '') === 'alerts' ? 'active' : '' ?>" href="index.php?page=alerts">Réclamations <b>2</b></a>
    <a class="<?= ($currentPage ?? '') === 'notification' ? 'active' : '' ?>" href="index.php?page=notification">Notifications</a>
    <a href="index.php?page=admin#statistiques">Statistiques</a>
    <p class="role">PAGES DE DÉMONSTRATION</p>
    <a class="<?= ($currentPage ?? '') === 'settings' ? 'active' : '' ?>" href="index.php?page=settings">Paramètres</a>
    <a class="<?= ($currentPage ?? '') === 'blank-page' ? 'active' : '' ?>" href="index.php?page=blank-page">Page vierge</a>
    <a class="<?= ($currentPage ?? '') === 'buttons' ? 'active' : '' ?>" href="index.php?page=buttons">Boutons</a>
    <a class="<?= ($currentPage ?? '') === 'cards' ? 'active' : '' ?>" href="index.php?page=cards">Cartes</a>
    <a class="<?= ($currentPage ?? '') === 'typography' ? 'active' : '' ?>" href="index.php?page=typography">Typographie</a>
    <a class="<?= ($currentPage ?? '') === 'icons' ? 'active' : '' ?>" href="index.php?page=icons">Icônes</a>
    <a class="<?= ($currentPage ?? '') === 'mdi-icons' ? 'active' : '' ?>" href="index.php?page=mdi-icons">Icônes MDI</a>
    <a class="<?= ($currentPage ?? '') === 'form-elements' ? 'active' : '' ?>" href="index.php?page=form-elements">Formulaires</a>
    <a class="<?= ($currentPage ?? '') === 'tables' ? 'active' : '' ?>" href="index.php?page=tables">Tableaux</a>
    <a class="<?= ($currentPage ?? '') === 'invoice' ? 'active' : '' ?>" href="index.php?page=invoice">Facture</a>
    <a class="<?= ($currentPage ?? '') === 'signin' ? 'active' : '' ?>" href="index.php?page=signin">Connexion</a>
    <a class="<?= ($currentPage ?? '') === 'signup' ? 'active' : '' ?>" href="index.php?page=signup">Inscription</a>
</aside>
