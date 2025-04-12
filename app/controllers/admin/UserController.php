<?php
require_once 'app/core/Auth.php';
require_once 'app/models/UserModel.php';
class UserController {
    private $userModel;
    
    public function __construct($db) {
        $this->userModel = new UserModel($db);
    }

    public function index() {
        Auth::checkAdmin();
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $perPage = 10;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        $users = $this->userModel->getAllUsers($page, $perPage, $search);
        $totalUsers = $this->userModel->countUsers($search);
        $totalPages = ceil($totalUsers / $perPage);
        
        include_once 'app/views/admin/account_users/index.php';
    }

    public function edit($user_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $user_id,
                'full_name' => trim($_POST['full_name']),
                'phone_number' => trim($_POST['phone_number']),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];
            
            if ($this->userModel->updateUser($data)) {
                $_SESSION['success'] = 'Cập nhật người dùng thành công';
                header('Location: ' . BASE_URL . 'admin/user');
                exit;
            } else {
                $_SESSION['error'] = 'Cập nhật người dùng thất bại';
            }
        }
        
        $user = $this->userModel->getUserById($user_id);
        if (!$user) {
            $_SESSION['error'] = 'Không tìm thấy người dùng';
            header('Location: ' . BASE_URL . 'admin/user');
            exit;
        }
        
        include_once 'app/views/admin/account_users/edit.php';
    }

    public function delete($user_id) {
        if ($this->userModel->deleteUser($user_id)) {
            $_SESSION['success'] = 'Xóa người dùng thành công';
        } else {
            $_SESSION['error'] = 'Xóa người dùng thất bại';
        }
        header('Location: ' . BASE_URL . 'admin/user');
        exit;
    }
}