<?php
namespace App\Services;

use App\Repositories\UserRepository;

class AuthService
{
    private UserRepository $repo;

    public function __construct()
    {
        $this->repo = new UserRepository();
    }

    public function attempt(string $email, string $senha): bool
    {
        session_start();
        $user = $this->repo->findByEmail($email);

        if ($user && password_verify($senha, $user['password_hash'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email']
            ];
            return true;
        }

        return false;
    }

    public function logout(): void
    {
        session_start();
        session_destroy();
    }

    public function register(string $name, string $email, string $senha): int
    {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        return $this->repo->create($name, $email, $hash);
    }

    public static function user(): ?array
    {
        session_start();
        return $_SESSION['user'] ?? null;
    }
}
