<?php

namespace App\Core;

class View {
    public static function render(string $view, array $data = []) {
        extract($data);
        include __DIR__ . "/../views/{$view}.php";
    }
}
