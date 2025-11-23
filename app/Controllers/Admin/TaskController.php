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

    public function index(Request $request): Response
    {
        $page = max(1, (int) $request->query->get('page', 1));
        $perPage = 5;
        $total = $this->repo->countAll();
        $tasks = $this->repo->paginate($page, $perPage);
        $pages = (int) ceil($total / $perPage);

        $html = $this->view->render('admin/tasks/index', compact('tasks', 'page', 'pages'));
        return new Response($html);


    }

    public function create(): Response
    {
        return new Response(
            $this->view->render('admin/tasks/create', [
                'csrf' => Csrf::token(),
                'categories' => $this->categoryRepo->findAll(),
                'tags' => $this->tagRepo->findAll(),
                'errors' => [],
                'old' => [],
                'selectedTagIds' => []
            ])
        );
    }

    public function store(Request $request): Response
    {
        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $data = $request->request->all();
        $data['tag_ids'] = $request->request->all('tag_ids') ?? [];
        $data['done'] = isset($data['done']) ? (int) $data['done'] : 0;
        $data['due_date'] = !empty($data['due_date']) ? date('Y-m-d', strtotime($data['due_date'])) : null;

        $errors = $this->service->validate($data);

        if ($errors) {
            return new Response(
                $this->view->render('admin/tasks/create', [
                    'csrf' => Csrf::token(),
                    'categories' => $this->categoryRepo->findAll(),
                    'tags' => $this->tagRepo->findAll(),
                    'errors' => $errors,
                    'old' => $data,
                    'selectedTagIds' => $data['tag_ids']
                ]),
                422
            );
        }

        $task = $this->service->make($data);
        $id = $this->repo->create($task);

        $_SESSION['success'] = 'Tarefa criada com sucesso!';
        return new RedirectResponse("/admin/tasks/show?id={$id}");
    }

    public function show(Request $request): Response
    {
        $id = (int) $request->query->get('id');
        $task = $this->repo->find($id);

        if (!$task) {
            return new Response('Tarefa não encontrada', 404);
        }

        return new Response(
            $this->view->render('admin/tasks/show', [
                'task' => $task
            ])
        );
    }

    public function edit(Request $request): Response
    {
        $id = (int) $request->query->get('id');
        $task = $this->repo->find($id);

        if (!$task) {
            return new Response('Tarefa não encontrada', 404);
        }

        $selectedTagIds = $task->tag_ids ?? [];

        return new Response(
            $this->view->render('admin/tasks/edit', [
                'csrf' => Csrf::token(),
                'task' => $task,
                'categories' => $this->categoryRepo->findAll(),
                'tags' => $this->tagRepo->findAll(),
                'errors' => [],
                'selectedTagIds' => $selectedTagIds
            ])
        );
    }

    public function update(Request $request): Response
    {
        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $data = $request->request->all();
        $data['id'] = (int) ($data['id'] ?? 0);
        $data['tag_ids'] = $request->request->all('tag_ids') ?? [];
        $data['category_id'] = $data['category_id'] ?? null;
        $data['done'] = isset($data['done']) ? (int) $data['done'] : 0;
        $data['due_date'] = !empty($data['due_date']) ? date('Y-m-d', strtotime($data['due_date'])) : null;

        $errors = $this->service->validate($data);

        if ($errors) {
            $task = $this->repo->find($data['id']);
            $selectedTagIds = $data['tag_ids'];

            return new Response(
                $this->view->render('admin/tasks/edit', [
                    'csrf' => Csrf::token(),
                    'task' => $task,
                    'categories' => $this->categoryRepo->findAll(),
                    'tags' => $this->tagRepo->findAll(),
                    'errors' => $errors,
                    'old' => $data,
                    'selectedTagIds' => $selectedTagIds
                ]),
                422
            );
        }

        $task = $this->service->make($data);
        $this->repo->update($task);

        $_SESSION['success'] = 'Tarefa atualizada com sucesso!';
        return new RedirectResponse("/admin/tasks/show?id={$task->id}");
    }

    public function delete(Request $request): Response
    {
        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $id = (int) $request->request->get('id');

        if ($id > 0) {
            $this->repo->delete($id);
            $_SESSION['success'] = 'Tarefa excluída com sucesso!';
        }

        return new RedirectResponse('/admin/tasks');
    }
}