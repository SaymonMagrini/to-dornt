<?php
namespace App\Controllers;
use App\Core\View;
use App\Repositories\TaskRepository;
use App\Repositories\CategoryRepository;
use App\Services\AuthService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TaskController
{
    private TaskRepository $tasks;
    private CategoryRepository $categoryRepo;
    private AuthService $auth;
    private View $view;
    public function __construct()
    {
        $this->tasks = new TaskRepository();
        $this->categories = new CategoryRepository();
        $this->auth = new AuthService();
        $this->view = new View();
    }

    public function index(): Response
    {
        $user = $this->auth->user();
        if (!$user)
            return new RedirectResponse('/auth/login');

        $tasks = $this->tasks->allByUser($user['id']);
        $categories = $this->categoryRepo->getArray();

        $html = $this->view->render('home', [
            'user' => $user,
            'tasks' => $tasks,
            'categories' => $categories
        ]);

        return new Response($html);
    }

    public function store(Request $req): Response
    {
        $user = $this->auth->user();
        $title = trim($req->request->get('title', ''));
        $categoryId = $req->request->get('category_id') ?: null;
        $tags = trim($req->request->get('tags', ''));

        if ($title !== '') {
            $this->tasks->create($user['id'], $title, $categoryId, $tags);
        }

        return new RedirectResponse('/');
    }

    public function toggle(int $id): Response
    {
        $this->tasks->toggleDone($id);
        return new RedirectResponse('/');
    }

    public function delete(int $id): Response
    {
        $this->tasks->delete($id);
        return new RedirectResponse('/');
    }
}
?>