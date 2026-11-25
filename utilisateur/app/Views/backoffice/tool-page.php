<section class="tool-page">
    <p class="subtitle"><?= htmlspecialchars($page['description']) ?></p>

    <?php if ($page['type'] === 'table'): ?>
        <article class="panel">
            <h2>Parkings récemment ajoutés</h2>
            <div class="table-wrap"><table>
                <thead><tr><th>Parking</th><th>Quartier</th><th>Tarif</th><th>Statut</th></tr></thead>
                <tbody>
                    <tr><td>Résidence Les Jardins du Lac</td><td>Les Berges du Lac 1</td><td>2,5 DT / h</td><td><span class="status">Actif</span></td></tr>
                    <tr><td>Garage privé Ennasr 2</td><td>Ennasr</td><td>2 DT / h</td><td><span class="status">En attente</span></td></tr>
                    <tr><td>Parking bureaux Lac 2</td><td>Les Berges du Lac 2</td><td>3 DT / h</td><td><span class="status">Actif</span></td></tr>
                </tbody>
            </table></div>
        </article>
    <?php elseif ($page['type'] === 'form'): ?>
        <article class="panel tool-panel">
            <h2><?= htmlspecialchars($page['title']) ?></h2>
            <form class="tool-form" method="post">
                <label>Nom de la plateforme<input name="platform_name" value="ParkShare"></label>
                <label>Adresse e-mail<input type="email" name="email" placeholder="admin@parkshare.tn"></label>
                <label>Langue<select name="language"><option>Français</option><option>العربية</option></select></label>
                <button type="submit">Enregistrer</button>
            </form>
        </article>
    <?php elseif ($page['type'] === 'auth'): ?>
        <article class="panel tool-panel">
            <h2><?= htmlspecialchars($page['title']) ?></h2>
            <form class="tool-form" method="post">
                <?php if ($currentPage === 'signup'): ?>
                    <label>Nom complet<input name="name" autocomplete="name" required></label>
                <?php endif; ?>
                <label>Adresse e-mail<input type="email" name="email" autocomplete="email" required></label>
                <label>Mot de passe<input type="password" name="password" autocomplete="current-password" required></label>
                <button type="submit"><?= $currentPage === 'signup' ? 'Créer un compte' : 'Se connecter' ?></button>
            </form>
            <p class="demo-note">Formulaire de démonstration — l’authentification n’est pas encore connectée.</p>
        </article>
    <?php elseif ($page['type'] === 'invoice'): ?>
        <article class="panel">
            <h2>Facture PS-2026-001</h2>
            <p>Client : Utilisateur ParkShare</p>
            <p>Réservation : Parking privé, Les Berges du Lac 1</p>
            <p>Durée : 3 heures</p>
            <strong>Total : 7,5 DT</strong>
        </article>
    <?php elseif ($page['type'] === 'alerts'): ?>
        <article class="panel">
            <h2>Messages récents</h2>
            <p class="notice notice-success">La plateforme fonctionne normalement.</p>
            <p class="notice notice-warning">Deux annonces attendent une validation.</p>
            <p class="notice notice-info">Les statistiques sont des données de démonstration.</p>
        </article>
    <?php elseif ($page['type'] === 'buttons'): ?>
        <article class="panel">
            <h2>Variantes</h2>
            <div class="button-samples"><button type="button">Principal</button><button type="button" class="secondary-button">Secondaire</button><button type="button" disabled>Désactivé</button></div>
        </article>
    <?php elseif ($page['type'] === 'cards'): ?>
        <section class="stats">
            <article><small>Utilisateurs</small><strong>1 248</strong><em>Démonstration</em></article>
            <article><small>Parkings</small><strong>312</strong><em>Démonstration</em></article>
            <article><small>Réservations</small><strong>2 480</strong><em>Démonstration</em></article>
        </section>
    <?php elseif ($page['type'] === 'typography'): ?>
        <article class="panel typography-samples">
            <h1>Titre principal</h1><h2>Titre de section</h2><h3>Sous-titre</h3>
            <p>Texte courant de l’interface ParkShare.</p><small>Texte secondaire et annotations</small>
        </article>
    <?php elseif ($page['type'] === 'icons'): ?>
        <article class="panel icon-samples">
            <span><b aria-hidden="true">⌂</b> Accueil</span>
            <span><b aria-hidden="true">P</b> Parking</span>
            <span><b aria-hidden="true">✓</b> Validation</span>
            <span><b aria-hidden="true">!</b> Alerte</span>
        </article>
    <?php else: ?>
        <article class="panel">
            <h2><?= htmlspecialchars($page['title']) ?></h2>
            <p>Cette page est prête à recevoir son contenu spécifique.</p>
        </article>
    <?php endif; ?>
</section>
