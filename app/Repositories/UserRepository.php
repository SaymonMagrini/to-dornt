<?php
namespace App\Repositories;

use App\Core\Database;
use App\Models\User;


use PDO;

class UserRepository {
    public function findByEmail(string $email): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $d = $stmt->fetch(PDO::FETCH_ASSOC);
        return $d ?: null;
    }

    public function find(int $id): ?array {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function all(): array {
        $db = Database::getConnection();
        return $db->query('SELECT id,name,email,role,created_at FROM users ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(User $u): int
    {
        $stmt = Database::getConnection()->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$u->name, $u->email, $u->password_hash]);
        return (int)Database::getConnection()->lastInsertId();
    }

    public function update(array $u): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare('UPDATE users SET name=?,email=?,password=?,role=? WHERE id=?');
        return $stmt->execute([$u['name'],$u['email'],$u['password'],$u['role'],$u['id']]);
    }

    public function delete(int $id): bool {
        $db = Database::getConnection();
        $stmt = $db->prepare('DELETE FROM users WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
