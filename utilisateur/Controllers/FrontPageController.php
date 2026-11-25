<?php
class FrontPageController
{
    protected function renderPage(string $key): void
    {
        $pages = [
            'about' => [
                'title' => 'Louer ma place',
                'description' => 'Transformez votre place de parking disponible en un espace utile et générez un revenu complémentaire.',
                'items' => [
                    ['title' => 'Publiez votre place', 'text' => 'Ajoutez son emplacement, ses horaires et son tarif.'],
                    ['title' => 'Gardez le contrôle', 'text' => 'Choisissez les disponibilités qui vous conviennent.'],
                    ['title' => 'Accueillez les conducteurs', 'text' => 'Proposez une place réservée près de leur destination.'],
                ],
            ],
            'courses' => [
                'title' => 'Comment ça marche',
                'description' => 'ParkShare facilite la recherche et la réservation de places de stationnement à Tunis.',
                'items' => [
                    ['title' => '1. Recherchez', 'text' => 'Indiquez le quartier, la date et la durée souhaitée.'],
                    ['title' => '2. Choisissez', 'text' => 'Comparez les places selon leur emplacement et leur tarif.'],
                    ['title' => '3. Stationnez', 'text' => 'Réservez la place qui correspond à votre besoin.'],
                ],
            ],
            'team' => [
                'title' => 'Entreprises et partenaires',
                'description' => 'Mettez en valeur vos places disponibles et facilitez le stationnement de vos visiteurs.',
                'items' => [
                    ['title' => 'Gestion centralisée', 'text' => 'Présentez les emplacements et disponibilités de votre organisation.'],
                    ['title' => 'Meilleure utilisation', 'text' => 'Rendez visibles les places inoccupées aux conducteurs du quartier.'],
                    ['title' => 'Grand Tunis', 'text' => 'Développez une offre de stationnement de proximité.'],
                ],
            ],
            'testimonial' => [
                'title' => 'Avis des utilisateurs',
                'description' => 'Les retours de la communauté ParkShare.',
                'items' => [
                    ['title' => 'Sonia · Les Berges du Lac', 'text' => '« J’ai trouvé une place proche de mon rendez-vous sans perdre de temps. »'],
                    ['title' => 'Amine · Ennasr', 'text' => '« La réservation m’a permis de mieux organiser mon déplacement. »'],
                    ['title' => 'Meriem · La Marsa', 'text' => '« Une solution pratique pour proposer ma place quand elle est libre. »'],
                ],
            ],
            'contact' => [
                'title' => 'Contactez ParkShare',
                'description' => 'Une question ou une suggestion ? Écrivez-nous à contact@parkshare.tn.',
                'items' => [
                    ['title' => 'Assistance', 'text' => 'Pour toute question concernant la recherche ou la réservation.'],
                    ['title' => 'Propriétaires', 'text' => 'Pour obtenir des informations sur la publication d’une place.'],
                    ['title' => 'Partenariats', 'text' => 'Pour discuter d’une collaboration avec ParkShare.'],
                ],
            ],
        ];

        if (!isset($pages[$key])) {
            throw new InvalidArgumentException('Page Front Office inconnue : ' . $key);
        }

        $page = $pages[$key];
        ob_start();
        require_once __DIR__ . '/../Views/frontoffice/static-page.php';
        $content = ob_get_clean();
        $title = $page['title'] . ' - ParkShare';
        $currentPage = $key;
        require_once __DIR__ . '/../Views/layouts/frontoffice.php';
    }
}
