<?php
require_once 'app/models/User.php';

class LoginController {
    private $user;

    public function __construct($db) {
        $this->user = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $user = $this->user->login($email, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
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

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !== $confirm_password) {
                $error = "Passwords do not match";
                require_once 'app/views/auth/register.php';
                return;
            }

            if ($this->user->register($username, $email, $password)) {
                header('Location: /login');
                exit;
            } else {
                $error = "Registration failed";
                require_once 'app/views/auth/register.php';
            }
        } else {
            require_once 'app/views/auth/register.php';
        }
    }

    public function logout() {
        $this->user->logout();
        header('Location: /login');
        exit;
    }
}