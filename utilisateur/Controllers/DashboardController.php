<?php


class DashboardController extends Controller
{
    protected string $page = 'admin';

    
    public function index(): void
    {
        AuthController::requirePermission('dashboard.view');

        $stats = $this->db->query(
            "SELECT COUNT(*) AS total,
                    SUM(created_at >= DATE_FORMAT(NOW(), '%Y-%m-01')) AS nouveaux,
                    SUM(role = 'client') AS client, SUM(role = 'proprietaire') AS proprietaire,
                    SUM(role = 'technicien') AS technicien, SUM(role = 'admin') AS admin,
                    SUM(statut = 'bloque') AS bloques
             FROM users"
        )->fetch();

        $latest = array_map(
            fn(array $row) => UserModel::fromArray($row),
            $this->db->query('SELECT * FROM users ORDER BY created_at DESC, id DESC LIMIT 5')->fetchAll()
        );

        $this->render('back/dashboard', [
            'title'  => 'Tableau de bord',
            'stats'  => array_map('intval', $stats),
            'latest' => $latest,
        ], 'admin');
    }
}
