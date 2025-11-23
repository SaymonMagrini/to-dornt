<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function validate(array $data): array
    {
        $errors = [];

        $title = trim($data['name'] ?? '');
        if ($title === '') {
            $errors['name'] = 'Título é obrigatório';
        }

        if (empty($data['category_id']) || !ctype_digit((string) $data['category_id'])) {
            $errors['category_id'] = 'Categoria é obrigatória';
        }

        if (!isset($data['tag_ids']) || !is_array($data['tag_ids'])) {
            $errors['tag_ids'] = 'Tags inválidas';
        } else {
            foreach ($data['tag_ids'] as $tagId) {
                if (!ctype_digit((string) $tagId)) {
                    $errors['tag_ids'] = 'Lista de tags contém valores inválidos';
                    break;
                }
            }
        }

        if (!empty($data['due_date'])) {
            $date = date_create($data['due_date']);
            if (!$date) {
                $errors['due_date'] = 'Data de entrega inválida';
            }
        }

        return $errors;
    }

    public function make(array $data): Task
    {
        return new Task(
            isset($data['id']) ? (int) $data['id'] : null,
            (int) ($data['category_id'] ?? 0),
            trim($data['name'] ?? ''),
            $data['tag_ids'] ?? [],
            trim($data['description'] ?? '') ?: null,
            $data['due_date'] ?? null,
            isset($data['done']) ? (bool) $data['done'] : false,
            $data['created_at'] ?? null
        );
    }
}