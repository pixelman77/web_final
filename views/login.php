<?php
ob_start();
?>
<h2>Login</h2>
<?php if (!empty($error)): ?>
    <div class="error"><?php echo $error; ?></div>
<?php endif; ?>
<form method="post">
    <label>Email:<br><input type="email" name="email" required></label><br><br>
    <label>Password:<br><input type="password" name="password" required></label><br><br>
    <button type="submit">Login</button>
</form>
<?php
$content = ob_get_clean();
require 'layout.php';
?>