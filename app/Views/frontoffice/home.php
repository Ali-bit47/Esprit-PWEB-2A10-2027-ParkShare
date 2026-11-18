<main class="home">
    <section class="content">
        <h1>Trouvez une place de parking à <span>Tunis</span> en quelques secondes</h1>
        <p class="subtitle">Réservez une place privée près de votre destination, payez en dinars et stationnez sans tourner.</p>

        <form class="search" action="index.php" method="get">
            <input type="hidden" name="page" value="home">
            <label>Où ?<input name="lieu" value="Les Berges du Lac 1"></label>
            <label>Quand ?<input type="datetime-local" name="date"></label>
            <label>Durée<select name="duree"><option>1 heure</option><option selected>3 heures</option><option> journée</option></select></label>
            <button class="btn primary" type="button" disabled>Rechercher</button>
        </form>

        <h2>Recommandé pour vous <span class="ia">IA</span></h2>
        <?php foreach ($parkings as $index => $parking): ?>
            <article class="parking-card <?= $index === 0 ? 'featured' : '' ?>">
                <div class="parking-icon">P</div>
                <div class="parking-info">
                    <h3><?= htmlspecialchars($parking['nom']) ?></h3>
                    <p><?= htmlspecialchars($parking['distance'] ?? '') ?> · <?= htmlspecialchars($parking['type'] ?? '') ?> · <?= htmlspecialchars($parking['adresse']) ?></p>
                    <span class="tag">★ <?= htmlspecialchars($parking['note'] ?? '—') ?></span>
                </div>
                <div class="price">
                    <strong><?= htmlspecialchars($parking['prix']) ?> DT</strong>
                    <small>par heure</small>
                    <a class="reserve" href="index.php?page=reservation&parking=<?= rawurlencode((string) ($parking['nom'] ?? '')) ?>">Réserver</a>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
    <aside class="map-placeholder">
        <img src="assets/images/tunis-placeholder.svg" alt="Carte illustrative de Tunis" class="map-image">
        <div class="map-label">CARTE DE TUNIS</div>
        <div class="map-water">Lac de Tunis</div>
        <span class="map-pin pin-one">2,5 DT</span>
        <span class="map-pin pin-two">3 DT</span>
        <span class="map-pin pin-three">2 DT</span>
        <p class="map-note">Maquette illustrative — à remplacer par Leaflet + OpenStreetMap.</p>
    </aside>
</main>
