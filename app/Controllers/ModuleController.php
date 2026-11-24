<?php


class ModuleController extends Controller
{
    
    private const MODULES = [
        'places'     => ['Places de parking et réservations', 'PlaceParking – Reservation', 'places.manage', 'places', 'admin_places'],
        'evenements' => ['Événements et réservations', 'Evenement – ReservationEvenement', 'evenements.manage', 'evenements', 'admin_evenements'],
        'forum'      => ['Forum et publications', 'Forum – Publication', 'forum.moderate', 'forum', 'admin_forum'],
        'materiel'   => ['Matériel et catégories', 'CategorieMateriel – Materiel', 'materiel.manage', 'materiel', 'admin_materiel'],
        'entretiens' => ['Entretien du matériel', 'Entretien – Traitement', 'entretiens.manage', 'signalement', 'admin_entretiens'],
        'reservations' => ['Mes réservations', 'Reservation – ReservationEvenement', 'places.manage', 'reservations', 'admin_places'],
    ];

    public function front(string $key): void
    {
        [$name, $entities, , $frontPage] = self::MODULES[$key];

        
        [$search, $searchErrors] = $key === 'places' && isset($_GET['lieu']) ? $this->validateSearch($_GET) : [null, []];

        $this->render('front/module', [
            'title' => $name, 'currentPage' => $frontPage, 'name' => $name, 'entities' => $entities,
            'search' => $search, 'searchErrors' => $searchErrors,
        ]);
    }

    
    private function validateSearch(array $get): array
    {
        $lieu  = trim((string) ($get['lieu'] ?? ''));
        $date  = trim((string) ($get['date'] ?? ''));
        $duree = (string) ($get['duree'] ?? '');
        $errors = [];

        if ($lieu === '') {
            $errors['lieu'] = 'Indiquez un quartier ou une adresse.';
        } elseif (mb_strlen($lieu) < 2 || mb_strlen($lieu) > 100 || !preg_match("/^[\p{L}0-9 '\-,.]+$/u", $lieu)) {
            $errors['lieu'] = 'Lieu invalide (2 à 100 caractères, lettres, chiffres et ponctuation simple).';
        }

        $d = DateTime::createFromFormat('!d/m/Y', $date);
        if (!$d || $d->format('d/m/Y') !== $date) {
            $errors['date'] = 'Date invalide : format JJ/MM/AAAA.';
        } elseif ($d < new DateTime('today')) {
            $errors['date'] = 'La date doit être aujourd’hui ou plus tard.';
        }

        if (!in_array($duree, ['1', '2', '3', '4', '6', '8', '12', '24'], true)) {
            $errors['duree'] = 'Durée invalide.';
        }

        return [['lieu' => $lieu, 'date' => $date, 'duree' => $duree], $errors];
    }

    public function back(string $key): void
    {
        [$name, $entities, $permission, , $backPage] = self::MODULES[$key];
        AuthController::requirePermission($permission);
        $this->render('back/module', [
            'title' => $name, 'currentPage' => $backPage, 'name' => $name, 'entities' => $entities,
        ], 'admin');
    }
}
