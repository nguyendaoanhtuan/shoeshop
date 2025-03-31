<?php
require_once 'app/models/User.php';

class AuthController {
    private $user;

    public function __construct($db) {
        $this->user = new User($db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validate
            $errors = [];
            if (empty($username)) $errors[] = "Username is required";
            if (empty($email)) $errors[] = "Email is required";
            if (empty($password)) $errors[] = "Password is required";
            if ($password !== $confirm_password) $errors[] = "Passwords do not match";

            if (empty($errors)) {
                if ($this->user->register($username, $email, $password, $confirm_password)) {
                    $_SESSION['success'] = "Registration successful!";
                    header('Location: /login');
                    exit;
                } else {
                    $errors[] = "Registration failed. Email may already exist.";
                }
            }
            
            require_once 'app/views/auth/register.php';
        } else {
            require_once 'app/views/auth/register.php';
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if ($this->user->login($email, $password)) {
                header('Location: /dashboard');
                exit;
            } else {
                $error = "Invalid email or password";
                require_once 'app/views/auth/login.php';
            }
        } else {
            require_once 'app/views/auth/login.php';
        }
    }

    public function logout() {
        $this->user->logout();
        header('Location: /login');
        exit;
    }
} 