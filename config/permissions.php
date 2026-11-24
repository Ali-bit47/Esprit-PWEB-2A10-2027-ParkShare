<?php


return [
    'admin' => [
        'backoffice', 'dashboard.view',
        'users.view', 'users.create', 'users.edit', 'users.delete', 'users.block', 'users.role', 'users.export',
        'places.manage', 'evenements.manage', 'forum.moderate', 'materiel.manage', 'entretiens.manage',
    ],
    'technicien' => [
        'backoffice', 'dashboard.view',
        'entretiens.manage',
    ],
    'proprietaire' => [
        'frontoffice',
        'places.publish', 'reservations.make', 'evenements.reserve', 'forum.post', 'entretiens.report',
    ],
    'client' => [
        'frontoffice',
        'reservations.make', 'evenements.reserve', 'forum.post', 'entretiens.report',
    ],
];
