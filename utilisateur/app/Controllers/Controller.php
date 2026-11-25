<?php


require_once __DIR__ . '/../../config/database.php';

abstract class Controller
{
    protected PDO $db;

    
    protected string $page = 'home';

    
    protected string $title = APP_NAME;

    public function __construct()
    {
        $this->db = Database::getConnexion();
    }

    
    protected function render(string $view, array $data = [], string $layout = 'front'): void
    {
        $content      = $this->capture(__DIR__ . '/../Views/pages/' . $view . '.php', $data);
        $title        = ($data['title'] ?? $this->title) . ' · ' . APP_NAME;
        $currentPage  = $data['currentPage'] ?? $this->page;
        $extraScripts = $data['extraScripts'] ?? [];

        require __DIR__ . '/../Views/' . ($layout === 'admin' ? 'layout_admin.php' : 'layout.php');
    }

    
    private function capture(string $file, array $data): string
    {
        extract($data, EXTR_SKIP);
        ob_start();
        require $file;
        return (string) ob_get_clean();
    }

    
    public function abort(int $code, string $message = ''): never
    {
        http_response_code($code);
        $layout = AuthController::can('backoffice') ? 'admin' : 'front';
        $this->render('errors/error', [
            'title'   => 'Erreur ' . $code,
            'code'    => $code,
            'message' => $message,
        ], $layout);
        exit;
    }

    
    protected function requirePost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->abort(405, 'Cette action doit être envoyée par un formulaire.');
        }
    }

    
    protected function requireCsrf(): void
    {
        if (!AuthController::verifyCsrfToken($_POST['csrf_token'] ?? null)) {
            $this->abort(403, 'Jeton de sécurité invalide. Rechargez la page et réessayez.');
        }
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
