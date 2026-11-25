<?php
class AdminController
{
    private ?PDO $db;

    public function __construct(?PDO $db = null)
    {
        $this->db = $db;
    }

    public function index(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['parking_id'])) {
            $this->updateParkingStatus((int) $_POST['parking_id'], $_POST['action'] === 'validate' ? 'valide' : 'refuse');
        }

        $stats = [
            'utilisateurs' => '1 248',
            'parkings' => '312',
            'reservations' => '2 480',
            'revenus' => '18 640 DT'
        ];
        ob_start();
        require_once __DIR__ . '/../Views/backoffice/dashboard.php';
        $content = ob_get_clean();
        $title = 'ParkShare - Administration';
        $currentPage = 'admin';
        require_once __DIR__ . '/../Views/layouts/backoffice.php';
    }

    private function updateParkingStatus(int $id, string $status): void
    {
        if (!$this->db || $id <= 0) {
            return;
        }

        $stmt = $this->db->prepare('UPDATE parkings SET statut = :statut WHERE id = :id');
        $stmt->execute(['statut' => $status, 'id' => $id]);
    }
}
