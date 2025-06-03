
<?php include 'views/partials/nav.php'; ?>
<div class="container">


<h1>Popular Posts</h1>

<?php foreach ($posts as $post): ?>
    <div style="border:1px solid #ccc; padding:10px; margin:10px 0;">
        <strong><?= htmlspecialchars($post['user_name']) ?></strong><br>
        <?= htmlspecialchars($post['content']) ?><br>
        <small>Views: <?= (int)$post['view_count'] ?> | PageRank: <?= round($ranks[$post['id']], 5) ?></small>
    </div>
<?php endforeach; ?>
</div>
</body>
</html>
