<?php
require_once 'models/User.php';

class UserController {
    private $pdo;
    private $userModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->userModel = new User($pdo);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            $errors = [];

            if (!$name || !$email || !$password || !$password2) {
                $errors[] = "All fields are required.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email.";
            }
            if ($password !== $password2) {
                $errors[] = "Passwords do not match.";
            }
            if ($this->userModel->findByEmail($email)) {
                $errors[] = "Email already registered.";
            }

            if (empty($errors)) {
                $this->userModel->create($name, $email, $password);
                header("Location: index.php?page=login");
                exit;
            }
        }
        require 'views/register.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $user = $this->userModel->findByEmail($email);

            if ($user && hash('sha256', $password) === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: index.php?page=home");
                exit;
            } else {
                $error = "Invalid credentials.";
            }
        }
        require 'views/login.php';
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?page=login");
        exit;
    }
}
?>