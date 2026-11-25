<?php
class AdminPageController
{
    protected function renderPage(string $key): void
    {
        $pages = [
            'tables' => ['title' => 'Tableaux', 'description' => 'Exemple de tableau de données ParkShare.', 'type' => 'table'],
            'signin' => ['title' => 'Connexion', 'description' => 'Maquette de connexion à l’administration.', 'type' => 'auth'],
            'settings' => ['title' => 'Paramètres', 'description' => 'Gérez les préférences générales de la plateforme.', 'type' => 'form'],
            'blank-page' => ['title' => 'Page vierge', 'description' => 'Espace de contenu prêt à être personnalisé.', 'type' => 'blank'],
            'invoice' => ['title' => 'Facture', 'description' => 'Exemple de récapitulatif de paiement.', 'type' => 'invoice'],
            'signup' => ['title' => 'Inscription', 'description' => 'Maquette de création de compte administrateur.', 'type' => 'auth'],
            'alerts' => ['title' => 'Alertes', 'description' => 'Exemples de messages d’état de la plateforme.', 'type' => 'alerts'],
            'buttons' => ['title' => 'Boutons', 'description' => 'Exemples de styles et d’actions disponibles.', 'type' => 'buttons'],
            'cards' => ['title' => 'Cartes', 'description' => 'Exemples de cartes de statistiques.', 'type' => 'cards'],
            'typography' => ['title' => 'Typographie', 'description' => 'Exemples de hiérarchie typographique.', 'type' => 'typography'],
            'icons' => ['title' => 'Icônes', 'description' => 'Exemples de symboles utilisés dans l’interface.', 'type' => 'icons'],
            'mdi-icons' => ['title' => 'Icônes MDI', 'description' => 'Aperçu de glyphes sans dépendance à une bibliothèque externe.', 'type' => 'icons'],
            'form-elements' => ['title' => 'Éléments de formulaire', 'description' => 'Exemples de champs utilisés dans le Back Office.', 'type' => 'form'],
            'notification' => ['title' => 'Notifications', 'description' => 'Exemples de notifications administratives.', 'type' => 'alerts'],
        ];

        if (!isset($pages[$key])) {
            throw new InvalidArgumentException('Page Back Office inconnue : ' . $key);
        }

        $page = $pages[$key];
        $currentPage = $key;
        $title = $page['title'] . ' - ParkShare Administration';
        $headerTitle = $page['title'];
        ob_start();
        require_once __DIR__ . '/../Views/backoffice/tool-page.php';
        $content = ob_get_clean();
        require_once __DIR__ . '/../Views/layouts/backoffice.php';
    }
}
