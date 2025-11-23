<?php

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\Flash;
use App\Core\View;
use App\Repositories\CategoryRepository;
use App\Repositories\TaskRepository;
use App\Services\CategoryService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController
{
    private View $view;
    private CategoryRepository $repo;
    private CategoryService $service;
    private TaskRepository $taskRepo;

    public function __construct()
    {
        $this->view = new View();
        $this->repo = new CategoryRepository();
        $this->service = new CategoryService();
        $this->taskRepo = new TaskRepository();
    }

    public function index(Request $request): Response
    {
        $page = max(1, (int) $request->query->get('page', 1));
        $perPage = 5;

        $total = $this->repo->countAll();
        $categories = $this->repo->paginate($page, $perPage);
        $pages = (int) ceil($total / $perPage);

        $html = $this->view->render('admin/categories/index', compact('categories', 'page', 'pages'));
        return new Response($html);
    }

    public function create(): Response
    {
        $html = $this->view->render('admin/categories/create', [
            'csrf' => Csrf::token(),
            'errors' => [],
            'old' => []
        ]);
        return new Response($html);
    }

    public function store(Request $request): Response
    {
        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $data = $request->request->all();
        $errors = $this->service->validate($data);

        if ($errors) {
            $html = $this->view->render('admin/categories/create', [
                'csrf' => Csrf::token(),
                'errors' => $errors,
                'old' => $data
            ]);
            return new Response($html, 422);
        }

        $category = $this->service->make($data);
        $this->repo->create($category);

        Flash::push('success', "Categoria criada com sucesso!");
        return new RedirectResponse('/admin/categories');
    }

    public function show(Request $request): Response
    {
        $id = (int) $request->query->get('id', 0);
        $category = $this->repo->find($id);

        if (!$category) {
            return new Response('Categoria não encontrada', 404);
        }

        $html = $this->view->render('admin/categories/show', ['category' => $category]);
        return new Response($html);
    }

    public function edit(Request $request): Response
    {
        $id = (int) $request->query->get('id', 0);
        $category = $this->repo->find($id);

        if (!$category) {
            return new Response('Categoria não encontrada', 404);
        }

        $html = $this->view->render('admin/categories/edit', [
            'category' => $category,
            'csrf' => Csrf::token(),
            'errors' => []
        ]);

        return new Response($html);
    }

    public function update(Request $request): Response
    {
        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $data = $request->request->all();
        $errors = $this->service->validate($data);

        if ($errors) {
            $category = $this->repo->find((int) $data['id']);

            $html = $this->view->render('admin/categories/edit', [
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

        Flash::push('success', "Categoria atualizada com sucesso!");
        return new RedirectResponse('/admin/categories');
    }

    public function delete(Request $request): Response
    {
        $categoryId = (int) $request->request->get('id', 0);

        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }


        if ($categoryId > 0) {
            $this->repo->delete($categoryId);
        }

        Flash::push('success', "Categoria excluída com sucesso!");
        return new RedirectResponse('/admin/categories');
    }
}
