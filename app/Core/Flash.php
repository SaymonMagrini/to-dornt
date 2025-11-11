<?php

namespace App\Core;

class Flash
{
    private static string $sessionKey = '_flash_messages';

    
    public static function add(string $message, string $type = 'info'): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION[self::$sessionKey][] = [
            'message' => $message,
            'type' => $type
        ];
    }

  
    public static function getAll(): array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $messages = $_SESSION[self::$sessionKey] ?? [];
        unset($_SESSION[self::$sessionKey]);

        return $messages;
    }


    public static function render(): void
    {
        foreach (self::getAll() as $msg) {
            $color = match ($msg['type']) {
                'error' => 'red',
                'success' => 'limegreen',
                'warning' => 'orange',
                default => 'cyan'
            };

            echo "<p style='color: {$color}; text-align:center;'>" . htmlspecialchars($msg['message']) . "</p>";
        }
    }
}
