<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Category;
use PDO;

class CategoryRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_CLASS);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_PROPS_LATE);
    }

    public function countAll(int $userId): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM categories WHERE user_id = ?"
        );
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }

    public function paginate(int $page, int $perPage, int $userId): array
    {
        $offset = ($page - 1) * $perPage;

        $stmt = $this->db->prepare(
            "SELECT * FROM categories 
             WHERE user_id = :user_id
             ORDER BY id DESC 
             LIMIT :limit OFFSET :offset"
        );

        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS, Category::class);
    }

    public function find(int $id, int $userId): ?Category
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM categories WHERE id = ? AND user_id = ?"
        );

        $stmt->execute([$id, $userId]);
        
        $stmt->setFetchMode(PDO::FETCH_CLASS, Category::class);
        $category = $stmt->fetch();

        return $category instanceof Category ? $category : null;
    }

    public function create(Category $category, int $userId): int
    {
        $stmt = $this->db->prepare(
            "INSERT INTO categories (user_id, name, description) VALUES (?, ?, ?)"
        );

        $stmt->execute([
            $userId,
            $category->name,
            $category->description
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function update(Category $category, int $userId): bool
    {
        $category->userId = $userId;
        
        $stmt = $this->db->prepare(
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
        $stmt = $this->db->prepare(
            "DELETE FROM categories WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([$id, $userId]);
    }

    public function findAll(int $userId): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM categories 
             WHERE user_id = ?
             ORDER BY id DESC"
        );

        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Category::class);
    }

    public function getArray(int $userId): array
    {
        $stmt = $this->db->prepare(
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