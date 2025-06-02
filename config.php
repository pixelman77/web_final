<?php
// Database config
define('DB_HOST', 'localhost');
define('DB_NAME', 'web_final');
define('DB_USER', 'root');
define('DB_PASS', ''); // set your MySQL password here

// Connect to DB using PDO
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
session_start();
?>