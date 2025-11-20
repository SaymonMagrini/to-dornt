<?php
namespace App\Repositories;

use App\Core\Database;
use App\Models\Task;
use PDO;

class TaskRepository
{
    /** Conta todas as tasks do usuário */
    public function countAll(int $userId): int
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT COUNT(*) FROM tasks WHERE user_id = ?"
        );
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }

    /** Paginação */
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

        // Adiciona tags para cada task
        foreach ($tasks as &$task) {
            $task['tags'] = $this->getTags($task['id']);
        }

        return $tasks;
    }

    /** Busca task por ID */
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

    /** Cria task */
    public function create(Task $task, int $userId): int
    {
        $stmt = Database::getConnection()->prepare("
            INSERT INTO tasks (title, description, category_id, user_id)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $task->title,
            $task->description,
            $task->category_id,
            $userId
        ]);

        $taskId = (int)Database::getConnection()->lastInsertId();

        // vinculando tags
        $this->syncTags($taskId, $task->tag_ids);

        return $taskId;
    }

    /** Atualiza task */
    public function update(Task $task, int $userId): bool
    {
        $stmt = Database::getConnection()->prepare("
            UPDATE tasks
            SET title = ?, description = ?, category_id = ?
            WHERE id = ? AND user_id = ?
        ");

        $result = $stmt->execute([
            $task->title,
            $task->description,
            $task->category_id,
            $task->id,
            $userId
        ]);

        // Atualiza tags
        $this->syncTags($task->id, $task->tag_ids);

        return $result;
    }

    /** Deleta task */
    public function delete(int $id, int $userId): bool
    {
        Database::getConnection()->prepare("DELETE FROM task_tag WHERE task_id = ?")->execute([$id]);

        $stmt = Database::getConnection()->prepare(
            "DELETE FROM tasks WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([$id, $userId]);
    }

    /** Busca tags da task */
    private function getTags(int $taskId): array
    {
        $stmt = Database::getConnection()->prepare("
            SELECT tags.id, tags.name
            FROM tags
            INNER JOIN task_tag ON task_tag.tag_id = tags.id
            WHERE task_tag.task_id = ?
        ");

        $stmt->execute([$taskId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Atualiza as tags relacionadas */
    private function syncTags(int $taskId, array $tags): void
    {
      
        Database::getConnection()->prepare("DELETE FROM task_tag WHERE task_id = ?")
            ->execute([$taskId]);

       
        foreach ($tags as $tagId) {
            $stmt = Database::getConnection()->prepare(
                "INSERT INTO task_tag (task_id, tag_id) VALUES (?, ?)"
            );
            $stmt->execute([$taskId, $tagId]);
        }
    }
}
