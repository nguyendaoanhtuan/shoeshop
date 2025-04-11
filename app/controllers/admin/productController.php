<?php


require_once 'app/models/productModel.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    public function index() {
        Auth::checkAdmin();
        // Lấy tham số tìm kiếm và trang
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 10; // Số sản phẩm mỗi trang
        
        // Lấy dữ liệu phân trang
        $data = $this->productModel->getPaginatedProducts($search, $page, $perPage);
        $products = $data['products'];
        $totalPages = $data['totalPages'];
        require 'app/views/admin/products/index.php';
    }

    public function create() {
        Auth::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'slug' => $this->createSlug($_POST['name'], $_POST['category_id']),
                'description' => $_POST['description'] ?? null,
                'short_description' => $_POST['short_description'] ?? null,
                'category_id' => $_POST['category_id'],
                'brand_id' => $_POST['brand_id'] ?? null,
                'price' => $_POST['price'],
                'discount_price' => $_POST['discount_price'] ?? null,
                'sku' => $_POST['sku'] ?? null,
                'stock_quantity' => $_POST['stock_quantity'] ?? 0,
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0
            ];

            if ($this->productModel->add($data)) {
                $_SESSION['success'] = "Thêm sản phẩm thành công";
            } else {
                $_SESSION['error'] = "Thêm sản phẩm thất bại";
            }
            header("Location: " . BASE_URL . "admin/product");
            exit();
        }

        $categories = $this->productModel->getAllCategories();
        $brands = $this->productModel->getAllBrands();
        require 'app/views/admin/products/create.php';
    }

    public function edit($id) {
        Auth::checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'slug' => $this->createSlug($_POST['name'], $_POST['category_id']),
                'description' => $_POST['description'] ?? null,
                'short_description' => $_POST['short_description'] ?? null,
                'category_id' => $_POST['category_id'],
                'brand_id' => $_POST['brand_id'] ?? null,
                'price' => $_POST['price'],
                'discount_price' => $_POST['discount_price'] ?? null,
                'sku' => $_POST['sku'] ?? null,
                'stock_quantity' => $_POST['stock_quantity'] ?? 0,
                'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'product_id' => $id
            ];

            if ($this->productModel->update($data)) {
                $_SESSION['success'] = "Cập nhật sản phẩm thành công";
            } else {
                $_SESSION['error'] = "Cập nhật sản phẩm thất bại";
            }
            header("Location: " . BASE_URL . "admin/product");
            exit();
        }

        $product = $this->productModel->getById($id);
        $categories = $this->productModel->getAllCategories();
        $brands = $this->productModel->getAllBrands();
        require 'app/views/admin/products/edit.php';
    }

    public function delete($id) {
        Auth::checkAdmin();
        if ($this->productModel->delete($id)) {
            $_SESSION['success'] = "Xóa sản phẩm thành công";
        } else {
            $_SESSION['error'] = "Xóa sản phẩm thất bại";
        }
        header("Location: " . BASE_URL . "admin/product");
        exit();
    }

    private function createSlug($string, $categoryId = null) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        $slug = strtolower($slug);
        
        // Nếu có category_id, thêm nó vào slug để đảm bảo uniqueness
        if ($categoryId) {
            $slug .= '-' . $categoryId;
        }
    
        return $slug;
    }
}
?>
