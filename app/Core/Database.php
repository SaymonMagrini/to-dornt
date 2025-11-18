<?php
namespace App\Core;
use PDO;

class Database {
    private static ?PDO $conn = null;

    public static function getConnection(): PDO {
        if (self::$conn === null) {
            $dir = __DIR__ . '/../../data';
            if (!is_dir($dir)) mkdir($dir, 0777, true);
            $path = $dir . '/database.sqlite';
            if (!file_exists($path)) touch($path);
            self::$conn = new PDO('sqlite:' . $path);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}
