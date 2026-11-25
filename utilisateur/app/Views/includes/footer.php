<?php  ?>
<footer class="footer">
    <div class="wrap">
        <div>
            <div class="brand">Park<span>Share</span></div>
            <p>La plateforme tunisienne qui connecte automobilistes, particuliers et entreprises pour partager les places de parking inutilisées.</p>
        </div>
        <div>
            <h4>ParkShare</h4>
            <ul>
                <li><a href="<?= url('home') ?>">Trouver une place</a></li>
                <li><a href="<?= url('evenements') ?>">Événements</a></li>
                <li><a href="<?= url('forum') ?>">Forum</a></li>
                <li><a href="<?= url('materiel') ?>">Matériel</a></li>
            </ul>
        </div>
        <div>
            <h4>Mon compte</h4>
            <ul>
                <?php if (current_user()): ?>
                    <li><a href="<?= url('profile') ?>">Mon profil</a></li>
                    <li><a href="<?= url('reservations') ?>">Mes réservations</a></li>
                    <li><a href="<?= url('signalement') ?>">Signaler une panne</a></li>
                <?php else: ?>
                    <li><a href="<?= url('login') ?>">Connexion</a></li>
                    <li><a href="<?= url('register') ?>">Créer un compte</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div>
            <h4>Contact</h4>
            <ul>
                <li>Les Berges du Lac 1, Tunis</li>
                <li>contact@parkshare.tn</li>
                <li>+216 71 000 000</li>
            </ul>
        </div>
    </div>
    <div class="copy">
        <div class="wrap">
            <span>© <?= date('Y') ?> ParkShare · Smart Parking Economy</span>
            <span>Projet Technologies Web 2A</span>
        </div>
    </div>
</footer>


<a href="#top" class="back-to-top" aria-label="Retour en haut">↑</a>
