<?php
namespace App\Core;

class Csrf {
    public static function token(): string {
        if (!session_id()) session_start();
        if (empty($_SESSION['_csrf'])) $_SESSION['_csrf'] = bin2hex(random_bytes(16));
        return $_SESSION['_csrf'];
    }
    public static function validate(?string $token): bool {
        if (!session_id()) session_start();
        return !empty($token) && !empty($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $token);
    }
}
