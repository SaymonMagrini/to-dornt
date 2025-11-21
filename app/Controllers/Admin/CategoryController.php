<?php

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Core\View;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController
{
    private View $view;
    private CategoryRepository $repo;
    private CategoryService $service;

    public function __construct()
    {
        $this->view = new View();
        $this->repo = new CategoryRepository();
        $this->service = new CategoryService();
    }

    private function getUserId(): int
    {
        return (int) ($_SESSION['user_id'] ?? 0);
    }

    public function index(Request $request): Response
    {
        $userId = $this->getUserId();
        
        if ($userId === 0) {
            $_SESSION['error'] = 'Acesso negado. Por favor, faça login.';
            return new RedirectResponse('/');
        }

        $page = max(1, (int)$request->query->get('page', 1));
        $perPage = 5;

        $total = $this->repo->countAll($userId);
        $categories = $this->repo->paginate( $page, $perPage, $userId);
        $pages = (int)ceil($total / $perPage);

        $html = $this->view->render('admin/categories/index', compact('categories', 'page', 'pages'));
        return new Response($html);
    }

    public function create(): Response
    {
        $userId = $this->getUserId();
        
        if ($userId === 0) {
            $_SESSION['error'] = 'Acesso negado. Por favor, faça login.';
            return new RedirectResponse('/');
        }
        
        $html = $this->view->render('admin/categories/create', [
            'csrf' => Csrf::token(),
            'errors' => [],
            'old' => []
        ]);
        return new Response($html);
    }

    public function store(Request $request): Response
    {
        $userId = $this->getUserId();

        if ($userId === 0) {
            $_SESSION['error'] = 'Acesso negado. Por favor, faça login.';
            return new RedirectResponse('/');
        }

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
        
        $id = $this->repo->create($category, $userId);

        $_SESSION['success'] = 'Categoria criada com sucesso!';
        return new RedirectResponse('/admin/categories');
    }

    public function show(Request $request): Response
    {
        $userId = $this->getUserId();

        if ($userId === 0) {
            $_SESSION['error'] = 'Acesso negado. Por favor, faça login.';
            return new RedirectResponse('/');
        }

        $id = (int)$request->query->get('id', 0);
        $category = $this->repo->find($id, $userId);

        if (!$category) {
            return new Response('Categoria não encontrada', 404);
        }

        $html = $this->view->render('admin/categories/show', ['category' => $category]);
        return new Response($html);
    }

    public function edit(Request $request): Response
    {
        $userId = $this->getUserId();

        if ($userId === 0) {
            $_SESSION['error'] = 'Acesso negado. Por favor, faça login.';
            return new RedirectResponse('/');
        }

        $id = (int)$request->query->get('id', 0);
        $category = $this->repo->find($id, $userId);

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
        $userId = $this->getUserId();

        if ($userId === 0) {
            $_SESSION['error'] = 'Acesso negado. Por favor, faça login.';
            return new RedirectResponse('/');
        }

        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        $data = $request->request->all();
        $errors = $this->service->validate($data);

        if ($errors) {
            $category = $this->repo->find((int)$data['id'], $userId);

            $categoryData = $category ? (array)$category : [];
            
            $html = $this->view->render('admin/categories/edit', [
                'category' => array_merge($categoryData, $data),
                'csrf' => Csrf::token(),
                'errors' => $errors
            ]);

            return new Response($html, 422);
        }

        $category = $this->service->make($data);

        if (!$category->id) {
            return new Response('ID inválido', 422);
        }

        $this->repo->update($category, $userId); 

        $_SESSION['success'] = 'Categoria atualizada com sucesso!';
        return new RedirectResponse('/admin/categories');
    }

    public function delete(Request $request): Response
    {
        $userId = $this->getUserId();
        
        if ($userId === 0) {
            $_SESSION['error'] = 'Acesso negado. Por favor, faça login.';
            return new RedirectResponse('/');
        }

        $categoryId = (int)$request->request->get('id', 0);

        if (!Csrf::validate($request->request->get('_csrf'))) {
            return new Response('Token CSRF inválido', 419);
        }

        if ($categoryId > 0) {
            $this->repo->delete($categoryId, $userId);
        }

        $_SESSION['success'] = 'Categoria excluída com sucesso!';
        return new RedirectResponse('/admin/categories');
    }
}