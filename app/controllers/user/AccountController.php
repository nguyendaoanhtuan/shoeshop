<?php
require_once 'app/core/Auth.php';
require_once 'app/models/UserModel.php';
require_once 'app/models/ShoppingCartModel.php';
require_once 'app/models/CartItemModel.php';

class AccountController {
    private $db;
    private $userModel;
    private $cartModel;
    private $cartItemModel;

    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new UserModel($db);
        $this->cartModel = new ShoppingCartModel();
        $this->cartItemModel = new CartItemModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require_once 'app/views/user/account/login.php';
            return;
        }
    
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
    
        $user = $this->userModel->login($email, $password);

        if ($user) {
            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
                'full_name' => $user['full_name'],
                'email' => $user['email']
            ];

            // Không xóa giỏ hàng khi đăng nhập
            // Chỉ cần đảm bảo giỏ hàng tồn tại
            $this->cartModel->getCartByUserId($user['user_id']); // Tạo giỏ hàng nếu chưa có

            header("Location: " . BASE_URL . "user/account/index");
            exit();
        }

        $_SESSION['login_error'] = "Email hoặc mật khẩu không đúng!";
        header("Location: " . BASE_URL . "user/account/login");
        exit();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            require_once 'app/views/user/account/register.php';
            return;
        }
    
        $data = [
            'fullname' => $_POST['fullname'] ?? '',
            'email' => $_POST['email'] ?? '',
            'DOB' => $_POST['DOB'] ?? null,
            'password' => $_POST['password'] ?? '',
            'password_confirmation' => $_POST['password_confirmation'] ?? ''
        ];
    
        $errors = $this->validateRegisterData($data);
        if (!empty($errors)) {
            $_SESSION['register_errors'] = $errors;
            $_SESSION['old_register_data'] = $data;
            header("Location: " . BASE_URL . "user/account/register");
            exit();
        }
    
        if ($this->userModel->register($data)) {
            $_SESSION['register_success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
            header("Location: " . BASE_URL . "user/account/login");
            exit();
        }
    
        $_SESSION['register_error'] = "Đăng ký thất bại. Vui lòng thử lại.";
        header("Location: " . BASE_URL . "user/account/register");
        exit();
    }

    private function validateRegisterData($data) {
        $errors = [];
    
        if (empty($data['fullname'])) {
            $errors['fullname'] = 'Vui lòng nhập họ và tên';
        }
    
        if (empty($data['email'])) {
            $errors['email'] = 'Vui lòng nhập email';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ';
        }
    
        if (empty($data['password'])) {
            $errors['password'] = 'Vui lòng nhập mật khẩu';
        } elseif (strlen($data['password']) < 6) {
            $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
        }
    
        if ($data['password'] !== $data['password_confirmation']) {
            $errors['password_confirmation'] = 'Mật khẩu nhập lại không khớp';
        }
    
        return $errors;
    }

    public function logout() {
        // Không xóa giỏ hàng khi đăng xuất
        unset($_SESSION['user']);
        session_destroy();
        header("Location: " . BASE_URL . "user/account/login");
        exit();
    }

    public function index() {
        Auth::checkUser();
        $user_id = $_SESSION['user']['user_id'] ?? null;
        if (!$user_id) {
            $_SESSION['error'] = "Phiên đăng nhập không hợp lệ.";
            header("Location: " . BASE_URL . "user/account/login");
            exit();
        }

        $user = $this->userModel->getUserById($user_id);
        $orders = $this->getOrders($user_id);
        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy thông tin người dùng.";
            header("Location: " . BASE_URL . "user/account/login");
            exit();
        }
        require_once 'app/views/user/account/index.php';
    }

    public function edit() {
        Auth::checkUser();
        $user_id = $_SESSION['user']['user_id'] ?? null;
        if (!$user_id) {
            $_SESSION['error'] = "Phiên đăng nhập không hợp lệ.";
            header("Location: " . BASE_URL . "user/account/login");
            exit();
        }

        $user = $this->userModel->getUserById($user_id);
        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy thông tin người dùng.";
            header("Location: " . BASE_URL . "user/account/login");
            exit();
        }
        require_once 'app/views/user/account/edit.php';
    }

    private function getOrders($user_id) {
        $query = "SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProfile() {
        Auth::checkUser();
        $user_id = $_SESSION['user']['user_id'] ?? null;
        if (!$user_id) {
            $_SESSION['error'] = "Phiên đăng nhập không hợp lệ.";
            header("Location: " . BASE_URL . "user/account/login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';

            $query = "UPDATE users SET full_name = :full_name, email = :email, phone_number = :phone, address = :address WHERE user_id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':full_name', $full_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':user_id', $user_id);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Cập nhật thông tin thành công!";
                $_SESSION['user']['full_name'] = $full_name;
                $_SESSION['user']['email'] = $email;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại!";
            }
            header('Location: ' . BASE_URL . 'user/account');
            exit();
        }
    }

    public function changePassword() {
        Auth::checkUser();
        $user_id = $_SESSION['user']['user_id'] ?? null;
        if (!$user_id) {
            $_SESSION['error'] = "Phiên đăng nhập không hợp lệ.";
            header("Location: " . BASE_URL . "user/account/login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            $query = "SELECT password_hash FROM users WHERE user_id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!password_verify($current_password, $user['password_hash'])) {
                $_SESSION['error'] = "Mật khẩu hiện tại không đúng!";
                header('Location: ' . BASE_URL . 'user/account/edit');
                exit();
            }

            if ($new_password !== $confirm_password) {
                $_SESSION['error'] = "Mật khẩu mới không khớp!";
                header('Location: ' . BASE_URL . 'user/account/edit');
                exit();
            }

            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password_hash = :password_hash WHERE user_id = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':password_hash', $hashed_password);
            $stmt->bindParam(':user_id', $user_id);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Đổi mật khẩu thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại!";
            }
            header('Location: ' . BASE_URL . 'user/account');
            exit();
        }
    }
}