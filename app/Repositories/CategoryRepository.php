<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Category;
use PDO;

class CategoryRepository
{
    public function countAll(int $userId): int
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT COUNT(*) FROM categories WHERE user_id = ?"
        );
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }

    public function paginate(int $userId, int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;

        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM categories 
             WHERE user_id = :user_id
             ORDER BY id DESC 
             LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function find(int $id, int $userId): ?array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM categories WHERE id = ? AND user_id = ?"
        );

        $stmt->execute([$id, $userId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function create(Category $category): int
    {
        $stmt = Database::getConnection()->prepare(
            "INSERT INTO categories (user_id, name, description) VALUES (?, ?, ?)"
        );

        $stmt->execute([
            $category->userId,
            $category->name,
            $category->description
        ]);

        return (int)Database::getConnection()->lastInsertId();
    }

    public function update(Category $category): bool
    {
        $stmt = Database::getConnection()->prepare(
            "UPDATE categories 
             SET name = ?, description = ?
             WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([
            $category->name,
            $category->description,
            $category->id,
            $category->userId
        ]);
    }

    public function delete(int $id, int $userId): bool
    {
        $stmt = Database::getConnection()->prepare(
            "DELETE FROM categories WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([$id, $userId]);
    }

    public function findAll(int $userId): array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM categories 
             WHERE user_id = ?
             ORDER BY id DESC"
        );

        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getArray(int $userId): array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT id, name FROM categories 
             WHERE user_id = ?
             ORDER BY id DESC"
        );

        $stmt->execute([$userId]);

        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $return = [];
        foreach ($categories as $category) {
            $return[$category['id']] = $category['name'];
        }

        return $return;
    }
}
