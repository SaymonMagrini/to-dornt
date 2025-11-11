<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Category;
use PDO;

class TagRepository
{
    public function countAll(): int
    {
        $stmt = Database::getConnection()->query("SELECT COUNT(*) FROM tags");
        return (int)$stmt->fetchColumn();
    }

    public function paginate(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = Database::getConnection()->prepare("SELECT * FROM tags ORDER BY id DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM tags WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(Category $tag): int
    {
        $stmt = Database::getConnection()->prepare("INSERT INTO tags (name, text) VALUES (?, ?)");
        $stmt->execute([$tag->name, $tag->text]);
        return (int)Database::getConnection()->lastInsertId();
    }

    public function update(Category $tag): bool
    {
        $stmt = Database::getConnection()->prepare("UPDATE tags SET name = ?, text = ? WHERE id = ?");
        return $stmt->execute([$tag->name, $tag->text, $tag->id]);
    }

    public function delete(int $id): bool
    {
        $stmt = Database::getConnection()->prepare("DELETE FROM tags WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
