<?php

namespace App\Core;

use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Controllers\AuthController;

class Router {
    public static function route() {
        $page = $_GET['page'] ?? 'main';

        switch ($page) {
            case 'main':
                (new PostController())->main();
                break;
            case 'users':
                (new UserController())->index();
                break;
            case 'login':
                (new \App\Controllers\AuthController())->login();
                break;

            case 'register':
                (new \App\Controllers\AuthController())->register();
                break;

            case 'popular':
                (new PostController())->popular();
                break;
            case 'make_post':
                (new \App\Controllers\MakePostController())->index();
                break;
            case 'logout':
                (new \App\Controllers\LogoutController())->index();
                break;

            default:
                echo "404 - Page Not Found";
        }
    }
}
