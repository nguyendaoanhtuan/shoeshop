<?php
require_once 'app/models/BrandsModel.php';

class BrandsController {
    private $brandsModel;

    public function __construct() {
        $this->brandsModel = new BrandsModel();
    }

    public function index() {
        Auth::checkAdmin();
        // Lấy tham số tìm kiếm và trang
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 10; // Số thương hiệu mỗi trang

        // Lấy dữ liệu phân trang
        $data = $this->brandsModel->getPaginatedBrands($search, $page, $perPage);

        $brands = $data['brands'];
        $totalPages = $data['totalPages'];
        require 'app/views/admin/brands/index.php';
    }

    public function create() {
        Auth::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'] ?? null,
                'logo_url' => $this->uploadImage(),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->brandsModel->addBrand($data)) {
                $_SESSION['success'] = "Thêm thương hiệu thành công";
                header("Location: " . BASE_URL . "admin/brands");
                exit();
            } else {
                $_SESSION['error'] = "Thêm thương hiệu thất bại";
            }
        }

        require 'app/views/admin/brands/create.php';
    }

    public function edit($id) {
        Auth::checkAdmin();
        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "ID thương hiệu không hợp lệ";
            header("Location: " . BASE_URL . "admin/brands");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'] ?? null,
                'logo_url' => $this->uploadImage(),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->brandsModel->updateBrand($id, $data)) {
                $_SESSION['success'] = "Cập nhật thương hiệu thành công";
                header("Location: " . BASE_URL . "admin/brands");
                exit();
            } else {
                $_SESSION['error'] = "Cập nhật thương hiệu thất bại";
            }
        }

        $brand = $this->brandsModel->getBrandById($id);
        if (!$brand) {
            $_SESSION['error'] = "Thương hiệu không tồn tại";
            header("Location: " . BASE_URL . "admin/brands");
            exit();
        }
        require 'app/views/admin/brands/edit.php';
    }

    public function delete($id) {
        Auth::checkAdmin();
        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = "ID thương hiệu không hợp lệ";
            header("Location: " . BASE_URL . "admin/brands");
            exit();
        }

        if ($this->brandsModel->deleteBrand($id)) {
            $_SESSION['success'] = "Xóa thương hiệu thành công";
        } else {
            $_SESSION['error'] = "Xóa thương hiệu thất bại";
        }
        header("Location: " . BASE_URL . "admin/brands");
        exit();
    }

    private function uploadImage() {
        Auth::checkAdmin();
        if (empty($_FILES['logo']['name'])) {
            return null;
        }

        $target_dir = "public/admin/assets/img/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $target_file = $target_dir . basename($_FILES["logo"]["name"]);
        move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file);
        return "admin/assets/img/" . basename($_FILES["logo"]["name"]);
    }
}