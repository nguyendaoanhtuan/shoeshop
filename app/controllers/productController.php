<?php
require_once 'app/models/Product.php';
require_once 'app/models/Category.php';

class ProductController {
    private $product;
    private $category;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->product = new Product($db);
        $this->category = new Category($db);
    }

    public function index() {
        // Lấy category_id từ URL nếu có
        $category_id = isset($_GET['category']) ? $_GET['category'] : null;
        
        // Lấy danh sách sản phẩm
        if($category_id) {
            $products = $this->product->getProductsByCategory($category_id);
        } else {
            $products = $this->product->getAllProducts(); // Sửa từ getProducts() thành getAllProducts()
        }
        
        // Lấy danh sách danh mục
        $categories = $this->category->getAllCategories();
        
        // Load view
        require_once 'app/views/user/products.php';
    }

    public function detail($id) {
        $product = $this->product->getProductById($id);
        if($product) {
            require_once 'app/views/user/product-detail.php';
        } else {
            header('Location: /shoeshop/products');
        }
    }
} 