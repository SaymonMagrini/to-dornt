<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Task;
use PDO;

class TaskRepository
{
    public function countAll(): int
    {
        return (int) Database::getConnection()
            ->query("SELECT COUNT(*) FROM tasks")
            ->fetchColumn();
    }


    public function paginate(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tasks ORDER BY id DESC LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    

    public function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare("
            SELECT t.*, c.name AS category_name
            FROM tasks t
            LEFT JOIN categories c ON c.id = t.category_id
            WHERE t.id = ?
            LIMIT 1
        ");
        $stmt->execute([$id]);

        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($task) {
            $task['tags'] = $this->getTags($id);
        }

        return $task ?: null;
    }

    public function findAll(): array
    {
        $stmt = Database::getConnection()->query("
            SELECT t.*, c.name AS category_name
            FROM tasks t
            LEFT JOIN categories c ON c.id = t.category_id
            ORDER BY t.id DESC
        ");

        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($tasks as &$task) {
            $task['tags'] = $this->getTags($task['id']);
        }

        return $tasks;
    }

    public function create(Task $task): int
    {
        $stmt = Database::getConnection()->prepare("
            INSERT INTO tasks (name, description, category_id, due_date, done, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");

        $stmt->execute([
            $task->name,
            $task->description,
            $task->category_id,
            $task->due_date,
            $task->done ? 1 : 0
        ]);

        $id = (int) Database::getConnection()->lastInsertId();
        $this->syncTags($id, $task->tag_ids);

        return $id;
    }

    public function update(Task $task): bool
    {
        $stmt = Database::getConnection()->prepare("
            UPDATE tasks
            SET name = ?, 
                description = ?, 
                category_id = ?, 
                due_date = ?, 
                done = ?
            WHERE id = ?
        ");

        $result = $stmt->execute([
            $task->name,
            $task->description,
            $task->category_id,
            $task->due_date,
            $task->done ? 1 : 0,
            $task->id
        ]);

        $this->syncTags($task->id, $task->tag_ids);

        return $result;
    }

    public function delete(int $id): bool
    {
        Database::getConnection()
            ->prepare("DELETE FROM task_tags WHERE task_id = ?")
            ->execute([$id]);

        $stmt = Database::getConnection()->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->execute([$id]);

        return $stmt->rowCount() > 0;
    }

    private function syncTags(int $taskId, array $tagIds): void
    {
        Database::getConnection()
            ->prepare("DELETE FROM task_tags WHERE task_id = ?")
            ->execute([$taskId]);

        if (!empty($tagIds)) {
            $stmt = Database::getConnection()->prepare("
                INSERT INTO task_tags (task_id, tag_id) VALUES (?, ?)
            ");

            foreach ($tagIds as $tagId) {
                $stmt->execute([$taskId, (int) $tagId]);
            }
        }
    }

    private function getTags(int $taskId): array
    {
        $stmt = Database::getConnection()->prepare("
            SELECT t.id, t.name
            FROM tags t
            INNER JOIN task_tags tt ON tt.tag_id = t.id
            WHERE tt.task_id = ?
        ");

        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}