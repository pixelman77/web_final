<?php include 'views/partials/nav.php'; ?>
<div class="container">


<h1>Users</h1>


<ul>
<?php foreach ($users as $user): ?>
    <li>
        <strong><?= htmlspecialchars($user['name']) ?></strong> — <?= htmlspecialchars($user['email']) ?>
    </li>
<?php endforeach; ?>
</ul>
</div>
</body>
</html>
