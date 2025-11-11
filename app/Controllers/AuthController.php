<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Flash;
use App\Core\Database;
use App\Services\UserService;
use PDO;

class AuthController
{
    private View $view;
    private UserService $userService;

    public function __construct()
    {
        $this->view = new View();
        $this->userService = new UserService();
    }

    public function showLogin(): void
    {
        echo $this->view->render('auth/login', []);
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($email === '' || $password === '') {
            Flash::add('Preencha todos os campos', 'error');
            header('Location: /login.php');
            exit;
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            Flash::add('Usuário ou senha incorretos', 'error');
            header('Location: /login.php');
            exit;
        }

        session_start();
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email']
        ];

        Flash::add('Login realizado com sucesso!', 'success');
        header('Location: /home.php');
        exit;
    }

    public function showRegister(): void
    {
        echo $this->view->render('auth/register', []);
    }

    public function register(): void
    {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($name === '' || $email === '' || $password === '') {
            Flash::add('Preencha todos os campos', 'error');
            header('Location: /register.php');
            exit;
        }

        $pdo = Database::getConnection();
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            Flash::add('E-mail já cadastrado', 'error');
            header('Location: /register.php');
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)');
        $stmt->execute([$name, $email, $hash]);

        Flash::add('Cadastro realizado com sucesso! Faça login.', 'success');
        header('Location: /login.php');
        exit;
    }

    public function logout(): void
    {
        session_start();
        session_destroy();

        Flash::add('Você saiu da conta.', 'info');
        header('Location: /login.php');
        exit;
    }
}
