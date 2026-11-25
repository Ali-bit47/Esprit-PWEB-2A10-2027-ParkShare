<?php

$me = current_user();
?>
<div class="wrap">
    <section class="hero">
        <div>
            <h1>Trouvez une place de parking à <span>Tunis</span> en quelques secondes</h1>
            <p class="sub">
                <?php if ($me): ?>Bonjour <?= e($me['prenom']) ?>, où stationnez-vous aujourd’hui ?<?php else: ?>Réservez une place près de votre destination ou pour un événement, échangez avec la communauté et signalez un équipement en panne.<?php endif; ?>
            </p>

            <form class="search" id="form-search" method="GET" action="index.php" autocomplete="off">
                <input type="hidden" name="action" value="places">
                <div class="f">
                    <label for="lieu">Où ?</label>
                    <input type="text" id="lieu" name="lieu" placeholder="Les Berges du Lac 1">
                    <small class="field-error" data-for="lieu"></small>
                </div>
                <div class="f">
                    <label for="date">Quand ?</label>
                    <input type="text" id="date" name="date" placeholder="JJ/MM/AAAA" value="<?= e(date('d/m/Y')) ?>">
                    <small class="field-error" data-for="date"></small>
                </div>
                <div class="f">
                    <label for="duree">Durée</label>
                    <select id="duree" name="duree">
                        <option value="">Choisir</option>
                        <?php foreach ([1, 2, 3, 4, 6, 8, 12, 24] as $h): ?>
                            <option value="<?= $h ?>" <?= $h === 3 ? 'selected' : '' ?>><?= $h ?> heure<?= $h > 1 ? 's' : '' ?></option>
                        <?php endforeach; ?>
                    </select>
                    <small class="field-error" data-for="duree"></small>
                </div>
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </form>

            <div class="chips">
                <a class="chip" href="<?= url('places') ?>">Place couverte</a>
                <a class="chip" href="<?= url('places') ?>">⚡ Borne de recharge</a>
                <a class="chip" href="<?= url('places') ?>">Caméra de surveillance</a>
                <a class="chip" href="<?= url('places') ?>">Barrière automatique</a>
            </div>
        </div>

        
        <div class="map" aria-label="Carte des places disponibles">
            <svg viewBox="0 0 536 286" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
                <path d="M290 296 C310 236 400 206 546 214 L546 296Z" fill="#CFE3EE"/>
                <g stroke="#fff" stroke-linecap="round" fill="none"><path d="M-10 70 L546 40" stroke-width="12"/><path d="M-10 172 L546 150" stroke-width="16"/><path d="M110 -10 L140 296" stroke-width="12"/><path d="M330 -10 L350 230" stroke-width="16"/><path d="M-10 240 L290 230" stroke-width="7"/><path d="M220 -10 L240 296" stroke-width="7"/><path d="M460 -10 L470 200" stroke-width="8"/></g>
                <g fill="#DDE7D6"><rect x="150" y="84" width="58" height="62" rx="8"/><rect x="370" y="60" width="74" height="70" rx="8"/></g>
            </svg>
            <span class="lab" style="left:4%;top:5%">CENTRE URBAIN NORD</span>
            <span class="lab" style="left:67%;top:65%">LES BERGES DU LAC 1</span>
            <span class="lab" style="left:75%;top:88%">LAC DE TUNIS</span>
            <div class="me" style="left:62%;top:53%"></div>
            <span class="pin s" style="left:69%;top:38%">2,5 DT</span>
            <span class="pin" style="left:26%;top:10%">3 DT</span>
            <span class="pin" style="left:5%;top:41%">2 DT</span>
            <span class="pin" style="left:31%;top:68%">3,5 DT</span>
            <span class="pin" style="left:86%;top:52%">4 DT</span>
            <span class="pin ev" style="left:44%;top:36%">★ Événement</span>
            <div class="mapinfo"><b>6 places</b> libres à moins de 2 km</div>
        </div>
    </section>

    <section class="grid3">
        
        <div class="panel">
            <h2>Places recommandées <span class="ia">IA</span><a href="<?= url('places') ?>">Voir tout</a></h2>
            <div class="c top"><div class="th">P</div><div><h3>Résidence Les Jardins du Lac</h3><p>350 m · Place couverte · Les Berges du Lac 1</p><span class="tag">★ 4,8</span><span class="tag eq">⚡ Borne</span><span class="tag eq">Caméra</span></div><div class="pr"><b>2,5 DT</b><small>par heure</small><a class="res" href="<?= url('places') ?>">Réserver</a></div></div>
            <div class="c"><div class="th">P</div><div><h3>Parking Centre Urbain Nord</h3><p>1,2 km · Gardé · Jusqu’à 18:00</p><span class="tag">★ 4,6</span><span class="tag eq">Barrière auto.</span><span class="tag eq">Éclairage</span></div><div class="pr"><b>3 DT</b><small>par heure</small><a class="res" href="<?= url('places') ?>">Réserver</a></div></div>
            <?php if ($me): ?>
                <div class="nx">MA PROCHAINE RÉSERVATION<b>Résidence Les Jardins du Lac · Place B-14</b>Aujourd’hui, 09:00 – 12:00 · 7,5 DT<span class="ok">Confirmée</span></div>
            <?php else: ?>
                <div class="nx">MES RÉSERVATIONS<b><a href="<?= url('login') ?>">Connectez-vous</a> pour retrouver vos réservations.</b>Inscription gratuite, paiement en dinars.</div>
            <?php endif; ?>
        </div>

        
        <div class="panel">
            <h2>Événements à venir<a href="<?= url('evenements') ?>">Tous les événements</a></h2>
            <div class="e"><div class="d"><b>29</b><small>NOV</small></div><div class="ei"><h3>Match de football · Ligue 1</h3><p>Stade Hammadi Agrebi, Radès · 15:00</p><div class="bar"><i style="width:72%"></i></div><div class="eb"><span>86 / 120 places réservées</span><a class="res" href="<?= url('evenements') ?>">Réserver · 8 DT</a></div></div></div>
            <div class="e"><div class="d"><b>04</b><small>DÉC</small></div><div class="ei"><h3>Salon de l’habitat</h3><p>Parc des expositions du Kram · 10:00</p><div class="bar"><i style="width:70%"></i></div><div class="eb"><span>140 / 200 places réservées</span><a class="res" href="<?= url('evenements') ?>">Réserver · 5 DT</a></div></div></div>
            <div class="nx">Place réservée = accès garanti le jour J, même quand le parking de l’événement affiche complet.</div>
        </div>

        
        <div class="panel">
            <h2>Forum de la communauté<a class="new" href="<?= url('forum') ?>">+ Publier</a></h2>
            <div class="post"><div class="avatar soft">SB</div><div><h3>Astuce : se garer aux Berges du Lac le samedi</h3><p>Sarra B. · il y a 2 h · 14 réponses</p></div></div>
            <div class="post"><div class="avatar soft">MK</div><div><h3>Quel tarif pour louer ma place à Ennasr ?</h3><p>Mehdi K. · il y a 5 h · 9 réponses</p></div></div>
            <div class="post"><div class="avatar soft">NA</div><div><h3>Retour sur le parking du Salon de l’habitat</h3><p>Nour A. · hier · 6 réponses</p></div></div>
            <div class="sig"><h3>Un équipement en panne ?</h3><p>Barrière, éclairage, borne de recharge : signalez-le et suivez son traitement.</p><div class="row"><span>#E-1042 · Barrière <span class="st">En cours</span></span><a class="bt" href="<?= url('signalement') ?>">Signaler</a></div></div>
        </div>
    </section>
</div>
