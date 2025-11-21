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


    public function paginate(int $page, int $perPage, int $userId): array
    {
        $offset = ($page - 1) * $perPage;

        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC LIMIT ? OFFSET ?"
        );

        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();

        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        foreach ($tasks as &$task) {
            $task['tags'] = $this->getTags($task['id']);
        }

        return $tasks;
    }

  
    public function find(int $id, int $userId): ?array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tasks WHERE id = ? AND user_id = ? LIMIT 1"
        );
        $stmt->execute([$id, $userId]);

        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($task) {
            $task['tags'] = $this->getTags($id);
        }

        return $task ?: null;
    }

    /** Cria nova task */
    public function create(Task $task, int $userId): int
    {
        $stmt = Database::getConnection()->prepare("
            INSERT INTO tasks (title, description, category_id, due_date, done, user_id, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->execute([
            $task->title,
            $task->description ?? null,
            $task->category_id ?? null,
            $task->due_date ?? null,
            $task->done ?? 0,
            $userId
        ]);

        $taskId = (int)Database::getConnection()->lastInsertId();

     
        $this->syncTags($taskId, $task->tag_ids ?? []);

        return $taskId;
    }

  
    public function update(Task $task, int $userId): bool
    {
        $stmt = Database::getConnection()->prepare("
            UPDATE tasks
            SET title = ?, description = ?, category_id = ?, due_date = ?, done = ?
            WHERE id = ? AND user_id = ?
        ");

        $result = $stmt->execute([
            $task->title,
            $task->description ?? null,
            $task->category_id ?? null,
            $task->due_date ?? null,
            $task->done ?? 0,
            $task->id,
            $userId
        ]);

        $this->syncTags($task->id, $task->tag_ids ?? []);

        return $result;
    }

    /** Deleta task e suas relações */
    public function delete(int $id, int $userId): bool
    {
        // Remove relações com tags primeiro
        Database::getConnection()
            ->prepare("DELETE FROM task_tag WHERE task_id = ?")
            ->execute([$id]);

        $stmt = Database::getConnection()->prepare(
            "DELETE FROM tasks WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([$id, $userId]);
    }


    private function getTags(int $taskId): array
    {
        $stmt = Database::getConnection()->prepare("
            SELECT t.id, t.name
            FROM tags t
            INNER JOIN task_tag tt ON tt.tag_id = t.id
            WHERE tt.task_id = ?
        ");

        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    private function syncTags(int $taskId, array $tagIds): void
    {
    
        Database::getConnection()
            ->prepare("DELETE FROM task_tag WHERE task_id = ?")
            ->execute([$taskId]);

       
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