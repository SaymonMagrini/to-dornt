<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Task;
use PDO;

class TaskRepository
{
    public function countAll(int $userId): int
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT COUNT(*) FROM tasks WHERE user_id = ?"
        );
        $stmt->execute([$userId]);

        return (int)$stmt->fetchColumn();
    }

    public function paginate(int $userId, int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;

        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tasks
             WHERE user_id = :user_id
             ORDER BY id DESC
             LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit',  $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset,  PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id, int $userId): ?array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tasks WHERE id = ? AND user_id = ?"
        );

        $stmt->execute([$id, $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $row['tag_ids'] = $this->getTagIds($id);

        return $row;
    }

    public function create(Task $task, int $userId): int
    {
        $stmt = Database::getConnection()->prepare(
            "INSERT INTO tasks (user_id, category_id, title, description, due_to, done, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->execute([
            $userId,
            $task->category_id,
            $task->title,
            $task->description,
            $task->due_to,
            $task->done,
            $task->created_at
        ]);

        $taskId = (int)Database::getConnection()->lastInsertId();

        $this->syncTags($taskId, $task->tag_ids);

        return $taskId;
    }

    public function update(Task $task, int $userId): bool
    {
        $stmt = Database::getConnection()->prepare(
            "UPDATE tasks
             SET category_id = ?, title = ?, description = ?, due_to = ?, done = ?
             WHERE id = ? AND user_id = ?"
        );

        $result = $stmt->execute([
            $task->category_id,
            $task->title,
            $task->description,
            $task->due_to,
            $task->done,
            $task->id,
            $userId
        ]);

        $this->syncTags($task->id, $task->tag_ids);

        return $result;
    }

    public function delete(int $id, int $userId): bool
    {
        $this->clearTags($id);

        $stmt = Database::getConnection()->prepare(
            "DELETE FROM tasks WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([$id, $userId]);
    }

    public function findAll(int $userId): array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tasks
             WHERE user_id = ?
             ORDER BY id DESC"
        );

        $stmt->execute([$userId]);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tasks as &$task) {
            $task['tag_ids'] = $this->getTagIds($task['id']);
        }

        return $tasks;
    }

    public function findByCategory(int $categoryId, int $userId): array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tasks
             WHERE category_id = ?
             AND user_id = ?
             ORDER BY id DESC"
        );

        $stmt->execute([$categoryId, $userId]);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tasks as &$task) {
            $task['tag_ids'] = $this->getTagIds($task['id']);
        }

        return $tasks;
    }

    public function findByTag(int $tagId, int $userId): array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT t.* FROM tasks t
             INNER JOIN task_tag tt ON t.id = tt.task_id
             WHERE tt.tag_id = ?
               AND t.user_id = ?
             ORDER BY t.id DESC"
        );

        $stmt->execute([$tagId, $userId]);
        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tasks as &$task) {
            $task['tag_ids'] = $this->getTagIds($task['id']);
        }

        return $tasks;
    }

    private function getTagIds(int $taskId): array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT tag_id FROM task_tag WHERE task_id = ?"
        );
        $stmt->execute([$taskId]);

        return array_column($stmt->fetchAll(), 'tag_id');
    }

    private function clearTags(int $taskId): void
    {
        $stmt = Database::getConnection()->prepare(
            "DELETE FROM task_tag WHERE task_id = ?"
        );
        $stmt->execute([$taskId]);
    }

    private function syncTags(int $taskId, array $tagIds): void
    {
        $this->clearTags($taskId);

        if (!empty($tagIds)) {
            $stmt = Database::getConnection()->prepare(
                "INSERT INTO task_tag (task_id, tag_id) VALUES (?, ?)"
            );

            foreach ($tagIds as $tagId) {
                $stmt->execute([$taskId, $tagId]);
            }
        }
    }
}
