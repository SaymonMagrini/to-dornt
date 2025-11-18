<?php
namespace App\Controllers;
use App\Core\View;

class HomeController {
    public function index() {
        $view = new View();
        echo $view->render('home/index');
    }
}
