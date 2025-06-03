<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Post;

class NewPostController {
    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
            $content = trim($_POST['content']);
            if ($content !== '') {
                Post::create($_SESSION['user']['id'], $content);
            }
        }
        header('Location: ?page=main');
        exit;
    }
}
