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

        if (!empty($data['due_to'])) {
            $dueTo = trim($data['due_to']);
            if (strtotime($dueTo) === false) {
                $errors['due_to'] = 'Data de entrega inválida';
            }
        }

        if (
            isset($data['is_completed'])
            && !in_array($data['is_completed'], [true, false, 0, 1, '0', '1'], true)
        ) {
            $errors['is_completed'] = 'Valor inválido para is_completed';
        }

        return $errors;
    }

    public function make(array $data): Task
    {
        $id = isset($data['id']) ? (int) $data['id'] : null;

        $title = trim($data['title'] ?? '');
        $description = isset($data['description']) ? trim($data['description']) : null;
        $dueTo = isset($data['due_to']) && trim($data['due_to']) !== ''
            ? trim($data['due_to'])
            : null;

        $isCompleted = isset($data['is_completed'])
            ? (bool) $data['is_completed']
            : false;

        $createdAt = $data['created_at'] ?? '';

        return new Task(
            $id,
            $title,
            $description,
            $dueTo,
            $isCompleted,
            $createdAt
        );
    }
}
