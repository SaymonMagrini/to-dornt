<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Tag;
use PDO;
use App\Repositories\TaskRepository;


class TagRepository
{
    public TaskRepository $taskRepo;

    public function countAll(): int
    {
     $userId = $taskRepo->userId ?? 0;

        $stmt = Database::getConnection()->prepare(
            "SELECT COUNT(*) FROM tags WHERE user_id = ?"
        );
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }

    public function paginate(int $page, int $perPage): array
    {
             $userId = $taskRepo->userId ?? 0;

        $offset = ($page - 1) * $perPage;

        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tags 
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
            "SELECT * FROM tags WHERE id = ? AND user_id = ?"
        );

        $stmt->execute([$id, $userId]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function findMany(array $ids, int $userId): array
{
    if (empty($ids)) {
        return [];
    }

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $params = array_merge($ids, [$userId]);

    $stmt = Database::getConnection()->prepare(
        "SELECT * FROM tags 
         WHERE id IN ($placeholders) 
         AND user_id = ?"
    );

    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function create(Tag $tag): int
    {
        $stmt = Database::getConnection()->prepare(
            "INSERT INTO tags (user_id, name, description) VALUES (?, ?, ?)"
        );

        $stmt->execute([
            $tag->userId,
            $tag->name,
            $tag->description
        ]);

        return (int)Database::getConnection()->lastInsertId();
    }

    public function update(Tag $tag): bool
    {
        $stmt = Database::getConnection()->prepare(
            "UPDATE tags 
             SET name = ?, description = ?
             WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([
            $tag->name,
            $tag->description,
            $tag->id,
            $tag->userId
        ]);
    }

    public function delete(int $id, int $userId): bool
    {
        $stmt = Database::getConnection()->prepare(
            "DELETE FROM tags WHERE id = ? AND user_id = ?"
        );

        return $stmt->execute([$id, $userId]);
    }

    public function findAll(int $userId): array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM tags 
             WHERE user_id = ?
             ORDER BY id DESC"
        );

        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getArray(int $userId): array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT id, name FROM tags 
             WHERE user_id = ?
             ORDER BY id DESC"
        );

        $stmt->execute([$userId]);

        $tags = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $return = [];
        foreach ($tags as $tag) {
            $return[$tag['id']] = $tag['name'];
        }

        return $return;
    }
}
