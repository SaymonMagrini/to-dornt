<?php
namespace App\Repositories;

use App\Core\Database;

use PDO;

class TaskRepository
{
    
    public function countByUser(int $userId): int
    {
        $stmt = Database::getConnection()->prepare("SELECT COUNT(*) FROM tasks WHERE user_id = ?");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }

    
    public function allByUser(int $userId): array
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function create(int $userId, string $title): int
    {
        $stmt = Database::getConnection()->prepare("INSERT INTO tasks (user_id, title, done) VALUES (?, ?, 0)");
        $stmt->execute([$userId, $title]);
        return (int)Database::getConnection()->lastInsertId();
    }

    
    public function toggleDone(int $id): bool
    {
        $stmt = Database::getConnection()->prepare("UPDATE tasks SET done = NOT done WHERE id = ?");
        return $stmt->execute([$id]);
    }

   
    public function delete(int $id): bool
    {
        $stmt = Database::getConnection()->prepare("DELETE FROM tasks WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
