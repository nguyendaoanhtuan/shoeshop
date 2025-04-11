<?php
class Auth {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function isLoggedIn() {
        return isset($_SESSION['user']);
    }
    
    public function isAdmin() {
        return isset($_SESSION['admin']);
    }
    
    public static function checkAdmin() {
        if (!isset($_SESSION['admin'])) {
            header("Location: " . BASE_URL . "admin/login"); // Sử dụng BASE_URL
            exit();
        }
    }

    public static function checkUser() {
        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "user/account/login");
            exit();
        }
    }
}