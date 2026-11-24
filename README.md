# ParkShare · Smart Parking Economy

Plateforme web tunisienne qui connecte **propriétaires de parkings privés**, **entreprises** et **automobilistes** pour louer les places de stationnement inutilisées, avec recommandation par IA et géolocalisation.

Projet Technologies Web 2A · 2026-2027 · PHP natif, architecture **MVC**, MySQL.

---

## Sommaire

1. [Fonctionnalités](#1-fonctionnalités)
2. [Technologies](#2-technologies)
3. [Structure du projet (MVC)](#3-structure-du-projet-mvc)
4. [Installation et configuration](#4-installation-et-configuration)
5. [Exécution](#5-exécution)
6. [Comptes de démonstration](#6-comptes-de-démonstration)
7. [Rôles et autorisations](#7-rôles-et-autorisations)
8. [Sécurité et sessions](#8-sécurité-et-sessions)
9. [Contrôle et validation des saisies](#9-contrôle-et-validation-des-saisies)
10. [Intégrer un nouveau module](#10-intégrer-un-nouveau-module)
11. [Travail en équipe (Git et GitHub Project)](#11-travail-en-équipe-git-et-github-project)
12. [Équipe](#12-équipe)

---

## 1. Fonctionnalités

### Modules du projet

| Module | Entités | État |
|---|---|---|
| Gestion des utilisateurs (commun) | Utilisateur | ✅ Intégré |
| Gestion des places de parking et des réservations | PlaceParking – Reservation | Page d’attente |
| Gestion du forum et des publications | Forum – Publication | Page d’attente |
| Gestion de l’entretien du matériel | Entretien – Traitement | Page d’attente |
| Gestion des événements et des réservations | Evenement – ReservationEvenement | Page d’attente |
| Gestion des catégories de matériel | CategorieMateriel – Materiel | Page d’attente |

### Module Gestion des utilisateurs

**Front Office (visiteurs, automobilistes, propriétaires)**
- Inscription avec choix du profil (automobiliste ou propriétaire), jamais technicien ni administrateur
- Connexion, déconnexion, retour automatique vers la page demandée avant la connexion
- Espace personnel : consulter son profil, modifier ses informations, changer son mot de passe, supprimer son compte (confirmation par mot de passe)

**Back Office (administrateur)**
- **CRUD complet** : ajouter, consulter (fiche détaillée), modifier, supprimer un utilisateur
- **Gestion des rôles** : automobiliste, propriétaire, technicien, administrateur
- **Bloquer / débloquer** un compte (la session d’un compte bloqué est fermée à sa requête suivante)
- Recherche (nom, prénom, email, téléphone), filtres par rôle et statut, tri, pagination
- Compteurs par rôle, export **CSV** de la liste filtrée (compatible Excel)
- Tableau de bord avec statistiques réelles des utilisateurs
- Règles métier : un administrateur ne peut ni se supprimer, ni se bloquer, ni changer son propre rôle ; la plateforme garde toujours au moins un administrateur

**Back Office (technicien)** : accès limité au tableau de bord et au module Entretiens & traitements.

---

## 2. Technologies

| Couche | Choix |
|---|---|
| Serveur | PHP 8.1 ou plus (testé avec PHP 8.3) |
| Base de données | MySQL 5.7+ / MariaDB 10.4+ (XAMPP, WAMP) avec PDO |
| Front | HTML, CSS (templates ParkShare sur mesure), JavaScript natif |
| Police | Inter, hébergée localement dans `app/Views/assets/fonts` |

Aucune dépendance Composer ou npm : le projet fonctionne tel quel avec XAMPP.

---

## 3. Structure du projet (MVC)

```
parkshare/
├── index.php                  # Point d'entrée unique : session, sécurité, routage (?action=)
├── config/
│   ├── config.php             # Identifiants MySQL, durée de session, paramètres
│   ├── database.php           # Classe Database (Singleton PDO)
│   └── permissions.php        # Matrice rôles → permissions
├── database/
│   └── parkshare.sql          # Création de la base + comptes de démonstration
├── app/
│   ├── routes.php             # Table action → [Contrôleur, méthode]
│   ├── helpers.php            # e(), url(), isActive(), csrf_field(), flash()...
│   ├── Controllers/           # Logique métier : SQL préparé, validation, sessions, rôles
│   │   ├── Controller.php     # Contrôleur de base : render() + layout
│   │   ├── AuthController.php # Inscription, connexion, sessions, rôles, CSRF, règles de validation
│   │   ├── UserController.php # CRUD des utilisateurs (Back Office)
│   │   ├── ProfileController.php
│   │   ├── DashboardController.php
│   │   ├── HomeController.php
│   │   └── ModuleController.php  # Pages d'attente des autres modules
│   ├── Models/
│   │   └── UserModel.php      # Attributs privés + getters/setters + fromArray() (aucun SQL)
│   └── Views/                 # Affichage uniquement (htmlspecialchars), aucune requête SQL
│       ├── layout.php         # Layout Front Office
│       ├── layout_admin.php   # Layout Back Office
│       ├── includes/          # Blocs communs Front : head, navbar, footer, scripts
│       ├── partials/          # Blocs communs Back : head, sidebar, header, footer, scripts
│       ├── pages/
│       │   ├── front/         # home, login, register, profile, ...
│       │   ├── back/          # dashboard, users/index, users/form, users/show, ...
│       │   ├── shared/        # Fragments communs (formulaires de profil, erreurs)
│       │   └── errors/        # Page d'erreur 403 / 404 / 405
│       └── assets/
│           ├── css/           # base.css, front.css, back.css
│           ├── js/            # validation.js (moteur), forms.js (règles), app.js
│           ├── img/           # logo, favicon
│           ├── fonts/         # Inter
│           └── lib/           # Bibliothèques tierces (ex. Leaflet pour la carte)
└── docs/
    └── GIT-WORKFLOW.md        # Organisation Git, branches, GitHub Project Board
```

**Circuit d’une requête** : le navigateur appelle `index.php?action=users` → `index.php` sécurise la session et consulte `app/routes.php` → `UserController::index()` vérifie la permission, interroge la base et prépare les données → `render()` capture la vue `pages/back/users/index.php` dans `$content` → `layout_admin.php` assemble `partials/` autour du contenu.

---

## 4. Installation et configuration

### Avec XAMPP (ou WAMP)

1. Copier le dossier du projet dans `C:\xampp\htdocs\parkshare` (ou `www` pour WAMP).
2. Démarrer **Apache** et **MySQL** depuis le panneau XAMPP.
3. Ouvrir **phpMyAdmin** (http://localhost/phpmyadmin), onglet **SQL**, coller le contenu de `database/parkshare.sql` et cliquer sur **Exécuter**.
   La base `parkshare`, la table `users` et les comptes de démonstration sont créés.
4. Si votre MySQL a un mot de passe ou un autre nom de base, modifier `config/config.php` :

   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'parkshare');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

### En ligne de commande

```bash
mysql -u root -p < database/parkshare.sql
```

---

## 5. Exécution

- XAMPP : http://localhost/parkshare/index.php
- Serveur intégré de PHP, depuis le dossier du projet :

  ```bash
  php -S localhost:8000
  ```

  puis http://localhost:8000/index.php

| Page | URL |
|---|---|
| Accueil (Front Office) | `index.php?action=home` |
| Connexion / Inscription | `index.php?action=login` · `index.php?action=register` |
| Mon profil | `index.php?action=profile` |
| Tableau de bord (Back Office) | `index.php?action=admin` |
| Gestion des utilisateurs | `index.php?action=users` |

---

## 6. Comptes de démonstration

| Rôle | Email | Mot de passe | Espace |
|---|---|---|---|
| Administrateur | admin@parkshare.tn | `Admin@2026` | Back Office complet |
| Technicien | technicien@parkshare.tn | `Tech@2026` | Back Office limité |
| Propriétaire | proprietaire@parkshare.tn | `Proprio@2026` | Front Office |
| Automobiliste | client@parkshare.tn | `Client@2026` | Front Office |

Le compte `yassine.gharbi@yahoo.fr` est **bloqué** pour tester le refus de connexion.
⚠️ Changer ces mots de passe avant toute mise en ligne.

---

## 7. Rôles et autorisations

Les droits sont centralisés dans `config/permissions.php`. Chaque action sensible appelle `AuthController::requirePermission('...')` **côté serveur** : masquer un lien dans le menu ne suffit jamais.

| Permission | Automobiliste | Propriétaire | Technicien | Admin |
|---|:-:|:-:|:-:|:-:|
| Front Office, réserver, forum, signaler une panne | ✅ | ✅ | | |
| Publier ses places | | ✅ | | |
| Back Office + tableau de bord | | | ✅ | ✅ |
| Entretiens & traitements | | | ✅ | ✅ |
| Utilisateurs : voir, ajouter, modifier, supprimer, bloquer, changer le rôle, exporter | | | | ✅ |
| Places, événements, forum, matériel (Back Office) | | | | ✅ |

Un accès refusé renvoie une page **403** ; un visiteur non connecté est redirigé vers la connexion.

---

## 8. Sécurité et sessions

Mise en œuvre du workshop « Sessions et Sécurité PHP » :

| Risque | Protection | Où ? |
|---|---|---|
| Injection SQL | Requêtes préparées PDO, `ATTR_EMULATE_PREPARES = false`, listes blanches pour le tri et les filtres | Contrôleurs, `config/database.php` |
| Mots de passe en clair | `password_hash()` (bcrypt + sel) / `password_verify()`, ré-hachage automatique | `AuthController`, `UserController`, `ProfileController` |
| XSS | `htmlspecialchars()` en sortie (fonction `e()`), validation des entrées, en-tête Content-Security-Policy (aucun script inline) | Vues, `index.php` |
| CSRF | Jeton unique par session dans chaque formulaire POST, vérifié avec `hash_equals()` | `AuthController`, `csrf_field()` |
| Fixation de session | `session_regenerate_id(true)` après connexion et changement de mot de passe | `AuthController::attemptLogin()` |
| Vol de session | Cookie `HttpOnly`, `SameSite=Lax`, `use_strict_mode`, `use_only_cookies` | `index.php` |
| Clickjacking / MIME | `X-Frame-Options: DENY`, `X-Content-Type-Options: nosniff`, `Referrer-Policy` | `index.php` |
| Élévation de privilèges | Rôle en liste blanche à l’inscription, `requirePermission()` sur chaque page, rôle relu en base à chaque requête | `AuthController`, `index.php` |
| Force brute | Verrouillage du compte 15 minutes après 5 échecs, message générique | `AuthController` |
| Sessions abandonnées | Expiration après 30 minutes d’inactivité | `index.php` |
| Pages en cache après déconnexion | `Cache-Control: no-store` | `index.php` |
| Suppression par lien piégé | Suppression, blocage et déconnexion uniquement en POST + CSRF (GET → 405) | `UserController`, `AuthController` |
| Injection de formules CSV | Préfixe `'` devant `=`, `+`, `-`, `@` dans l’export | `UserController::export()` |

---

## 9. Contrôle et validation des saisies

**Aucun attribut de validation HTML5** n’est utilisé (`required`, `pattern`, `type="email"`, `minlength`...). Chaque formulaire est contrôlé **deux fois** :

1. **JavaScript** (`assets/js/validation.js` + `assets/js/forms.js`) : messages sous chaque champ, en direct et à l’envoi, envoi bloqué tant qu’une erreur existe.
2. **PHP** (`AuthController::validateUserInput()` et contrôleurs) : toujours exécuté, même si JavaScript est désactivé ou contourné.

| Champ | Règle (identique en JS et en PHP) |
|---|---|
| Nom, prénom | Obligatoire, 2 à 50 lettres (accents, espaces, tiret, apostrophe) |
| Nom d’utilisateur | Obligatoire, 3 à 50 caractères : lettres, chiffres, `.` `_` `-`, unique |
| Email | Obligatoire, format valide, 150 caractères max., unique |
| Téléphone | Obligatoire, numéro tunisien de 8 chiffres commençant par 2, 3, 4, 5, 7 ou 9 (`+216` et espaces acceptés) |
| Mot de passe | 8 à 72 caractères, au moins une majuscule, une minuscule et un chiffre ; confirmation identique |
| Rôle, statut | Liste blanche (le formulaire public n’accepte que automobiliste / propriétaire) |
| Conditions d’utilisation | Case obligatoire à l’inscription |
| Recherche de place (accueil) | Lieu 2 à 100 caractères, date `JJ/MM/AAAA` valide et non passée, durée dans une liste |
| Recherche d’utilisateurs | 100 caractères max., `<` et `>` interdits |

**Réutiliser le moteur pour un autre module** : ajouter dans `forms.js`

```js
PSValidator.attach('form-place', {
  adresse: [['required', 'Adresse obligatoire.'], ['minLen', 5, '5 caractères minimum.']],
  tarif:   [['required', 'Tarif obligatoire.'], ['pattern', /^\d+(,\d{1,3})?$/, 'Tarif invalide (ex : 2,5).']]
});
```

et refaire les mêmes contrôles en PHP dans le contrôleur du module.

---

## 10. Intégrer un nouveau module

Exemple pour le module Places de parking :

1. Créer `app/Models/PlaceModel.php` (attributs privés, getters/setters, `fromArray()`).
2. Créer `app/Controllers/PlaceController.php` qui `extends Controller` ; en tête de chaque méthode : `AuthController::requireAuth()` ou `AuthController::requirePermission('places.manage')`.
3. Créer les vues dans `app/Views/pages/front/places/` et `app/Views/pages/back/places/` (HTML pur, `e()` pour tout affichage).
4. Afficher avec `$this->render('back/places/index', [...], 'admin')` : le layout et les partials sont ajoutés automatiquement.
5. Dans `app/routes.php`, remplacer la ligne `'places' => ['ModuleController', ...]` par `'places' => ['PlaceController', 'index']`.
6. Ajouter le script SQL des nouvelles tables dans `database/` (clé étrangère vers `users(id)` pour la jointure avec Utilisateur).

---

## 11. Travail en équipe (Git et GitHub Project)

Voir **[docs/GIT-WORKFLOW.md](docs/GIT-WORKFLOW.md)** : une branche par module, Pull Requests vers `main`, tâches suivies dans le GitHub Project Board, procédure de préparation de la machine de validation.

⚠️ Le nom du repository doit respecter la nomenclature communiquée par l’enseignant.

---

## 12. Équipe

| Membre | Module |
|---|---|
| Ali Lajnef | *à compléter* |
| Malek Lassoued | *à compléter* |
| Amenallah Belgesmi | *à compléter* |
| Elyes Hajji | *à compléter* |
| Omar Ben Ammar | *à compléter* |

Le module **Gestion des utilisateurs** est réalisé en commun par les cinq membres.
