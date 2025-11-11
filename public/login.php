<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$controller = new AuthController();

if ($request->getMethod() === 'POST') {
    $controller->login();
} else {
    $controller->showLogin();
}