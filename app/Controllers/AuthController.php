<?php
namespace App\Controllers;
use App\Core\View;
use App\Repositories\UserRepository;

class AuthController {
    private View $view;
    private UserRepository $repo;
    public function __construct() {
        $this->view = new View();
        $this->repo = new UserRepository();
    }

    public function loginForm() {
        echo $this->view->render('auth/login', ['error' => null]);
    }

    public function loginPost() {
        $email = $_POST['email'] ?? '';
        $pass = $_POST['password'] ?? '';
        $user = $this->repo->findByEmail($email);
        if ($user && password_verify($pass, $user['password'])) {
            if (!session_id()) session_start();
            $_SESSION['user'] = $user;
            header('Location: /?p=tasks'); exit;
        }
        echo $this->view->render('auth/login', ['error' => 'Credenciais inválidas']);
    }

    public function logout() {
        if (!session_id()) session_start();
        unset($_SESSION['user']);
        header('Location: /?p=home'); exit;
    }
}
