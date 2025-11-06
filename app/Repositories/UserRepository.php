<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;

class UserRepository
{
    public function findByEmail(string $email): ?array
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function create(string $nome, string $email, string $senha): int
    {
        $stmt = Database::getConnection()->prepare(
            "INSERT INTO users (nome, email, senha) VALUES (?, ?, ?)"
        );
        $stmt->execute([$nome, $email, $senha]);
        return (int) Database::getConnection()->lastInsertId();
    }
}
