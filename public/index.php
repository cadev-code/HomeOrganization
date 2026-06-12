<?php
// reporte de errores (desarrollo local)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../app/Controllers/HomeController.php';

use App\Controllers\HomeController;

$url = $_SERVER['REQUEST_URI'] ?? '/';

switch ($url) {
    case '/' || '/index.php':
        $controller = new HomeController();
        $controller->index();
        break;
    default:
        http_response_code(404);
        echo "404 - Página no encontrada";
        break;
}