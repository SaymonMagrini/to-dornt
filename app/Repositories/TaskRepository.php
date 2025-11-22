<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Task;
use PDO;

class TaskRepository
{

    public function countAll(): int
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT COUNT(*) FROM tasks"
        );
        $stmt->execute([]);
        return (int) $stmt->fetchColumn();
    }


    public function paginate(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;

        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tasks ORDER BY id DESC LIMIT ? OFFSET ?"
        );

        $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();

        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);


        foreach ($tasks as &$task) {
            $task['tags'] = $this->getTags($task['id']);
        }

        return $tasks;
    }

    private function syncTags(int $taskId, array $tagIds): void
    {

        Database::getConnection()
            ->prepare("DELETE FROM task_tags WHERE task_id = ?")
            ->execute([$taskId]);


        if (!empty($tagIds)) {
            $stmt = Database::getConnection()->prepare(
                "INSERT INTO task_tags (task_id, tag_id) VALUES (?, ?)"
            );
            foreach ($tagIds as $tagId) {
                $stmt->execute([$taskId, $tagId]);
            }
        }
    }


    public function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tasks WHERE id = ? LIMIT 1"
        );
        $stmt->execute([$id]);

        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($task) {
            $task['tags'] = $this->getTags($id);
        }

        return $task ?: null;
    }
    public function findAll(): array
{
    $stmt = Database::getConnection()->query(
        "SELECT * FROM tasks ORDER BY created_at DESC"
    );

    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($tasks as &$task) {
        $task['tags'] = $this->getTags($task['id']);
    }

    return $tasks;
}


    /** Cria nova task */
    public function create(Task $task): int
    {
        $stmt = Database::getConnection()->prepare("
            INSERT INTO tasks (name, description, category_id, due_date, done, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");

        $stmt->execute([
            $task->name,
            $task->description ?? null,
            $task->category_id ?? null,
            $task->due_date ?? null,
            (int) $task->done
        ]);

        $taskId = (int) Database::getConnection()->lastInsertId();


        $this->syncTags($taskId, $task->tag_ids ?? []);

        return $taskId;
    }


    public function update(Task $task): bool
    {
        $stmt = Database::getConnection()->prepare("
            UPDATE tasks
            SET name = ?, description = ?, category_id = ?, due_date = ?, done = ?
            WHERE id = ? AND user_id = ?
        ");

        $result = $stmt->execute([
            $task->name,
            $task->description ?? null,
            $task->category_id ?? null,
            $task->due_date ?? null,
            $task->done ?? 0,
            $task->id,

        ]);

        $this->syncTags($task->id, $task->tag_ids ?? []);

        return $result;
    }

    /** Deleta task e suas relações */
    public function delete(int $id): bool
    {
        // Remove relações com tags primeiro
        Database::getConnection()
            ->prepare("DELETE FROM task_tags WHERE task_id = ?")
            ->execute([$id]);

        $stmt = Database::getConnection()->prepare(
            "DELETE FROM tasks WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([$id]);
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
