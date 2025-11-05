<?php
namespace App\Controllers\User;

use App\Core\Csrf;
use App\Core\View;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController {
    private View $view;
    private TaskRepository $repo;
    private TaskService $service;

    public function __construct() {
        $this->view = new View();
        $this->repo = new TaskRepository();
        $this->service = new TaskService();
    }

    public function index(Request $request): Response {
        $page = max(1, (int)$request->query->get('page', 1));
        $perPage = 5;
        $total = $this->repo->countAll();
        $tasks = $this->repo->paginate($page, $perPage);
        $pages = (int)ceil($total / $perPage);
        $html = $this->view->render('user/tasks/index', compact('tasks','page','pages'));
        return new Response($html);
    }

    public function create(): Response {
        $html = $this->view->render('user/tasks/create', ['csrf' => Csrf::token(), 'errors' => []]);
        return new Response($html);
    }

    public function store(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $file = $request->files->get('image');
        $errors = $this->service->validate($request->request->all(), $file);
        if ($errors) {
            $html = $this->view->render('user/tasks/create', ['csrf' => Csrf::token(), 'errors' => $errors, 'old' => $request->request->all()]);
            return new Response($html, 422);
        }
        $imagePath = $this->service->storeImage($file);
        $task = $this->service->make($request->request->all(), $imagePath);
        $id = $this->repo->create($task);
        return new RedirectResponse('/user/tasks/show?id=' . $id);
    }

    public function show(Request $request): Response {
        $id = (int)$request->query->get('id', 0);
        $task = $this->repo->find($id);
        if (!$task) return new Response('Tarefa não encontrada', 404);
        $html = $this->view->render('user/tasks/show', ['task' => $task]);
        return new Response($html);
    }

    public function edit(Request $request): Response {
        $id = (int)$request->query->get('id', 0);
        $task = $this->repo->find($id);
        if (!$task) return new Response('Tarefa não encontrada', 404);
        $html = $this->view->render('use/tasks/edit', ['task' => $task, 'csrf' => Csrf::token(), 'errors' => []]);
        return new Response($html);
    }

    public function update(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $data = $request->request->all();
        $file = $request->files->get('image');
        $errors = $this->service->validate($data, $file);
        if ($errors) {
            $html = $this->view->render('use/tasks/edit', ['task' => array_merge($this->repo->find((int)$data['id']), $data), 'csrf' => Csrf::token(), 'errors' => $errors]);
            return new Response($html, 422);
        }
        $imagePath = $this->service->storeImage($file) ?? ($this->repo->find((int)$data['id'])['image_path'] ?? null);
        $task = $this->service->make($data, $imagePath);
        if (!$task->id) return new Response('ID inválido', 422);
        $this->repo->update($task);
        return new RedirectResponse('/use/tasks/show?id=' . $task->id);
    }

    public function delete(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $id = (int)$request->request->get('id', 0);
        if ($id > 0) $this->repo->delete($id);
        return new RedirectResponse('/use/tasks');
    }
}
