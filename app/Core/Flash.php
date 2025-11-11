<?php

namespace App\Core;

class Flash
{
    public static function push(string $type, string $message): void
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $_SESSION['flash'][] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public static function getAll(): array
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $messages = $_SESSION['flash'] ?? [];
        unset($_SESSION['flash']);
        return $messages;
    }
}
