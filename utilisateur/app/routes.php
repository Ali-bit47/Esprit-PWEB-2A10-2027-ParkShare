<?php

return [
    'home'             => ['HomeController', 'index'],

    'login'            => ['AuthController', 'login'],
    'register'         => ['AuthController', 'register'],
    'logout'           => ['AuthController', 'logout'],

    'profile'          => ['ProfileController', 'show'],
    'profile_edit'     => ['ProfileController', 'edit'],
    'password'         => ['ProfileController', 'password'],
    'profile_delete'   => ['ProfileController', 'delete'],

    'admin'            => ['DashboardController', 'index'],

    'users'            => ['UserController', 'index'],
    'user_create'      => ['UserController', 'create'],
    'user_show'        => ['UserController', 'show'],
    'user_edit'        => ['UserController', 'edit'],
    'user_delete'      => ['UserController', 'delete'],
    'user_toggle'      => ['UserController', 'toggleStatus'],
    'users_export'     => ['UserController', 'export'],

    'places'           => ['ModuleController', 'front', 'places'],
    'evenements'       => ['ModuleController', 'front', 'evenements'],
    'forum'            => ['ModuleController', 'front', 'forum'],
    'materiel'         => ['ModuleController', 'front', 'materiel'],
    'reservations'     => ['ModuleController', 'front', 'reservations'],
    'signalement'      => ['ModuleController', 'front', 'entretiens'],

    'admin_places'     => ['ModuleController', 'back', 'places'],
    'admin_evenements' => ['ModuleController', 'back', 'evenements'],
    'admin_forum'      => ['ModuleController', 'back', 'forum'],
    'admin_materiel'   => ['ModuleController', 'back', 'materiel'],
    'admin_entretiens' => ['ModuleController', 'back', 'entretiens'],
];
