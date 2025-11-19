<?php
namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function validate(array $data): array
    {
        $errors = [];

        $title = trim($data['title'] ?? '');
        if ($title === '') {
            $errors['title'] = 'Título é obrigatório';
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

        if (!empty($data['due_to'])) {
            $date = date_create($data['due_to']);
            if (!$date) {
                $errors['due_to'] = 'Data de entrega inválida';
            }
        }

        return $errors;
    }

    public function make(array $data): Task
    {
        $id = isset($data['id']) ? (int) $data['id'] : null;
        $category_id = (int) ($data['category_id'] ?? 0);
        $tag_ids = $data['tag_ids'] ?? [];
        $title = trim($data['title'] ?? '');
        $description = trim($data['description'] ?? '') ?: null;
        $due_to = $data['due_to'] ?? null;
        $done = isset($data['done']) ? (bool) $data['done'] : false;
        $created_at = $data['created_at'] ?? '';

        return new Task(
            $id,
            $category_id,
            $title,
            $tag_ids,
            $description,
            $due_to,
            $done,
            $created_at
        );
    }
}
