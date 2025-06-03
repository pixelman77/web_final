<?php include 'views/partials/nav.php'; ?>
<div class="container">


<h1>Main Feed</h1>

<?php foreach ($posts as $post): ?>
    <div style="border:1px solid #ccc; padding:10px; margin:10px 0;">
        <strong><?= htmlspecialchars($post['user_name']) ?></strong><br>
        <?= htmlspecialchars($post['content']) ?><br>
        <small>Views: <?= (int)$post['view_count'] ?></small>
    </div>
<?php endforeach; ?>

<!-- Pagination -->
<div style="margin-top: 20px;">
    <?php
    $start = max(1, $page - 5);
    $end = $page + 5;
    for ($i = $start; $i <= $end; $i++): ?>
        <?php if ($i === $page): ?>
            <strong>[<?= $i ?>]</strong>
        <?php else: ?>
            <a href="?page=main&p=<?= $i ?>">[<?= $i ?>]</a>
        <?php endif; ?>
    <?php endfor; ?>
</div>
</div>
</body>
</html>
