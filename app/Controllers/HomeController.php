<?php

namespace App\Controllers;

use App\Core\View;
use App\Core\Database;
use App\Core\Flash;
use PDO;

class HomeController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function index(): void
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            Flash::add('Você precisa estar logado para acessar o painel.', 'error');
            header('Location: /login.php');
            exit;
        }

        $pdo = Database::getConnection();

        // Busca categorias
        $stmt = $pdo->query('SELECT id, name FROM categories ORDER BY name');
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Busca tarefas do usuário logado
        $stmt = $pdo->prepare('
            SELECT tasks.*, categories.name AS category_name
            FROM tasks
            LEFT JOIN categories ON tasks.category_id = categories.id
            WHERE tasks.user_id = ?
            ORDER BY tasks.id DESC
        ');
        $stmt->execute([$_SESSION['user']['id']]);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo $this->view->render('auth/home', [
            'user' => $_SESSION['user'],
            'categories' => $categories,
            'tasks' => $tasks
        ]);
    }
}
