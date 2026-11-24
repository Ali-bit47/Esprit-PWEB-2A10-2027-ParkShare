<?php
class ReservationController
{
    public function create(): void
    {
        $parking = trim((string) ($_POST['parking'] ?? $_GET['parking'] ?? ''));
        $reservationSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST';

        ob_start();
        require_once __DIR__ . '/../Views/frontoffice/reservation.php';
        $content = ob_get_clean();
        $title = 'Réservation - ParkShare';
        $currentPage = 'reservation';
        require_once __DIR__ . '/../Views/layouts/frontoffice.php';
    }
}
