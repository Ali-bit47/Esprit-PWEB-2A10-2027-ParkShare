# ParkShare - Architecture MVC

Structure de départ pour organiser les templates Front Office et Back Office en PHP MVC.

## Démarrage
1. Placez le dossier `ParkShare_MVC` dans `htdocs` (XAMPP) ou le répertoire du serveur PHP.
2. Configurez `config/database.php` avec vos identifiants MySQL.
3. Ouvrez `http://localhost/ParkShare_MVC/public/`.

## Organisation
- `app/Models` : accès aux données et requêtes SQL.
- `app/Controllers` : traitement des requêtes.
- `app/Views` : affichage HTML/PHP.
- `public/assets` : CSS, JavaScript et images.
- `public/index.php` : point d'entrée et routage simple.

Les données de démonstration sont utilisées tant que la base de données n'est pas configurée.

## Templates intégrés
- `app/Views/layouts/frontoffice.php` : layout du site public.
- `app/Views/layouts/backoffice.php` : layout de l'administration.
- `app/Views/partials/front` : head, navbar, footer et scripts du Front Office.
- `app/Views/partials/admin` : head, sidebar, header, footer et scripts du Back Office.
- `app/routes.php` : table centralisée des routes.
- Les pages Front Office `about`, `courses`, `team`, `testimonial` et `contact`, ainsi que les pages de démonstration Back Office, sont accessibles via `index.php?page=<clé>`.

Les pages ajoutées sont des maquettes ParkShare utilisant les layouts existants. Les fichiers sources eLearning et TailAdmin ne faisant pas partie du dépôt, ces pages ne reproduisent pas leurs templates d'origine à l'identique. Les formulaires de connexion, inscription et paramètres restent des exemples sans persistance.
