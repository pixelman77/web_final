<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\User;

class AuthController
{
    public function register()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            if ($name === '' || $email === '' || $password === '') {
                $error = "All fields are required.";
            } else {
                try {
                    User::create($name, $email, $password);
                    header('Location: ?page=login');
                    exit;
                } catch (\PDOException $e) {
                    $error = "Email already exists.";
                }
            }
        }

        View::render('register', ['error' => $error]);
    }

    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $hashedInput = hash('sha256', $password);

            $user = User::findByEmail($email);

            if ($user && $user['password'] === $hashedInput) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email']
                ];
                
                
                //file_put_contents('php://stderr', print_r($_SESSION, TRUE));
                //file_put_contents('php://stderr', "...");

                header('Location: ?page=main');
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        }

        View::render('login', ['error' => $error]);
    }
}
