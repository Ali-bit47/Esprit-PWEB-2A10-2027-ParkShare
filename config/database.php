<?php


require_once __DIR__ . '/config.php';

class Database
{
    private static ?PDO $pdo = null;

    
    private function __construct()
    {
    }

    public static function getConnexion(): PDO
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                    DB_USER,
                    DB_PASS,
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false,                  
                    ]
                );
            } catch (PDOException $e) {
                http_response_code(500);
                
                die(APP_DEBUG
                    ? 'Erreur de connexion : ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')
                    : 'Erreur de connexion à la base de données. Vérifiez config/config.php.');
            }
        }
        return self::$pdo;
    }
}
