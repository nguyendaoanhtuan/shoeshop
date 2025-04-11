<?php
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';
require_once 'app/models/BrandsModel.php';

class ProductController {
    private $productModel;
    private $categoryModel;
    private $brandsModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->brandsModel = new BrandsModel();
    }

    public function index() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 12;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'product_id_asc'; // Mặc định sắp xếp theo product_id tăng dần
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
        $brandId = isset($_GET['brand_id']) ? (int)$_GET['brand_id'] : null;

        $productData = $this->productModel->getPaginatedProducts($search, $page, $perPage, null, $sort, $categoryId, $brandId);
        $products = $productData['products'];
        $totalPages = $productData['totalPages'];

        $categoryData = $this->categoryModel->getPaginatedCategories();
        $categories = $categoryData['categories'];
        $brandData = $this->brandsModel->getPaginatedBrands();
        $brands = $brandData['brands'];

        $menCategories = array_filter($categories, function($category) {
            return $category['parent_id'] == 1;
        });
        $womenCategories = array_filter($categories, function($category) {
            return $category['parent_id'] == 2;
        });

        $categoryName = 'Tất cả sản phẩm';
        $parentCategoryId = null;
        require_once 'app/views/user/products/index.php';
    }

    public function men() {
        $parentCategoryId = 1;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 12;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'product_id_asc';
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
        $brandId = isset($_GET['brand_id']) ? (int)$_GET['brand_id'] : null;

        $productData = $this->productModel->getPaginatedProducts($search, $page, $perPage, $parentCategoryId, $sort, $categoryId, $brandId);
        $products = $productData['products'];
        $totalPages = $productData['totalPages'];

        $categoryData = $this->categoryModel->getPaginatedCategories();
        $categories = $categoryData['categories'];
        $brandData = $this->brandsModel->getPaginatedBrands();
        $brands = $brandData['brands'];

        $menCategories = array_filter($categories, function($category) {
            return $category['parent_id'] == 1;
        });
        $womenCategories = array_filter($categories, function($category) {
            return $category['parent_id'] == 2;
        });

        $categoryName = 'Giày Nam';
        require_once 'app/views/user/products/men.php';
    }

    public function women() {
        $parentCategoryId = 2;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 12;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'product_id_asc';
        $categoryId = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
        $brandId = isset($_GET['brand_id']) ? (int)$_GET['brand_id'] : null;

        $productData = $this->productModel->getPaginatedProducts($search, $page, $perPage, $parentCategoryId, $sort, $categoryId, $brandId);
        $products = $productData['products'];
        $totalPages = $productData['totalPages'];

        $categoryData = $this->categoryModel->getPaginatedCategories();
        $categories = $categoryData['categories'];
        $brandData = $this->brandsModel->getPaginatedBrands();
        $brands = $brandData['brands'];

        $menCategories = array_filter($categories, function($category) {
            return $category['parent_id'] == 1;
        });
        $womenCategories = array_filter($categories, function($category) {
            return $category['parent_id'] == 2;
        });

        $categoryName = 'Giày Nữ';
        require_once 'app/views/user/products/women.php';
    }

    public function detail($productId) {
        $product = $this->productModel->getById($productId);
        if (!$product) {
            header("Location: " . BASE_URL . "user/Product/index");
            exit();
        }
        require_once 'app/views/user/products/detail.php';
    }
}
?>