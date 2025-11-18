<?php
namespace App\Controllers\Admin;
use App\Core\View;
use App\Repositories\TaskRepository;
use App\Repositories\TagRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\TaskCategoryRepository;

class TaskController
{
    private View $view;
    private TaskRepository $repo;
    private TagRepository $tagRepo;

    private CategoryRepository $catRepo;
    private TaskCategoryRepository $tcRepo;
    public function __construct()
    {
        $this->view = new View();
        $this->repo = new TaskRepository();
        $this->catRepo = new CategoryRepository();
        $this->tagRepo = new TagRepository();
        $this->tcRepo = new TaskCategoryRepository();
    }

    private function adminAuth()
    {
        if (!session_id())
            session_start();
        $u = $_SESSION['user'] ?? null;
        if (!$u || ($u['role'] ?? '') !== 'admin') {
            header('Location: /?p=auth/login');
            exit;
        }
    }

    public function index()
    {
        $this->adminAuth();
        $tasks = $this->repo->all();
        $db = \App\Core\Database::getConnection();
        $stmt = $db->query('SELECT t.*, u.name AS user_name FROM tasks t LEFT JOIN users u ON u.id=t.user_id ORDER BY t.id DESC');
        $tasks = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        echo $this->view->render('admin/tasks/index', ['tasks' => $tasks, 'user' => $_SESSION['user']]);
    }

    public function store()
    {
        $this->adminAuth();
        if (!\App\Core\Csrf::validate($_POST['_csrf'] ?? '')) {
            echo 'CSRF inválido';
            exit;
        }
        $title = trim($_POST['title'] ?? '');
        if ($title === '') {
            echo 'Nome obrigatório';
            exit;

        }
        $userId = $_POST['user'] ?? null;
        if ($userId === '') {
            echo 'Usuário obrigatório';
            exit;
        }
        $categoryId = $_POST['category'] ?? null;
        if ($categoryId === '') {
            echo 'Categoria obrigatória';
            exit;
        }
        $description = $_POST['description'] ?? null;
        if ($description === '') {
            echo 'Categoria obrigatória';
            exit;
        }


        $this->repo->create($userId, $categoryId, $title, $description);
        header('Location: /?p=admin/categories');
        exit;
    }


    public function edit()
    {
        $this->adminAuth();
        $id = (int) ($_GET['id'] ?? 0);
        $task = $this->repo->find($id);
        $cats = $this->catRepo->all();
        $tags = $this->tagRepo->all();
        $assigned = $this->tcRepo->getCategoriesForTask($id);
        echo $this->view->render('admin/tasks/edit', ['task' => $task, 'categories' => $cats, 'tags' => $tags, 'assigned' => $assigned, 'csrf' => \App\Core\Csrf::token()]);
    }

    public function update()
    {
        $this->adminAuth();
        if (!\App\Core\Csrf::validate($_POST['_csrf'] ?? '')) {
            echo 'CSRF inválido';
            exit;
        }
        $id = (int) ($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $done = isset($_POST['done']) ? 1 : 0;
        $this->repo->update($id, $title, $description, (bool) $done);
        $cats = $_POST['categories'] ?? [];
        $tags = $_POST['tags'] ?? [];

        $this->tcRepo->setForTask($id, is_array($cats) ? $cats : []);
        header('Location: /?p=admin/tasks');
        exit;
    }

    public function delete()
    {
        $this->adminAuth();
        if (!\App\Core\Csrf::validate($_POST['_csrf'] ?? '')) {
            echo 'CSRF inválido';
            exit;
        }
        $id = (int) ($_POST['id'] ?? 0);
        $this->repo->delete($id);
        header('Location: /?p=admin/tasks');
        exit;
    }
}
