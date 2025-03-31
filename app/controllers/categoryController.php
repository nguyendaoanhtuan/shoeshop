<?php
require_once 'app/models/CategoryModel.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        require 'app/views/admin/quanlydanhmuc.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'parent_id' => ($_POST['parent_id'] == 1 || $_POST['parent_id'] == 2) ? (int)$_POST['parent_id'] : null,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->categoryModel->addCategory($data)) {
                $_SESSION['success'] = "Thêm danh mục thành công";
                header("Location: ?controller=category&action=index");
                exit();
            } else {
                $_SESSION['error'] = "Thêm danh mục thất bại";
            }
        }

        $parentCategories = $this->categoryModel->getParentCategories();
        require 'app/views/admin/them-danhmuc.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'parent_id' => ($_POST['parent_id'] == 1 || $_POST['parent_id'] == 2) ? (int)$_POST['parent_id'] : null,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->categoryModel->updateCategory($id, $data)) {
                $_SESSION['success'] = "Cập nhật danh mục thành công";
                header("Location: ?controller=category&action=index");
                exit();
            } else {
                $_SESSION['error'] = "Cập nhật danh mục thất bại";
            }
        }

        $category = $this->categoryModel->getCategoryById($id);
        $parentCategories = $this->categoryModel->getParentCategories();
        require 'app/views/admin/sua-danhmuc.php';
    }

    public function delete($id) {
        if ($this->categoryModel->deleteCategory($id)) {
            $_SESSION['success'] = "Xóa danh mục thành công";
        } else {
            $_SESSION['error'] = "Xóa danh mục thất bại";
        }
        header("Location: ?controller=category&action=index");
        exit();
    }
}
?>