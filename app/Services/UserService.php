<?php
namespace App\Services;

class UserService {
    public function validate(array $data, bool $updating = false): array {
        $errors = [];
        if (empty($data['name'])) $errors[] = 'Nome obrigatório';
        if (empty($data['email'])) $errors[] = 'Email obrigatório';
        return $errors;
    }

    public function make(array $data): object {
        $u = new \stdClass();
        $u->id = $data['id'] ?? null;
        $u->name = trim($data['name'] ?? '');
        $u->email = trim($data['email'] ?? '');
        $u->password = $data['password'] ?? null;
        $u->role = $data['role'] ?? 'user';
        return $u;
    }
}
