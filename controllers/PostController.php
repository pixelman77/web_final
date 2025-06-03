<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Post;
use App\Models\PostView;
use App\Models\PostRelation;

class PostController {
    public function main() {
        $page = isset($_GET['p']) ? max(1, intval($_GET['p'])) : 1;
        $posts = Post::getAllPaginated($page);
        View::render('main', ['posts' => $posts, 'page' => $page]);
    }

    public function popular() {
        $ranks = PostRelation::computePageRank();
        $posts = Post::getByIds(array_keys($ranks));
        usort($posts, fn($a, $b) => $ranks[$b['id']] <=> $ranks[$a['id']]);
        View::render('popular', ['posts' => $posts, 'ranks' => $ranks]);
    }
}
