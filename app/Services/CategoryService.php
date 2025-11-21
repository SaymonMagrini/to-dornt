<?php
namespace App\Services;

use App\Models\Category;

class CategoryService {
    public function validate(array $data): array {
        $errors = [];
        $name = trim($data['name'] ?? '');
    
        if ($name === '') $errors['name'] = 'Nome é obrigatório';

        return $errors;
    }

    public function make(array $data): Category {
        $userId = isset($data['userId']) ? (int) $data['userId'] : null;
        
        $name = trim($data['name'] ?? '');
        $description = trim($data['description'] ?? '');
        $id = isset($data['id']) ? (int)$data['id'] : null;
        
        return new Category($id, $userId, $name, $description);
    }
}