<?php
ob_start();
?>
<h2>Latest Posts</h2>
<?php if (empty($posts)): ?>
    <p>No posts yet.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <div class="post">
            <strong><?php echo htmlspecialchars($post['name']); ?></strong>:
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
        </div>
    <?php endforeach; ?>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="index.php?page=home&p=<?php echo $page - 1; ?>">Prev</a>
        <?php endif; ?>
        <strong>Page <?php echo $page; ?> of <?php echo $totalPages; ?></strong>
        <?php if ($page < $totalPages): ?>
            <a href="index.php?page=home&p=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php
$content = ob_get_clean();
require 'layout.php';
?>