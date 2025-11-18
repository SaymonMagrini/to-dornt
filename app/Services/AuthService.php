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

    private UserService $service;

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

    public function register(string $name, string $email, string $password): int
    {
        $data['name'] = $name;
        $data['email'] = strtolower(trim($email));
        $data['password'] = AuthService::hashPassword($password);
        $user = $this->service->make($data);
        return $this->repo->create($user);
    }

    public static function user(): ?array
    {
        session_start();
        return $_SESSION['user'] ?? null;
    }
    public static function hashPassword(string $password): string
    {
        $algo = defined('PASSWORD_ARGON2ID') ? PASSWORD_ARGON2ID : PASSWORD_BCRYPT;
        return password_hash($password, $algo);
    }

}
