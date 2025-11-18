<?php
namespace App\Repositories;
use App\Core\Database;
use PDO;

class TaskRepository {
    public function allByUser(int $userId): array {
        $db = Database::getConnection();
        $stmt = $db->prepare(
            'SELECT t.*, GROUP_CONCAT(c.name) AS categories
             FROM tasks t
             LEFT JOIN task_categories tc ON tc.task_id = t.id
             LEFT JOIN categories c ON c.id = tc.category_id
             WHERE t.user_id = ? GROUP BY t.id ORDER BY t.id DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $userId, string $title, ?string $description = null): int {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO tasks (user_id,title,description,done) VALUES (?,?,?,0)');
        $stmt->execute([$userId,$title,$description]);
        return (int)$db->lastInsertId();
    }

    public function find(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM tasks WHERE id=?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function update(int $id, string $title, ?string $description, bool $done): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE tasks SET title=?,description=?,done=? WHERE id=?');
        return $stmt->execute([$title,$description,(int)$done,$id]);
    }

    public function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM tasks WHERE id=?');
        return $stmt->execute([$id]);
    }

    public function toggleDone(int $id): bool {
        $db = Database::getConnection();
        
        $stmt = $db->prepare('UPDATE tasks SET done = CASE WHEN done=1 THEN 0 ELSE 1 END WHERE id=?');
        return $stmt->execute([$id]);
    }
}
