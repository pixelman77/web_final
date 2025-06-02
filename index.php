<?php
require_once 'config.php';

$page = $_GET['page'] ?? 'home';

// Load controller based on page
switch($page) {
    case 'register':
        require_once 'controllers/UserController.php';
        $controller = new UserController($pdo);
        $controller->register();
        break;
    case 'login':
        require_once 'controllers/UserController.php';
        $controller = new UserController($pdo);
        $controller->login();
        break;
    case 'logout':
        require_once 'controllers/UserController.php';
        $controller = new UserController($pdo);
        $controller->logout();
        break;
    case 'post':
        require_once 'controllers/PostController.php';
        $controller = new PostController($pdo);
        $controller->create();
        break;
    case 'popular':
        require_once 'controllers/PostController.php';
        $controller = new PostController($pdo);
        $controller->popular();
        break;
    case 'home':
    default:
        require_once 'controllers/PostController.php';
        $controller = new PostController($pdo);
        $controller->index();
        break;
        
}
?>