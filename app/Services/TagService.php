<?php
namespace App\Services;

use App\Models\Tag;

class TagService {
    public function validate(array $data): array {
        $errors = [];
        $name = trim($data['name'] ?? '');
    
        if ($name === '') $errors['name'] = 'Nome é obrigatório';

        return $errors;
    }

    public function make(array $data): Tag {
        $userId = trim($data['userId'] ?? '');
        $name = trim($data['name'] ?? '');
        $description = trim($data['description'] ?? '');
        $id = isset($data['id']) ? (int)$data['id'] : null;
        return new Tag($id, $userId, $name, $description);
    }
}
