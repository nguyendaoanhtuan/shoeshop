<?php
require_once 'app/models/CategoryModel.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        Auth::checkAdmin();
        // Lấy tham số tìm kiếm và trang
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 10; // Số danh mục mỗi trang

        // Lấy dữ liệu phân trang
        $data = $this->categoryModel->getPaginatedCategories($search, $page, $perPage);
        
        $categories = $data['categories'];
        $totalPages = $data['totalPages'];
        require 'app/views/admin/categories/index.php';
    }

    public function create() {
        Auth::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'parent_id' => ($_POST['parent_id'] == 1 || $_POST['parent_id'] == 2) ? (int)$_POST['parent_id'] : null,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->categoryModel->addCategory($data)) {
                $_SESSION['success'] = "Thêm danh mục thành công";
                header("Location: " . BASE_URL . "admin/category");
                exit();
            } else {
                $_SESSION['error'] = "Thêm danh mục thất bại";
            }
        }

        $parentCategories = $this->categoryModel->getParentCategories();
        require 'app/views/admin/categories/create.php';
    }

    public function edit($id) {
        Auth::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'parent_id' => ($_POST['parent_id'] == 1 || $_POST['parent_id'] == 2) ? (int)$_POST['parent_id'] : null,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->categoryModel->updateCategory($id, $data)) {
                $_SESSION['success'] = "Cập nhật danh mục thành công";
                header("Location: " . BASE_URL . "admin/category");
                exit();
            } else {
                $_SESSION['error'] = "Cập nhật danh mục thất bại";
            }
        }

        $category = $this->categoryModel->getCategoryById($id);
        $parentCategories = $this->categoryModel->getParentCategories();
        require 'app/views/admin/categories/edit.php';
    }

    public function delete($id) {
        Auth::checkAdmin();
        if ($this->categoryModel->deleteCategory($id)) {
            $_SESSION['success'] = "Xóa danh mục thành công";
        } else {
            $_SESSION['error'] = "Xóa danh mục thất bại";
        }
        header("Location: " . BASE_URL . "admin/category");
        exit();
    }
}
?>
