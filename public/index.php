<?php

spl_autoload_register(function($class){
    $prefix = 'App\\';
    if (strpos($class,$prefix)!==0) return;
    $rel = substr($class, strlen($prefix));
    $path = __DIR__ . '/../app/' . str_replace('\\','/',$rel) . '.php';
    if (file_exists($path)) require $path;
});

$path = $_GET['p'] ?? 'home';

switch ($path) {
    case 'home':
        (new App\Controllers\HomeController())->index();
        break;

    case 'auth/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') (new App\Controllers\AuthController())->loginPost();
        else (new App\Controllers\AuthController())->loginForm();
        break;

    case 'auth/logout':
        (new App\Controllers\AuthController())->logout();
        break;

    case 'tasks':
        (new App\Controllers\TaskController())->index();
        break;

    case 'tasks/store':
        (new App\Controllers\TaskController())->store();
        break;

    case 'tasks/toggle':
        (new App\Controllers\TaskController())->toggle();
        break;

    case 'tasks/delete':
        (new App\Controllers\TaskController())->delete();
        break;

    // admin
    case 'admin':
        (new App\Controllers\Admin\TaskController())->index();
        break;

    case 'admin/users':
        (new App\Controllers\Admin\UserController())->index();
        break;
    case 'admin/users/create':
        (new App\Controllers\Admin\UserController())->create();
        break;
    case 'admin/users/store':
        (new App\Controllers\Admin\UserController())->store();
        break;
    case 'admin/users/edit':
        (new App\Controllers\Admin\UserController())->edit();
        break;
    case 'admin/users/update':
        (new App\Controllers\Admin\UserController())->update();
        break;
    case 'admin/users/delete':
        (new App\Controllers\Admin\UserController())->delete();
        break;

    case 'admin/categories':
        (new App\Controllers\Admin\CategoryController())->index();
        break;
    case 'admin/categories/create':
        (new App\Controllers\Admin\CategoryController())->create();
        break;
    case 'admin/categories/store':
        (new App\Controllers\Admin\CategoryController())->store();
        break;
    case 'admin/categories/edit':
        (new App\Controllers\Admin\CategoryController())->edit();
        break;
    case 'admin/categories/update':
        (new App\Controllers\Admin\CategoryController())->update();
        break;
    case 'admin/categories/delete':
        (new App\Controllers\Admin\CategoryController())->delete();
        break;

    case 'admin/tasks':
        (new App\Controllers\Admin\TaskController())->index();
        break;
    case 'admin/tasks/edit':
        (new App\Controllers\Admin\TaskController())->edit();
        break;
    case 'admin/tasks/update':
        (new App\Controllers\Admin\TaskController())->update();
        break;
    case 'admin/tasks/delete':
        (new App\Controllers\Admin\TaskController())->delete();
        break;

    default:
        echo "Página não encontrada";
        break;
}
