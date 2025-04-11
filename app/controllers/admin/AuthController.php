<?php
require_once 'app/models/AdminModel.php'; // Sửa đường dẫn cho đúng

class AuthController {
    private $db;
    private $adminModel;

    public function __construct($db) {
        $this->db = $db;
        $this->adminModel = new AdminModel($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require_once 'app/views/admin/login.php';
            return;
        }

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $admin = $this->adminModel->login($username, $password);

        if ($admin) {
            $_SESSION['admin'] = [
                'admin_id' => $admin['admin_id'],
                'username' => $admin['username'],
                'full_name' => $admin['full_name'],
                'role' => $admin['role']
            ];
            header("Location: " . BASE_URL . "admin/product/index");
            exit();
        }

        $_SESSION['admin_login_error'] = "Tên đăng nhập hoặc mật khẩu không đúng";
        header("Location: " . BASE_URL . "admin/login");
        exit();
    }

    public function logout() {
        unset($_SESSION['admin']);
        session_destroy();
        header("Location: " . BASE_URL . "admin/login");
        exit();
    }
}