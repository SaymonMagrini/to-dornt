<?php
namespace App\Repositories;
use App\Core\Database;
use PDO;

class CategoryRepository {
    public function all(): array {
        $db = Database::getConnection();
        return $db->query('SELECT * FROM categories ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM categories WHERE id=?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(string $name): int {
        $db = Database::getConnection();
        $stmt = $db->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->execute([$name]);
        return (int)$db->lastInsertId();
    }

    public function update(int $id, string $name): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE categories SET name=? WHERE id=?');
        return $stmt->execute([$name,$id]);
    }

    public function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM categories WHERE id=?');
        return $stmt->execute([$id]);
    }
}
