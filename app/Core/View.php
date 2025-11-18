<?php

namespace App\Core;

class View {
    public function render(string $tpl, array $vars = []): string {
        $file = __DIR__ . '/../../views/' . $tpl . '.php';
        extract($vars, EXTR_SKIP);
        if (!file_exists($file)) return "View not found: {$file}";
        ob_start();
        include $file;
        return ob_get_clean();
    }
}
