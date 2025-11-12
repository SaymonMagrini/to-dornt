<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Core\View;

$view = new View();
try {
    echo $view->render('auth/home', [
        'user' => ['name' => 'Teste'],
        'categories' => [['id' => 1, 'name' => 'Categoria 1']],
        'tasks' => [['id' => 1, 'title' => 'Tarefa 1', 'done' => 0, 'category_name' => 'Categoria 1']]
    ]);
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>