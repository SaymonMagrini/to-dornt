<?php
namespace App\Repositories;

use App\Core\Database;
use App\Models\Task;
use PDO;

class TaskRepository {
    public function countAll(): int {
        $stmt = Database::getConnection()->query("SELECT COUNT(*) FROM tasks");
        return (int)$stmt->fetchColumn();
    }
    public function paginate(int $page, int $perPage): array {
        $offset = ($page - 1) * $perPage;
        $stmt = Database::getConnection()->prepare("SELECT * FROM tasks ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function find(int $id): ?array {
        $stmt = Database::getConnection()->prepare("SELECT * FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: [];
    }
    public function create(Task $p): int {
        $stmt = Database::getConnection()->prepare("INSERT INTO tasks (name, price, image_path) VALUES (?, ?, ?)");
        $stmt->execute([$p->name, $p->price, $p->image_path]);
        return (int)Database::getConnection()->lastInsertId();
    }
    public function update(Task $p): bool {
        $stmt = Database::getConnection()->prepare("UPDATE tasks SET name = ?, price = ?, image_path = ? WHERE id = ?");
        return $stmt->execute([$p->name, $p->price, $p->image_path, $p->id]);
    }
    public function delete(int $id): bool {
        $stmt = Database::getConnection()->prepare("DELETE FROM tasks WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
