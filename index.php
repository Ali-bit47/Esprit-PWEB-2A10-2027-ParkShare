<?php

declare(strict_types=1);

require_once __DIR__ . '/config/config.php';


ini_set('session.use_strict_mode', '1');    
ini_set('session.use_only_cookies', '1');   
ini_set('session.cookie_httponly', '1');    
ini_set('session.cookie_samesite', 'Lax');  
session_start();




if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_LIFETIME)) {
    $wasLogged = !empty($_SESSION['user_id']);
    $_SESSION = [];
    session_destroy();
    session_start();
    if ($wasLogged) {
        $_SESSION['flash'][] = ['type' => 'info', 'message' => 'Votre session a expiré après 30 minutes d’inactivité. Reconnectez-vous.'];
    }
}
$_SESSION['last_activity'] = time();




header('X-Frame-Options: DENY');                                   
header('X-Content-Type-Options: nosniff');                         
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data:");
header('Cache-Control: no-store');                                 




require_once __DIR__ . '/app/helpers.php';


spl_autoload_register(function (string $class): void {
    foreach (['Controllers', 'Models'] as $folder) {
        $file = __DIR__ . '/app/' . $folder . '/' . $class . '.php';
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});



AuthController::syncSession();




$routes = require __DIR__ . '/app/routes.php';
$action = (string) ($_GET['action'] ?? 'home');

if (!isset($routes[$action])) {
    (new HomeController())->abort(404, 'La page demandée n’existe pas.');
}

[$controllerName, $method] = $routes[$action];
$param = $routes[$action][2] ?? null;

$controller = new $controllerName();
$param === null ? $controller->$method() : $controller->$method($param);
