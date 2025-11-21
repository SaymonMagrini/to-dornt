<?php
namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function validate(array $data): array
    {
        $errors = [];

        $name = trim($data['name'] ?? '');
        if ($name === '') {
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
    $id = isset($data['id']) ? (int) $data['id'] : null;
    $category_id = (int) ($data['category_id'] ?? 0);
    $tag_ids = $data['tag_ids'] ?? [];
    $name = trim($data['name'] ?? '');
    $description = trim($data['description'] ?? '') ?: null;

    $due_date = $data['due_date'] ?? null;
    $done = !empty($data['done']) ? 1 : 0;
    $created_at = '';  

    return new Task(
        $id,
        $category_id,
        $name,
        $tag_ids,
        $description,
        $due_date,
        (bool) $done,
        $created_at
    );
}
}
