<?php
namespace App\Controllers\Admin;
use App\Core\View;
use App\Repositories\TagRepository;

class TagController {
    private View $view;
    private TagRepository $repo;
    public function __construct() {
        $this->view = new View();
        $this->repo = new TagRepository();
    }

    private function adminAuth() {
        if (!session_id()) session_start();
        $u = $_SESSION['user'] ?? null;
        if (!$u || ($u['role'] ?? '') !== 'admin') { header('Location: /?p=auth/login'); exit; }
    }

    public function index() {
        $this->adminAuth();
        $cats = $this->repo->all();
        echo $this->view->render('admin/tags/index',['tags'=>$cats,'user'=>$_SESSION['user']]);
    }

    public function create() {
        $this->adminAuth();
        echo $this->view->render('admin/tags/create',['csrf'=>\App\Core\Csrf::token(),'errors'=>[],'old'=>[]]);
    }

    public function store() {
        $this->adminAuth();
        if (!\App\Core\Csrf::validate($_POST['_csrf'] ?? '')) { echo 'CSRF inválido'; exit; }
        $name = trim($_POST['name'] ?? '');
        if ($name==='') { echo 'Nome obrigatório'; exit; }
        $this->repo->create($name);
        header('Location: /?p=admin/tags'); exit;
    }

    public function edit() {
        $this->adminAuth();
        $id = (int)($_GET['id'] ?? 0);
        $cat = $this->repo->find($id);
        echo $this->view->render('admin/tags/edit',['tag'=>$cat,'csrf'=>\App\Core\Csrf::token(),'errors'=>[]]);
    }

    public function update() {
        $this->adminAuth();
        if (!\App\Core\Csrf::validate($_POST['_csrf'] ?? '')) { echo 'CSRF inválido'; exit; }
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $this->repo->update($id,$name);
        header('Location: /?p=admin/tags'); exit;
    }

    public function delete() {
        $this->adminAuth();
        if (!\App\Core\Csrf::validate($_POST['_csrf'] ?? '')) { echo 'CSRF inválido'; exit; }
        $id = (int)($_POST['id'] ?? 0);
        $this->repo->delete($id);
        header('Location: /?p=admin/tags'); exit;
    }
}
