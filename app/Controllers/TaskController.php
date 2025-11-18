<?php
namespace App\Controllers;
use App\Core\View;
use App\Repositories\TaskRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\TaskCategoryRepository;

class TaskController {
    private View $view;
    private TaskRepository $repo;
    private CategoryRepository $catRepo;
    private TaskCategoryRepository $tcRepo;

    public function __construct() {
        $this->view = new View();
        $this->repo = new TaskRepository();
        $this->catRepo = new CategoryRepository();
        $this->tcRepo = new TaskCategoryRepository();
    }

    private function auth() {
        if (!session_id()) session_start();
        return $_SESSION['user'] ?? null;
    }

    public function index() {
        $user = $this->auth();
        if (!$user) { header('Location: /?p=auth/login'); exit; }
        $tasks = $this->repo->allByUser((int)$user['id']);
        $categories = $this->catRepo->all();
        echo $this->view->render('user/tasks/index', ['user'=>$user,'tasks'=>$tasks,'categories'=>$categories]);
    }

    public function store() {
        $user = $this->auth();
        if (!$user) { header('Location: /?p=auth/login'); exit; }
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $categoryIds = $_POST['categories'] ?? []; 
        if ($title !== '') {
            $taskId = $this->repo->create((int)$user['id'],$title,$description);
            if (!empty($categoryIds)) $this->tcRepo->setForTask($taskId,$categoryIds);
        }
        header('Location: /?p=tasks'); exit;
    }

    public function toggle() {
        $user = $this->auth();
        if (!$user) { header('Location: /?p=auth/login'); exit; }
        $id = (int)($_GET['id'] ?? 0);
        $this->repo->toggleDone($id);
        header('Location: /?p=tasks'); exit;
    }

    public function delete() {
        $user = $this->auth();
        if (!$user) { header('Location: /?p=auth/login'); exit; }
        $id = (int)($_GET['id'] ?? 0);
        $this->repo->delete($id);
        header('Location: /?p=tasks'); exit;
    }
}
