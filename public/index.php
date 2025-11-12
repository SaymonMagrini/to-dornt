<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\AuthController;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


if ($path === '/' || $path === '/home') {
    $controller = new HomeController();
    $controller->index();
} elseif ($path === '/login') {
    $controller = new AuthController();
    $controller->login();
} elseif ($path === '/register') {
    $controller = new AuthController();
    $controller->register();
} elseif ($path === '/tasks') {
    $controller = new HomeController(); 
    $controller->index(); 
} elseif ($path === '/logout') {
    $controller = new AuthController();
    $controller->logout();
} else {
    http_response_code(404);
    echo "Página não encontrada";
}