<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\View;
use App\Services\AuthService;

$auth = new AuthService();

if (!$auth->check()) {
    header('Location: /login.php');
    exit;
}

$view = new View();
echo $view->render('home');
