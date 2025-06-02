<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Simple Twitter MVC</title>
<style>
    body { font-family: Arial, sans-serif; margin: 20px; max-width: 700px; }
    nav a { margin-right: 15px; }
    .error { color: red; }
    .post { border-bottom: 1px solid #ccc; padding: 10px 0; }
    .post strong { font-weight: bold; }
    .pagination a { margin: 0 5px; text-decoration: none; }
    .pagination strong { margin: 0 5px; }
</style>
</head>
<body>
<nav>
    <a href="index.php?page=home">Home</a>
    <a href="index.php?page=popular">Popular Posts</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="index.php?page=post">Post</a>
        <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
        <a href="index.php?page=logout">Logout</a>
    <?php else: ?>
        <a href="index.php?page=login">Login</a>
        <a href="index.php?page=register">Register</a>
    <?php endif; ?>
</nav>
<hr>
<div>
<?php echo $content ?? ''; ?>
</div>
</body>
</html>