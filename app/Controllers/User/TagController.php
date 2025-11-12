<?php
namespace App\Controllers;

use App\Core\Csrf;
use App\Core\View;
use App\Repositories\TagRepository;
use App\Services\TagService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TagController {
    private View $view;
    private TagRepository $repo;
    private TagService $service;

    public function __construct() {
        $this->view = new View();
        $this->repo = new TagRepository();
        $this->service = new TagService();
    }

    public function index(Request $request): Response {
        $page = max(1, (int)$request->query->get('page', 1));
        $perPage = 5;
        $total = $this->repo->countAll();
        $tags = $this->repo->paginate($page, $perPage);
        $pages = (int)ceil($total / $perPage);
        $html = $this->view->render('user/tags/index', compact('tags','page','pages'));
        return new Response($html);
    }

    public function create(): Response {
        $html = $this->view->render('user/tags/create', ['csrf' => Csrf::token(), 'errors' => []]);
        return new Response($html);
    }

    public function store(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $errors = $this->service->validate($request->request->all());
        if ($errors) {
            $html = $this->view->render('user/tags/create', ['csrf' => Csrf::token(), 'errors' => $errors, 'old' => $request->request->all()]);
            return new Response($html, 422);
        }
        $tag = $this->service->make($request->request->all());
        $id = $this->repo->create($tag);
        return new RedirectResponse('/user/tags/show?id=' . $id);
    }

    public function show(Request $request): Response {
        $id = (int)$request->query->get('id', 0);
        $tag = $this->repo->find($id);
        if (!$tag) return new Response('Categoria não encontrada', 404);
        $html = $this->view->render('user/tags/show', ['tag' => $tag]);
        return new Response($html);
    }

    public function edit(Request $request): Response {
        $id = (int)$request->query->get('id', 0);
        $tag = $this->repo->find($id);
        if (!$tag) return new Response('Categoria não encontrada', 404);
        $html = $this->view->render('user/tags/edit', ['tag' => $tag, 'csrf' => Csrf::token(), 'errors' => []]);
        return new Response($html);
    }

    public function update(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $data = $request->request->all();
        $file = $request->files->get('image');
        $errors = $this->service->validate($data);
        if ($errors) {
            $html = $this->view->render('user/tags/edit', ['tag' => array_merge($this->repo->find((int)$data['id']), $data), 'csrf' => Csrf::token(), 'errors' => $errors]);
            return new Response($html, 422);
        }
        $tag = $this->service->make($data);
        if (!$tag->id) return new Response('ID inválido', 422);
        $this->repo->update($tag);
        return new RedirectResponse('/user/tags/show?id=' . $tag->id);
    }

    public function delete(Request $request): Response {
        if (!Csrf::validate($request->request->get('_csrf'))) return new Response('Token CSRF inválido', 419);
        $id = (int)$request->request->get('id', 0);
        if ($id > 0) $this->repo->delete($id);
        return new RedirectResponse('/user/tags');
    }
}
