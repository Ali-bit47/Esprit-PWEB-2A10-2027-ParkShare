<main class="info-page">
    <section class="info-intro">
        <p class="eyebrow">PARKSHARE · GRAND TUNIS</p>
        <h1><?= htmlspecialchars($page['title']) ?></h1>
        <p class="subtitle"><?= htmlspecialchars($page['description']) ?></p>
        <?php if ($currentPage === 'contact'): ?>
            <a class="btn primary" href="mailto:contact@parkshare.tn">Écrire à ParkShare</a>
        <?php else: ?>
            <a class="btn primary" href="index.php?page=home">Trouver une place</a>
        <?php endif; ?>
    </section>
    <section class="info-cards" aria-label="Informations">
        <?php foreach ($page['items'] as $item): ?>
            <article class="info-card">
                <h2><?= htmlspecialchars($item['title']) ?></h2>
                <p><?= htmlspecialchars($item['text']) ?></p>
            </article>
        <?php endforeach; ?>
    </section>
</main>
