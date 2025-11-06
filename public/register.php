<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$controller = new AuthController();

if ($request->getMethod() === 'POST') {
    $name = $request->request->get('name');
    $email = $request->request->get('email');
    $password = $request->request->get('password');

    $controller->auth->register($name, $email, $password);
    header('Location: /login.php');
    exit;
} else {
    $html = (new App\Core\View())->render('auth/register', ['csrf' => App\Core\Csrf::token()]);
    echo $html;
}
