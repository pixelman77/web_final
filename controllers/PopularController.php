<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Post;
use App\Models\User;
use App\Models\PostRelation;

class PopularController
{
    public function index()
    {
        $page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $ranks = PostRelation::computePageRank(); // post_id => rank
        arsort($ranks); // highest ranked first

        // Pagination
        $paginatedPostIds = array_slice(array_keys($ranks), $offset, $limit);
        $posts = Post::findByIds($paginatedPostIds);

        foreach ($posts as &$post) {
            $post['user_name'] = User::findById($post['user_id'])['name'] ?? 'Unknown';
            $post['view_count'] = Post::getViewCount($post['id']);
        }

        View::render('popular', [
            'posts' => $posts,
            'ranks' => $ranks,
            'page' => $page
        ]);
    }
}
