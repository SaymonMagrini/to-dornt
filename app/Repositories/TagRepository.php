<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Tag;
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
        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tags ORDER BY id DESC LIMIT :limit OFFSET :offset"
        );
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

    public function create(Tag $tag): int
    {
        $stmt = Database::getConnection()->prepare(
            "INSERT INTO tags (name, description) VALUES (?, ?)"
        );
        $stmt->execute([$tag->name, $tag->description]);
        return (int)Database::getConnection()->lastInsertId();
    }

    public function update(Tag $tag): bool
    {
        $stmt = Database::getConnection()->prepare(
            "UPDATE tags SET name = ?, description = ? WHERE id = ?"
        );
        return $stmt->execute([$tag->name, $tag->description, $tag->id]);
    }

    public function delete(int $id): bool
    {
        $stmt = Database::getConnection()->prepare("DELETE FROM tags WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findAll(): array
    {
        $stmt = Database::getConnection()->query("SELECT * FROM tags ORDER BY id DESC");
        return $stmt->fetchAll();
    }
}