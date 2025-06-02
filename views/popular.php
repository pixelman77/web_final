<?php
ob_start();
?>
<h2>Top 10 Popular Posts</h2>
<?php if (empty($top_posts)): ?>
    <p>No data available.</p>
<?php else: ?>
    <ol>
    <?php foreach ($top_posts as $post): ?>
        <li class="post">
            <strong><?php echo htmlspecialchars($post['name']); ?></strong>:
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <small><em>Views: <?php echo (int)$post['views']; ?></em></small>
        </li>
    <?php endforeach; ?>
    </ol>
<?php endif; ?>
<?php
$content = ob_get_clean();
require 'layout.php';
?>
