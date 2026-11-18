<?php
require_once __DIR__ . '/../Models/Parking.php';

class HomeController
{
    private ?PDO $db;

    public function __construct(?PDO $db)
    {
        $this->db = $db;
    }

    public function index(): void
    {
        $search = trim((string) ($_GET['lieu'] ?? ''));
        $parkings = (new Parking($this->db))->search($search);
        ob_start();
        require_once __DIR__ . '/../Views/frontoffice/home.php';
        $content = ob_get_clean();
        $title = 'ParkShare - Trouver une place';
        $currentPage = 'home';
        require_once __DIR__ . '/../Views/layouts/frontoffice.php';
    }
}
