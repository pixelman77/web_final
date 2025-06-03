<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Twitter-Like App</title>
    <link rel="stylesheet" href="/web_final/public/css/style.css">
</head>
<body>

<header>
    <div class="nav-left">
        <a href="?page=main">Home</a>
        <a href="?page=users">Users</a>
        <a href="?page=popular">Popular</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="?page=make_post">Make Post</a>
        <?php endif; ?>
    </div>
    <div class="nav-right">
        <?php if (isset($_SESSION['user'])): ?>
            <span>Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?></span>
            <a href="?page=logout">Logout</a>
        <?php else: ?>
            <a href="?page=login">Login</a>
            <a href="?page=register">Register</a>
        <?php endif; ?>
    </div>
</header>
