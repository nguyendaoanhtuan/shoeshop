<?php
require_once 'app/models/User.php';

class LoginController {
    private $user;

    public function __construct($db) {
        $this->user = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $user = $this->user->login($email, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /shoeshop');
                exit;
            } else {
                $error = "Email hoặc mật khẩu không chính xác";
                require_once 'app/views/user/dangnhap.php';
            }
        } else {
            require_once 'app/views/user/dangnhap.php';
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);

            // Validate dữ liệu
            if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
                $error = "Vui lòng điền đầy đủ thông tin";
                require_once 'app/views/user/dangky.php';
                return;
            }

            if ($password !== $confirm_password) {
                $error = "Mật khẩu nhập lại không khớp";
                require_once 'app/views/user/dangky.php';
                return;
            }

            if (strlen($password) < 6) {
                $error = "Mật khẩu phải có ít nhất 6 ký tự";
                require_once 'app/views/user/dangky.php';
                return;
            }

            // Thực hiện đăng ký
            $result = $this->user->register($username, $email, $password, $full_name);

            if ($result === true) {
                // Đăng ký thành công, chuyển đến trang đăng nhập
                header('Location: /shoeshop/login');
                exit;
            } else {
                // Đăng ký thất bại, hiển thị lỗi
                $error = $result;
                require_once 'app/views/user/dangky.php';
            }
        } else {
            require_once 'app/views/user/dangky.php';
        }
    }

    public function logout() {
        $this->user->logout();
        header('Location: /shoeshop/login');
        exit;
    }
}