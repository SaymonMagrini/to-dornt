<?php
namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\View;
use App\Repositories\CategoryRepository;
use App\Repositories\TagRepository;
use App\Repositories\TaskRepository;
use App\Services\TaskService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    public function index(Request $request, int $userId): Response
    {
        $page = max(1, (int)$request->query->get('page', 1));
        $perPage = 10;

        $total = $this->repo->countAll($userId);
        $tasks = $this->repo->paginate($userId, $page, $perPage);
        $pages = (int)ceil($total / $perPage);

        $categories = $this->categoryRepo->getArray($userId);
        $tags = $this->tagRepo->getArray($userId);

        return new Response(
            $this->view->render('admin/tasks/index', compact('tasks', 'page', 'pages', 'categories', 'tags'))
        );
    }

    public function create(int $userId): Response
    {
        $categories = $this->categoryRepo->findAll($userId);
        $tags = $this->tagRepo->findAll($userId);

        return new Response(
            $this->view->render('admin/tasks/create', [
                'csrf' => Csrf::token(),
                'errors' => [],
                'categories' => $categories,
                'tags' => $tags,
                'old' => []
            ])
        );
    }

    public function store(Request $request, int $userId): Response
    {
        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $data = $request->request->all();
        $data['tag_ids'] = $request->request->all('tag_ids'); // ensure array

        $errors = $this->service->validate($data);
        if ($errors) {
            return new Response(
                $this->view->render('admin/tasks/create', [
                    'csrf' => Csrf::token(),
                    'errors' => $errors,
                    'categories' => $this->categoryRepo->findAll($userId),
                    'tags' => $this->tagRepo->findAll($userId),
                    'old' => $data
                ]),
                422
            );
        }

        $task = $this->service->make($data);
        $id = $this->repo->create($task, $userId);

        return new RedirectResponse('/admin/tasks/show?id=' . $id);
    }

    public function show(Request $request, int $userId): Response
    {
        $id = (int)$request->query->get('id', 0);
        $task = $this->repo->find($id, $userId);

        if (!$task) {
            return new Response('Tarefa não encontrada', 404);
        }

        return new Response(
            $this->view->render('admin/tasks/show', ['task' => $task])
        );
    }

    public function edit(Request $request, int $userId): Response
    {
        $id = (int)$request->query->get('id', 0);
        $task = $this->repo->find($id, $userId);

        if (!$task) {
            return new Response('Tarefa não encontrada', 404);
        }

        return new Response(
            $this->view->render('admin/tasks/edit', [
                'task' => $task,
                'csrf' => Csrf::token(),
                'errors' => [],
                'categories' => $this->categoryRepo->findAll($userId),
                'tags' => $this->tagRepo->findAll($userId)
            ])
        );
    }

    public function update(Request $request, int $userId): Response
    {
        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $data = $request->request->all();
        $data['tag_ids'] = $request->request->all('tag_ids');

        $errors = $this->service->validate($data);
        if ($errors) {

            $task = $this->repo->find((int)$data['id'], $userId);
            $taskArray = array_merge((array)$task, $data);

            return new Response(
                $this->view->render('admin/tasks/edit', [
                    'task' => $taskArray,
                    'csrf' => Csrf::token(),
                    'errors' => $errors,
                    'categories' => $this->categoryRepo->findAll($userId),
                    'tags' => $this->tagRepo->findAll($userId)
                ]),
                422
            );
        }

        $task = $this->service->make($data);
        $this->repo->update($task, $userId);

        return new RedirectResponse('/admin/tasks/show?id=' . $task->id);
    }

    public function delete(Request $request, int $userId): Response
    {
        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $id = (int)$request->request->get('id', 0);

        if ($id > 0) {
            $this->repo->delete($id, $userId);
        }

        return new RedirectResponse('/admin/tasks');
    }
}
