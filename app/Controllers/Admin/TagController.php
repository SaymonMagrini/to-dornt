<?php

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\Flash;
use App\Core\View;
use App\Repositories\TagRepository;
use App\Repositories\TaskRepository;
use App\Services\TagService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TagController
{
    private View $view;
    private TagRepository $repo;
    private TagService $service;
    private TaskRepository $taskRepo;

    public function __construct()
    {
        $this->view = new View();
        $this->repo = new TagRepository();
        $this->service = new TagService();
        $this->taskRepo = new TaskRepository();
    }

    public function index(Request $request, int $userId): Response
    {
        $page = max(1, (int)$request->query->get('page', 1));
        $perPage = 5;

        $total = $this->repo->countAll($userId);
        $tags = $this->repo->paginate($userId, $page, $perPage);
        $pages = (int)ceil($total / $perPage);

        $html = $this->view->render('admin/tags/index', compact('tags', 'page', 'pages'));
        return new Response($html);
    }

    public function create(int $userId): Response
    {
        $html = $this->view->render('admin/tags/create', [
            'csrf' => Csrf::token(),
            'errors' => [],
            'old' => []
        ]);
        return new Response($html);
    }

    public function store(Request $request, int $userId): Response
    {
        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $data = $request->request->all();
        $errors = $this->service->validate($data);

        if ($errors) {
            $html = $this->view->render('admin/tags/create', [
                'csrf' => Csrf::token(),
                'errors' => $errors,
                'old' => $data
            ]);
            return new Response($html, 422);
        }

        $category = $this->service->make($data);
        $this->repo->create($category);

        Flash::push('success', "Tag criada com sucesso!");
        return new RedirectResponse('/admin/tags');
    }

    public function show(Request $request, int $userId): Response
    {
        $id = (int)$request->query->get('id', 0);
        $category = $this->repo->find($id, $userId);

        if (!$category) {
            return new Response('Tag não encontrada', 404);
        }

        $html = $this->view->render('admin/tags/show', ['category' => $category]);
        return new Response($html);
    }

    public function edit(Request $request, int $userId): Response
    {
        $id = (int)$request->query->get('id', 0);
        $category = $this->repo->find($id, $userId);

        if (!$category) {
            return new Response('Tag não encontrada', 404);
        }

        $html = $this->view->render('admin/tags/edit', [
            'category' => $category,
            'csrf' => Csrf::token(),
            'errors' => []
        ]);

        return new Response($html);
    }

    public function update(Request $request, int $userId): Response
    {
        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $data = $request->request->all();
        $errors = $this->service->validate($data);

        if ($errors) {
            $category = $this->repo->find((int)$data['id'], $userId);

            $html = $this->view->render('admin/tags/edit', [
                'category' => array_merge($category, $data),
                'csrf' => Csrf::token(),
                'errors' => $errors
            ]);

            return new Response($html, 422);
        }

        $category = $this->service->make($data);

        if (!$category->id) {
            return new Response('ID inválido', 422);
        }

        $this->repo->update($category);

        Flash::push('success', "Tag atualizada com sucesso!");
        return new RedirectResponse('/admin/tags');
    }

    public function delete(Request $request, int $userId): Response
    {
        $categoryId = (int)$request->request->get('id', 0);

        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }


        if ($categoryId > 0) {
            $this->repo->delete($categoryId, $userId);
        }

        Flash::push('success', "Tag excluída com sucesso!");
        return new RedirectResponse('/admin/tags');
    }
}
