<?php
ob_start();
?>
<h2>Create Post</h2>
<?php if (!empty($error)): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>
<form method="post">
    <textarea name="content" rows="4" cols="50" required></textarea><br><br>
    <button type="submit">Post</button>
</form>
<?php
$content = ob_get_clean();
require 'layout.php';
?>