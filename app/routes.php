<?php

$routes = [
    'home' => [HomeController::class, 'index'],
    'admin' => [AdminController::class, 'index'],
    'dashboard' => [AdminController::class, 'index'],
    'reservation' => [ReservationController::class, 'create'],
    'about' => [AboutController::class, 'index'],
    'courses' => [CoursesController::class, 'index'],
    'team' => [TeamController::class, 'index'],
    'testimonial' => [TestimonialController::class, 'index'],
    'contact' => [ContactController::class, 'index'],
    'tables' => [TablesController::class, 'index'],
    'signin' => [SigninController::class, 'index'],
    'settings' => [SettingsController::class, 'index'],
    'blank-page' => [BlankPageController::class, 'index'],
    'invoice' => [InvoiceController::class, 'index'],
    'signup' => [SignupController::class, 'index'],
    'alerts' => [AlertsController::class, 'index'],
    'buttons' => [ButtonsController::class, 'index'],
    'cards' => [CardsController::class, 'index'],
    'typography' => [TypographyController::class, 'index'],
    'icons' => [IconsController::class, 'index'],
    'mdi-icons' => [MdiIconsController::class, 'index'],
    'form-elements' => [FormElementsController::class, 'index'],
    'notification' => [NotificationController::class, 'index'],
];

$page = $_GET['page'] ?? 'home';

if (isset($routes[$page])) {
    [$controllerClass, $method] = $routes[$page];
    $controller = in_array($page, ['home', 'admin', 'dashboard'], true)
        ? new $controllerClass($db)
        : new $controllerClass();
    $controller->{$method}();
    return;
}

http_response_code(404);
ob_start();
?>
<main class="home">
    <section class="content">
        <h1>404 - Page introuvable</h1>
        <p><a href="index.php?page=home">Retour à l'accueil</a></p>
    </section>
</main>
<?php
$content = ob_get_clean();
$title = 'Page introuvable - ParkShare';
$currentPage = 'not-found';
require_once __DIR__ . '/Views/layouts/frontoffice.php';
