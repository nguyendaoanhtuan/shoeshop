<?php
require_once 'app/models/BrandsModel.php';

class BrandsController {
    private $brandsModel;

    public function __construct() {
        $this->brandsModel = new BrandsModel();
    }

    public function index() {
        $brands = $this->brandsModel->getAllBrands();
        require 'app/views/admin/quanlythuonghieu.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'] ?? null,
                'logo_url' => $this->uploadImage(),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->brandsModel->addBrand($data)) {
                $_SESSION['success'] = "Thêm thương hiệu thành công";
                header("Location: ?controller=brands&action=index");
                exit();
            } else {
                $_SESSION['error'] = "Thêm thương hiệu thất bại";
            }
        }

        require 'app/views/admin/them-thuonghieu.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'] ?? null,
                'logo_url' => $this->uploadImage(),
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->brandsModel->updateBrand($id, $data)) {
                $_SESSION['success'] = "Cập nhật thương hiệu thành công";
                header("Location: ?controller=brands&action=index");
                exit();
            } else {
                $_SESSION['error'] = "Cập nhật thương hiệu thất bại";
            }
        }

        $brand = $this->brandsModel->getBrandById($id);
        require 'app/views/admin/sua-thuonghieu.php';
    }

    public function delete($id) {
        if ($this->brandsModel->deleteBrand($id)) {
            $_SESSION['success'] = "Xóa thương hiệu thành công";
        } else {
            $_SESSION['error'] = "Xóa thương hiệu thất bại";
        }
        header("Location: ?controller=brands&action=index");
        exit();
    }
    private function uploadImage() {
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
?>