<?php
ob_start();
?>
<h2>Register</h2>
<?php if (!empty($errors)): ?>
    <div class="error"><?php echo implode('<br>', $errors); ?></div>
<?php endif; ?>
<form method="post">
    <label>Name:<br><input type="text" name="name" required></label><br><br>
    <label>Email:<br><input type="email" name="email" required></label><br><br>
    <label>Password:<br><input type="password" name="password" required></label><br><br>
    <label>Confirm Password:<br><input type="password" name="password2" required></label><br><br>
    <button type="submit">Register</button>
</form>
<?php
$content = ob_get_clean();
require 'layout.php';
?>