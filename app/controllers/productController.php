<?php
require_once 'app/models/productModel.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    public function index() {
        $products = $this->productModel->getAll();
        require 'app/views/admin/quanlysanpham.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'slug' => $this->createSlug($_POST['name']),
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
            header("Location: ?controller=product&action=index");
            exit();
        }

        $categories = $this->productModel->getAllCategories();
        $brands = $this->productModel->getAllBrands();
        require 'app/views/admin/them-sanpham.php';
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'slug' => $this->createSlug($_POST['name']),
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
            header("Location: ?controller=product&action=index");
            exit();
        }

        $product = $this->productModel->getById($id);
        $categories = $this->productModel->getAllCategories();
        $brands = $this->productModel->getAllBrands();
        require 'app/views/admin/sua-sanpham.php';
    }

    public function delete($id) {
        if ($this->productModel->delete($id)) {
            $_SESSION['success'] = "Xóa sản phẩm thành công";
        } else {
            $_SESSION['error'] = "Xóa sản phẩm thất bại";
        }
        header("Location: ?controller=product&action=index");
        exit();
    }

    private function createSlug($string) {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        $slug = strtolower($slug);
        return $slug;
    }
}