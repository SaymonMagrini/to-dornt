<?php

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\View;
use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TaskController
{
    private View $view;
    private TaskRepository $repo;
    private TaskService $service;
    private CategoryRepository $categoryRepo;
    private TagRepository $tagRepo;

    public function __construct()
    {
        $this->view = new View();
        $this->repo = new TaskRepository();
        $this->service = new TaskService();
        $this->categoryRepo = new CategoryRepository();
        $this->tagRepo = new TagRepository();
    }

    /** Obtém o ID do usuário logado */
    private function getUserId(): int
    {
        return (int) ($_SESSION['user_id'] ?? 0);
    }

    public function index(Request $request): Response
    {
        $userId = $this->getUserId();

        $page = max(1, (int)$request->query->get('page', 1));
        $perPage = 10;

        $total = $this->repo->countAll($userId);
        $tasks = $this->repo->paginate($page, $perPage, $userId);
        $pages = (int) ceil($total / $perPage);

        $categories = $this->categoryRepo->findAll($userId);
        $tags = $this->tagRepo->findAll($userId);

        return new Response(
            $this->view->render('admin/tasks/index', compact('tasks', 'page', 'pages', 'categories', 'tags'))
        );
    }

    public function create(Request $request): Response
    {
        $userId = $this->getUserId();

        return new Response(
            $this->view->render('admin/tasks/create', [
                'csrf' => Csrf::token(),
                'categories' => $this->categoryRepo->findAll($userId),
                'tags' => $this->tagRepo->findAll($userId),
                'errors' => [],
                'old' => []
            ])
        );
    }

    public function store(Request $request): Response
    {
        $userId = $this->getUserId();

        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $data = $request->request->all();
        $data['tag_ids'] = $request->request->all('tag_ids');

        $errors = $this->service->validate($data);
        if ($errors) {
            return new Response(
                $this->view->render('admin/tasks/create', [
                    'csrf' => Csrf::token(),
                    'categories' => $this->categoryRepo->findAll($userId),
                    'tags' => $this->tagRepo->findAll($userId),
                    'errors' => $errors,
                    'old' => $data
                ]), 422
            );
        }

        $task = $this->service->make($data);
        $id = $this->repo->create($task, $userId);

        return new RedirectResponse('/admin/tasks/show?id=' . $id);
    }

    public function show(Request $request): Response
    {
        $userId = $this->getUserId();

        $id = (int) $request->query->get('id');
        $task = $this->repo->find($id, $userId);

        if (!$task) {
            return new Response('Tarefa não encontrada', 404);
        }

        return new Response(
            $this->view->render('admin/tasks/show', ['task' => $task])
        );
    }

    public function edit(Request $request): Response
    {
        $userId = $this->getUserId();

        $id = (int) $request->query->get('id');
        $task = $this->repo->find($id, $userId);

        if (!$task) {
            return new Response('Tarefa não encontrada', 404);
        }

        return new Response(
            $this->view->render('admin/tasks/edit', [
                'csrf' => Csrf::token(),
                'task' => $task,
                'categories' => $this->categoryRepo->findAll($userId),
                'tags' => $this->tagRepo->findAll($userId),
                'errors' => []
            ])
        );
    }

    public function update(Request $request): Response
    {
        $userId = $this->getUserId();

        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $data = $request->request->all();
        $data['tag_ids'] = $request->request->all('tag_ids');

        $errors = $this->service->validate($data);
        if ($errors) {
            return new Response(
                $this->view->render('admin/tasks/edit', [
                    'csrf' => Csrf::token(),
                    'task' => $data,
                    'categories' => $this->categoryRepo->findAll($userId),
                    'tags' => $this->tagRepo->findAll($userId),
                    'errors' => $errors
                ]),
                422
            );
        }

        $task = $this->service->make($data);
        $this->repo->update($task, $userId);

        return new RedirectResponse('/admin/tasks/show?id=' . $task->id);
    }

    public function delete(Request $request): Response
    {
        $userId = $this->getUserId();

        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $id = (int) $request->request->get('id');

        if ($id > 0) {
            $this->repo->delete($id, $userId);
        }

        return new RedirectResponse('/admin/tasks');
    }
}
