<nav class="navbar">
    <a class="logo" href="index.php">Park<span>Share</span></a>
    <div class="links">
        <a class="<?= in_array($currentPage ?? 'home', ['home', 'reservation'], true) ? 'active' : '' ?>" href="index.php?page=home">Trouver une place</a>
        <a class="<?= ($currentPage ?? '') === 'about' ? 'active' : '' ?>" href="index.php?page=about">Louer ma place</a>
        <a class="<?= ($currentPage ?? '') === 'courses' ? 'active' : '' ?>" href="index.php?page=courses">Comment ça marche</a>
        <a class="<?= ($currentPage ?? '') === 'team' ? 'active' : '' ?>" href="index.php?page=team">Entreprises</a>
        <a class="<?= ($currentPage ?? '') === 'testimonial' ? 'active' : '' ?>" href="index.php?page=testimonial">Avis</a>
        <a class="<?= ($currentPage ?? '') === 'contact' ? 'active' : '' ?>" href="index.php?page=contact">Contact</a>
    </div>
    <div class="actions">
        <a class="btn" href="index.php?page=signin">Connexion</a>
        <a class="btn primary" href="index.php?page=signup">S'inscrire</a>
    </div>
</nav>
