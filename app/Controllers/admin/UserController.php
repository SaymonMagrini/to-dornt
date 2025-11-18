<?php
namespace App\Controllers\Admin;
use App\Core\View;
use App\Repositories\UserRepository;
use App\Services\UserService;

class UserController {
    private View $view;
    private UserRepository $repo;
    private UserService $service;
    public function __construct() {
        $this->view = new View();
        $this->repo = new UserRepository();
        $this->service = new UserService();
    }

    private function adminAuth() {
        if (!session_id()) session_start();
        $u = $_SESSION['user'] ?? null;
        if (!$u || ($u['role'] ?? '') !== 'admin') { header('Location: /?p=auth/login'); exit; }
    }

    public function index() {
        $this->adminAuth();
        $users = $this->repo->all();
        echo $this->view->render('admin/users/index', ['users'=>$users,'user'=>$_SESSION['user']]);
    }

    public function create() {
        $this->adminAuth();
        echo $this->view->render('admin/users/create', ['csrf'=>\App\Core\Csrf::token(),'errors'=>[],'old'=>[]]);
    }

    public function store() {
        $this->adminAuth();
        if (!\App\Core\Csrf::validate($_POST['_csrf'] ?? '')) { echo 'CSRF inválido'; exit; }
        $errors = $this->service->validate($_POST);
        if ($errors) {
            echo $this->view->render('admin/users/create',['csrf'=>\App\Core\Csrf::token(),'errors'=>$errors,'old'=>$_POST]);
            return;
        }
        $u = $this->service->make($_POST);
        $u->password = password_hash($_POST['password'] ?? '123456', PASSWORD_DEFAULT);
        $this->repo->create($u);
        header('Location: /?p=admin/users'); exit;
    }

    public function edit() {
        $this->adminAuth();
        $id = (int)($_GET['id'] ?? 0);
        $u = $this->repo->find($id);
        echo $this->view->render('admin/users/edit',['user'=>$u,'csrf'=>\App\Core\Csrf::token(),'errors'=>[]]);
    }

    public function update() {
        $this->adminAuth();
        if (!\App\Core\Csrf::validate($_POST['_csrf'] ?? '')) { echo 'CSRF inválido'; exit; }
        $data = $_POST;
        $errors = $this->service->validate($data, true);
        if ($errors) {
            echo $this->view->render('admin/users/edit',['user'=>array_merge($this->repo->find((int)$data['id']), $data),'csrf'=>\App\Core\Csrf::token(),'errors'=>$errors]);
            return;
        }
        $u = $this->service->make($data);
        $u->password = !empty($_POST['password']) ? password_hash($_POST['password'],PASSWORD_DEFAULT) : $this->repo->find((int)$data['id'])['password'];
        $u->id = (int)$data['id'];
        $this->repo->update((array)$u);
        header('Location: /?p=admin/users'); exit;
    }

    public function delete() {
        $this->adminAuth();
        if (!\App\Core\Csrf::validate($_POST['_csrf'] ?? '')) { echo 'CSRF inválido'; exit; }
        $id = (int)($_POST['id'] ?? 0);
        $this->repo->delete($id);
        header('Location: /?p=admin/users'); exit;
    }
}
