<?php
class AccountController {
    private $db;
    private $user;

    public function __construct($db) {
        $this->db = $db;
        if (!isset($_SESSION['user_id'])) {
            header('Location: /shoeshop/login');
            exit();
        }
        $this->user = $this->getUserData($_SESSION['user_id']);
    }

    private function getUserData($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function index() {
        $orders = $this->getOrders($_SESSION['user_id']);
        require_once 'app/views/user/account.php';
    }

    private function getOrders($user_id) {
        $query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';

            $query = "UPDATE users SET name = :name, email = :email, phone = :phone, address = :address WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':id', $_SESSION['user_id']);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Cập nhật thông tin thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại!";
            }
            header('Location: /shoeshop/account');
            exit();
        }
    }

    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Kiểm tra mật khẩu hiện tại
            $query = "SELECT password FROM users WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!password_verify($current_password, $user['password'])) {
                $_SESSION['error'] = "Mật khẩu hiện tại không đúng!";
                header('Location: /shoeshop/account');
                exit();
            }

            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = "Mật khẩu mới không khớp!";
                header('Location: /shoeshop/account');
                exit();
            }

            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':id', $_SESSION['user_id']);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Đổi mật khẩu thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại!";
            }
            header('Location: /shoeshop/account');
            exit();
        }
    }
} 