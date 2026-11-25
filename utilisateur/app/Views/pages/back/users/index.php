<?php

$query = array_filter($filters, fn($v) => $v !== '' && $v !== 'recent');
$meId = (int) $_SESSION['user_id'];
?>
<div class="top">
    <div>
        <div class="crumb"><a href="<?= url('admin') ?>">Tableau de bord</a> / Utilisateurs</div>
        <h1>Gestion des utilisateurs</h1>
        <p><?= $stats['total'] ?> comptes · <?= $stats['bloques'] ?> bloqué(s)</p>
    </div>
    <div style="display:flex;gap:10px">
        <?php if (can('users.export')): ?>
            <a class="btn" href="<?= url('users_export', $query) ?>">Exporter (CSV)</a>
        <?php endif; ?>
        <?php if (can('users.create')): ?>
            <a class="btn btn-primary" href="<?= url('user_create') ?>">+ Ajouter un utilisateur</a>
        <?php endif; ?>
    </div>
</div>

<div class="chips-stats">
    <a class="<?= $filters['role'] === '' ? 'active' : '' ?>" href="<?= url('users', array_diff_key($query, ['role' => 1])) ?>">Tous <b><?= $stats['total'] ?></b></a>
    <?php foreach (AuthController::ALL_ROLES as $role): ?>
        <a class="<?= $filters['role'] === $role ? 'active' : '' ?>" href="<?= url('users', array_merge($query, ['role' => $role])) ?>"><?= e(role_label($role)) ?>s <b><?= $stats[$role] ?></b></a>
    <?php endforeach; ?>
</div>

<div class="p">
    <form class="toolbar" id="form-filters" method="GET" action="index.php">
        <input type="hidden" name="action" value="users">
        <div class="field grow">
            <label for="q">Recherche</label>
            <input class="input" type="text" id="q" name="q" value="<?= e($filters['q']) ?>" placeholder="Nom, prénom, email, téléphone…">
            <small class="field-error" data-for="q"></small>
        </div>
        <div class="field">
            <label for="f-role">Rôle</label>
            <select class="select js-autosubmit" id="f-role" name="role">
                <option value="">Tous</option>
                <?php foreach (AuthController::ALL_ROLES as $role): ?>
                    <option value="<?= e($role) ?>" <?= $filters['role'] === $role ? 'selected' : '' ?>><?= e(role_label($role)) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="field">
            <label for="f-statut">Statut</label>
            <select class="select js-autosubmit" id="f-statut" name="statut">
                <option value="">Tous</option>
                <option value="actif" <?= $filters['statut'] === 'actif' ? 'selected' : '' ?>>Actif</option>
                <option value="bloque" <?= $filters['statut'] === 'bloque' ? 'selected' : '' ?>>Bloqué</option>
            </select>
        </div>
        <div class="field">
            <label for="f-sort">Trier par</label>
            <select class="select js-autosubmit" id="f-sort" name="sort">
                <?php foreach (['recent' => 'Plus récents', 'ancien' => 'Plus anciens', 'nom' => 'Nom (A→Z)', 'email' => 'Email', 'role' => 'Rôle'] as $k => $label): ?>
                    <option value="<?= $k ?>" <?= $filters['sort'] === $k ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-dark">Filtrer</button>
        <?php if ($query): ?><a class="btn" href="<?= url('users') ?>">Réinitialiser</a><?php endif; ?>
    </form>

    <div class="table-wrap">
    <table class="data">
        <thead>
            <tr><th>Utilisateur</th><th>Contact</th><th>Rôle</th><th>Statut</th><th>Activité</th><th></th></tr>
        </thead>
        <tbody>
        <?php if (!$users): ?>
            <tr><td colspan="6" class="empty">Aucun utilisateur ne correspond à ces critères.</td></tr>
        <?php endif; ?>
        <?php foreach ($users as $u):  ?>
            <tr>
                <td>
                    <a class="who-cell" href="<?= url('user_show', ['id' => $u->getId()]) ?>">
                        <span class="avatar"><?= e(initials($u->getPrenom(), $u->getNom())) ?></span>
                        <span><b><?= e($u->getPrenom() . ' ' . $u->getNom()) ?></b><small>@<?= e($u->getUsername()) ?></small></span>
                    </a>
                </td>
                <td><?= e($u->getEmail()) ?><br><small class="muted"><?= e($u->getTelephone()) ?></small></td>
                <td><span class="badge badge-<?= e($u->getRole()) ?>"><?= e(role_label($u->getRole())) ?></span></td>
                <td><span class="badge badge-<?= e($u->getStatut()) ?>"><?= e(statut_label($u->getStatut())) ?></span></td>
                <td style="white-space:nowrap"><?= e(format_date($u->getCreatedAt())) ?><br><small class="muted">Vu : <?= e(format_date($u->getLastLogin())) ?></small></td>
                <td>
                    <div class="actions">
                        <?php if (can('users.edit')): ?>
                            <a class="btn btn-sm" href="<?= url('user_edit', ['id' => $u->getId()]) ?>">Modifier</a>
                        <?php endif; ?>
                        <?php if ($u->getId() !== $meId && can('users.block')): ?>
                            <form class="inline js-confirm" method="POST" action="<?= url('user_toggle') ?>"
                                  data-confirm="<?= $u->getStatut() === 'actif' ? 'Bloquer' : 'Débloquer' ?> le compte de <?= e($u->getPrenom() . ' ' . $u->getNom()) ?> ?">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= $u->getId() ?>">
                                <button type="submit" class="btn btn-sm"><?= $u->getStatut() === 'actif' ? 'Bloquer' : 'Débloquer' ?></button>
                            </form>
                        <?php endif; ?>
                        <?php if ($u->getId() !== $meId && can('users.delete')): ?>
                            <form class="inline js-confirm" method="POST" action="<?= url('user_delete') ?>"
                                  data-confirm="Supprimer définitivement le compte de <?= e($u->getPrenom() . ' ' . $u->getNom()) ?> ?">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= $u->getId() ?>">
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>

    <div class="pagination">
        <span><?= $total ?> résultat(s) · page <?= $page ?> / <?= $pages ?></span>
        <?php if ($pages > 1): ?>
            <nav aria-label="Pagination">
                <?php if ($page > 1): ?><a href="<?= url('users', array_merge($query, ['page' => $page - 1])) ?>">‹</a><?php endif; ?>
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <?php if ($i === $page): ?><span class="cur"><?= $i ?></span>
                    <?php else: ?><a href="<?= url('users', array_merge($query, ['page' => $i])) ?>"><?= $i ?></a><?php endif; ?>
                <?php endfor; ?>
                <?php if ($page < $pages): ?><a href="<?= url('users', array_merge($query, ['page' => $page + 1])) ?>">›</a><?php endif; ?>
            </nav>
        <?php endif; ?>
    </div>
</div>
