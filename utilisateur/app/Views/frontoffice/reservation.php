<main class="home">
    <section class="content">
        <h1>Réserver <?= $parking !== '' ? htmlspecialchars($parking) : 'une place' ?></h1>
        <form class="search" method="post" action="index.php?page=reservation">
            <input type="hidden" name="parking" value="<?= htmlspecialchars($parking) ?>">
            <label>Quand ?<input type="datetime-local" name="date" required></label>
            <label>Durée<select name="duree"><option>1 heure</option><option selected>3 heures</option><option>1 journée</option></select></label>
            <button class="btn primary" type="submit">Confirmer</button>
        </form>
        <?php if ($reservationSubmitted): ?>
            <p class="success">Votre demande de réservation pour <?= htmlspecialchars($parking) ?> a été enregistrée.</p>
        <?php endif; ?>
    </section>
</main>
