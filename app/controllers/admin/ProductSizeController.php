<?php
require_once 'app/models/ProductSizeModel.php';
require_once 'app/core/Auth.php';

class ProductSizeController {
    private $db;
    private $productSizeModel;

    public function __construct($db) {
        $this->db = $db;
        $this->productSizeModel = new ProductSizeModel($db);
    }

    // Hiển thị tất cả sản phẩm kèm danh sách kích thước
    public function index() {
        Auth::checkAdmin();
       // Lấy tham số tìm kiếm và trang
       $search = isset($_GET['search']) ? trim($_GET['search']) : '';
       $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
       $perPage = 10; // Số sản phẩm mỗi trang

       // Lấy dữ liệu phân trang
       $data = $this->productSizeModel->getPaginatedProductsWithSizes($search, $page, $perPage);
       
       $products = $data['products'];
       $totalPages = $data['totalPages'];
        require_once 'app/views/admin/product_sizes/index.php';
    }

    // Hiển thị form thêm kích thước với danh sách sản phẩm và kích thước
    public function create() {
        Auth::checkAdmin();
        $products = $this->productSizeModel->getAllProducts();
        $all_sizes = $this->productSizeModel->getAllSizes();
        require_once 'app/views/admin/product_sizes/create.php';
    }

    // Xử lý thêm kích thước
    public function store() {
        Auth::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $size_ids = $_POST['size_ids'] ?? [];

            if (!$product_id || empty($size_ids)) {
                $_SESSION['error'] = "Vui lòng chọn sản phẩm và ít nhất một kích thước";
                header("Location: " . BASE_URL . "admin/ProductSize/create");
                exit();
            }

            if ($this->productSizeModel->create($product_id, $size_ids)) {
                $_SESSION['success'] = "Thêm kích thước thành công";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi thêm kích thước";
            }
            header("Location: " . BASE_URL . "admin/ProductSize/index");
            exit();
        }
    }

    // Hiển thị form sửa kích thước
    public function edit() {
        Auth::checkAdmin();
        $product_id = $_GET['product_id'] ?? null;
        if (!$product_id) {
            $_SESSION['error'] = "Vui lòng cung cấp product_id";
            header("Location: " . BASE_URL . "admin/ProductSize/index");
            exit();
        }
        $product = $this->productSizeModel->getAllProducts();
        $product = array_filter($product, function($p) use ($product_id) {
            return $p['product_id'] == $product_id;
        });
        $product = reset($product);
        if (!$product) {
            $_SESSION['error'] = "Sản phẩm không tồn tại";
            header("Location: " . BASE_URL . "admin/ProductSize/index");
            exit();
        }
        $current_sizes = $this->productSizeModel->getSizesByProduct($product_id);
        $all_sizes = $this->productSizeModel->getAllSizes();
        require_once 'app/views/admin/product_sizes/edit.php';
    }

    // Xử lý cập nhật kích thước
    public function update() {
        Auth::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $size_ids = $_POST['size_ids'] ?? [];

            if (!$product_id) {
                $_SESSION['error'] = "Vui lòng cung cấp product_id";
                header("Location: " . BASE_URL . "admin/ProductSize/index");
                exit();
            }

            if ($this->productSizeModel->update($product_id, $size_ids)) {
                $_SESSION['success'] = "Cập nhật kích thước thành công";
            } else {
                $_SESSION['error'] = "Lỗi khi cập nhật kích thước";
            }
            header("Location: " . BASE_URL . "admin/ProductSize/index");
            exit();
        }
    }

    // Xóa tất cả kích thước của một sản phẩm
    public function delete() {
        Auth::checkAdmin();
        $product_id = $_GET['product_id'] ?? null;
        if (!$product_id) {
            $_SESSION['error'] = "Vui lòng cung cấp product_id";
            header("Location: " . BASE_URL . "admin/ProductSize/index");
            exit();
        }
        if ($this->productSizeModel->deleteByProduct($product_id)) {
            $_SESSION['success'] = "Xóa tất cả kích thước thành công";
        } else {
            $_SESSION['error'] = "Lỗi khi xóa kích thước";
        }
        header("Location: " . BASE_URL . "admin/ProductSize/index");
        exit();
    }
}
?>