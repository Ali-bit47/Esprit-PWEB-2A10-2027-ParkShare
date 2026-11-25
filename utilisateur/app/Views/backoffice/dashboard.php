    <section class="stats">
        <article><small>Utilisateurs inscrits</small><strong><?= htmlspecialchars($stats['utilisateurs']) ?></strong><em>+86 ce mois</em></article>
        <article><small>Parkings actifs</small><strong><?= htmlspecialchars($stats['parkings']) ?></strong><em>+24 ce mois</em></article>
        <article><small>Réservations du mois</small><strong><?= htmlspecialchars($stats['reservations']) ?></strong><em>+12 %</em></article>
        <article><small>Revenus du mois</small><strong><?= htmlspecialchars($stats['revenus']) ?></strong><em>+9 %</em></article>
    </section>
    <section class="panels">
        <article class="panel"><h2>Réservations par mois</h2><div class="chart">
            <?php foreach ([38,46,52,49,63,71,78,92] as $height): ?>
                <span style="height:<?= $height ?>%"></span>
            <?php endforeach; ?>
        </div><div class="months">Avr · Mai · Juin · Juil · Août · Sept · Oct · Nov</div></article>
        <article class="panel"><h2>Quartiers les plus demandés</h2>
            <?php foreach (['Les Berges du Lac 1' => '24 %', 'Centre-ville de Tunis' => '21 %', 'Ennasr' => '17 %', 'La Marsa' => '14 %', 'Centre Urbain Nord' => '11 %'] as $district => $percent): ?>
                <div class="district"><span><?= htmlspecialchars($district) ?></span><strong><?= $percent ?></strong></div>
            <?php endforeach; ?>
        </article>
    </section>
    <section class="panel pending"><h2>Annonces de parkings en attente de validation</h2>
        <div class="table-wrap"><table>
            <thead><tr><th>Parking</th><th>Propriétaire</th><th>Quartier</th><th>Tarif</th><th>Statut</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ([['id' => 1, 'parking' => 'Garage privé Ennasr 2', 'owner' => 'Particulier', 'district' => 'Ennasr', 'price' => '2 DT / h'], ['id' => 2, 'parking' => 'Parking bureaux Lac 2', 'owner' => 'Entreprise', 'district' => 'Les Berges du Lac 2', 'price' => '3 DT / h'], ['id' => 3, 'parking' => 'Cour résidence La Marsa', 'owner' => 'Particulier', 'district' => 'La Marsa', 'price' => '2,5 DT / h']] as $announcement): ?>
            <tr>
                <td><?= htmlspecialchars($announcement['parking']) ?></td>
                <td><?= htmlspecialchars($announcement['owner']) ?></td>
                <td><?= htmlspecialchars($announcement['district']) ?></td>
                <td><?= htmlspecialchars($announcement['price']) ?></td>
                <td><span class="status">En attente</span></td>
                <td>
                    <form method="post" action="index.php?page=admin" class="action-form">
                        <input type="hidden" name="parking_id" value="<?= (int) $announcement['id'] ?>">
                        <button type="submit" name="action" value="validate">Valider</button>
                        <button type="submit" name="action" value="reject" class="reject">Refuser</button>
                    </form>
                </td>
            </tr>
            <?php endforeach ?>
            </tbody>
        </table></div>
    </section>
