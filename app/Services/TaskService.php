<?php
namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function validate(array $data, ): array
    {
        $errors = [];
        $title = trim($data['name'] ?? '');

        if ($title === '')
            $errors['name'] = 'Nome é obrigatório';

        return $errors;
    }
    public function make(array $data, ?string $imagePath = null): Task
    {
        $title = trim($data['name'] ?? '');
        $id = isset($data['id']) ? (int) $data['id'] : null;
        return new Task($id, $title, , );
    }
}
